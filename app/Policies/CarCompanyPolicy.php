<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarCompany;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarCompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the carCompany can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carCompany can view the model.
     */
    public function view(User $user, CarCompany $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carCompany can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the carCompany can update the model.
     */
    public function update(User $user, CarCompany $model): bool
    {
        return true;
    }

    /**
     * Determine whether the carCompany can delete the model.
     */
    public function delete(User $user, CarCompany $model): bool
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
     * Determine whether the carCompany can restore the model.
     */
    public function restore(User $user, CarCompany $model): bool
    {
        return false;
    }

    /**
     * Determine whether the carCompany can permanently delete the model.
     */
    public function forceDelete(User $user, CarCompany $model): bool
    {
        return false;
    }
}
