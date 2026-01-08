<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Toon het publieke profiel van een gebruiker.
     */
    public function show(User $user): View
    {
        return view('user.show', compact('user'));
    }
}
