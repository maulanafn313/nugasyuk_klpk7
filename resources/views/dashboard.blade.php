<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quote Card -->
            <div class="mb-8">
                <x-card title="Daily Quote" color="purple">
                    <x-quote-carousel />
                </x-card>
            </div>

            <!-- Schedule Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-card 
                    title="To Do" 
                    :count="$scheduleCounts['to-do']" 
                    color="blue" 
                    icon="📋" 
                    link="{{ route('user.view-schedule', ['status' => 'to-do']) }}"
                />
                <x-card 
                    title="In Progress" 
                    :count="$scheduleCounts['processed']" 
                    color="yellow" 
                    icon="🔄" 
                    link="{{ route('user.view-schedule', ['status' => 'processed']) }}"
                />
                <x-card 
                    title="Done" 
                    :count="$scheduleCounts['done']" 
                    color="green" 
                    icon="✅" 
                    link="{{ route('user.view-schedule', ['status' => 'completed']) }}"
                />
                <x-card 
                    title="Late" 
                    :count="$scheduleCounts['overdue']" 
                    color="red" 
                    icon="⚠️" 
                    link="{{ route('user.view-schedule', ['status' => 'overdue']) }}"
                />
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card title="Create New Schedule" color="indigo">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div class="flex justify-center mt-5">
                            <x-picture-student-do-task class="w-48 h-48 object-contain rounded-xl shadow-sm" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <p class="text-gray-600 mb-3 text-sm">Create a new schedule to manage your tasks and activities.</p>
                            <a href="{{ route('user.create-schedule') }}" class="inline-flex items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Create Schedule
                            </a>
                        </div>
                    </div>
                </x-card>

                <x-card title="View All Schedules" color="teal">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div class="flex justify-center mt-5">
                            <x-picture-student-review-task class="w-48 h-48 object-contain rounded-xl shadow-sm" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <p class="text-gray-600 mb-3 text-sm">View and manage all your schedules in one place.</p>
                            <a href="{{ route('user.view-schedule') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700">
                                View Schedules
                            </a>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-app-layout>

<x-footer />