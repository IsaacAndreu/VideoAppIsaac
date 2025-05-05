<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Gestió de Sèries
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <div class="mb-4">
            <a href="{{ route('series.manage.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                ➕ Crear nova sèrie
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full border">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Títol</th>
                    <th class="border px-4 py-2">Usuari</th>
                    <th class="border px-4 py-2">Accions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($series as $serie)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $serie->id }}</td>
                        <td class="border px-4 py-2">{{ $serie->title }}</td>
                        <td class="border px-4 py-2">{{ $serie->user_name }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('series.manage.edit', $serie->id) }}" class="text-green-600 hover:underline">✏️ Editar</a>
                            <a href="{{ route('series.manage.delete', $serie->id) }}" class="text-red-600 hover:underline ml-4">🗑️ Eliminar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginació -->
        <div class="mt-6">
            {{ $series->links() }}
        </div>
    </div>
</x-app-layout>
