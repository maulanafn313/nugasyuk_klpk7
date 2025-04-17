<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Create New Schedule</h2>
                    
                    <form action="{{ route('user.store-schedule') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Schedule Name -->
                        <div>
                            <x-input-label for="schedule_name" :value="__('Schedule Name')" />
                            <x-text-input id="schedule_name" name="schedule_name" type="text" class="mt-1 block w-full" :value="old('schedule_name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('schedule_name')" />
                        </div>

                        <!-- Schedule Category -->
                        <div>
                            <x-input-label for="schedule_category" :value="__('Schedule Category')" />
                            <select id="schedule_category" name="schedule_category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <option value="task" {{ old('schedule_category') == 'task' ? 'selected' : '' }}>Task</option>
                                <option value="activities" {{ old('schedule_category') == 'activities' ? 'selected' : '' }}>Activities</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('schedule_category')" />
                        </div>

                        <!-- Priority -->
                        <div>
                            <x-input-label for="priority" :value="__('Priority')" />
                            <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Priority</option>
                                <option value="important" {{ old('priority') == 'important' ? 'selected' : '' }}>Important</option>
                                <option value="very important" {{ old('priority') == 'very important' ? 'selected' : '' }}>Very Important</option>
                                <option value="not important" {{ old('priority') == 'not important' ? 'selected' : '' }}>Not Important</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('priority')" />
                        </div>

                        <!-- Schedule Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="start_schedule" :value="__('Start Schedule')" />
                                <x-text-input id="start_schedule" name="start_schedule" type="datetime-local" class="mt-1 block w-full" :value="old('start_schedule')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('start_schedule')" />
                            </div>

                            <div>
                                <x-input-label for="due_schedule" :value="__('Due Schedule')" />
                                <x-text-input id="due_schedule" name="due_schedule" type="datetime-local" class="mt-1 block w-full" :value="old('due_schedule')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('due_schedule')" />
                            </div>

                            <div>
                                <x-input-label for="before_due_schedule" :value="__('Reminder Before Start')" />
                                <x-text-input id="before_due_schedule" name="before_due_schedule" type="datetime-local" class="mt-1 block w-full" :value="old('before_due_schedule')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('before_due_schedule')" />
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <x-input-label for="upload_file" :value="__('Upload File')" />
                            <x-text-input id="upload_file" name="upload_file" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('upload_file')" />
                        </div>

                        <!-- URL -->
                        <div>
                            <x-input-label for="url" :value="__('URL (Optional)')" />
                            <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url')" />
                            <x-input-error class="mt-2" :messages="$errors->get('url')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Collaborators -->
                        <div>
                            <x-input-label :value="__('Collaborators')" />
                            <div id="collaborators-container" class="space-y-4">
                                <div class="collaborator-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <select name="collaborators[0][user_id]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <select name="collaborators[0][role]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="editor">Editor</option>
                                            <option value="viewer">Viewer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addCollaborator()" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Add Collaborator
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Schedule') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let collaboratorCount = 1;
        
        function addCollaborator() {
            const container = document.getElementById('collaborators-container');
            const newEntry = document.createElement('div');
            newEntry.className = 'collaborator-entry grid grid-cols-1 md:grid-cols-2 gap-4 mt-4';
            newEntry.innerHTML = `
                <div>
                    <select name="collaborators[${collaboratorCount}][user_id]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="collaborators[${collaboratorCount}][role]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="editor">Editor</option>
                        <option value="viewer">Viewer</option>
                    </select>
                </div>
            `;
            container.appendChild(newEntry);
            collaboratorCount++;
        }
    </script>
</x-app-layout>

<x-footer></x-footer>
