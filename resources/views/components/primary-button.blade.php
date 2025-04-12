<button {{ $attributes->merge(['type' => 'submit', 'class' => 'iinline-flex items-center justify-center w-full px-4 py-4 text-base font-semibold text-white bg-blue-600 border border-transparent rounded-md focus:outline-none hover:opacity-80 focus:opacity-80']) }}>
    {{ $slot }}
</button>
