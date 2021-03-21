<?php

namespace App\Traits;

use App\Model\Shipment;

trait CourierTrait {

    public function courier() {
        if (($s = Shipment::session_content()) && ($r = request('rate_object_id'))) {
            return array_values(array_filter($s, fn($v) => $v['object_id'] == $r))[0];
        }    
    }
}