<?php

namespace App\Observers;

use App\Jobs\SendLeadNotificationEmail;
use App\Jobs\StoreLeadNotification;
use App\Models\LeadDistributor;

class LeadDistributorObserver
{
    /**
     * Handle the LeadDistributor "created" event.
     */
    public function created(LeadDistributor $leadDistributor): void
    {
        // Enviar correo
        SendLeadNotificationEmail::dispatch($leadDistributor->load('codeUbigeoRel'), 'lead_distributors')->onQueue('high');
    }

    /**
     * Handle the LeadDistributor "updated" event.
     */
    public function updated(LeadDistributor $leadDistributor): void
    {
        //
    }

    /**
     * Handle the LeadDistributor "deleted" event.
     */
    public function deleted(LeadDistributor $leadDistributor): void
    {
        //
    }

    /**
     * Handle the LeadDistributor "restored" event.
     */
    public function restored(LeadDistributor $leadDistributor): void
    {
        //
    }

    /**
     * Handle the LeadDistributor "force deleted" event.
     */
    public function forceDeleted(LeadDistributor $leadDistributor): void
    {
        //
    }
}
