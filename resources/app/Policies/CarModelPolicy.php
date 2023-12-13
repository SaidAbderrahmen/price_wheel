<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the carModel can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carModel can view the model.
     */
    public function view(User $user, CarModel $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carModel can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carModel can update the model.
     */
    public function update(User $user, CarModel $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carModel can delete the model.
     */
    public function delete(User $user, CarModel $model): bool
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
     * Determine whether the carModel can restore the model.
     */
    public function restore(User $user, CarModel $model): bool
    {
        return false;
    }

    /**
     * Determine whether the carModel can permanently delete the model.
     */
    public function forceDelete(User $user, CarModel $model): bool
    {
        return false;
    }
}
