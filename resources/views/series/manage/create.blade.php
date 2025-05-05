<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Crear nova sèrie
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <form action="{{ route('series.manage.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">Títol:</label>
                <input type="text" name="title" required data-qa="series-title"
                       class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Descripció:</label>
                <textarea name="description" required data-qa="series-description"
                          class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Imatge (opcional):</label>
                <input type="text" name="image" data-qa="series-image"
                       class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Nom d'usuari:</label>
                <input type="text" name="user_name" required data-qa="series-user-name"
                       value="{{ auth()->user()->name }}"
                       class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Foto d'usuari (opcional):</label>
                <input type="text" name="user_photo_url" data-qa="series-user-photo-url"
                       value="{{ auth()->user()->profile_photo_url }}"
                       class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Data de publicació (opcional):</label>
                <input type="date" name="published_at" data-qa="series-published-at"
                       class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        data-qa="submit-create-series"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Crear sèrie
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
