<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Schedule') }}
        </h2>
    </x-slot>
    
    <!-- Alert Success -->
    @if(session('success'))
        <div id="alert-success" class="fixed top-4 right-4 z-50">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="closeAlert('alert-success')" class="text-green-700 hover:text-green-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>about:blank#blocked
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                    <div class="overflow-hidden rounded-lg shadow-lg 
                        @if($schedule->priority == 'very_important')
                            bg-red-100 border-red-400
                        @elseif($schedule->priority == 'important')
                            bg-blue-300 border-blue-500
                        @else
                            bg-green-100 border-green-400
                        @endif
                        border">
                        <div class="px-6 py-4">
                            <!-- Card Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-lg 
                                    @if($schedule->priority == 'very_important')
                                        text-red-700
                                    @elseif($schedule->priority == 'important')
                                        text-blue-700
                                    @else
                                        text-green-700
                                    @endif">
                                    {{ $schedule->schedule_name }}
                                </h3>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($schedule->priority == 'very_important')
                                        bg-red-200 text-red-800
                                    @elseif($schedule->priority == 'important')
                                        bg-blue-400 text-blue-800
                                    @else
                                        bg-green-200 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $schedule->priority)) }}
                                </span>
                            </div>

                            <!-- Card Content -->
                            <div class="space-y-2">
                                <p class="text-gray-600">
                                    <span class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Category:</span> 
                                    {{ ucfirst($schedule->schedule_category) }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Due:</span> 
                                    {{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Status:</span>
                                    <span class="px-2 py-1 rounded-full text-xs
                                        @if($schedule->status == 'completed')
                                            bg-green-200 text-green-800
                                        @elseif($schedule->status == 'overdue')
                                            bg-red-200 text-red-800
                                        @else
                                            bg-yellow-200 text-yellow-800
                                        @endif">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </p>
                            </div>

                            <!-- Card Actions -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <button onclick="openModal('schedule-{{ $schedule->id }}')" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    View Details
                                </button>

                                <!-- Button Edit -->
                                @if ($schedule->collaborators->where('id', Auth::id())->first()?->pivot->role == 'owner' ||
                                    $schedule->collaborators->where('id', Auth::id())->first()?->pivot->role == 'editor')
                                    <button onclick="openEditModal('edit-schedule-{{ $schedule->id }}')"
                                        class= "inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:border-yellow-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Edit
                                    </button>
                                @endif


                                <!--Button Delete -->
                                @if ($schedule->collaborators->where('id', Auth::id())->first()?->pivot->role == 'owner')
                                    <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal for each schedule -->
                    <div id="schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md @if($schedule->priority == 'very_important') bg-red-200 @elseif($schedule->priority == 'important') bg-blue-200 @else bg-green-200 @endif">
                            <div class="flex justify-between items-center pb-3">
                                <h3 class="text-xl font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">{{ $schedule->schedule_name }}</h3>
                                <button onclick="closeModal('schedule-{{ $schedule->id }}')" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Category</p>
                                        <p>{{ ucfirst($schedule->schedule_category) }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Priority</p>
                                        <p>{{ ucfirst(str_replace('_', ' ', $schedule->priority)) }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Start Date</p>
                                        <p>{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Due Date</p>
                                        <p>{{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Reminder</p>
                                        <p>{{ \Carbon\Carbon::parse($schedule->before_due_schedule)->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Status</p>
                                        <p>{{ ucfirst($schedule->status) }}</p>
                                    </div>
                                </div>

                                @if($schedule->description)
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Description</p>
                                        <p class="mt-1">{{ $schedule->description }}</p>
                                    </div>
                                @endif

                                @if($schedule->url)
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">URL</p>
                                        <a href="{{ $schedule->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $schedule->url }}</a>
                                    </div>
                                @endif

                                @if($schedule->upload_file)
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Attached File</p>
                                        <a href="{{ Storage::url($schedule->upload_file) }}" target="_blank" 
                                            class="text-blue-600 hover:underline">
                                            Download File
                                        </a>
                                    </div>
                                @endif

                                @if($schedule->collaborators->count() > 0)
                                    <div>
                                        <p class="font-semibold @if($schedule->priority == 'very_important') text-red-700 @elseif($schedule->priority == 'important') text-blue-700 @else text-green-700 @endif">Collaborators</p>
                                        <div class="mt-2 space-y-2">
                                            @foreach($schedule->collaborators as $collaborator)
                                                <div class="flex items-center space-x-2">
                                                    <span>{{ $collaborator->name }}</span>
                                                    <span class="text-xs px-2 py-1 rounded-full bg-gray-200">
                                                        {{ ucfirst($collaborator->pivot->role) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal for each schedule -->
                    @if($schedule->collaborators->where('id', Auth::id())->first()?->pivot->role === 'owner' || 
                    $schedule->collaborators->where('id', Auth::id())->first()?->pivot->role === 'editor')
                    <div id="edit-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                            <div class="flex justify-between items-center pb-3">
                                <h3 class="text-xl font-semibold text-gray-900">Edit Schedule</h3>
                                <button onclick="closeModal('edit-schedule-{{ $schedule->id }}')" class="text-gray-500 hover:text-gray-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Schedule Name</label>
                                        <input type="text" name="schedule_name" value="{{ $schedule->schedule_name }}" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="schedule_category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="task" {{ $schedule->schedule_category === 'task' ? 'selected' : '' }}>Task</option>
                                            <option value="activities" {{ $schedule->schedule_category === 'activities' ? 'selected' : '' }}>Activities</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Priority</label>
                                        <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="very_important" {{ $schedule->priority === 'very_important' ? 'selected' : '' }}>Very Important</option>
                                            <option value="important" {{ $schedule->priority === 'important' ? 'selected' : '' }}>Important</option>
                                            <option value="not_important" {{ $schedule->priority === 'not_important' ? 'selected' : '' }}>Not Important</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                        <input type="datetime-local" name="start_schedule" value="{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('Y-m-d\TH:i') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                        <input type="datetime-local" name="due_schedule" value="{{ \Carbon\Carbon::parse($schedule->due_schedule)->format('Y-m-d\TH:i') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Reminder</label>
                                        <input type="datetime-local" name="before_due_schedule" value="{{ \Carbon\Carbon::parse($schedule->before_due_schedule)->format('Y-m-d\TH:i') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" rows="3" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $schedule->description }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">URL</label>
                                        <input type="url" name="url" value="{{ $schedule->url }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Upload File</label>
                                        <input type="file" name="upload_file"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @if($schedule->upload_file)
                                            <p class="mt-2 text-sm text-gray-500">Current file: {{ basename($schedule->upload_file) }}</p>
                                        @endif
                                    </div>

                                    <div class="flex justify-end space-x-2 pt-4">
                                        <button type="button" onclick="closeModal('edit-schedule-{{ $schedule->id }}')"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            Update Schedule
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        // New alert functions
        function closeAlert(alertId) {
            document.getElementById(alertId).remove();
        }

        // Auto close alert after 5 seconds
        @if(session('success'))
            setTimeout(function() {
                const alert = document.getElementById('alert-success');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        @endif

        function openEditModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

        // Update the window.onclick handler to handle both modals
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                document.body.style.overflow = 'auto';
                }
            }
    </script>
</x-app-layout>

<x-footer></x-footer>