<x-videos-app-layout>
    <x-slot name="title">Crear Vídeo</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">➕ Crear un nou vídeo</h1>

        <form action="{{ route('videos.manage.store') }}" method="POST" class="bg-white shadow-xl rounded-lg p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block font-semibold text-base text-gray-700">Títol:</label>
                <input type="text" id="title" name="title" required data-qa="video-title"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 text-base">
            </div>

            <div>
                <label for="description" class="block font-semibold text-base text-gray-700">Descripció:</label>
                <textarea id="description" name="description" data-qa="video-description"
                          class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 text-base"></textarea>
            </div>

            <div>
                <label for="url" class="block font-semibold text-base text-gray-700">URL:</label>
                <input type="url" id="url" name="url" required data-qa="video-url"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 text-base">
            </div>

            <div>
                <label for="series_id" class="block font-semibold text-base text-gray-700">Sèrie:</label>
                <select id="series_id" name="series_id" data-qa="video-series"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 text-base">
                    <option value="">-- Sense sèrie --</option>
                    @foreach ($series as $serie)
                        <option value="{{ $serie->id }}">{{ $serie->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <x-button type="submit" data-qa="submit-create-video">
                    💾 Desar
                </x-button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
