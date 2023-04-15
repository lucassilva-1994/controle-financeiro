<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcome extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build(){
        return $this->view('emails.welcome',
        ['name' => $this->data['name'],'token' => $this->data['token']])->from(env('MAIL_USERNAME'),'Controle financeiro')
        ->to($this->data['email'])->subject('Controle financeiro - cadastro.');
    }
}
