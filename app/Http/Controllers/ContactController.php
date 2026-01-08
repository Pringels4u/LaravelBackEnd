<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Save message
        $contact = ContactMessage::create($data);

        // Find an admin email (first admin user)
        $admin = User::where('is_admin', true)->first();

        if ($admin && $admin->email) {
            Mail::to($admin->email)->send(new ContactFormSubmitted($contact));
        }

        return redirect()->route('contact.create')->with('success', 'Bericht verzonden.');
    }

    /**
     * Simple admin listing of messages. Only admins may view.
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.contacts.index', compact('messages'));
    }
}
