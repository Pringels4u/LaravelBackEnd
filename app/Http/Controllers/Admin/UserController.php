<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users for admin management.
     */
    public function index()
    {
        $users = User::orderBy('id')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle the is_admin flag for a user.
     */
    public function toggleAdmin(Request $request, User $user)
    {
        // Prevent demoting yourself accidentally
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'Je kunt jezelf niet promoten of degradere n via deze pagina.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        return back()->with('success', 'Gebruiker bijgewerkt.');
    }
}
