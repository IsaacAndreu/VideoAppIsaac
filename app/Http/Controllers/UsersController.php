<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Mostra la llista de tots els usuaris (pàgina pública),
     * amb un camp de cerca per nom o email.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            // Filtre per nom o correu
            $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->get();
        } else {
            $users = User::all();
        }

        return view('users.index', compact('users'));
    }

    /**
     * Mostra un usuari específic (pàgina pública) i els seus vídeos.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Si tens la relació user->videos() al model User:
        // $videos = $user->videos;
        // Si no, pots fer directament:
        $videos = Video::where('user_id', $user->id)->get();

        return view('users.show', compact('user', 'videos'));
    }
}
