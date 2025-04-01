@extends('layouts.videosapp')

@section('title', 'Llista d\'Usuaris')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Llista d'Usuaris</h1>

    <!-- Formulari de cerca -->
    <form action="{{ route('users.index') }}" method="GET" class="mb-4">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cerca per nom o email..."
            data-qa="search-user"
            class="border px-2 py-1 rounded"
        >
        <button
            type="submit"
            data-qa="search-submit"
            class="bg-blue-500 text-white px-3 py-1 rounded"
        >
            Buscar
        </button>
    </form>

    <!-- Taula d'usuaris -->
    <table class="min-w-full border">
        <thead>
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Nom</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Accions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->id }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    <!-- Enllaç al detall -->
                    <a href="{{ route('users.show', $user->id) }}" class="text-blue-500">Veure detall</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                    No s'han trobat usuaris.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
