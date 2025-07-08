<?php

namespace App\Policies\v1;

use App\Models\GeneralInformation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GeneralInformationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.informacion-general.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GeneralInformation $generalInformation): bool
    {
        if ($user->can('configuracion.informacion-general.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('configuracion.informacion-general.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GeneralInformation $generalInformation): bool
    {
        if ($user->can('configuracion.informacion-general.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GeneralInformation $generalInformation): bool
    {
        if ($user->can('configuracion.informacion-general.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GeneralInformation $generalInformation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GeneralInformation $generalInformation): bool
    {
        return false;
    }
}
