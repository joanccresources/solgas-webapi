<?php

namespace App\Policies\v1;

use App\Models\LeadEmailDestination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadEmailDestinationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('leads.emails-de-recepcion.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadEmailDestination $leadEmailDestination): bool
    {
        if ($user->can('leads.emails-de-recepcion.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('leads.emails-de-recepcion.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeadEmailDestination $leadEmailDestination): bool
    {
        if ($user->can('leads.emails-de-recepcion.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadEmailDestination $leadEmailDestination): bool
    {
        if ($user->can('leads.emails-de-recepcion.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeadEmailDestination $leadEmailDestination): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeadEmailDestination $leadEmailDestination): bool
    {
        return false;
    }
}
