<x-videos-app-layout>
    <h1 class="text-2xl font-bold mb-4">Gestió de Vídeos</h1>

    {{-- ✅ Missatges de feedback --}}
    @if (session('success'))
        <div class="alert bg-green-500 text-white px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert bg-red-500 text-white px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.remove());
        }, 3000);
    </script>

    <x-link-button href="{{ route('videos.manage.create') }}" class="mb-4">
        ➕ Crear un nou vídeo
    </x-link-button>

    {{-- 🔍 Si no hi ha vídeos --}}
    @if($videos->isEmpty())
        <p class="text-gray-600 mt-4">Encara no hi ha cap vídeo creat.</p>
    @else

        {{-- 🌐 Taula per escriptori --}}
        <div class="hidden sm:block">
            <table class="min-w-full border bg-white shadow rounded">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Títol</th>
                    <th class="border px-4 py-2">Descripció</th>
                    <th class="border px-4 py-2">URL</th>
                    <th class="border px-4 py-2">Accions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($videos as $video)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $video->title }}</td>
                        <td class="border px-4 py-2">{{ $video->description }}</td>
                        <td class="border px-4 py-2">
                            <x-link-button href="{{ $video->url }}" target="_blank" color="blue">
                                Veure
                            </x-link-button>
                        </td>
                        <td class="border px-4 py-2 flex flex-wrap gap-2">
                            <x-link-button href="{{ route('videos.manage.edit', $video->id) }}" color="green">
                                ✏️ Editar
                            </x-link-button>

                            <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest vídeo?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" color="red" size="sm">
                                    🗑️ Eliminar
                                </x-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- 📱 Cards (només per mòbil) --}}
        <div class="sm:hidden space-y-4">
            @foreach ($videos as $video)
                <x-card :title="$video->title">
                    <p><strong>Descripció:</strong> {{ $video->description }}</p>
                    <p><strong>URL:</strong> <a href="{{ $video->url }}" class="text-blue-600 underline" target="_blank">Veure vídeo</a></p>

                    <x-slot name="footer">
                        <div class="flex gap-2">
                            <x-link-button href="{{ route('videos.manage.edit', $video->id) }}" color="green" size="sm">
                                ✏️ Editar
                            </x-link-button>

                            <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest vídeo?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" color="red" size="sm">
                                    🗑️ Eliminar
                                </x-button>
                            </form>
                        </div>
                    </x-slot>
                </x-card>
            @endforeach
        </div>
    @endif
</x-videos-app-layout>
