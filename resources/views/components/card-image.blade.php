@props(['image' => null, 'title' => '', 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white shadow-md rounded-lg overflow-hidden flex flex-col']) }}>
    @if ($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-40 object-cover">
    @else
        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
            Sense imatge
        </div>
    @endif

    <div class="p-4 flex flex-col flex-1">
        <h2 class="text-lg font-semibold mb-1">{{ $title }}</h2>
        <div class="text-gray-600 text-sm flex-1">
            {{ $slot }}
        </div>

        @if ($footer)
            <div class="mt-4">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
