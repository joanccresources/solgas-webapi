<?php

namespace App\Policies\v1;

use App\Models\Module;
use App\Models\User;

class ModulePolicy
{
    /**
     * Check if the user has the required permission for modules or submodules.
     */
    protected function hasPermission(User $user, string $action): bool
    {
        return $user->can("configuracion.modulos.$action") || $user->can("configuracion.submodulos.$action");
    }

    /**
     * Determine whether the user can view any modules or submodules.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'index');
    }

    /**
     * Determine whether the user can view a specific module or submodule.
     */
    public function view(User $user, Module $module): bool
    {
        return $this->hasPermission($user, 'index');
    }

    /**
     * Determine whether the user can create modules or submodules.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'create');
    }

    /**
     * Determine whether the user can update a module or submodule.
     */
    public function update(User $user, Module $module): bool
    {
        return $this->hasPermission($user, 'edit');
    }

    /**
     * Determine whether the user can delete a module or submodule.
     */
    public function delete(User $user, Module $module): bool
    {
        return $this->hasPermission($user, 'destroy');
    }

    /**
     * Determine whether the user can reorder modules or submodules.
     */
    public function order(User $user): bool
    {
        return $this->hasPermission($user, 'order');
    }

    /**
     * Determine whether the user can restore a module or submodule.
     */
    public function restore(User $user, Module $module): bool
    {
        return false; // Restoring is not allowed.
    }

    /**
     * Determine whether the user can permanently delete a module or submodule.
     */
    public function forceDelete(User $user, Module $module): bool
    {
        return false; // Permanent deletion is not allowed.
    }
}
