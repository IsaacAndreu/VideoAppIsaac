@extends('layouts.videosapp')

@section('title', 'Detall Usuari')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Detall de l'Usuari</h1>

    <p><strong>ID:</strong> {{ $user->id }}</p>
    <p><strong>Nom:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <hr class="my-6">

    <h2 class="text-xl font-bold mb-4">Vídeos de l'Usuari</h2>
    @if ($videos->isEmpty())
        <p>L'usuari no té cap vídeo.</p>
    @else
        <ul class="list-disc ml-6">
            @foreach ($videos as $video)
                <li>
                    {{ $video->title }} -
                    <a href="{{ $video->url }}" class="text-blue-500" target="_blank">Veure vídeo</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
