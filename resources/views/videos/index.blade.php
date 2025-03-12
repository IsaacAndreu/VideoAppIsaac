<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Llista de Vídeos</h1>

    @if ($videos->isEmpty())
        <p>No hi ha vídeos disponibles.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($videos as $video)
                <div class="border rounded-lg shadow-md p-4 bg-white">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 mb-2">
                        <iframe
                            src="{{ $video->url }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="w-full h-full"
                        ></iframe>
                    </div>
                    <h2 class="text-lg font-semibold">{{ $video->title }}</h2>
                    <p class="text-gray-600">{{ Str::limit($video->description, 80) }}</p>
                    <a href="{{ route('videos.show', $video->id) }}" class="text-blue-500 mt-2 inline-block">Veure vídeo</a>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
