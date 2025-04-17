@props(['title', 'count' => null, 'color' => 'blue', 'icon' => null, 'link' => null])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-{{ $color }}-900">{{ $title }}</h3>
            @if($count !== null)
                <p class="text-3xl font-bold text-{{ $color }}-600 mt-2">{{ $count }}</p>
            @endif
        </div>
        @if($icon)
            <div class="text-{{ $color }}-500 text-2xl">
                {!! $icon !!}
            </div>
        @endif
    </div>
    
    @if($link)
        <div class="mt-4">
            <a href="{{ $link }}" class="text-{{ $color }}-600 hover:text-{{ $color }}-800 font-medium">
                View Details →
            </a>
        </div>
    @endif
    
    {{ $slot }}
</div> 