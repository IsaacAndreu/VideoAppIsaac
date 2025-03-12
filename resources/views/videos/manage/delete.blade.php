<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Vídeo</title>
</head>
<body>
<h1>Eliminar el vídeo: {{ $video->title }}</h1>

<p>Segur que vols eliminar aquest vídeo?</p>

<form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Segur que vols eliminar aquest vídeo?')">Sí, eliminar</button>
    <a href="{{ route('videos.manage.index') }}">Cancel·lar</a>
</form>
</body>
</html>
