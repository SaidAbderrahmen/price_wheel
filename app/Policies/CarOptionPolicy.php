<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the carOption can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carOption can view the model.
     */
    public function view(User $user, CarOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carOption can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carOption can update the model.
     */
    public function update(User $user, CarOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carOption can delete the model.
     */
    public function delete(User $user, CarOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carOption can restore the model.
     */
    public function restore(User $user, CarOption $model): bool
    {
        return false;
    }

    /**
     * Determine whether the carOption can permanently delete the model.
     */
    public function forceDelete(User $user, CarOption $model): bool
    {
        return false;
    }
}
