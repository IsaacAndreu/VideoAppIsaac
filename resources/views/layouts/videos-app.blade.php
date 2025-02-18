<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'VideosApp' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="flex justify-between items-center p-4 bg-gray-800 text-white">
    <h1 class="text-xl font-bold">VideosApp</h1>

    @can('manage-videos')
        <a href="{{ route('videos.index') }}" class="bg-blue-500 px-4 py-2 rounded text-white">
            Gestionar vídeos
        </a>
    @endcan
</header>

<main class="p-6">
    {{ $slot }}
</main>

<footer class="text-center text-gray-600 py-4">
    <p>&copy; {{ date('Y') }} VideosApp. Tots els drets reservats.</p>
</footer>
</body>
</html>
