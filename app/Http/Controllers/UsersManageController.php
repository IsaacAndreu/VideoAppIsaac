<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsersManageController extends Controller
{
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('users.manage.index')
            ->with('success', "Usuari {$user->name} creat correctament!");
    }

    public function edit(int $id): View
    {
        $user = User::findOrFail($id);
        return view('users.manage.edit', compact('user'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$id}",
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $user->update($data);

        return redirect()->route('users.manage.index')
            ->with('success', "Usuari {$user->name} actualitzat correctament!");
    }

    public function delete(int $id): View
    {
        $user = User::findOrFail($id);
        return view('users.manage.delete', compact('user'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.manage.index')
            ->with('success', "Usuari {$userName} eliminat correctament!");
    }

    public function testedBy(int $id): View
    {
        $user = User::findOrFail($id);
        // suposant que tinguis un model Test amb camp user_id
        $tests = $user->testedBy;
        return view('users.manage.testedby', compact('user', 'tests'));
    }
}
