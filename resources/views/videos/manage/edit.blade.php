@extends('layouts.videosapp')

@section('title', 'Editar Vídeo')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar el vídeo: {{ $video->title }}</h1>

    <form action="{{ route('videos.manage.update', $video->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block font-medium">Títol:</label>
            <input type="text" id="title" name="title" value="{{ $video->title }}" required data-qa="video-title" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Descripció:</label>
            <textarea id="description" name="description" required data-qa="video-description" class="mt-1 block w-full border-gray-300 rounded-md">{{ $video->description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="url" class="block font-medium">URL:</label>
            <input type="url" id="url" name="url" value="{{ $video->url }}" required data-qa="video-url" class="mt-1 block w-full border-gray-300 rounded-md">
        </div>

        <button type="
