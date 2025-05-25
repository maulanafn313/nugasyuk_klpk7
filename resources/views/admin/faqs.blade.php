<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Question FAQ') }}
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @if (count($faqs) === 0)
                <div class="bg-gray-50 rounded-lg p-6 shadow-md text-center">
                    <script
                    src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
                    type="module"
                    ></script>

                    <dotlottie-player
                    src="https://lottie.host/4611d93b-9bcd-4592-846e-3a8fe71023c4/vNvbYC2Ery.lottie"
                    background="transparent"
                    speed="1"
                    style="width: 300px; height: 300px"
                    loop
                    autoplay
                    class="mx-auto mb-4"
                    ></dotlottie-player>
                    <h3 class="text-xl font-semibold mb-3">Belum ada pertanyaan yang diajukan.</h3>
                    <p class="text-gray-500">Silakan tunggu hingga ada pertanyaan dari pengguna.</p>
                </div>
            @else
                @foreach ($faqs as $faq)
                    <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                        <h3 class="text-xl font-semibold mb-3">{{ $faq->question }}</h3>
                        <form action="{{ route('admin.faqs.answer', $faq) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="answer" class="block text-lg font-medium mb-2">Jawaban</label>
                                <textarea name="answer" id="answer" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm" required></textarea>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Kirim Jawaban</button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </x-slot>
</x-app-layout>
<x-footer></x-footer>