<?php

namespace App\Models;

use Shippo;
use Shippo_Rate;
use Shippo_Shipment;
use Shippo_Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Session;

class Shipment extends Model
{
    protected $guarded = [];
    protected $casts = ['started_at' => 'datetime', 'delivered_at' => 'datetime'];
    protected $pickedupAddress;
    protected $deliveryAddress;
    protected $parcel;
    protected $shipment;

    public function __construct()
    {
        Shippo::setApiKey(config('shop.shipping_token'));
    }
    
    public function address() {
     
        return $this->belongsTo(Address::class);
    }

    public function addShip($ship)
    {
        $content = new Collection();
        $content->put($ship->object_id, $ship);
        Session::put('ship', $content);

        return $ship;
    }

    public static function session_content() : array
    {
        $s = Session::get('ship');
        return $s ?  $s->first()->rates : [];
    }

    public static function session_remove()
    {
         Session::forget('ship');
         return Session::save();

    }

    /**
     * Address where the shipment will be picked up
     */
    public static function setAddress(Address $address, $returnOrder = false) :object
    {
        $warehouse = [
            'name' => config('app.name'),
            'street1' => config('shop.warehouse.address_1'),
            'city' => config('shop.warehouse.city'),
            'state' => config('shop.warehouse.state'),
            'zip' => config('shop.warehouse.zip'),
            'country' => config('shop.warehouse.country'),
            'phone' => config('shop.phone'),
            'email' => config('shop.email')
        ];

        $setAddress =  [
            'name' => $address->alias,
            'street1' => $address->address_1,
            'city' => $address->city,
            'zip' => $address->zip,
            'country' => $address->country->iso,
            'phone' => $address->phone,
            'email' => Auth::user()->email
        ];
    
        $o = new self;
        $o->pickedupAddress = $returnOrder ?  $setAddress  :  $warehouse;
        $o->deliveryAddress = !$returnOrder ?  $setAddress  :  $warehouse;
        return  $o;
    }

    public function readyShipment()
    {
        $shipment = Shippo_Shipment::create([
                'address_from'=> $this->pickedupAddress,
                'address_to'=> $this->deliveryAddress,
                'parcels'=> $this->parcel,
                'async'=> false
        ]); 
        $this->addShip($shipment);  
        return $shipment; 
    }

    /**
     * @param string $id
     * @param string $currency
     *
     * @return \Shippo_Shipment
     */
    public static function getRates(string $id, string $currency = 'USD')
    {
        return Shippo_Shipment::get_shipping_rates(compact('id', 'currency'));
    }

    public static function retrieveRate(string $id)
    {
        return Shippo_Rate::retrieve($id);
    }

    /**
     * @param Collection $collection
     *
     * @return void
     */
    public function readyParcel(Collection $collection, $cart = true)
    {
        $weight =  $cart ?  Cart::weight() : $collection->map(fn($v) => $v->product_weight * $v->product_quantity)->sum();
        $weight = intval($weight) ?  $weight : 1;
        $parcel = array(
            'length'=> '50',
            'width'=> '50',
            'height'=> '10',
            'distance_unit'=> 'cm',
            'weight'=> $weight,
            'mass_unit'=> 'kg',
        );

        $this->parcel = $parcel;
        return $this;
    }

    // public function transaction($selected_rate_object_id) {
    

    //     $transaction = Shippo_Transaction::create(array(
    //         'rate'=> $selected_rate_object_id,
    //         'async'=> false,
    //     ));
        
    //     // Print the shipping label from label_url
    //     // Get the tracking number from tracking_number
    //     if ($transaction['status'] == 'SUCCESS'){
    //         echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
    //         echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
    //     } else {
    //         echo "Transaction failed with messages:" . "\n";
    //         foreach ($transaction['messages'] as $message) {
    //             echo "--> " . $message . "\n";
    //         }
    //     }
        
    // }

}
