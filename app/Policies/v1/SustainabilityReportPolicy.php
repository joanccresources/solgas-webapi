<?php

namespace App\Policies\v1;

use App\Models\SustainabilityReport;
use App\Models\User;

class SustainabilityReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('reporte-sostenibilidad.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SustainabilityReport $sustainabilityReport): bool
    {
        if ($user->can('reporte-sostenibilidad.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('reporte-sostenibilidad.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SustainabilityReport $sustainabilityReport): bool
    {
        if ($user->can('reporte-sostenibilidad.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SustainabilityReport $sustainabilityReport): bool
    {
        if ($user->can('reporte-sostenibilidad.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('reporte-sostenibilidad.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SustainabilityReport $sustainabilityReport): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SustainabilityReport $sustainabilityReport): bool
    {
        return false;
    }
}
