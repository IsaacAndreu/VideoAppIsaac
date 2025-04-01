@extends('layouts.videosapp')

@section('title', 'Gestió d\'Usuaris')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Gestió d'Usuaris</h1>

    <a href="{{ route('users.manage.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Crear nou usuari</a>

    <table class="min-w-full mt-4 border">
        <thead>
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Nom</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Accions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="border px-4 py-2 text-center">{{ $user->id }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    <!-- Enllaç per editar l'usuari -->
                    <a href="{{ route('users.manage.edit', $user->id) }}" class="text-green-500">Editar</a>

                    <!-- Enllaç per eliminar l'usuari -->
                    <a href="{{ route('users.manage.delete', $user->id) }}" class="text-red-500 ml-2">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
