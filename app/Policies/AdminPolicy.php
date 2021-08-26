<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    use HandlesAuthorization;

    public function edit(Admin $auth, Admin $target) {

        // super admin can edit any admin
        // administrator can edit any admin except super admin
        // any admin can edit their account
        return $auth->can('edit admins') && !$target->hasRole(Role::SUPER_ADMIN) 
                ? true 
                : ($target->is($auth) || $auth->hasRole(Role::SUPER_ADMIN));
    }

    public function delete(Admin $auth, Admin $target) {

        // super admin can delete any admin
        // administrator can delete any admin except super admin
        return $auth->can('delete admins') && !$target->hasRole(Role::SUPER_ADMIN) 
                ? true 
                : $auth->hasRole(Role::SUPER_ADMIN);
    }
}
