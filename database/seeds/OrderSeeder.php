<?php

use App\Enums\CancelOrderStatus;
use App\Enums\OrderStatus;
use App\Enums\ReturnOrderStatus;
use App\Models\Address;
use App\Models\CancelOrderItem;
use App\Models\CancelOrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ReturnOrderRequest;
use App\Models\Shipment;
use App\Models\User;
use App\Services\CancelOrderService;
use Illuminate\Support\Str;
use App\Services\OrderService;
use App\Services\ReturnOrderService;
use Illuminate\Database\Seeder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderCount =   100;
        $cancelOrderRequestsCount =   10;
        $retrunOrderRequestsCount =   10;
        
        $addresses = Address::select('id', 'user_id')->get();
        $products = Product::all();
        $coupons = Coupon::all();
        $faker = Faker\Factory::create(); 

        // Create Orders
        
        for ($i = 0; $i < $orderCount; $i++) { 

            for ($j = 0; $j < rand(1,5); $j++) { 

                $product = $products->random();
                $colors = collect($product->product_color);
                $sizes = collect($product->product_size);

                Cart::add($product, rand(1,2), [
                    'color' => $colors->isNotEmpty() ? $colors->random() : null,
                    'size' => $sizes->isNotEmpty() ? $sizes->random() : null,
                ]);
            }
            
            Cart::setGlobalDiscount(0);
            if ($faker->boolean(10)) {
                $c = $coupons->random();
                if (Coupon::valid($c->coupon_name)->first()) {
                    Session::put('coupon', $c->coupon_name);
                    Cart::setGlobalDiscount($c->discount);    
                }
            }

            $address = $addresses->random();
            $time = $faker->dateTimeBetween('-1 year');

            OrderService::create(
                collect(Order::PAYMENT_METHODS)->random() ,
                $this->courier(Cart::priceTotal()),
                [
                    'billing_address' => $address->id, 
                    'shipping_address' => $address->id,
                    'user_id' => $address->user_id,
                    'status' =>  array_rand([0,1,2,3]),
                    'created_at' => $time,
                    'updated_at' => $time,
                ]
            );    
        }

        // Update Orders

        Shipment::whereHas('order', fn($q) => $q->whereEnum('status', ['shipped', 'delivered']))->update(['started_at' => now()]);
        Shipment::whereHas('order', fn($q) => $q->whereEnum('status', 'delivered'))->update(['delivered_at' => now()->addDays(rand(1,5))]);


        // Create Cancel Order Requests

        $cancelable_orders = Order::select('id', 'status') 
        ->with('orderItems:id,order_id,product_id,product_quantity') 
        ->whereEnum('status', ['pending', 'paid']) 
        ->get();
        $cancelQ = [];
        
        for ($i=0; $i < $cancelOrderRequestsCount; $i++) { 

            $order = $cancelable_orders->random();
            $rand_items = rand(1, count($order->orderItems));
            $items = $order->orderItems->random($rand_items);
            $cancelQ[] = $items->map(fn($v) => ['id' => $v->id , 'quantity' => rand(1, $v->product_quantity)]);
            $sumQ = collect($cancelQ)->collapse()->groupBy('id')->map(fn($v) => $v->sum(fn($v) => $v['quantity']));

            if (!$items->every(fn($v) => $sumQ[$v->id] <= $v->product_quantity)) {
                $i--;
                array_pop($cancelQ);
                continue;
            }

            CancelOrderService::create(
                $this->courier($items->map(fn($v) => $v->product_quantity * $v->product_price)->sum()),
                [
                    'billing_address' => $address->id, 
                    'shipping_address' => $address->id,
                    'order_id' =>   $order->id,
                ], 
                $items
            );
        }
        
        // Update Cancel Order Requests

        CancelOrderRequest::with('order:id,coupon_id', 'order.orderItems')->get()->each(function ($v) {

            $status = collect(CancelOrderStatus::getValues())->random();
            $v->update(['status' => $status]);

            if (in_array($status, ['approved', 'refunded'])) {

                $v->decrementOrderItems();

                $data = [
                    'subtotal_price' => $totalPrice = $v->order->orderItems->sum->totalPrice,
                    'discount' => $discount = (float) discountPrice($totalPrice, optional($v->order->coupon)->discount),
                    'shipping_cost' => $shipping = $v->shipping_cost,
                    'total_price' => $totalPrice - $discount + $shipping,    
                ];
    
                if ($v->order->areAllItemsCanceled()) {
                    $data['status'] = OrderStatus::canceled()->getIndex();
                }
    
                $v->order->update($data);
            }
        });


        // Create Retrun Order Requests

        $returnable_orders = Order::select('id', 'status') 
        ->with('orderItems:id,order_id,product_id,product_quantity,product_price') 
        ->whereEnum('status', ['delivered', 'partiallyReturned']) 
        ->get();
        $returnQ = [];
        
        for ($i=0; $i < $retrunOrderRequestsCount; $i++) { 

            $order = $returnable_orders->random();
            $rand_items = rand(1, count($order->orderItems));
            $items = $order->orderItems->random($rand_items);
            $returnQ[] = $items->map(fn($v) => ['id' => $v->id , 'quantity' => rand(1, $v->product_quantity)]);
            $sumQ = collect($returnQ)->collapse()->groupBy('id')->map(fn($v) => $v->sum(fn($v) => $v['quantity']));

            if (!$items->every(fn($v) => $sumQ[$v->id] <= $v->product_quantity)) {
                $i--;
                array_pop($returnQ);
                continue;
            }

            $address = $addresses->random();

            ReturnOrderService::create(
                collect(Order::PAYMENT_METHODS)->random(),
                $this->courier($items->map(fn($v) => $v->product_quantity * $v->product_price)->sum()),
                [
                    'billing_address' => $address->id, 
                    'shipping_address' => $address->id,
                    'order_id' =>   $order->id,
                    'reason' => array_rand(ReturnOrderRequest::REASONS),
                    'details' => $faker->text,
                ],
                $items,
            );    

        }

        // Update Retrun Order Requests

        ReturnOrderRequest::with('order:id')->get()->each(function ($v) {

            $status = collect(ReturnOrderStatus::getValues())->random();
            $v->update(['status' => $status]);

            if ($status == 'approved') {
                $v->order->update(['status' => OrderStatus::returning()->getIndex()]);                
            }

            if ($status == 'returned') {
                $v->order->update(['status' =>  $v->order->returnStatus()->getIndex()]);;
            }
        });

        ReturnOrderRequest::whereEnum('status', ['shipped', 'returned'])->update(['shipping_started_at' => now()]);
        ReturnOrderRequest::whereEnum('status', ['returned'])->update(['shipping_returned_at' => now()->addDays(rand(1,5))]);
    }

    private function courier($order_price) {
        $courier = new Shippo_Object;
        $courier->amount =  rand(5, 10)/100 * $order_price;
        $courier->provider =  collect(['FedEx', 'USPS'])->random();
        $courier->servicelevel =  new Shippo_Object;
        $courier->servicelevel->name =  collect(['Express Saver', 'Ground', 'Priority Mail', 'First Overnight', 'Parcel Select'])->random();
        return $courier;
    }
}

