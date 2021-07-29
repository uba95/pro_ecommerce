<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];
    protected $with = ['country:id,name,iso'];

    public function country() {
     
        return $this->belongsTo(Country::class);
    }
}
