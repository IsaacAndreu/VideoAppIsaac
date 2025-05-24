<x-videos-app-layout>
    <x-slot name="title">Editar Vídeo</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ Editar el vídeo: {{ $video->title }}</h1>

        <form action="{{ route('videos.manage.update', $video->id) }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block font-medium text-base">Títol:</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $video->title) }}"
                    required
                    data-qa="video-title"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
            </div>

            <div>
                <label for="description" class="block font-medium text-base">Descripció:</label>
                <textarea
                    id="description"
                    name="description"
                    required
                    data-qa="video-description"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >{{ old('description', $video->description) }}</textarea>
            </div>

            <div>
                <label for="url" class="block font-medium text-base">URL:</label>
                <input
                    type="url"
                    id="url"
                    name="url"
                    value="{{ old('url', $video->url) }}"
                    required
                    data-qa="video-url"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
            </div>

            <div>
                <label for="series_id" class="block font-medium text-base">Sèrie:</label>
                <select
                    id="series_id"
                    name="series_id"
                    data-qa="video-series"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
                    <option value="">-- Sense sèrie --</option>
                    @foreach ($series as $serie)
                        <option value="{{ $serie->id }}" {{ old('series_id', $video->series_id) == $serie->id ? 'selected' : '' }}>
                            {{ $serie->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <x-button type="submit" data-qa="submit-edit-video">
                    💾 Actualitzar
                </x-button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
