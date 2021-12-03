<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Mail\OrderMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Facades\Invoice;
use Shippo_Object;
use Stripe\Charge;

class OrderService
{
    public static function create(string $payment_method, Shippo_Object $courier, $data = []) {
        try {

            $coupon = self::checkCoupon();
            
            DB::beginTransaction();

            $times = [
                'created_at' =>  $data['created_at'] ?? now(),
                'updated_at' =>  $data['updated_at'] ?? now(),
            ];

            $order = Order::create([
                'user_id'           => $data['user_id'] ?? current_user()->id,
                'address_id'        => $data['billing_address'],
                'coupon_id'         => $coupon['id'] ?? null,
                'payment_method'    => $payment_method,
                'subtotal_price'    => Cart::priceTotal(),
                'discount'          => Cart::discount(),
                'shipping_cost'     => $courier['amount'],
                'total_price'       => Cart::subtotal() + $courier['amount'],
                'status'            => $data['status'] ?? 0,
            ] + $times);

            DB::table('order_items')->insert(
                Cart::content()->map(fn($product) => [
                    'order_id'          => $order->id,
                    'product_id'        => $product->id,
                    'product_name'      => $product->name,
                    'product_quantity'  => $product->qty,
                    'product_price'     => $product->price,
                    'product_color'     => $product->options->color,
                    'product_size'      => $product->options->size,
                    'product_weight'    => $product->weight,
                    ] + $times
                )->all()    
            );
    
            DB::table('shipments')->insert([
                'order_id'      => $order->id,
                'address_id'    => $data['shipping_address'],
                'courier'       => $courier['servicelevel']['name'] . '-' . $courier['provider'],
            ] + $times);

            DB::commit();

            $coupon ? $coupon->increment('use_count', 1) : '';
            Cart::destroy();
            Session::forget('coupon');
            Session::forget('checkout_cart');
            Shipment::session_remove();

            Mail::to(current_user()->email)->send(new OrderMail($order));

            return redirect()->route('home')->with(toastNotification('Order', 'created'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }

    private static function checkCoupon() {
        $coupon = [];
        if ($v = Session::get('coupon')) {
            $coupon =  Coupon::valid($v)->first();

            if (!$coupon) {
                return redirect()->route('checkout.index')->with(toastNotification('Coupon Not Valid', 'error'));
            }
        }
        return $coupon;
    }

    private static function makeInvoice(Order $order) {

        $customer = new Buyer([
            'name'          => $order->user->name,
            'custom_fields' => [
                'address' =>  $order->address->address_1,
                'code' =>  $order->address->zip,
                'phone' =>  $order->address->phone,
                'email' =>  $order->user->email,
            ],
        ]);

        $items = $order->orderItems()
            ->NotCanceled()
            ->get()
            ->map(fn($v) => (new InvoiceItem())->title($v->product_name)->quantity($v->product_quantity)->pricePerUnit($v->product_price))
            ->toArray();

        $invoice = Invoice::make()
            ->sequence($order->id)
            ->serialNumberFormat('#{SEQUENCE}')
            ->buyer($customer)
            ->totalDiscount($order->discount)
            ->shipping($order->shipping_cost)
            ->addItems($items)
            ->filename(strtolower(config('app.name')) . '_invoice_' . $order->id);
            // ->logo(public_path('vendor/invoices/sample-logo.png'))
                
        return $invoice;
    }

    public static function generateInvoice(Order $order) {

        return self::makeInvoice($order)->stream();
    }

    public static function saveInvoice(Order $order) {

        return self::makeInvoice($order)->save('public')->url();
    }
}