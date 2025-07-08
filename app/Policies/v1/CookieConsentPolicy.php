<?php

namespace App\Policies\v1;

use App\Models\CookieConsent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CookieConsentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can('configuracion.consentimiento-cookie.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CookieConsent $cookieConsent): bool
    {
        if ($user->can('configuracion.consentimiento-cookie.index')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CookieConsent $cookieConsent): bool
    {
        if ($user->can('configuracion.consentimiento-cookie.destroy')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CookieConsent $cookieConsent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CookieConsent $cookieConsent): bool
    {
        return false;
    }
}
