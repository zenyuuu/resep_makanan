<?php

namespace App\Policies;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResepPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // public listing allowed
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Resep $resep): bool
    {
        // anyone can view a resep
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // any authenticated user can create
        return (bool) $user;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resep $resep): bool
    {
        return $user->id === $resep->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resep $resep): bool
    {
        return $user->id === $resep->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resep $resep): bool
    {
        return $user->id === $resep->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resep $resep): bool
    {
        return $user->id === $resep->user_id;
    }
}
