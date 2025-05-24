<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-4">Llista d'Usuaris</h1>

        {{-- 🔍 Formulari de cerca --}}
        <form action="{{ route('users.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cerca per nom o email..."
                data-qa="search-user"
                class="border px-3 py-2 rounded w-full sm:w-auto text-base"
            >
            <x-button type="submit" data-qa="search-submit">
                Buscar
            </x-button>
        </form>

        {{-- 🌐 Versió taula per escriptori --}}
        <div class="hidden md:block">
            <table class="min-w-full border bg-white shadow rounded">
                <thead class="bg-gray-100 text-base">
                <tr>
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Nom</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Accions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->name }}</td>
                        <td class="border px-4 py-2">{{ $user->email }}</td>
                        <td class="border px-4 py-2">
                            <x-link-button href="{{ route('users.show', $user->id) }}" color="blue">
                                👁️ Veure detall
                            </x-link-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                            No s'han trobat usuaris.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📱 Cards en mòbil --}}
        <div class="md:hidden space-y-4">
            @forelse ($users as $user)
                <x-card :title="$user->name">
                    <p class="text-base"><strong>ID:</strong> {{ $user->id }}</p>
                    <p class="text-base"><strong>Email:</strong> {{ $user->email }}</p>

                    <x-slot name="footer">
                        <x-link-button href="{{ route('users.show', $user->id) }}" color="blue">
                            👁️ Veure detall
                        </x-link-button>
                    </x-slot>
                </x-card>
            @empty
                <p class="text-gray-500">No s'han trobat usuaris.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
