<?php

namespace App\Policies\CompanyDetail;

use App\Models\CompanyDetail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyDetailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CompanyDetail $companyDetail): bool
    {
        return $companyDetail->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CompanyDetail $companyDetail): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CompanyDetail $companyDetail): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CompanyDetail $companyDetail): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CompanyDetail $companyDetail): bool
    {
        return false;
    }
}
