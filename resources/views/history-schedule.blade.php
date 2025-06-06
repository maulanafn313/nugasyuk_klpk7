<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Success -->
            @if(session('success'))
                <div id="alert-success" class="mb-4">
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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto mb-10">
                        <h3 class="font-bold text-lg mb-2">Your Completed Schedules</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Schedule Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Priority
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Completion Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Completed At
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if($ownedSchedules->isEmpty())
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No completed schedules found.
                                        </td>
                                    </tr>
                                @else
                                    @foreach($ownedSchedules as $schedule)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $schedule->schedule_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ ucfirst($schedule->category->schedule_category) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($schedule->priority == 'very_important') bg-red-100 text-red-800
                                                    @elseif($schedule->priority == 'important') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $schedule->priority)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $schedule->completed_at <= $schedule->due_schedule ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $schedule->completed_at <= $schedule->due_schedule ? 'On Time' : 'Late' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($schedule->completed_at)->format('d M Y, H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="openModal('detail-schedule-{{ $schedule->id }}')" 
                                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Detail
                                                </button>
                                                <button onclick="openModal('delete-schedule-{{ $schedule->id }}')"
                                                    class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Detail Modal -->
                                        <div id="detail-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-semibold text-gray-900">Schedule Details</h3>
                                                    <button onclick="closeModal('detail-schedule-{{ $schedule->id }}')" class="text-gray-400 hover:text-gray-500">
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
                                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ ucfirst($schedule->category->schedule_category) }}</div>
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
                                                        <label class="font-semibold text-sm">Description</label>
                                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ $schedule->description ?? 'No description' }}</div>
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
                                                            <a href="{{ Storage::url($schedule->upload_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                                Download File
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="delete-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                                <div class="mt-3 text-center">
                                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Schedule History</h3>
                                                    <div class="mt-2 px-7 py-3">
                                                        <p class="text-sm text-gray-500">
                                                            Are you sure you want to delete this schedule history? This action can be undone by an administrator.
                                                        </p>
                                                    </div>
                                                    <div class="flex justify-center space-x-4 mt-5">
                                                        <button type="button" onclick="closeModal('delete-schedule-{{ $schedule->id }}')"
                                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('history.destroy', $schedule) }}" method="POST">
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
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="overflow-x-auto">
                        <h3 class="font-bold text-lg mb-2">Collaborator Schedules</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Schedule Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Priority
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Due Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Completion Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Completed At
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if($collabSchedules->isEmpty())
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No collaborator schedules found.
                                        </td>
                                    </tr>
                                @else
                                    @foreach($collabSchedules as $schedule)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $schedule->schedule_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ ucfirst($schedule->category->schedule_category) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($schedule->priority == 'very_important') bg-red-100 text-red-800
                                                    @elseif($schedule->priority == 'important') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $schedule->priority)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($schedule->due_schedule)->format('d M Y, H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $schedule->completed_at <= $schedule->due_schedule ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $schedule->completed_at <= $schedule->due_schedule ? 'On Time' : 'Late' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($schedule->completed_at)->format('d M Y, H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="openModal('detail-schedule-{{ $schedule->id }}')" 
                                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Detail
                                                </button>
                                                <button onclick="openModal('delete-schedule-{{ $schedule->id }}')"
                                                    class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Detail Modal -->
                                        <div id="detail-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-semibold text-gray-900">Schedule Details</h3>
                                                    <button onclick="closeModal('detail-schedule-{{ $schedule->id }}')" class="text-gray-400 hover:text-gray-500">
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
                                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ ucfirst($schedule->category->schedule_category) }}</div>
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
                                                        <label class="font-semibold text-sm">Description</label>
                                                        <div class="mt-1 px-3 py-2 bg-gray-50 rounded-md">{{ $schedule->description ?? 'No description' }}</div>
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
                                                            <a href="{{ Storage::url($schedule->upload_file) }}" target="_blank" class="text-blue-600 hover:underline">
                                                                Download File
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div id="delete-schedule-{{ $schedule->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                                <div class="mt-3 text-center">
                                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Schedule History</h3>
                                                    <div class="mt-2 px-7 py-3">
                                                        <p class="text-sm text-gray-500">
                                                            Are you sure you want to delete this schedule history? This action can be undone by an administrator.
                                                        </p>
                                                    </div>
                                                    <div class="flex justify-center space-x-4 mt-5">
                                                        <button type="button" onclick="closeModal('delete-schedule-{{ $schedule->id }}')"
                                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                                            Cancel
                                                        </button>
                                                        <form action="{{ route('history.destroy', $schedule) }}" method="POST">
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
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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

        // Auto-close alert
        @if(session('success'))
            setTimeout(() => closeAlert('alert-success'), 5000);
        @endif
    </script>
</x-app-layout>
<x-footer></x-footer>
