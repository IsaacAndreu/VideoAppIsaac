<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'VideosApp' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<!-- Navbar -->
<header class="flex justify-between items-center p-4 bg-gray-800 text-white">
    <div class="flex items-center space-x-4">
        <h1 class="text-xl font-bold">VideosApp</h1>
        <a href="{{ route('videos.index') }}" class="hover:underline">Inici</a>
        @auth
            @can('manage videos')
                <a href="{{ route('videos.manage.index') }}" class="hover:underline">Gestionar Vídeos</a>
            @endcan
        @endauth
    </div>
    <div>
        @auth
            <span>{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="ml-4 hover:underline"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Tanca Sessió
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:underline">Inicia Sessió</a>
            <a href="{{ route('register') }}" class="ml-4 hover:underline">Registra't</a>
        @endauth
    </div>
</header>

<!-- Contingut Principal -->
<main class="p-6">
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="text-center text-gray-600 py-4 border-t">
    <p>&copy; {{ date('Y') }} VideosApp. Tots els drets reservats.</p>
</footer>
</body>
</html>
