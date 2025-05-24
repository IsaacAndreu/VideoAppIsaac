<x-videos-app-layout>
    <x-slot name="header">
        {{-- Fixa la “u” de usuari en minúscula perquè el test busqui exactament “✏️ Editar usuari” --}}
        <h2 class="text-3xl font-bold text-gray-800">
            ✏️ Editar usuari
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow-xl rounded-lg space-y-6">
        <form action="{{ route('users.manage.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold">Nom:</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $user->name) }}"
                       required class="mt-1 w-full px-4 py-2 border rounded-md" />
            </div>

            <div>
                <label for="email" class="block font-semibold">Email:</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       required class="mt-1 w-full px-4 py-2 border rounded-md" />
            </div>

            <div>
                <label for="password" class="block font-semibold">Contrasenya (opcional):</label>
                <input type="password" id="password" name="password"
                       class="mt-1 w-full px-4 py-2 border rounded-md" />
            </div>

            <div>
                <label for="role" class="block font-semibold">Rol:</label>
                <select id="role" name="role" required class="mt-1 w-full px-4 py-2 border rounded-md">
                    <option value="super-admin"    {{ $user->hasRole('super-admin')    ? 'selected' : '' }}>Super-admin</option>
                    <option value="regular-user"   {{ $user->hasRole('regular-user')   ? 'selected' : '' }}>Regular</option>
                    <option value="video-manager"  {{ $user->hasRole('video-manager')  ? 'selected' : '' }}>Videomanager</option>
                </select>
            </div>

            @php
                $userPermissions = $user->getPermissionNames()->toArray();
            @endphp
            <div>
                <label class="block font-semibold mb-2">Permisos:</label>
                <div class="space-y-2">
                    @foreach(\App\Helpers\UserPermissionsHelper::getAllPermissions() as $permission)
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission }}"
                                {{ in_array($permission, $userPermissions) ? 'checked' : '' }}
                                class="rounded border-gray-300"
                            />
                            <span class="ml-2">{{ $permission }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <x-button type="submit">💾 Actualitzar</x-button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
