<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Eliminar sèrie
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <p>Estàs segur/a que vols eliminar la sèrie: <strong>{{ $serie->title }}</strong>?</p>

        <form action="{{ route('series.manage.destroy', $serie->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')

            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" data-qa="confirm-delete-series">
                Sí, eliminar
            </button>

            <a href="{{ route('series.manage.index') }}" class="ml-4 text-blue-500 hover:underline">Cancel·lar</a>
        </form>
    </div>
</x-app-layout>
