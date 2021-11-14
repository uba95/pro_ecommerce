<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Charge;
use Stripe\Stripe;
use Shippo_Object;

class StripeService 
{
    public static function charge(float $amount, $courier, $returnOrder = false) {

        Stripe::setApiKey(config('services.stripe.client_secret'));
        
        Charge::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'source' => request('stripeToken'),
        ]);

        return !$returnOrder 
                ?  OrderService::create(Order::PAYMENT_METHODS['stripe'], $courier, request()->only('billing_address', 'shipping_address')) 
                : ReturnOrderService::create(Order::PAYMENT_METHODS['stripe'], $courier, request()->all());
    }

}