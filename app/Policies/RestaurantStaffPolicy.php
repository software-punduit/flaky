<?php

namespace App\Policies;

use App\Models\RestaurantStaff;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestaurantStaffPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('restaurant-staff.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RestaurantStaff $restaurantStaff): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('restaurant-staff.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RestaurantStaff $restaurantStaff): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RestaurantStaff $restaurantStaff): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RestaurantStaff $restaurantStaff): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RestaurantStaff $restaurantStaff): bool
    {
        //
    }
}
