<?php

namespace App\Policies\v1;

use App\Models\LeadWorkWithUs;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadWorkWithUsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('leads.trabaja-con-nosotros.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadWorkWithUs $leadWorkWithUs): bool
    {
        if ($user->can('leads.trabaja-con-nosotros.index')) {
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
    public function update(User $user, LeadWorkWithUs $leadWorkWithUs): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadWorkWithUs $leadWorkWithUs): bool
    {
        if ($user->can('leads.trabaja-con-nosotros.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeadWorkWithUs $leadWorkWithUs): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeadWorkWithUs $leadWorkWithUs): bool
    {
        return false;
    }
}
