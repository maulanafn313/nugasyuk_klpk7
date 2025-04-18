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
                            <div class="mt-4 flex justify-end">
                                <button onclick="openModal('schedule-{{ $schedule->id }}')" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    View Details
                                </button>
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
    </script>
</x-app-layout>

<x-footer></x-footer>