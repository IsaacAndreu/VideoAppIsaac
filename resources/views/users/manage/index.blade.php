<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Gestió d'Usuaris
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

        {{-- ➕ Botó per crear --}}
        <div class="mb-4">
            <x-link-button href="{{ route('users.manage.create') }}">
                ➕ Crear nou usuari
            </x-link-button>
        </div>

        {{-- ❌ Si no hi ha usuaris --}}
        @if($users->isEmpty())
            <p class="text-gray-600 mt-4">Encara no hi ha cap usuari registrat.</p>
        @else
            {{-- 🌐 Versió taula per escriptori --}}
            <div class="hidden sm:block overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full border">
                    <thead class="bg-gray-100 text-base">
                    <tr>
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Nom</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2 flex flex-wrap gap-2">
                                <x-link-button href="{{ route('users.manage.edit', $user->id) }}" color="green">
                                    ✏️ Editar
                                </x-link-button>

                                <x-link-button href="{{ route('users.manage.delete', $user->id) }}" color="red">
                                    🗑️ Eliminar
                                </x-link-button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 📱 Versió mòbil amb cards --}}
            <div class="sm:hidden space-y-4 mt-6">
                @foreach ($users as $user)
                    <x-card :title="$user->name">
                        <p class="text-base"><strong>ID:</strong> {{ $user->id }}</p>
                        <p class="text-base"><strong>Email:</strong> {{ $user->email }}</p>

                        <x-slot name="footer">
                            <div class="flex gap-2">
                                <x-link-button href="{{ route('users.manage.edit', $user->id) }}" color="green" size="sm">
                                    ✏️ Editar
                                </x-link-button>

                                <x-link-button href="{{ route('users.manage.delete', $user->id) }}" color="red" size="sm">
                                    🗑️ Eliminar
                                </x-link-button>
                            </div>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
