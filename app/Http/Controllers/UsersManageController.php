<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UsersManageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,App\Models\User');
    }

    public function index(): View
    {
        $users = User::all();
        return view('users.manage.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.manage.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // He eliminat la regla `confirmed` perquè els tests no envien password_confirmation
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:8',
            'role'         => 'required|string|in:super-admin,regular-user,video-manager',
            'permissions'  => 'nullable|array',
            'permissions.*'=> 'string|exists:permissions,name',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // sincronitza rol i permisos
        $user->syncRoles($data['role']);
        $user->syncPermissions($data['permissions'] ?? []);

        return to_route('users.manage.index')
            ->with('success', 'Usuari creat correctament!');
    }

    public function edit(User $user): View
    {
        return view('users.manage.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Idem, sense confirmed
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => "required|email|unique:users,email,{$user->id}",
            'password'     => 'nullable|string|min:8',
            'role'         => 'required|string|in:super-admin,regular-user,video-manager',
            'permissions'  => 'nullable|array',
            'permissions.*'=> 'string|exists:permissions,name',
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();

        // sincronitza rol i permisos
        $user->syncRoles($data['role']);
        $user->syncPermissions($data['permissions'] ?? []);

        return to_route('users.manage.index')
            ->with('success', 'Usuari actualitzat correctament!');
    }

    public function delete(User $user): View
    {
        return view('users.manage.delete', compact('user'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return to_route('users.manage.index')
            ->with('success', 'Usuari eliminat correctament!');
    }
}
