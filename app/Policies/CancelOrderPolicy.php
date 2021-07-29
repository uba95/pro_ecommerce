<?php

namespace App\Policies;

use App\Models\CancelOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CancelOrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user,Order $order) {
        return $user->id ===  $order->user_id;
    }

}
