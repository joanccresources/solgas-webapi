<?php

namespace App\Jobs;

use App\Mail\LeadNotificationMail;
use App\Mail\LeadThankYouMail;
use App\Models\GeneralInformation;
use App\Models\LeadEmailDestination;
use App\Models\User;
use App\Notifications\v1\LeadRegisteredNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SendLeadNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $lead;
    public $leadType;

    public function __construct($lead, string $leadType)
    {
        $this->lead = $lead;
        $this->leadType = $leadType;
    }

    public function handle()
    {
        // Enviar la notificación usando la fachada Notification
        $users = User::all();
        Notification::send(
            $users,
            new LeadRegisteredNotification($this->lead, $this->leadType)
        );

        //obtener el logo email de la informacion general
        $general_information = GeneralInformation::first();

        // Lógica para enviar el correo a los emails de recepción
        $email_destinations = LeadEmailDestination::all();
        Mail::to($email_destinations)->send(new LeadNotificationMail($this->lead, $this->leadType, $general_information->logo_email_format));


        // Enviar el correo al cliente
        Mail::to($this->lead->email)->send(new LeadThankYouMail($this->lead, $general_information->logo_email_format));
    }
}
