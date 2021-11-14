<?php

namespace App\Traits;

use App\Models\Shipment;

trait CourierTrait {

    public function courier() {
        // get rate from session
        if (($rates = Shipment::getRates()) && ($rate_object_id = request('rate_object_id'))) {
            return array_values(array_filter($rates, fn($v) => $v['object_id'] == $rate_object_id))[0];
        }    
    }
}