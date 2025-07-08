<?php

namespace App\Observers;

use App\Jobs\SendLeadNotificationEmail;
use App\Models\LeadWorkWithUs;

class LeadWorkWithUsObserver
{
    /**
     * Handle the LeadWorkWithUs "created" event.
     */
    public function created(LeadWorkWithUs $leadWorkWithUs): void
    {
        // Enviar correo
        SendLeadNotificationEmail::dispatch($leadWorkWithUs->load('employmentRel'), 'lead_work_with_us')->onQueue('high');
    }

    /**
     * Handle the LeadWorkWithUs "updated" event.
     */
    public function updated(LeadWorkWithUs $leadWorkWithUs): void
    {
        //
    }

    /**
     * Handle the LeadWorkWithUs "deleted" event.
     */
    public function deleted(LeadWorkWithUs $leadWorkWithUs): void
    {
        //
    }

    /**
     * Handle the LeadWorkWithUs "restored" event.
     */
    public function restored(LeadWorkWithUs $leadWorkWithUs): void
    {
        //
    }

    /**
     * Handle the LeadWorkWithUs "force deleted" event.
     */
    public function forceDeleted(LeadWorkWithUs $leadWorkWithUs): void
    {
        //
    }
}
