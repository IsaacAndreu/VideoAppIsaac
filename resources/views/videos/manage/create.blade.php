@extends('layouts.videosapp')

@section('title', 'Crear Vídeo')

@section('content')
    <h1>Crear un nou vídeo</h1>
    <form action="{{ route('videos.manage.store') }}" method="POST">
        @csrf
        <label for="title">Títol:</label>
        <input type="text" id="title" name="title" required data-qa="video-title"><br>

        <label for="description">Descripció:</label>
        <textarea id="description" name="description" data-qa="video-description"></textarea><br>

        <label for="url">URL:</label>
        <input type="url" id="url" name="url" required data-qa="video-url"><br>

        <button type="submit">Desar</button>
    </form>
@endsection
