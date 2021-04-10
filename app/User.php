<?php

namespace App;

use App\Model\Address;
use App\Model\Order;
use App\Model\Wishlist;
use App\Model\WishlistItem;
use Laravel\Passport\HasApiTokens;
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

    public function wishlist() {
        
        return $this->hasOne(Wishlist::class);
    }

    public function addresses() {
        
        return $this->hasMany(Address::class);
    }

    public function orders() {
        
        return $this->hasMany(Order::class);
    }

    public function wishlistItems() {
        
        return $this->hasManyThrough(WishlistItem::class, Wishlist::class);
    }

    public function hasProductOnWishlist($product_id) {

        return $this->wishlistItems->contains('product_id', $product_id);
    }

}
