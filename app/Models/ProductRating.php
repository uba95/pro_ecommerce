<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    protected $guarded = [];

    public function scopeGetAvg($q) {
        return $q->selectRaw('product_id, ROUND(AVG(`value`) / 10, 1) AS avg')->groupBy('product_id');
    }

}
