<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary">
            ➕ Crear un nou usuari
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-xl">
        <form action="{{ route('users.manage.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-medium">Nom:</label>
                <input type="text" id="name" name="name" required class="mt-1 w-full px-3 py-2 border rounded-md" />
            </div>

            <div>
                <label for="email" class="block font-medium">Email:</label>
                <input type="email" id="email" name="email" required class="mt-1 w-full px-3 py-2 border rounded-md" />
            </div>

            <div>
                <label for="password" class="block font-medium">Contrasenya:</label>
                <input type="password" id="password" name="password" required class="mt-1 w-full px-3 py-2 border rounded-md" />
            </div>

            <div>
                <label for="role" class="block font-medium">Rol:</label>
                <select id="role" name="role" required class="mt-1 w-full px-3 py-2 border rounded-md">
                    <option value="super-admin">Super-admin</option>
                    <option value="regular-user">Regular</option>
                    <option value="video-manager">Videomanager</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-2">Permisos:</label>
                <div class="space-y-2">
                    @foreach(\App\Helpers\UserPermissionsHelper::getAllPermissions() as $permission)
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission }}"
                                class="rounded border-gray-300"
                            />
                            <span class="ml-2">{{ $permission }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <x-button type="submit">💾 Desar</x-button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
