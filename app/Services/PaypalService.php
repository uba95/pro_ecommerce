<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaypalService 
{
    public static function charge($amount, $return=false) {

        $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));

        $client = new PayPalHttpClient($environment);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $return_requset = $return ? request()->only(['order_id','reason','details']) : [];
        
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => round($amount, 2),
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('checkout.index'),
                "return_url" => route('payment.paypal.order', request()->only([
                    'billing_address',
                    'shipping_address',
                    'rate_object_id',
                ]) + $return_requset + compact('return')) // PaypalController
            ] 
        ];
        
        try {
            $response = (object) $client->execute($request);
            return redirect($response->result->links[1]->href);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}