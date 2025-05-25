<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FAQ') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold mb-6">Ask Question</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 font-medium text-gray-700">
            <p>
                if you have any questions, please fill out the form below. We will get back to you as soon as possible.
            </p>
        </div>

        <form action="{{ route('faq.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="question" class="block text-lg font-medium mb-2">Your Question</label>
                <textarea name="question" id="question" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>
                @error('question')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Submit</button>
        </form>
    </div>
</x-app-layout>
<x-footer></x-footer>