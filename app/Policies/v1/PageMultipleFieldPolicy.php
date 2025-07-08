<?php

namespace App\Policies\v1;

use App\Models\PageMultipleField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PageMultipleFieldPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.elementos-multiples.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageMultipleField $pageMultipleField): bool
    {
        if ($user->can('configuracion.elementos-multiples.index')) {
            return true;
        }
        return false;
    }

    public function viewPageMultipleField(User $user, PageMultipleField $pageMultipleField): bool
    {
        if ($user->can('contenido.paginas.index')) {
            return true;
        }
        return false;
    }

    public function viewPageMultipleFieldFormat(User $user, PageMultipleField $pageMultipleField): bool
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
        if ($user->can('configuracion.elementos-multiples.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageMultipleField $pageMultipleField): bool
    {
        if ($user->can('configuracion.elementos-multiples.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageMultipleField $pageMultipleField): bool
    {
        if ($user->can('configuracion.elementos-multiples.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('configuracion.elementos-multiples.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageMultipleField $pageMultipleField): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageMultipleField $pageMultipleField): bool
    {
        return false;
    }
}
