<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $logo_email;

    /**
     * Create a new message instance.
     */
    public function __construct($lead, $logo_email)
    {
        $this->lead = $lead;
        $this->logo_email = $logo_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gracias por contactarnos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.leads.thank_you', // Vista del correo
            with: [
                'lead' => $this->lead, // Pasar datos dinámicos a la vista
                'url_fronted' => config('services.urls.url_fronted'), // Pasar la URL del frontend
                'logo_email' => $this->logo_email, // Pasar el logo_email
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
