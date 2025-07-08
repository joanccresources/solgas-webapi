<?php

namespace App\Policies\v1;

use App\Models\ContentFooter;
use App\Models\User;

class ContentFooterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('contenido.footer.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentFooter $contentFooter): bool
    {
        if ($user->can('contenido.footer.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('contenido.footer.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentFooter $contentFooter): bool
    {
        if ($user->can('contenido.footer.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentFooter $contentFooter): bool
    {
        if ($user->can('contenido.footer.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentFooter $contentFooter): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentFooter $contentFooter): bool
    {
        return false;
    }
}
