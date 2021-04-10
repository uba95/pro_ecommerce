<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReturnOrderItem extends Model
{
    protected $guarded = [];

    public function returnOrderRequest() {
     
        return $this->belongsTo(ReturnOrderRequest::class, 'request_id');
    }

    public function orderItem() {
     
        return $this->belongsTo(OrderItem::class);
    }

}
