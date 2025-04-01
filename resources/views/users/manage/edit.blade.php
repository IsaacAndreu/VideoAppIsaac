@extends('layouts.videosapp')

@section('title', 'Editar Usuari')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar usuari: {{ $user->name }}</h1>

    <form action="{{ route('users.manage.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium">Nom:</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ $user->name }}"
                required
                data-qa="user-name"
                class="mt-1 block w-full border-gray-300 rounded-md"
            >
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ $user->email }}"
                required
                data-qa="user-email"
                class="mt-1 block w-full border-gray-300 rounded-md"
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium">Contrasenya (opcional):</label>
            <input
                type="password"
                id="password"
                name="password"
                data-qa="user-password"
                class="mt-1 block w-full border-gray-300 rounded-md"
            >
        </div>

        <button
            type="submit"
            data-qa="submit-edit-user"
            class="bg-blue-500 text-white px-4 py-2 rounded"
        >
            Actualitzar
        </button>
    </form>

    <hr class="my-6">

    <h2 class="text-xl font-bold mb-4">Llista d'Usuaris</h2>
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
        @foreach ($allUsers as $oneUser)
            <tr>
                <td class="border px-4 py-2">{{ $oneUser->id }}</td>
                <td class="border px-4 py-2">{{ $oneUser->name }}</td>
                <td class="border px-4 py-2">{{ $oneUser->email }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('users.manage.edit', $oneUser->id) }}" class="text-green-500">Editar</a>
                    <a href="{{ route('users.manage.delete', $oneUser->id) }}" class="text-red-500 ml-2">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
