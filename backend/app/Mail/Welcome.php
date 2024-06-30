<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(protected User $user){
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem-vindo ao Sistema de Controle Financeiro'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.welcome',
            with: [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'token' => $this->user->token
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
