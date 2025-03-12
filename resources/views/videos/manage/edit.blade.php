<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vídeo</title>
</head>
<body>
<h1>Editar el vídeo: {{ $video->title }}</h1>

<form action="{{ route('videos.manage.update', $video->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="title">Títol:</label>
    <input type="text" id="title" name="title" value="{{ $video->title }}" required data-qa="video-title"><br>

    <label for="description">Descripció:</label>
    <textarea id="description" name="description" data-qa="video-description">{{ $video->description }}</textarea><br>

    <label for="url">URL:</label>
    <input type="url" id="url" name="url" value="{{ $video->url }}" required data-qa="video-url"><br>

    <button type="submit">Actualitzar</button>
</form>
</body>
</html>
