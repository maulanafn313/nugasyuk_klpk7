<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit FAQ') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.faqs.update', $faq->id) }}" method="post">
                    @csrf
                    @method('PUT')


                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-blue-700 mb-4">FAQ Details</h3>
                        <div class="grid grid-cols-1 gap-6">
                           
                            <div>
                                <label for="question" class="block text-sm font-medium text-blue-700 mb-2">Question</label>
                                <input type="text" name="question" id="question"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('question', $faq->question) }}">
                                @error('question')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <div>
                                <label for="answer" class="block text-sm font-medium text-blue-700 mb-2">Answer</label>
                                <textarea name="answer" id="answer" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('answer', $faq->answer) }}</textarea>
                                @error('answer')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>


<x-footer></x-footer>


