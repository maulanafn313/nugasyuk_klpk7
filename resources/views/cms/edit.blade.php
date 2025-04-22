<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit CMS') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.cms.update', $cms->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <!-- Color -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Color</h3>
                        <div>
                            <label for="color" class="block text-sm font-medium text-blue-700 mb-2">Color</label>
                            <input type="text" name="color" id="color"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('color', $cms->color) }}">
                            @error('color')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <!-- Logo Upload -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Logo Upload</h3>
                        <div>
                            <label for="logo" class="block text-sm font-medium text-blue-700 mb-2">Upload Logo</label>
                            <input type="file" name="logo" id="logo"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*">
                            @error('logo')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($cms->logo)
                        <div class="mt-4">
                            <img src="{{ asset('storage/cms/' . $cms->logo) }}" alt="Current Logo" class="w-32 h-32 object-cover">
                        </div>
                        @endif
                    </div>


                    <!-- Hero Text and Description 1 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Hero Text and Description 1</h3>
                        <div>
                            <label for="hero_text" class="block text-sm font-medium text-blue-700 mb-2">Hero Text 1</label>
                            <input type="text" name="hero_text" id="hero_text"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('hero_text', $cms->hero_text) }}">
                            @error('hero_text')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="description_text" class="block text-sm font-medium text-blue-700 mb-2">Description 1</label>
                            <textarea name="description_text" id="description_text" rows="4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description_text', $cms->description_text) }}</textarea>
                            @error('description_text')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <!-- Hero Text and Description 2 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Hero Text and Description 2</h3>
                        <div>
                            <label for="hero_text2" class="block text-sm font-medium text-blue-700 mb-2">Hero Text 2</label>
                            <input type="text" name="hero_text2" id="hero_text2"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('hero_text2', $cms->hero_text2) }}">
                            @error('hero_text2')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="description_text2" class="block text-sm font-medium text-blue-700 mb-2">Description 2</label>
                            <textarea name="description_text2" id="description_text2" rows="4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description_text2', $cms->description_text2) }}</textarea>
                            @error('description_text2')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="img_text2" class="block text-sm font-medium text-blue-700 mb-2">Image 2</label>
                            <input type="file" name="img_text2" id="img_text2"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*">
                            @error('img_text2')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($cms->img_text2)
                        <div class="mt-4">
                            <img src="{{ asset('storage/cms/' . $cms->img_text2) }}" alt="Current Image 2" class="w-32 h-32 object-cover">
                        </div>
                        @endif
                    </div>


                    <!-- Hero Text and Description 3 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Hero Text and Description 3</h3>
                        <div>
                            <label for="hero_text3" class="block text-sm font-medium text-blue-700 mb-2">Hero Text 3</label>
                            <input type="text" name="hero_text3" id="hero_text3"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('hero_text3', $cms->hero_text3) }}">
                            @error('hero_text3')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="description_text3" class="block text-sm font-medium text-blue-700 mb-2">Description 3</label>
                            <textarea name="description_text3" id="description_text3" rows="4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description_text3', $cms->description_text3) }}</textarea>
                            @error('description_text3')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="img_text3" class="block text-sm font-medium text-blue-700 mb-2">Image 3</label>
                            <input type="file" name="img_text3" id="img_text3"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*">
                            @error('img_text3')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($cms->img_text3)
                        <div class="mt-4">
                            <img src="{{ asset('storage/cms/' . $cms->img_text3) }}" alt="Current Image 3" class="w-32 h-32 object-cover">
                        </div>
                        @endif
                    </div>
                    <!-- Hero Text and Description 4 -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">Hero Text and Description 4</h3>
                        <div>
                            <label for="hero_text4" class="block text-sm font-medium text-blue-700 mb-2">Hero Text 4</label>
                            <input type="text" name="hero_text4" id="hero_text4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                value="{{ old('hero_text4', $cms->hero_text4) }}">
                            @error('hero_text4')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="description_text4" class="block text-sm font-medium text-blue-700 mb-2">Description 4</label>
                            <textarea name="description_text4" id="description_text4" rows="4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description_text4', $cms->description_text3) }}</textarea>
                            @error('description_text4')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <label for="img_text4" class="block text-sm font-medium text-blue-700 mb-2">Image 4</label>
                            <input type="file" name="img_text4" id="img_text4"
                                class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                accept="image/*">
                            @error('img_text4')
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @if ($cms->img_text4)
                        <div class="mt-4">
                            <img src="{{ asset('storage/cms/' . $cms->img_text4) }}" alt="Current Image 3" class="w-32 h-32 object-cover">
                        </div>
                        @endif
                    </div>


                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update CMS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<x-footer></x-footer>






