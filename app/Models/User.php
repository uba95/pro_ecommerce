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
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail 
{
    use  Notifiable;

    const AVATARS_STOREAGE = 'media/users/avatars/';

    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    // protected $fillable = [
    //     'name', 'email', 'password','phone','avatar'
    // ];

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
        
        return $this->belongsToMany(Product::class, 'wishlist_items')->withTimestamps()->select(['id','product_name','selling_price','discount_price','cover']);
    }

    public function hasProductOnWishlist($product_id) {

        return $this->wishlistItems->contains('pivot.product_id', $product_id);
    }

    public function ratings() {
        
        return $this->hasMany(ProductRating::class);
    }
    
    public function productRatings() {

        return $this->belongsToMany(Product::class, 'product_ratings')->withTimestamps()->select('id', 'value');
    }

    public function reviews() {
        
        return $this->hasMany(ProductReview::class);
    }

    public function productReviews() {

        return $this->belongsToMany(Product::class, 'product_reviews')->withTimestamps()->selection()->withPivot('headline', 'body');
    }

    public function theirProductRating($product_id) {
        
        return number_format($this->ratings()->where('product_id', $product_id)->value('value') / 10, 1);
    }

    public function theirProductReview($product_id) {
        
        return $this->reviews()->firstWhere('product_id', $product_id);
    }

    public function getAvatarAttribute($value) {
        
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        return asset($value ? 'storage/'. $value : 'frontend/images/default-user-profile.png');
    }

    public function setPasswordAttribute($value) {
        return $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

}