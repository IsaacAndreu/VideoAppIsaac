{{-- resources/views/series/show.blade.php --}}
<x-videos-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                {{ $serie->title }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('series.index') }}"
                   class="text-blue-600 hover:underline">
                    ← Totes les Sèries
                </a>
                @can('update', $serie)
                    <a href="{{ route('series.manage.edit', $serie) }}"
                       class="text-blue-600 hover:underline">
                        ✏️ Editar
                    </a>
                @endcan
                @can('delete', $serie)
                    <form action="{{ route('series.manage.destroy', $serie) }}"
                          method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:underline">
                            🗑️ Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        {{-- Imatge --}}
        @if($serie->image)
            <div class="rounded-lg overflow-hidden">
                <img src="{{ Storage::url($serie->image) }}"
                     alt="{{ $serie->title }}"
                     class="w-full object-cover"/>
            </div>
        @endif

        {{-- Descripció --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-2">Descripció</h3>
            <p class="text-gray-700">{{ $serie->description }}</p>
        </div>

        {{-- Autor i data --}}
        <div class="flex items-center space-x-4 text-gray-500">
            @if($serie->user_photo_url)
                <img src="{{ $serie->user_photo_url }}"
                     alt="{{ $serie->user_name }}"
                     class="h-10 w-10 rounded-full object-cover"/>
            @endif
            <div>
                <p class="text-sm">Creat per {{ $serie->user_name }}</p>
                @if($serie->published_at)
                    <p class="text-sm">
                        Publicada el {{ $serie->published_at->format('d/m/Y') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Afegir vídeo a la sèrie --}}
        @can('create', App\Models\Video::class)
            <div class="flex justify-end">
                <x-button href="{{ route('videos.manage.create', ['series_id' => $serie->id]) }}">
                    ➕ Afegir Vídeo
                </x-button>
            </div>
        @endcan

        {{-- Llista de vídeos --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Vídeos de la sèrie</h3>

            @if($serie->videos->isEmpty())
                <p class="text-gray-500">Encara no hi ha vídeos.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($serie->videos as $video)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <a href="{{ route('videos.show', $video) }}"
                                   class="text-blue-600 hover:underline text-lg">
                                    {{ $video->title }}
                                </a>
                                <p class="text-gray-500 text-sm">
                                    Publicat per {{ $video->user->name ?? '–' }}
                                    el {{ $video->published_at?->format('d/m/Y') ?? '–' }}
                                </p>
                            </div>
                            @can('update', $video)
                                <a href="{{ route('videos.manage.edit', $video) }}"
                                   class="text-gray-600 hover:underline">
                                    ✏️
                                </a>
                            @endcan
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</x-videos-app-layout>
