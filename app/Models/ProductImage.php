<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = [];
    
    public function getNameAttribute($value) {
        return asset('storage/'. $value);
    }

}
