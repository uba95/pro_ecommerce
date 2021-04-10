<?php

namespace App\Model;

use App\Model\Order;
use App\Enums\CancelOrderStatus;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class CancelOrderRequest extends Model
{
    use HasEnums;

    protected $guarded = [];
    protected $casts = ['status' => 'int'];
    protected $enums = ['status' => CancelOrderStatus::class];

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

}
