<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaypalService 
{
    public static function charge($amount) {

        $environment = new SandboxEnvironment(env('PP_CLIENT_ID'), env('PP_CLIENT_SECRET'));
        $client = new PayPalHttpClient($environment);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
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
                    'rate_object_id'
                ])) // PaypalController
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