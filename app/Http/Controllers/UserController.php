<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Utilisateur introuvable'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        $user->save();

        return response()->json($user);
    }
}
