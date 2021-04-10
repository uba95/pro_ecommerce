<?php

namespace App\Policies;

use App\Model\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Order $order) {

        return $user->id ===  $order->user_id;
    }

}
