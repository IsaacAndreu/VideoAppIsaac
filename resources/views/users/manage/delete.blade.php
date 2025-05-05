<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            🗑️ Eliminar usuari
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <div class="bg-white shadow rounded p-6">
            <h1 class="text-2xl font-bold mb-4">Eliminar usuari: {{ $user->name }}</h1>

            <p class="mb-6 text-red-700">⚠️ Estàs segur/a que vols eliminar aquest usuari? Aquesta acció no es pot desfer.</p>

            <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST" class="flex items-center">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    data-qa="submit-delete-user"
                    class="bg-red-600 text-black px-4 py-2 rounded hover:bg-red-700"
                    onclick="return confirm('Realment vols eliminar aquest usuari?')"
                >
                    ✅ Sí, eliminar
                </button>

                <a href="{{ route('users.manage.index') }}" class="ml-6 text-blue-600 hover:underline">
                    ❌ Cancel·lar
                </a>
            </form>
        </div>
    </div>
</x-videos-app-layout>
