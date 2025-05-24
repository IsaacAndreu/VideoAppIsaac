<x-app-layout>
    <x-slot:title>
        {{ $video->title }}
    </x-slot:title>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <article class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <header>
                <h1 class="text-3xl font-bold text-primary mb-2">{{ $video->title }}</h1>
                <p class="text-gray-600 text-base">{{ $video->description }}</p>
            </header>

            <div>
                <p class="text-sm text-gray-500">
                    <strong class="text-gray-700">📅 Publicat el:</strong> {{ $video->formatted_published_at }}
                </p>
            </div>

            <div class="aspect-video rounded overflow-hidden shadow transition">
                <iframe
                    src="{{ str_replace('watch?v=', 'embed/', $video->url) }}"
                    title="{{ $video->title }}"
                    frameborder="0"
                    allowfullscreen
                    class="w-full h-full"
                ></iframe>
            </div>

            <footer class="flex justify-between items-center pt-4 border-t">
                @if($video->previous)
                    <x-link-button href="{{ route('videos.show', $video->previous) }}" color="gray">
                        &larr; Vídeo anterior
                    </x-link-button>
                @else
                    <span></span>
                @endif

                @if($video->next)
                    <x-link-button href="{{ route('videos.show', $video->next) }}" color="gray">
                        Vídeo següent &rarr;
                    </x-link-button>
                @endif
            </footer>
        </article>
    </div>
</x-app-layout>
