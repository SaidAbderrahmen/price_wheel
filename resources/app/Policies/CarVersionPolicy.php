<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarVersion;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarVersionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the carVersion can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carVersion can view the model.
     */
    public function view(User $user, CarVersion $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carVersion can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carVersion can update the model.
     */
    public function update(User $user, CarVersion $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carVersion can delete the model.
     */
    public function delete(User $user, CarVersion $model): bool
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
     * Determine whether the carVersion can restore the model.
     */
    public function restore(User $user, CarVersion $model): bool
    {
        return false;
    }

    /**
     * Determine whether the carVersion can permanently delete the model.
     */
    public function forceDelete(User $user, CarVersion $model): bool
    {
        return false;
    }
}
