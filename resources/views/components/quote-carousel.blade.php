@props(['quotes' => [
    [
        'text' => "The only way to do great work is to love what you do.",
        'author' => "Steve Jobs"
    ],
    [
        'text' => "Success is not final, failure is not fatal: it is the courage to continue that counts.",
        'author' => "Winston Churchill"
    ],
    [
        'text' => "The future belongs to those who believe in the beauty of their dreams.",
        'author' => "Eleanor Roosevelt"
    ],
    [
        'text' => "Don't watch the clock; do what it does. Keep going.",
        'author' => "Sam Levenson"
    ],
    [
        'text' => "The only limit to our realization of tomorrow is our doubts of today.",
        'author' => "Franklin D. Roosevelt"
    ]
]])

<div x-data="{ 
    currentQuote: 0,
    quotes: {{ json_encode($quotes) }},
    init() {
        setInterval(() => {
            this.currentQuote = (this.currentQuote + 1) % this.quotes.length;
        }, 5000);
    }
}" class="relative">
    <div class="overflow-hidden">
        <div x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-full"
                class="flex flex-col items-center text-center">
            <p class="text-gray-600 italic text-lg mb-2" x-text="quotes[currentQuote].text"></p>
            <p class="text-gray-500" x-text="'- ' + quotes[currentQuote].author"></p>
        </div>
    </div>
    
    <!-- Quote Indicators -->
    <div class="flex justify-center mt-4">
        <template x-for="(quote, index) in quotes" :key="index">
            <button @click="currentQuote = index" 
                    class="w-2 h-2 mx-1 rounded-full transition-colors duration-300"
                    :class="currentQuote === index ? 'bg-blue-400' : 'bg-gray-300'">
            </button>
        </template>
    </div>
</div> 