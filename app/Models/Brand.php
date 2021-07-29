<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];

    public function getBrandLogoAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }

    // public function getLogo() {

    //     $value = $this->brand_logo;
    //     return asset($value ? 'storage/'. $value : '/media/default-logo.png');
    // }

}
