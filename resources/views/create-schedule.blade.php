<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('user.store-schedule') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="schedule_name" class="block text-sm font-medium text-blue-700 mb-2">Schedule Name</label>
                                <input type="text" name="schedule_name" id="schedule_name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('schedule_name') }}" @error('schedule_name') is-invalid @enderror>
                                @error('schedule_name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-blue-700 mb-2">Schedule Category</label>
                                <select name="category_id" id="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->schedule_category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div>
                                <label for="priority" class="block text-sm font-medium text-blue-700 mb-2">Priority</label>
                                <select name="priority" id="priority" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select Priority</option>
                                    <option value="very_important" {{ old('priority') == 'very_important' ? 'selected' : '' }}>Very Important</option>
                                    <option value="important" {{ old('priority') == 'important' ? 'selected' : '' }}>Important</option>
                                    <option value="not_important" {{ old('priority') == 'not_important' ? 'selected' : '' }}>Not Important</option>
                                </select>
                                @error('priority')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <!-- Schedule Dates Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Schedule Dates</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="start_schedule" class="block text-sm font-medium text-blue-700 mb-2">Start Schedule</label>
                                <input type="datetime-local" name="start_schedule" id="start_schedule" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('start_schedule') }}" 
                                    min="{{ date('Y-m-d\TH:i') }}"
                                    @error('start_schedule') is-invalid @enderror>
                                @error('start_schedule')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div>
                                <label for="due_schedule" class="block text-sm font-medium text-blue-700 mb-2">Due Schedule</label>
                                <input type="datetime-local" name="due_schedule" id="due_schedule" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('due_schedule') }}" @error('due_schedule') is-invalid @enderror>
                                @error('due_schedule')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <div>
                                <label for="before_due_schedule" class="block text-sm font-medium text-blue-700 mb-2">Reminder Before Due</label>
                                <input type="datetime-local" name="before_due_schedule" id="before_due_schedule" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('before_due_schedule') }}" @error('before_due_schedule') is-invalid @enderror>
                                @error('before_due_schedule')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <!-- Additional Information Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Additional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="upload_file" class="block text-sm font-medium text-blue-700 mb-2">Upload File</label>
                                <input type="file" name="upload_file" id="upload_file" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
    
                            <div>
                                <label for="url" class="block text-sm font-medium text-blue-700 mb-2">URL</label>
                                <input type="url" name="url" id="url" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('url') }}">
                            </div>
    
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-blue-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
    
                    <!-- Collaborators Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Collaborators</h3>
                        <div id="collaborator-list" class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <select name="collaborators[0][user_id]" 
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <select name="collaborators[0][role]" 
                                    class="w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select Role</option>
                                    <option value="viewer">Viewer</option>
                                    <option value="editor">Editor</option>
                                </select>
                                <button type="button" onclick="removeCollaborator(this)" 
                                    class="text-red-600 hover:text-red-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" onclick="addCollaborator()" 
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Collaborator
                        </button>
                    </div>
    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        let collaboratorCount = 1;
        
        function addCollaborator() {
            const container = document.getElementById('collaborator-list');
            const newCollaborator = document.createElement('div');
            newCollaborator.className = 'flex items-center space-x-4';
            
            newCollaborator.innerHTML = `
                <select name="collaborators[${collaboratorCount}][user_id]" 
                    class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <select name="collaborators[${collaboratorCount}][role]" 
                    class="w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Role</option>
                    <option value="viewer">Viewer</option>
                    <option value="editor">Editor</option>
                </select>
                <button type="button" onclick="removeCollaborator(this)" 
                    class="text-red-600 hover:text-red-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            
            container.appendChild(newCollaborator);
            collaboratorCount++;
        }
        
        function removeCollaborator(button) {
            const collaboratorDiv = button.parentElement;
            if (document.getElementById('collaborator-list').children.length > 1) {
                collaboratorDiv.remove();
            }
        }

        // Set minimum date for start schedule
        document.addEventListener('DOMContentLoaded', function() {
            const startScheduleInput = document.getElementById('start_schedule');
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            startScheduleInput.min = now.toISOString().slice(0,16);
            
            // Update min attribute every minute to keep it current
            setInterval(() => {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                startScheduleInput.min = now.toISOString().slice(0,16);
            }, 60000);
        });
    </script>
</x-app-layout>

<x-footer></x-footer>