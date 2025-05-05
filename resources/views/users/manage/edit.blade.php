<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ✏️ Editar Usuari
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <form action="{{ route('users.manage.update', $user->id) }}" method="POST" class="bg-white shadow rounded p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium">Nom:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    data-qa="user-name"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                >
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    data-qa="user-email"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium">Contrasenya (opcional):</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    data-qa="user-password"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                >
            </div>

            <div class="mb-4">
                <label for="role" class="block font-medium">Rol:</label>
                <select
                    id="role"
                    name="role"
                    data-qa="user-role"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                >
                    <option value="superadmin" @if($user->role === 'superadmin') selected @endif>Superadmin</option>
                    <option value="regular" @if($user->role === 'regular') selected @endif>Regular</option>
                    <option value="videomanager" @if($user->role === 'videomanager') selected @endif>Videomanager</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Permisos:</label>
                <div class="space-y-2">
                    @foreach (\App\Helpers\UserPermissionsHelper::getAllPermissions() as $permission)
                        <div>
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission }}"
                                    @if(in_array($permission, $user->permissions ?? [])) checked @endif
                                    data-qa="user-permission-{{ $permission }}"
                                    class="rounded border-gray-300"
                                >
                                <span class="ml-2">{{ $permission }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    data-qa="submit-edit-user"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    💾 Actualitzar
                </button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
