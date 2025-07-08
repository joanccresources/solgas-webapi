<?php

namespace App\Policies\v1;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    protected function hasPermission(User $user, string $action): bool
    {
        return $user->can("configuracion.paginas.$action")
            || $user->can("seo.$action")
            || $user->can("contenido.paginas.$action");
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'index');
    }

    public function view(User $user, Page $page): bool
    {
        return $this->hasPermission($user, 'index');
    }

    public function viewPageSection(User $user, Page $page): bool
    {
        return $this->hasPermission($user, 'index');
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'create');
    }

    public function update(User $user, Page $page): bool
    {
        return $this->hasPermission($user, 'edit');
    }

    public function delete(User $user, Page $page): bool
    {
        return $this->hasPermission($user, 'destroy');
    }
}
