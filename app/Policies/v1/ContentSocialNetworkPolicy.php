<?php

namespace App\Policies\v1;

use App\Models\ContentSocialNetwork;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContentSocialNetworkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('redes-sociales.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentSocialNetwork $contentSocialNetwork): bool
    {
        if ($user->can('redes-sociales.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('redes-sociales.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentSocialNetwork $contentSocialNetwork): bool
    {
        if ($user->can('redes-sociales.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentSocialNetwork $contentSocialNetwork): bool
    {
        if ($user->can('redes-sociales.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('redes-sociales.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentSocialNetwork $contentSocialNetwork): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentSocialNetwork $contentSocialNetwork): bool
    {
        return false;
    }
}
