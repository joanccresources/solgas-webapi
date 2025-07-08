<?php

namespace App\Policies\v1;

use App\Models\Map;
use App\Models\User;

class MapPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('mapas.distribuidores.index') || $user->can('mapas.estaciones-de-servicios.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Map $map): bool
    {
        if ($user->can('mapas.distribuidores.index') || $user->can('mapas.estaciones-de-servicios.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('mapas.distribuidores.create') || $user->can('mapas.estaciones-de-servicios.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Map $map): bool
    {
        if ($user->can('mapas.distribuidores.edit') || $user->can('mapas.estaciones-de-servicios.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Map $map): bool
    {
        if ($user->can('mapas.distribuidores.destroy') || $user->can('mapas.estaciones-de-servicios.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('mapas.distribuidores.order') || $user->can('mapas.estaciones-de-servicios.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Map $map): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Map $map): bool
    {
        return false;
    }
}
