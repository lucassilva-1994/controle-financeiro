<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build(){
        return $this->view('emails.resetpassword',[
            'token' => $this->data['token'],
            'name' =>$this->data['name']
        ])
        ->to($this->data['email'])
        ->from(env('MAIL_USERNAME'),"Controle financeiro")
        ->subject("redefinir senha");
    }
}
