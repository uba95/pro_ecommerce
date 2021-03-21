<?php

namespace App\Model;

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
    protected $customer;
    protected $warehouseAddress;
    protected $deliveryAddress;
    protected $parcel;
    protected $shipment;
    // public static $session;

    public function __construct()
    {
        Shippo::setApiKey(config('shop.shipping_token'));

        $this->customer = Auth::user();
        // $this->session = app(SessionManager::class);
    }

    public function addShip($ship)
    {
        $content = new Collection();
        $content->put($ship->object_id, $ship);
        Session::put('ship', $content);
        // $this->session->put('ship.default', $content);

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
    public static function setPickupAddress() : object
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

        $o = new self;
        $o->warehouseAddress = $warehouse;
        return $o;
    }

    /**
     * @param Address $address
     */
    public function setDeliveryAddress(Address $address)
    {
        $delivery =  [
            'name' => $address->alias,
            'street1' => $address->address_1,
            'city' => $address->city,
            'zip' => $address->zip,
            'country' => $address->country->iso,
            'phone' => $address->phone,
            'email' => $this->customer->email
        ];

        $this->deliveryAddress = $delivery;
        return $this;
    }

    /**
     * @return \Shippo_Shipment
     */
    public function readyShipment()
    {
        $shipment = Shippo_Shipment::create([
                'address_from'=> $this->warehouseAddress,
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
    public function readyParcel(Collection $collection)
    {
        // $weight = $collection->map(fn($v) => $v->weight * $v->qty)->sum();
        $weight = Cart::weight();

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
