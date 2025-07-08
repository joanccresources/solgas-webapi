<?php

namespace App\Observers;

use App\Jobs\SendLeadNotificationEmail;
use App\Models\LeadServiceStation;

class LeadServiceStationObserver
{
    /**
     * Handle the LeadServiceStation "created" event.
     */
    public function created(LeadServiceStation $leadServiceStation): void
    {
        // Enviar correo
        SendLeadNotificationEmail::dispatch($leadServiceStation, 'lead_service_stations')->onQueue('high');
    }

    /**
     * Handle the LeadServiceStation "updated" event.
     */
    public function updated(LeadServiceStation $leadServiceStation): void
    {
        //
    }

    /**
     * Handle the LeadServiceStation "deleted" event.
     */
    public function deleted(LeadServiceStation $leadServiceStation): void
    {
        //
    }

    /**
     * Handle the LeadServiceStation "restored" event.
     */
    public function restored(LeadServiceStation $leadServiceStation): void
    {
        //
    }

    /**
     * Handle the LeadServiceStation "force deleted" event.
     */
    public function forceDeleted(LeadServiceStation $leadServiceStation): void
    {
        //
    }
}
