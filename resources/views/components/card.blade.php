@props(['title' => null, 'image' => null])

<div class="bg-white rounded shadow-md p-4 flex flex-col gap-3">
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-40 object-cover rounded">
    @endif

    @if($title)
        <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
    @endif

    <div class="text-gray-700 text-sm">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="mt-4">
            {{ $footer }}
        </div>
    @endisset
</div>
