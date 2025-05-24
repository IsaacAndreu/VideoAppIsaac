<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary">
            ✏️ Editar sèrie
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form action="{{ route('series.manage.update', $serie->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-base font-semibold text-gray-700">Títol</label>
                <input type="text" name="title" value="{{ $serie->title }}" required data-qa="series-title"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base focus:ring-primary focus:border-primary">
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Descripció</label>
                <textarea name="description" required data-qa="series-description"
                          class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base focus:ring-primary focus:border-primary">{{ $serie->description }}</textarea>
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Imatge (opcional)</label>
                <input type="text" name="image" value="{{ $serie->image }}" data-qa="series-image"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base">
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Nom d'usuari</label>
                <input type="text" name="user_name" value="{{ $serie->user_name }}" required data-qa="series-user-name"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base">
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Foto d'usuari (opcional)</label>
                <input type="text" name="user_photo_url" value="{{ $serie->user_photo_url }}" data-qa="series-user-photo-url"
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base">
            </div>

            <div class="flex justify-end">
                <x-button type="submit" color="primary" data-qa="submit-edit-series">
                    💾 Actualitzar
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
