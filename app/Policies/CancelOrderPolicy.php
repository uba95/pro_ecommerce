<?php

namespace App\Policies;

use App\Model\CancelOrderRequest;
use App\Model\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CancelOrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user,Order $order) {
        return $user->id ===  $order->user_id;
    }

}
