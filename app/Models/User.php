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
    protected $guard = 'web';

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
        
        return $this->belongsToMany(Product::class, 'wishlist_items')->withTimestamps()->select(['id','product_name','selling_price','discount_price','hot_new','cover']);
    }

    public function hasProductOnWishlist($product_id) {

        return $this->wishlistItems->contains('pivot.product_id', $product_id);
    }

    // public function ratings() {
        
    //     return $this->hasMany(ProductRating::class);
    // }
    
    public function productRatings() {

        return $this->belongsToMany(Product::class, 'product_ratings')->withTimestamps()->select('id')->withPivot('value');
    }

    public function theirProductRating($product_id) {
        
        return optional($this->productRatings()->firstWhere('products.id', $product_id))->value;
    }

    public function getAvatarAttribute($value) {

        return asset($value ? 'storage/'. $value : 'frontend/images/default-user-profile.png');
    }
}