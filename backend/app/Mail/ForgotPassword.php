<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(protected User $user){
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alteração de senha',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.forgot-password',
            with:[
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'password' => $this->user->password
            ]
        );
    }
}
