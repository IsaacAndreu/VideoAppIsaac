<x-videos-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            ➕ Crear un nou usuari
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        <form action="{{ route('users.manage.store') }}" method="POST" class="bg-white shadow rounded p-6">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium">Nom:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
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
                    required
                    data-qa="user-email"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium">Contrasenya:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
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
                    <option value="superadmin">Superadmin</option>
                    <option value="regular">Regular</option>
                    <option value="videomanager">Videomanager</option>
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
                    data-qa="submit-create-user"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    💾 Desar
                </button>
            </div>
        </form>
    </div>
</x-videos-app-layout>
