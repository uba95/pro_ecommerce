<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminPasswordResetNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    protected $guarded = [];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value) {
        return $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function sendPasswordResetNotification($token)
    {
        return $this->notify(new AdminPasswordResetNotification($token));
    }
    
    public function sendEmailVerificationNotification()
    {
        return $this->notify(new VerifyEmail);
    }

    public function getAvatarAttribute($value) {
        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public static function filterRolesForSuperAdminRole($admin, $roles) {

        return $admin->hasRole(Role::SUPER_ADMIN) ? $roles : $roles->diff([Role::SUPER_ADMIN]);
    }

}
