<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $leadType;
    public $logo_email;

    /**
     * Create a new message instance.
     */
    public function __construct($lead, string $leadType, $logo_email)
    {
        $this->lead = $lead;
        $this->leadType = $leadType;
        $this->logo_email = $logo_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailContent = $this->getEmailsContentForLeadType();

        return new Envelope(
            subject: $emailContent['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $emailContent = $this->getEmailsContentForLeadType();

        return new Content(
            view: $emailContent['view'], // Vista específica para el lead_type
            with: [
                'lead' => $this->lead,           // Pasar los datos del lead
                'leadType' => $this->leadType,   // Tipo de lead
                'title' => $emailContent['subject'], // Pasar el título dinámico
                'logo_email' => $this->logo_email, // Pasar el logo_email
            ]
        );
    }

    /**
     * Get email content based on lead type.
     */
    protected function getEmailsContentForLeadType(): array
    {
        $content = [
            'lead_distributors' => [
                'subject' => 'Nuevo Lead Distribuidor Registrado',
                'view' => 'emails.leads.distributor',
            ],
            'lead_service_stations' => [
                'subject' => 'Nuevo Lead Estación de Servicio Registrado',
                'view' => 'emails.leads.service_station',
            ],
            'lead_work_with_us' => [
                'subject' => 'Nuevo Lead Trabaja con Nosotros Registrado',
                'view' => 'emails.leads.work_with_us',
            ],
            'lead' => [
                'subject' => 'Nuevo Contacto Registrado',
                'view' => 'emails.leads.lead',
            ],
        ];

        return $content[$this->leadType] ?? [
            'subject' => 'Nuevo Contacto Registrado',
            'view' => 'emails.leads.lead',
        ];
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
