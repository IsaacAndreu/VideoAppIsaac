<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Gestió d'Usuaris
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <div class="mb-4">
            <a href="{{ route('users.manage.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                ➕ Crear nou usuari
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full border">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Nom</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Accions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('users.manage.edit', $user->id) }}" class="text-green-600 hover:underline">✏️ Editar</a>
                            <a href="{{ route('users.manage.delete', $user->id) }}" class="text-red-600 hover:underline ml-4">🗑️ Eliminar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
