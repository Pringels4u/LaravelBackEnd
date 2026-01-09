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
     * Show the form to create a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user (admin created with provided password).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'nullable|boolean',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = $data['password']; // will be hashed by model cast
        $user->is_admin = !empty($data['is_admin']);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Nieuwe gebruiker aangemaakt.');
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
