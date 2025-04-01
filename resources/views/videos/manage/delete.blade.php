@extends('layouts.videosapp')

@section('title', 'Eliminar Vídeo')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Eliminar el vídeo: {{ $video->title }}</h1>

    <p class="mb-4">Segur que vols eliminar aquest vídeo?</p>

    <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Segur que vols eliminar aquest vídeo?')">Sí, eliminar</button>
        <a href="{{ route('videos.manage.index') }}" class="ml-4 text-blue-500">Cancel·lar</a>
    </form>
@endsection
