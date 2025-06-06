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
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if (count($schedules) == 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900">No Schedules Found</h3>
                            <p class="mt-2 text-gray-600">You have no schedules at the moment.</p>
                        </div>
                @else
                    @foreach($schedules as $schedule)
                        <div class="overflow-hidden rounded-lg shadow-lg border
                            @if($schedule->priority == 'very_important') bg-red-100 border-red-400
                            @elseif($schedule->priority == 'important') bg-blue-300 border-blue-500
                            @else bg-green-100 border-green-400 @endif"
                            @if($schedule->status == 'completed') hidden @endif>
                            <div class="px-6 py-4">
                                <!-- Card Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-lg
                                        @if($schedule->priority == 'very_important') text-red-700
                                        @elseif($schedule->priority == 'important') text-blue-700
                                        @else text-green-700 @endif">
                                        {{ $schedule->schedule_name }}
                                    </h3>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($schedule->priority == 'very_important') bg-red-200 text-red-800
                                        @elseif($schedule->priority == 'important') bg-blue-400 text-blue-800
                                        @else bg-green-200 text-green-800 @endif">
                                        {{ ucfirst(str_replace('_',' ',$schedule->priority)) }}
                                    </span>
                                </div>

                                <!-- Card Content -->
                                <div class="space-y-2 text-gray-600">
                                    <p><span class="font-semibold
                                        @if($schedule->priority == 'very_important') text-red-700
                                        @elseif($schedule->priority == 'important') text-blue-700
                                        @else text-green-700 @endif">Category:</span>
                                        {{ ucfirst($schedule->category->schedule_category) }}</p>
                                    <p><span class="font-semibold
                                        @if($schedule->priority == 'very_important') text-red-700
                                        @elseif($schedule->priority == 'important') text-blue-700
                                        @else text-green-700 @endif">Due:</span>
                                        {{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}</p>
                                    <p><span class="font-semibold
                                        @if($schedule->priority == 'very_important') text-red-700
                                        @elseif($schedule->priority == 'important') text-blue-700
                                        @else text-green-700 @endif">Status:</span>
                                        <span class="px-2 py-1 rounded-full text-xs
                                            @if($schedule->status == 'completed') bg-green-200 text-green-800
                                            @elseif($schedule->status == 'overdue') bg-red-200 text-red-800
                                            @elseif($schedule->isNearDeadline()) bg-orange-200 text-orange-800
                                            @elseif($schedule->status == 'processed') bg-yellow-200 text-yellow-800
                                            @else bg-gray-200 text-gray-800 @endif">
                                            {{ $schedule->getStatusLabel() }}</span>
                                    </p>
                                </div>

                                <!-- Card Actions -->
                                <div class="mt-4 flex justify-between items-center">
                                    <!-- Left: Owner/Editor Actions -->
                                    <div class="flex space-x-2">
                                        @php $role = $schedule->collaborators->where('id', Auth::id())->first()?->pivot->role; @endphp

                                        {{-- Mark as Done (owner only) --}}
                                        @if($role === 'owner')
                                            <button onclick="openModal('complete-schedule-{{ $schedule->id }}')"
                                                class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                                Mark as Done
                                            </button>
                                        @endif

                                        {{-- Edit (owner & editor) --}}
                                        @if(in_array($role, ['owner','editor']))
                                            <button onclick="openModal('edit-schedule-{{ $schedule->id }}')"
                                                class="px-3 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-700">
                                                Edit
                                            </button>
                                        @endif

                                        {{-- Delete (owner only) --}}
                                        @if($role === 'owner')
                                            <button onclick="openModal('delete-schedule-{{ $schedule->id }}')"
                                                class="px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                                Delete
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Right: View Details -->
                                    <button onclick="openModal('schedule-{{ $schedule->id }}')"
                                        class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- View Details Modal --}}
                        <div id="schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md @if($schedule->priority == 'very_important') bg-red-100 border-red-400 @elseif($schedule->priority == 'important') bg-blue-300 border-blue-500 @else bg-green-200 border-green-400 @endif">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Schedule Details</h3>
                                    <button onclick="closeModal('schedule-{{ $schedule->id }}')" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="font-semibold text-sm">Schedule Name</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ $schedule->schedule_name }}</div>
                                    </div>
                                    
                                    <div>
                                        <label class="font-semibold text-sm">Category</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            {{ ucfirst($schedule->category->schedule_category) }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Priority</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ ucfirst(str_replace('_', ' ', $schedule->priority)) }}</div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Start Date</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            {{ \Carbon\Carbon::parse($schedule->start_schedule)->format('d M Y, H:i') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Due Date</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            {{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Reminder Before Due</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            {{ \Carbon\Carbon::parse($schedule->before_due_schedule)->format('d M Y, H:i') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Status</label>
                                        <div class="mt-1 px-3 py-2 
                                            @if($schedule->status == 'completed') 
                                                bg-green-200 text-green-800
                                            @elseif($schedule->status == 'overdue') 
                                                bg-red-200 text-red-800
                                            @elseif($schedule->status == 'processed' && $schedule->isNearDeadline()) 
                                                bg-orange-200 text-orange-800
                                            @elseif($schedule->status == 'processed') 
                                                bg-blue-200 text-blue-800
                                            @else 
                                                bg-gray-200 text-gray-800 
                                            @endif 
                                            rounded-md">
                                            {{ $schedule->getStatusLabel() }}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="font-semibold text-sm">Description</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ $schedule->description }}</div>
                                    </div>

                                    @if($schedule->url)
                                    <div>
                                        <label class="font-semibold text-sm">URL</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            <a href="{{ $schedule->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $schedule->url }}</a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($schedule->upload_file)
                                    <div>
                                        <label class="font-semibold text-sm">Attached File</label>
                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">
                                            <a href="{{ asset('storage/' . $schedule->upload_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                Download File
                                            </a>
                                        </div>
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

                        {{-- Edit Modal --}}
                        <div id="edit-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Edit Schedule</h3>
                                    <button onclick="closeModal('edit-schedule-{{ $schedule->id }}')" class="text-gray-400 hover:text-gray-500">
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
                                            <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $schedule->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->schedule_category }}
                                                    </option>
                                                @endforeach
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
                                            <input type="datetime-local" name="start_schedule" 
                                                value="{{ \Carbon\Carbon::parse($schedule->start_schedule)->format('Y-m-d\TH:i') }}"
                                                min="{{ date('Y-m-d\TH:i') }}"
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

                        {{-- Delete Confirmation Modal --}}
                        <div id="delete-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3 text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Schedule</h3>
                                    <div class="mt-2 px-7 py-3">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to delete this schedule? This action cannot be undone.
                                        </p>
                                    </div>
                                    <div class="flex justify-center space-x-4 mt-5">
                                        <button type="button" onclick="closeModal('delete-schedule-{{ $schedule->id }}')"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <form action="{{ route('schedule.destroy', $schedule) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Mark as Done Confirmation Modal --}}
                        <div id="complete-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3 text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Mark as Complete</h3>
                                    <div class="mt-2 px-7 py-3">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to mark this schedule as complete?
                                        </p>
                                    </div>
                                    <div class="flex justify-center space-x-4 mt-5">
                                        <button type="button" onclick="closeModal('complete-schedule-{{ $schedule->id }}')"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <form action="{{ route('schedule.complete', $schedule) }}" method="POST" >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                                Complete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function closeAlert(id) {
            document.getElementById(id)?.remove();
        }

        // New script for date validation
        document.addEventListener('DOMContentLoaded', function() {
            // Function to update min datetime for all edit modals
            function updateMinDateTime() {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                const minDateTime = now.toISOString().slice(0,16);

                // Update all start_schedule inputs in edit modals
                document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
                    // Only update min if the schedule hasn't started yet
                    const currentValue = new Date(input.value);
                    if (currentValue > now) {
                        input.min = minDateTime;
                    }
                });
            }

            // Initial update
            updateMinDateTime();

            // Update every minute
            setInterval(updateMinDateTime, 60000);
        });

        // Auto-close alert
        @if(session('success'))
            setTimeout(() => closeAlert('alert-success'), 5000);
        @endif
    </script>
</x-app-layout>

<x-footer></x-footer>
