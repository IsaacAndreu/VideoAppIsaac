<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary">
            ➕ Crear nova sèrie
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form
            action="{{ route('series.manage.store') }}"
            method="POST"
            enctype="multipart/form-data"         {{-- <- importantíssim per pujar fitxers --}}
            class="bg-white shadow rounded-xl p-6 space-y-4"
        >
            @csrf

            <div>
                <label class="block text-base font-semibold text-gray-700">Títol</label>
                <input
                    type="text"
                    name="title"
                    required
                    data-qa="series-title"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base focus:ring-primary focus:border-primary"
                >
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Descripció</label>
                <textarea
                    name="description"
                    required
                    data-qa="series-description"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base focus:ring-primary focus:border-primary"
                ></textarea>
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Imatge (opcional)</label>
                <input
                    type="file"                                      {{-- <- ara és un file upload --}}
                name="image"
                    accept="image/*"
                    data-qa="series-image"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
                @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Nom d'usuari</label>
                <input
                    type="text"
                    name="user_name"
                    required
                    data-qa="series-user-name"
                    value="{{ auth()->user()->name }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Foto d'usuari (opcional)</label>
                <input
                    type="text"
                    name="user_photo_url"
                    data-qa="series-user-photo-url"
                    value="{{ auth()->user()->profile_photo_url }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
            </div>

            <div>
                <label class="block text-base font-semibold text-gray-700">Data de publicació (opcional)</label>
                <input
                    type="date"
                    name="published_at"
                    data-qa="series-published-at"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-base"
                >
            </div>

            <div class="flex justify-end">
                <x-button
                    type="submit"
                    color="primary"
                    data-qa="submit-create-series"
                >
                    💾 Crear sèrie
                </x-button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
