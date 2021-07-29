<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReturnOrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user, OrderItem $orderItem) {
        return $user->id === $orderItem->order->user_id;
    }

}
