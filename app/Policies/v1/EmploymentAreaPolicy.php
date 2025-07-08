<?php

namespace App\Policies\v1;

use App\Models\EmploymentArea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmploymentAreaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('empleos.areas.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmploymentArea $employmentArea): bool
    {
        if ($user->can('empleos.areas.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('empleos.areas.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmploymentArea $employmentArea): bool
    {
        if ($user->can('empleos.areas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmploymentArea $employmentArea): bool
    {
        if ($user->can('empleos.areas.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmploymentArea $employmentArea): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmploymentArea $employmentArea): bool
    {
        return false;
    }
}
