@extends('layouts.videosapp')

@section('title', 'Eliminar Usuari')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Eliminar usuari: {{ $user->name }}</h1>

    <p class="mb-4">Estàs segur/a que vols eliminar aquest usuari?</p>

    <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            data-qa="submit-delete-user"
            class="bg-red-500 text-white px-4 py-2 rounded"
            onclick="return confirm('Realment vols eliminar aquest usuari?')"
        >
            Sí, eliminar
        </button>
        <a href="{{ route('users.manage.index') }}" class="ml-4 text-blue-500">Cancel·lar</a>
    </form>
@endsection
