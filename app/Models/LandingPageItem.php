<?php

namespace App\Models;

use App\Enums\LandingPageItemStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class LandingPageItem extends Model
{
    use HasEnums;

    const IMAGES_STOREAGE = 'media/landing page/images/';

    protected $guarded = [];
    protected $casts = ['status' => 'int'];
    protected $enums = ['status' => LandingPageItemStatus::class];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getMainBannerImgAttribute($value) {
        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public function getBannerSliderImgAttribute($value) {
        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public function getAdvertImgAttribute($value) {
        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }
    
    public function  scopeActive($q){
        return $q->whereEnum('status', 'active');
    }

}
