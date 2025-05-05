<x-videos-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Llista de Vídeos</h1>

        @auth
            <a href="{{ route('videos.manage.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                ➕ Crear nou vídeo
            </a>
        @endauth
    </div>

    @if ($videos->isEmpty())
        <p>No hi ha vídeos disponibles.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($videos as $video)
                <div class="border rounded-lg shadow-md p-4 bg-white flex flex-col">
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

                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('videos.show', $video->id) }}" class="text-blue-500 hover:underline">
                            👁️ Veure vídeo
                        </a>

                        @auth
                            <div class="flex gap-4">
                                <a href="{{ route('videos.manage.edit', $video->id) }}" class="text-green-600 hover:underline">
                                    ✏️ Editar
                                </a>

                                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest vídeo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-videos-app-layout>
