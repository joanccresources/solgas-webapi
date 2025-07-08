<?php

namespace App\Policies\v1;

use App\Models\LeadServiceStation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadServiceStationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('leads.estacion-de-servicios.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadServiceStation $leadServiceStation): bool
    {
        if ($user->can('leads.estacion-de-servicios.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeadServiceStation $leadServiceStation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadServiceStation $leadServiceStation): bool
    {
        if ($user->can('leads.estacion-de-servicios.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeadServiceStation $leadServiceStation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeadServiceStation $leadServiceStation): bool
    {
        return false;
    }
}
