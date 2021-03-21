<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Frontend\LandingPageController')->name('pages.index');

// Route::get('/', function () {return view('pages.index');});
//auth & user
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'HomeController@changePassword')->name('password.change');
Route::post('/password-update', 'HomeController@updatePassword')->name('password_update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');


Route::post('newslaters', 'Admin\NewslaterController@store')->name('newslaters.store');

Route::get('wishlist', 'Frontend\WishlistController@index')->name('wishlist.index');
Route::post('wishlist/{product}', 'Frontend\WishlistController@store')->name('wishlist.store');

Route::get('cart', 'Frontend\CartController@show')->name('cart.show');
Route::post('cart/{product}', 'Frontend\CartController@store')->name('cart.store');
Route::delete('cart/{cartItem}', 'Frontend\CartController@destroy')->name('cart.destroy');
Route::patch('cart/{cartItem}', 'Frontend\CartController@update')->name('cart.update');
Route::delete('cart', 'Frontend\CartController@destroyAll')->name('cart.destroyAll');

Route::get('products/{product_name}', 'Frontend\ShowProductController')->name('products.show');

Route::group(['middleware' => 'auth:web'], function () {

    Route::get('checkout', 'Frontend\CheckoutController@index')->name('checkout.index');
    Route::post('checkout/coupon', 'Frontend\CheckoutController@coupon')->name('checkout.coupon');
    Route::delete('checkout/coupon/delete', 'Frontend\CheckoutController@couponDelete')->name('checkout.coupon.destroy');
    
    Route::post('payment/store', 'Frontend\PaymentController@store')->name('payment.store');
    Route::get('payment/paypal', 'Frontend\PaymentController@paypal')->name('payment.paypal');
    Route::get('payment/paypal/order', 'Frontend\PaypalController')->name('payment.paypal.order');
    
    Route::resource('addresses', 'Frontend\AddressController')->except('show');

});