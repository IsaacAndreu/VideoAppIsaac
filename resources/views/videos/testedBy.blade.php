<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vídeos testejats</title>
</head>
<body>
<h1>Vídeos testejats per l'usuari</h1>
<ul>
    @foreach ($videos as $video)
        <li>
            <h2>{{ $video->title }}</h2>
            <p>{{ $video->description }}</p>
            <a href="{{ $video->url }}" target="_blank">Veure vídeo</a>
        </li>
    @endforeach
</ul>
</body>
</html>
