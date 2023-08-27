<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $from_email, $from_name, $subject, $view, $to_email, $to_name, $activation_code;

    public function __construct(User $user)
    {

        // Adatok elmentése
        $this->from_email = env('WEBSHOP_EMAIL');
        $this->from_name = env('WEBSHOP_NAME');
        $this->subject = "Regisztráció véglegesítése";
        $this->view = "mail.register";
        $this->to_email = $user->email;
        $this->to_name = $user->name;
        $this->activation_code = $user->activation_code;
        
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address($this->from_email, $this->from_name),
            subject: $this->subject
        );
    }

    public function content()
    {
        return new Content(
            view: $this->view,
            with: [
                'name' => $this->to_name,
                'activation_code' => $this->activation_code
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
