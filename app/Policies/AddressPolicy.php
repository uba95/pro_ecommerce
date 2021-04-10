<?php

namespace App\Policies;

use App\Model\Address;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy 
{
    use HandlesAuthorization;

    public function change(User $user, Address $address) {
        return $user->id ===  $address->user_id;
    }
}
