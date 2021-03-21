<?php

namespace App\Services;

use Stripe\Charge;
use Stripe\Stripe;
use Shippo_Object;

class StripeService 
{
    public static function charge(float $amount, $courier) {

        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        $charge = Charge::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'source' => request('stripeToken'),
        ]);

        return OrderService::create('Stripe', $courier, $charge);
    }

}