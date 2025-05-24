<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-danger">
            🗑️ Eliminar sèrie
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded-xl p-6">
            <p class="text-base text-red-700 font-medium mb-4">
                ⚠️ Estàs segur/a que vols eliminar la sèrie <strong class="text-lg">{{ $serie->title }}</strong>? Aquesta acció no es pot desfer.
            </p>

            <form action="{{ route('series.manage.destroy', $serie->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                @csrf
                @method('DELETE')

                <x-button type="submit" color="red" data-qa="confirm-delete-series">
                    ✅ Sí, eliminar
                </x-button>

                <x-link-button href="{{ route('series.manage.index') }}" color="gray">
                    ❌ Cancel·lar
                </x-link-button>
            </form>
        </div>
    </div>
</x-app-layout>
