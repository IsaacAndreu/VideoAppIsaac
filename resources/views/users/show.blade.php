<x-videos-app-layout>
    <x-slot name="title">
        Detall Usuari
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow rounded p-6">
            <h1 class="text-2xl font-bold mb-4">👤 Detall de l'Usuari</h1>

            <div class="space-y-2 text-base text-gray-700">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Nom:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>

            <hr class="my-6">

            <h2 class="text-xl font-bold mb-4">🎥 Vídeos de l'Usuari</h2>

            @if ($videos->isEmpty())
                <p class="text-gray-500">Aquest usuari no té cap vídeo assignat.</p>
            @else
                <div class="space-y-4">
                    @foreach ($videos as $video)
                        <x-card :title="$video->title">
                            <p>
                                <x-link-button href="{{ $video->url }}" target="_blank" color="blue">
                                    Veure vídeo
                                </x-link-button>
                            </p>
                        </x-card>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-videos-app-layout>
