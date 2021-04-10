<?php

namespace App\Policies;

use App\Model\Order;
use App\Model\OrderItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReturnOrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user, OrderItem $orderItem) {
        return $user->id === $orderItem->order->user_id;
    }

}
