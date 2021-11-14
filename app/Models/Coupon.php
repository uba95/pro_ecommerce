<?php

namespace App\Models;

use App\Enums\CouponStatus;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasEnums;

    protected $guarded = [];
    protected $casts = ['started_at' => 'datetime', 'expired_at' => 'datetime', 'status' => 'int'];
    protected $enums = ['status' => CouponStatus::class];

    public function  scopeActive($q){
        return $q->whereEnum('status', 'active');
    }
   
    public function scopeValid($q, $code) {
        $q->where('coupon_name', $code)
        ->where(fn($q) => 
            $q->where(fn($q) =>
                $q->where('max_use_count', '<>', 0)->whereColumn('use_count', '<', 'max_use_count'))
            ->orWhere('max_use_count', 0))
        ->active();
    }
}