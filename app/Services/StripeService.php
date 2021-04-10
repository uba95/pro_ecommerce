<?php

namespace App\Services;

use Stripe\Charge;
use Stripe\Stripe;
use Shippo_Object;

class StripeService 
{
    public static function charge(float $amount, $courier, $returnOrder = false) {

        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        Charge::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'source' => request('stripeToken'),
        ]);

        return !$returnOrder 
                ?  OrderService::create('Stripe', $courier) 
                : ReturnOrderService::create('Stripe', $courier);
    }

}