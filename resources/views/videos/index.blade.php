<x-videos-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <h1 class="text-2xl font-bold">Llista de Vídeos</h1>

            @auth
                <x-link-button href="{{ route('videos.manage.create') }}">
                    ➕ Crear nou vídeo
                </x-link-button>
            @endauth
        </div>

        @if ($videos->isEmpty())
            <p class="text-gray-600">No hi ha vídeos disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($videos as $video)
                    <x-card :title="$video->title">
                        {{-- Vídeo embedit --}}
                        <div class="aspect-video bg-gray-200 mb-4 rounded overflow-hidden">
                            <iframe
                                src="{{ $video->url }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="w-full h-full"
                            ></iframe>
                        </div>

                        <p class="text-gray-600 mb-4">{{ Str::limit($video->description, 80) }}</p>

                        <x-slot name="footer">
                            <x-link-button href="{{ route('videos.show', $video->id) }}" color="blue" class="mb-2 inline-block">
                                👁️ Veure vídeo
                            </x-link-button>

                            @auth
                                <div class="flex gap-2">
                                    <x-link-button href="{{ route('videos.manage.edit', $video->id) }}" color="green">
                                        ✏️ Editar
                                    </x-link-button>

                                    <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest vídeo?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" color="red">
                                            🗑️ Eliminar
                                        </x-button>
                                    </form>
                                </div>
                            @endauth
                        </x-slot>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</x-videos-app-layout>
