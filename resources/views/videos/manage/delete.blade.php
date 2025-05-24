<x-videos-app-layout>
    <x-slot name="title">Eliminar Vídeo</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">🗑️ Eliminar el vídeo: {{ $video->title }}</h1>

        <p class="mb-6 text-red-600 text-base">⚠️ Estàs segur/a que vols eliminar aquest vídeo? Aquesta acció <strong>no es pot desfer</strong>.</p>

        <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" class="flex flex-wrap items-center gap-4">
            @csrf
            @method('DELETE')

            <x-button type="submit" color="red" onclick="return confirm('Segur que vols eliminar aquest vídeo?')" data-qa="confirm-delete-video">
                ✅ Sí, eliminar
            </x-button>

            <x-link-button href="{{ route('videos.manage.index') }}" color="gray">
                ❌ Cancel·lar
            </x-link-button>
        </form>
    </div>
</x-videos-app-layout>
