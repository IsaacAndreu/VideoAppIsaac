<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Gestió de Sèries
        </h2>
    </x-slot>

    <div class="py-4 px-6">

        {{-- ✅ Missatges de feedback --}}
        @if (session('success'))
            <div class="alert bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert bg-red-500 text-white px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <script>
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(el => el.remove());
            }, 3000);
        </script>

        <div class="mb-4">
            <x-link-button href="{{ route('series.manage.create') }}">
                ➕ Crear nova sèrie
            </x-link-button>
        </div>

        @if($series->isEmpty())
            <p class="text-gray-600 mt-4">Encara no hi ha cap sèrie creada.</p>
        @else

            {{-- 🌐 Taula (visible només en escriptori) --}}
            <div class="hidden sm:block bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Títol</th>
                        <th class="border px-4 py-2">Usuari</th>
                        <th class="border px-4 py-2">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($series as $serie)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">{{ $serie->id }}</td>
                            <td class="border px-4 py-2">{{ $serie->title }}</td>
                            <td class="border px-4 py-2">{{ $serie->user_name }}</td>
                            <td class="border px-4 py-2 flex flex-wrap gap-2">
                                <x-link-button href="{{ route('series.manage.edit', $serie->id) }}" color="green">
                                    ✏️ Editar
                                </x-link-button>

                                <x-link-button href="{{ route('series.manage.delete', $serie->id) }}" color="red">
                                    🗑️ Eliminar
                                </x-link-button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 📱 Cards (només per mòbil) --}}
            <div class="sm:hidden space-y-4">
                @foreach ($series as $serie)
                    <x-card :title="$serie->title">
                        <p><strong>ID:</strong> {{ $serie->id }}</p>
                        <p><strong>Usuari:</strong> {{ $serie->user_name }}</p>

                        <x-slot name="footer">
                            <div class="flex gap-2">
                                <x-link-button href="{{ route('series.manage.edit', $serie->id) }}" color="green" size="sm">
                                    ✏️ Editar
                                </x-link-button>

                                <x-link-button href="{{ route('series.manage.delete', $serie->id) }}" color="red" size="sm">
                                    🗑️ Eliminar
                                </x-link-button>
                            </div>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>
            {{-- 📄 Paginació --}}
            <div class="mt-6">
                {{ $series->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
