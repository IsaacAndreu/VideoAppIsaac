{{-- resources/views/series/index.blade.php --}}
<x-videos-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Totes les Sèries
            </h2>

            @can('create', App\Models\Serie::class)
                <a href="{{ route('series.manage.create') }}">
                    <x-button color="primary" class="inline-flex items-center space-x-2">
                        <span>➕</span>
                        <span>Nova Sèrie</span>
                    </x-button>
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Formulari de cerca --}}
        <form method="GET" action="{{ route('series.index') }}" class="mb-6 flex flex-col sm:flex-row gap-2">
            <input
                type="text"
                name="search"
                placeholder="Cerca una sèrie…"
                value="{{ request('search') }}"
                class="w-full sm:w-1/3 border-gray-300 rounded-md px-3 py-2 text-base"
            />

            {{-- Botó manual per garantir text + icona --}}
            <button
                type="submit"
                class="inline-flex items-center space-x-2 px-4 py-2 border border-transparent rounded-md font-semibold
                       bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-white"
            >
                <span>🔍</span>
                <span>Buscar</span>
            </button>
        </form>

        {{-- Llistat de sèries --}}
        @if ($series->isEmpty())
            <p class="text-gray-600">No hi ha sèries disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($series as $serie)
                    <x-card-image :image="Storage::url($serie->image)" :title="$serie->title">
                        <p>{{ \Illuminate\Support\Str::limit($serie->description, 80) }}</p>
                        <x-slot name="footer">
                            <a href="{{ route('series.show', $serie) }}">
                                <x-button color="primary" class="inline-flex items-center space-x-2">
                                    <span>👁️</span>
                                    <span>Veure</span>
                                </x-button>
                            </a>
                        </x-slot>
                    </x-card-image>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $series->links() }}
            </div>
        @endif
    </div>
</x-videos-app-layout>
