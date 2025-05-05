<x-videos-app-layout>
    <x-slot name="title">Crear Vídeo</x-slot>

    <h1 class="text-2xl font-bold mb-6">➕ Crear un nou vídeo</h1>

    <form action="{{ route('videos.manage.store') }}" method="POST" class="bg-white shadow-md rounded p-6">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-medium">Títol:</label>
            <input type="text" id="title" name="title" required data-qa="video-title"
                   class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-medium">Descripció:</label>
            <textarea id="description" name="description" data-qa="video-description"
                      class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2"></textarea>
        </div>

        <div class="mb-4">
            <label for="url" class="block font-medium">URL:</label>
            <input type="url" id="url" name="url" required data-qa="video-url"
                   class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="series_id" class="block font-medium">Sèrie:</label>
            <select id="series_id" name="series_id" data-qa="video-series"
                    class="mt-1 block w-full border-gray-300 rounded-md px-3 py-2">
                <option value="">-- Sense sèrie --</option>
                @foreach ($series as $serie)
                    <option value="{{ $serie->id }}">{{ $serie->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" data-qa="submit-create-video"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Desar
            </button>
        </div>
    </form>
</x-videos-app-layout>
