<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-red-600 leading-tight">
            🗑️ Eliminar usuari
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-xl rounded-lg p-6 space-y-6">
            <h1 class="text-2xl font-bold text-gray-800">Eliminar usuari: {{ $user->name }}</h1>

            <p class="text-red-600 text-base">
                ⚠️ Estàs segur/a que vols eliminar aquest usuari? Aquesta acció <strong>no es pot desfer</strong>.
            </p>

            <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
                @csrf
                @method('DELETE')

                <x-button type="submit" color="red" data-qa="submit-delete-user" onclick="return confirm('Realment vols eliminar aquest usuari?')">
                    ✅ Sí, eliminar
                </x-button>

                <x-link-button href="{{ route('users.manage.index') }}" color="gray">
                    ❌ Cancel·lar
                </x-link-button>
            </form>
        </div>
    </div>
</x-videos-app-layout>
