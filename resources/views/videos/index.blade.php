<x-app-layout>
    <h1 class="text-2xl font-bold">Llista de Vídeos</h1>

    @if ($videos->isEmpty())
        <p>No hi ha vídeos disponibles.</p>
    @else
        @foreach ($videos as $video)
            <div class="p-4 border-b">
                <h2 class="text-xl">{{ $video->title }}</h2>
                <p>{{ $video->description }}</p>
                <a href="{{ route('videos.show', $video->id) }}" class="text-blue-500">Veure vídeo</a>
            </div>
        @endforeach
    @endif
</x-app-layout>
