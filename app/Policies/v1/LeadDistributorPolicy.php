<?php

namespace App\Policies\v1;

use App\Models\LeadDistributor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadDistributorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('leads.distribuidores.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadDistributor $leadDistributor): bool
    {
        if ($user->can('leads.distribuidores.index')) {
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
    public function update(User $user, LeadDistributor $leadDistributor): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadDistributor $leadDistributor): bool
    {
        if ($user->can('leads.distribuidores.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeadDistributor $leadDistributor): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeadDistributor $leadDistributor): bool
    {
        return false;
    }
}
