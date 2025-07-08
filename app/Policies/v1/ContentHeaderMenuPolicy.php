<?php

namespace App\Policies\v1;

use App\Models\ContentHeaderMenu;
use App\Models\User;

class ContentHeaderMenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('contenido.header.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentHeaderMenu $contentHeaderMenu): bool
    {
        if ($user->can('contenido.header.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('contenido.header.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentHeaderMenu $contentHeaderMenu): bool
    {
        if ($user->can('contenido.header.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentHeaderMenu $contentHeaderMenu): bool
    {
        if ($user->can('contenido.header.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('contenido.header.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentHeaderMenu $contentHeaderMenu): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentHeaderMenu $contentHeaderMenu): bool
    {
        return false;
    }
}
