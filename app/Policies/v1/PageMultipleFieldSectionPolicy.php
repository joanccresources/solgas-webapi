<?php

namespace App\Policies\v1;

use App\Models\PageMultipleFieldSection;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PageMultipleFieldSectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.elementos-multiples-para-secciones.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageMultipleFieldSection $pageMultipleFieldSection): bool
    {
        if ($user->can('configuracion.elementos-multiples-para-secciones.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('configuracion.elementos-multiples-para-secciones.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageMultipleFieldSection $pageMultipleFieldSection): bool
    {
        if ($user->can('configuracion.elementos-multiples-para-secciones.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageMultipleFieldSection $pageMultipleFieldSection): bool
    {
        if ($user->can('configuracion.elementos-multiples-para-secciones.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageMultipleFieldSection $pageMultipleFieldSection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageMultipleFieldSection $pageMultipleFieldSection): bool
    {
        return false;
    }
}
