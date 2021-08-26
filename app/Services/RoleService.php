<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Collection;

class RoleService 
{
    private Collection $roles;

    public static function filter(Admin $admin, Collection $roles) {
        $obj = new self;
        $obj->roles = $admin->hasRole(Role::SUPER_ADMIN) ? $roles : $roles->diff([Role::SUPER_ADMIN]);
        return $obj;
    }
    
    public function assignTo(Admin $admin) {
        return $admin->syncRoles($this->roles);
    }

    public function get() {
        return $this->roles;
    }
}