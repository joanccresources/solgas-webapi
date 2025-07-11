<?php

namespace App\Policies\v1;

use App\Models\Employment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmploymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('empleos.publicaciones.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employment $employment): bool
    {
        if ($user->can('empleos.publicaciones.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('empleos.publicaciones.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employment $employment): bool
    {
        if ($user->can('empleos.publicaciones.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employment $employment): bool
    {
        if ($user->can('empleos.publicaciones.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employment $employment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employment $employment): bool
    {
        return false;
    }
}
