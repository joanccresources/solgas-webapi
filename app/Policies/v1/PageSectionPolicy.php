<?php

namespace App\Policies\v1;

use App\Models\PageSection;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PageSectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.secciones.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PageSection $pageSection): bool
    {
        if ($user->can('configuracion.secciones.index')) {
            return true;
        }
        return false;
    }

    public function viewPageSectionField(User $user, PageSection $pageSection): bool
    {
        if ($user->can('contenido.paginas.index')) {
            return true;
        }
        return false;
    }

    public function viewPageMultipleFieldSection(User $user, PageSection $pageSection): bool
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
        if ($user->can('configuracion.secciones.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PageSection $pageSection): bool
    {
        if ($user->can('configuracion.secciones.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updatePageSectionField(User $user, PageSection $pageSection): bool
    {
        if ($user->can('contenido.paginas.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PageSection $pageSection): bool
    {
        if ($user->can('configuracion.secciones.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('configuracion.secciones.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PageSection $pageSection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PageSection $pageSection): bool
    {
        return false;
    }
}
