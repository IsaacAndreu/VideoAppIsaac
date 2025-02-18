<x-videos-app-layout>
    <x-slot:title>
        {{ $video->title }}
    </x-slot:title>

    <div class="max-w-4xl mx-auto py-8">
        <article class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $video->title }}</h1>

            <p class="text-gray-600 mb-6">{{ $video->description }}</p>

            <div class="mb-4">
                <strong class="text-gray-700">Publicat el:</strong> <span>{{ $video->formatted_published_at }}</span>
            </div>

            <div class="mb-6">
                <iframe width="560" height="315"
                        src="{{ str_replace('watch?v=', 'embed/', $video->url) }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        allowfullscreen>
                </iframe>
            </div>

            @if($video->previous)
                <div class="mb-4">
                    <a href="{{ route('videos.show', $video->previous) }}" class="text-blue-500 underline">&larr; Vídeo anterior</a>
                </div>
            @endif

            @if($video->next)
                <div>
                    <a href="{{ route('videos.show', $video->next) }}" class="text-blue-500 underline">Vídeo següent &rarr;</a>
                </div>
            @endif
        </article>
    </div>
</x-videos-app-layout>
