<?php

namespace App\Policies;

use App\Helpers\Role;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnnouncementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Announcement $announcement): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if(Role::isAdminOrManagementOrPrincipalOrManager()){
            return true;
        }

        if(Role::isTeacher()){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        if(Role::isAdminOrManagementOrPrincipalOrManager()){
            return true;
        }

        if(Role::isTeacher() && $announcement->user_id == $user->id && !$announcement->is_published){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        if(Role::isAdminOrManagementOrPrincipalOrManager()){
            return true;
        }

        if(Role::isTeacher() && $announcement->user_id == $user->id && !$announcement->is_published){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Announcement $announcement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Announcement $announcement): bool
    {
        return false;
    }
}
