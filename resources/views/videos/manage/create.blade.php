<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vídeo</title>
</head>
<body>
<h1>Crear un nou vídeo</h1>
<form action="{{ route('videos.manage.store') }}" method="POST">
    @csrf
    <label for="title">Títol:</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="description">Descripció:</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <label for="url">URL:</label>
    <input type="url" id="url" name="url" required>
    <br>
    <button type="submit">Desar</button>
</form>
</body>
</html>
