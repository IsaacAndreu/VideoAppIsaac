<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'VideosApp' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header>
    <h1>VideosApp</h1>
</header>
<main>
    {{ $slot }}
</main>
<footer>
    <p>&copy; {{ date('Y') }} VideosApp. Tots els drets reservats.</p>
</footer>
</body>
</html>
