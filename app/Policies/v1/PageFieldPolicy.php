<?php

namespace App\Policies\v1;

use App\Models\PageField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PageFieldPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.campos.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageField $pageField): bool
    {
        if ($user->can('configuracion.campos.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('configuracion.campos.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageField $pageField): bool
    {
        if ($user->can('configuracion.campos.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageField $pageField): bool
    {
        if ($user->can('configuracion.campos.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('configuracion.campos.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageField $pageField): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageField $pageField): bool
    {
        return false;
    }
}
