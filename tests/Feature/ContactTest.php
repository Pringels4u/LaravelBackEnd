<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_saves_message_and_sends_mail()
    {
        Mail::fake();

        // Ensure an admin exists so the controller will send the mailable
        \App\Models\User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@example.test',
        ]);

        $data = [
            'name' => 'Visitor',
            'email' => 'visitor@example.test',
            'subject' => 'Hello',
            'message' => 'This is a test message from visitor',
        ];

        $response = $this->post(route('contact.store'), $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'visitor@example.test',
            'subject' => 'Hello',
        ]);

        Mail::assertSent(ContactFormSubmitted::class);
    }
}
