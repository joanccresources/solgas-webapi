<?php

namespace App\Policies\v1;

use App\Models\PageMultipleFieldData;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PageMultipleFieldDataPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageMultipleFieldData $pageMultipleFieldData): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageMultipleFieldData $pageMultipleFieldData): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageMultipleFieldData $pageMultipleFieldData): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('configuracion.campos-elementos-multiples.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageMultipleFieldData $pageMultipleFieldData): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageMultipleFieldData $pageMultipleFieldData): bool
    {
        return false;
    }
}
