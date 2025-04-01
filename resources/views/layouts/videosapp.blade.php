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
        <!-- Nom / Logo de l'app -->
        <h1 class="text-xl font-bold">VideosApp</h1>

        <!-- Enllaç a la pàgina de vídeos -->
        <a href="{{ route('videos.index') }}" class="hover:underline">Inici Vídeos</a>

        <!-- Enllaç a la pàgina d'usuaris (només si estàs autenticat) -->
        @auth
            <a href="{{ route('users.index') }}" class="hover:underline">Usuaris</a>

            @can('manage videos')
                <a href="{{ route('videos.manage.index') }}" class="hover:underline">Gestionar Vídeos</a>
            @endcan

            @can('manage users')
                <a href="{{ route('users.manage.index') }}" class="hover:underline">Gestionar Usuaris</a>
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
    @yield('content')
</main>

<!-- Footer -->
<footer class="text-center text-gray-600 py-4 border-t">
    <p>&copy; {{ date('Y') }} VideosApp. Tots els drets reservats.</p>
</footer>
</body>
</html>
