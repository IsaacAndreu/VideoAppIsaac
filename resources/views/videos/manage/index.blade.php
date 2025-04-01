@extends('layouts.videosapp')

@section('title', 'Gestió de Vídeos')

@section('content')
    <!-- Copiem l'estructura bàsica de Jetstream -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h1 class="text-2xl font-bold mb-4">Gestió de Vídeos</h1>

                <a href="{{ route('videos.manage.create') }}" class="bg-blue-500 px-4 py-2 rounded text-white mb-4 inline-block">
                    Crear un nou vídeo
                </a>

                <table class="min-w-full border">
                    <thead>
                    <tr>
                        <th class="border px-4 py-2">Títol</th>
                        <th class="border px-4 py-2">Descripció</th>
                        <th class="border px-4 py-2">URL</th>
                        <th class="border px-4 py-2">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td class="border px-4 py-2">{{ $video->title }}</td>
                            <td class="border px-4 py-2">{{ $video->description }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ $video->url }}" target="_blank" class="text-blue-500">Veure</a>
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('videos.manage.edit', $video->id) }}" class="text-green-500">Editar</a>

                                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 ml-2"
                                            onclick="return confirm('Segur que vols eliminar aquest vídeo?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
