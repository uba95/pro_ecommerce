<?php

use App\Enums\ReturnOrderStatus;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ReturnOrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

Route::get('/', 'Frontend\LandingPageController')->name('pages.index');

// Route::get('/', function () {return view('pages.index');});
//auth & user
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'HomeController@changePassword')->name('password.change');
Route::post('/password-update', 'HomeController@updatePassword')->name('password_update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');


Route::post('newslaters', 'Admin\NewslaterController@store')->name('newslaters.store');


Route::get('cart', 'Frontend\CartController@show')->name('cart.show');
Route::post('cart/{product}', 'Frontend\CartController@store')->name('cart.store');
Route::delete('cart/{cartItem}', 'Frontend\CartController@destroy')->name('cart.destroy');
Route::patch('cart/{cartItem}', 'Frontend\CartController@update')->name('cart.update');
Route::delete('cart', 'Frontend\CartController@destroyAll')->name('cart.destroyAll');

Route::get('products/{product_name}', 'Frontend\ShowProductController')->name('products.show');

Route::group(['middleware' => 'auth:web'], function () {

    Route::get('wishlist', 'Frontend\WishlistController@index')->name('wishlist.index');
    Route::post('wishlist/{product}', 'Frontend\WishlistController@store')->name('wishlist.store');
    
    Route::get('checkout', 'Frontend\CheckoutController@index')->name('checkout.index');
    Route::post('checkout/coupon', 'Frontend\CheckoutController@coupon')->name('checkout.coupon');
    Route::delete('checkout/coupon/delete', 'Frontend\CheckoutController@couponDelete')->name('checkout.coupon.destroy');
    
    Route::post('payment/store', 'Frontend\PaymentController@store')->name('payment.store');
    Route::get('payment/paypal', 'Frontend\PaymentController@paypal')->name('payment.paypal');
    Route::get('payment/paypal/order', 'Frontend\PaypalController')->name('payment.paypal.order');
    
    Route::resource('addresses', 'Frontend\AddressController')->except('show');

    Route::resource('orders', 'Frontend\OrderController')->only('index', 'show');
    
    Route::resource('cancel_orders', 'Frontend\CancelOrderRequestController')->only('index', 'show','create','store');
    
    Route::resource('return_orders', 'Frontend\ReturnOrderRequestController')->only('index', 'show','create','store');
    Route::get('ss', function () {
    //    dd(Session::all());
    });
});