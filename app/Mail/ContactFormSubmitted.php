<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $messageModel;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $message)
    {
        $this->messageModel = $message;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->messageModel->subject ?? 'Nieuw contactbericht')
                    ->view('emails.contact')
                    ->with(['contact' => $this->messageModel])
                    ->replyTo($this->messageModel->email, $this->messageModel->name);
    }
}
