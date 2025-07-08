<?php

namespace App\Policies\v1;

use App\Models\PageMultipleContent;
use App\Models\User;

class PageMultipleContentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewPageMultipleContent(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        if ($user->can('contenido.paginas.index')) {
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
     * Determine whether the user can create models.
     */
    public function createPageMultipleContent(User $user): bool
    {
        if ($user->can('contenido.paginas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageMultipleContent $pageMultipleContent): bool
    {

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updatePageMultipleContent(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        if ($user->can('contenido.paginas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deletePageMultipleContent(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        if ($user->can('contenido.paginas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function orderPageMultipleContent(User $user): bool
    {
        if ($user->can('contenido.paginas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageMultipleContent $pageMultipleContent): bool
    {
        return false;
    }
}
