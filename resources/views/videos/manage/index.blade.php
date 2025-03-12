
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de Vídeos</title>
</head>
<body>
<h1>Gestió de Vídeos</h1>

<a href="{{ route('videos.manage.create') }}">Crear un nou vídeo</a>

<table border="1">
    <thead>
    <tr>
        <th>Títol</th>
        <th>Descripció</th>
        <th>URL</th>
        <th>Accions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($videos as $video)
        <tr>
            <td>{{ $video->title }}</td>
            <td>{{ $video->description }}</td>
            <td><a href="{{ $video->url }}" target="_blank">Veure</a></td>
            <td>
                <a href="{{ route('videos.manage.edit', $video->id) }}">Editar</a>
                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Segur que vols eliminar aquest vídeo?')">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
