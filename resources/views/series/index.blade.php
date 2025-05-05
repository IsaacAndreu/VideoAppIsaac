<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Totes les Sèries
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <!-- Formulari de cerca -->
        <form method="GET" action="{{ route('series.index') }}" class="mb-6">
            <input
                type="text"
                name="search"
                placeholder="Cerca una sèrie..."
                value="{{ request('search') }}"
                class="w-full md:w-1/3 border-gray-300 rounded-md p-2"
                data-qa="search-series"
            >
        </form>

        <!-- Llistat de sèries -->
        @if ($series->isEmpty())
            <p class="text-gray-600">No hi ha sèries disponibles.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($series as $serie)
                    <div class="border rounded-lg shadow-md p-4 bg-white hover:shadow-lg transition">
                        @if ($serie->image)
                            <img src="{{ $serie->image }}" alt="{{ $serie->title }}" class="w-full h-40 object-cover mb-2 rounded">
                        @else
                            <div class="w-full h-40 bg-gray-200 mb-2 rounded"></div>
                        @endif

                        <h3 class="text-lg font-semibold mb-2">{{ $serie->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($serie->description, 80) }}</p>

                        <a href="{{ route('series.show', $serie->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" data-qa="view-series-{{ $serie->id }}">
                            Veure detalls
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Paginació -->
            <div class="mt-6">
                {{ $series->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
