<?php

namespace App\Policies\v1;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttributePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.atributos.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attribute $attribute): bool
    {
        if ($user->can('configuracion.atributos.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('configuracion.atributos.create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attribute $attribute): bool
    {
        if ($user->can('configuracion.atributos.edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attribute $attribute): bool
    {
        if ($user->can('configuracion.atributos.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function order(User $user): bool
    {
        if ($user->can('configuracion.atributos.order')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attribute $attribute): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attribute $attribute): bool
    {
        return false;
    }
}
