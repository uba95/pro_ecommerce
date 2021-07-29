<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Address;
use App\Models\WishlistItem;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail 
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses() {
        
        return $this->hasMany(Address::class);
    }

    public function orders() {
        
        return $this->hasMany(Order::class);
    }

    public function wishlistItems() {
        
        return $this->belongsToMany(Product::class, 'wishlist_items')->withTimestamps()->select(['id','product_name','selling_price','discount_price','hot_new','image_one']);
    }

    public function hasProductOnWishlist($product_id) {

        return $this->wishlistItems->contains('pivot.product_id', $product_id);
    }

    public function getAvatarAttribute($value) {

        return asset($value ? 'storage/'. $value : 'frontend/images/default-user-profile.png');
    }
}
