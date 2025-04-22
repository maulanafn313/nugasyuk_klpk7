<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Facility') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.facilities.update', $facility->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Image Upload</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="img" class="block text-sm font-medium text-blue-700 mb-2">Upload Image</label>
                                <input type="file" name="img" id="img"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    accept="image/*">
                                @error('img')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <div>
                                <label for="title" class="block text-sm font-medium text-blue-700 mb-2">Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('title', $facility->title) }}">
                                @error('title')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-blue-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $facility->description) }}</textarea>
                                @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Facility
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>


<x-footer></x-footer>


