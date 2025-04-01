@extends('layouts.videosapp')

@section('title', 'Crear Usuari')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear un nou usuari</h1>

    <form action="{{ route('users.manage.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-medium">Nom:</label>
            <input
                type="text"
                id="name"
                name="name"
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
                required
                data-qa="user-email"
                class="mt-1 block w-full border-gray-300 rounded-md"
            >
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium">Contrasenya:</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                data-qa="user-password"
                class="mt-1 block w-full border-gray-300 rounded-md"
            >
        </div>

        <button
            type="submit"
            data-qa="submit-create-user"
            class="bg-blue-500 text-white px-4 py-2 rounded"
        >
            Desar
        </button>
    </form>
@endsection
