<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    protected $guarded = [];
    public $table = 'product_meta';
    public $primaryKey = 'product_id';
    public    $incrementing = false;
    
    public function product() {
        return $this->belongsTo(Product::class);
    }

}
