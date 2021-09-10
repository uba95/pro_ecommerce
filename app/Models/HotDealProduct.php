<?php

namespace App\Models;

use App\Enums\HotDealStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class HotDealProduct extends Model
{
    use HasEnums;

    protected $guarded = [];
    protected $primaryKey = 'product_id';
    protected $casts = ['started_at' => 'datetime', 'expired_at' => 'datetime', 'status' => 'int'];
    protected $enums = ['status' => HotDealStatus::class];

    public function product() {
        return $this->belongsTo(Product::class)->select(
            [
                'id','category_id','subcategory_id','brand_id','sku','product_name','product_slug','selling_price',
                'product_quantity','discount_price','status','hot_new','cover'
            ]);
    }
}
