<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Editar sèrie
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <form action="{{ route('series.manage.update', $serie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Títol:</label>
                <input type="text" name="title" value="{{ $serie->title }}" required data-qa="series-title" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Descripció:</label>
                <textarea name="description" required data-qa="series-description" class="mt-1 block w-full border-gray-300 rounded-md">{{ $serie->description }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Imatge (opcional):</label>
                <input type="text" name="image" value="{{ $serie->image }}" data-qa="series-image" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Nom d'usuari:</label>
                <input type="text" name="user_name" value="{{ $serie->user_name }}" required data-qa="series-user-name" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Foto d'usuari (opcional):</label>
                <input type="text" name="user_photo_url" value="{{ $serie->user_photo_url }}" data-qa="series-user-photo-url" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">Actualitzar</button>
        </form>
    </div>
</x-app-layout>
