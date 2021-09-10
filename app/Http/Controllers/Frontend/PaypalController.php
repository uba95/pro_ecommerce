<?php

namespace App\Http\Controllers\Frontend;

use Shippo_Object;
use App\Models\Shipment;
use App\Traits\CourierTrait;
use PayPalHttp\HttpException;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Services\ReturnOrderService;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalController extends Controller
{
    use CourierTrait;

    public function __invoke()
    {
        $request = new OrdersCaptureRequest(request('token'));
        $request->prefer('return=representation');

        try {
            $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.client_secret'));
            $client = new PayPalHttpClient($environment);
            $response = (object) $client->execute($request);
            
            if ($response->result->status == "COMPLETED") {
                return !request('return') 
                ?  OrderService::create('Paypal', $this->courier()) 
                : ReturnOrderService::create('Paypal', $this->courier());
            }
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}
