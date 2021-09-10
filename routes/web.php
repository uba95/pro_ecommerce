<?php

use App\Enums\ReturnOrderStatus;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ReturnOrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;


// Route::get('/', function () {return view('pages.landing_page.index');});
//auth & user



Route::group(['namespace' => 'Frontend'], function () {
    
    Auth::routes(['verify' => true]);
    Route::get('/redirect/{service}', 'Auth\LoginController@redirectService')->name('loginWith');
    Route::get('/callback/{service}', 'Auth\LoginController@callbackService');
    
    Route::get('/', 'LandingPageController')->name('pages.landing_page.index');

    Route::get('cart', 'CartController@show')->name('cart.show');
    Route::post('cart/{product}', 'CartController@store')->name('cart.store');
    Route::delete('cart/{cartItem}', 'CartController@destroy')->name('cart.destroy');
    Route::patch('cart/{cartItem}', 'CartController@update')->name('cart.update');
    Route::delete('cart', 'CartController@destroyAll')->name('cart.destroyAll');
    
    Route::get('products/{product_slug}', 'ShowProductController')->name('products.show');
    
    Route::get('blog/posts', 'BlogController@index')->name('blog.index');
    Route::get('blog/posts/{blog_post}', 'BlogController@show')->name('blog.show');
    Route::get('blog/categories/{blog_category}', 'BlogController@showCategory')->name('blog.category');

    Route::get('shop', 'ShopController@index')->name('shop.index');
    Route::get('shop/search', 'ShopController@search')->name('shop.search');

    Route::resource('contact', 'ContactController')->only('index','store');
    
    Route::post('newslaters', 'NewslaterController@store')->name('newslaters.store');
    Route::delete('newslaters', 'NewslaterController@destroy')->name('newslaters.destroy');
    

    Route::group(['middleware' => ['auth:web', 'verified']], function () {

        Route::get('/home', 'HomeController@index')->name('home');
        Route::put('/home', 'HomeController@update')->name('home.update')->middleware('password.confirm');
        Route::get('/home/password', 'HomeController@password')->name('home.password');
        Route::put('/home/password/update', 'HomeController@updatePassword')->name('home.password.update');
        
        Route::get('wishlist', 'WishlistController@index')->name('wishlist.index');
        Route::post('wishlist/{product}', 'WishlistController@store')->name('wishlist.store');
        
        Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
        Route::post('checkout/coupon', 'CheckoutController@coupon')->name('checkout.coupon');
        Route::delete('checkout/coupon/delete', 'CheckoutController@couponDelete')->name('checkout.coupon.destroy');
        
        Route::post('payment/store', 'PaymentController@store')->name('payment.store');
        Route::get('payment/paypal', 'PaymentController@paypal')->name('payment.paypal');
        Route::get('payment/paypal/order', 'PaypalController')->name('payment.paypal.order');
        
        Route::resource('addresses', 'AddressController')->except('show');
    
        Route::resource('orders', 'OrderController')->only('index', 'show');
        
        Route::resource('cancel_orders', 'CancelOrderRequestController')->only('index', 'show','create','store');
        
        Route::resource('return_orders', 'ReturnOrderRequestController')->only('index', 'show','create','store');

        Route::post('product/ratings/{product}', 'ProductRatingController@store')->name('rating.store');
        Route::delete('product/ratings/{product}', 'ProductRatingController@destroy')->name('rating.destroy');

        Route::get('ss', function () {
        // \Debugbar::startMeasure('render');
		// foreach (App\Models\User::cursor()as $u) {
		// 	$u->name;
		// }
		// \Debugbar::stopMeasure('render');
		// return view('welcome');
        });
    });
});
