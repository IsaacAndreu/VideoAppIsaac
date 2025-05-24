<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificacions en temps real') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Últimes notificacions</h3>
                <ul id="notifications" class="list-disc pl-6 space-y-2 text-gray-700">
                    <li>Esperant notificacions...</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script src="https://js.pusher.com/8.0/pusher.min.js"></script>
    @vite('resources/js/app.js')

    <script>
        Echo.channel('videos')
            .listen('.video.created', (e) => {
                const ul = document.getElementById('notifications');
                const li = document.createElement('li');
                li.textContent = `Nou vídeo: ${e.title} (${e.description})`;
                ul.prepend(li);
            });
    </script>
@endpush
