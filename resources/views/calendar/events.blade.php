{{-- filepath: c:\laragon\www\nugasyuk_klpk7\resources\views\calendar\events.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Google Calendar') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-5">

        <!-- FullCalendar Container -->
        <div id="calendar" data-events="{{ json_encode($events) }}"></div>
    </div>
</x-app-layout>