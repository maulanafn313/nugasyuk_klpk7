@props(['disabled' => false, 'placeholder' => ''])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full py-4 pl-10 pr-4 text-black placeholder-gray-500 transition-all duration-200 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white caret-blue-600', 'placeholder' => $placeholder ]) }}>
