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
Route::get('cart/checkout', 'Frontend\CartController@checkout')->name('cart.checkout')->middleware('auth:web');

Route::get('products/{product_name}', 'Frontend\ShowProductController')->name('products.show');
// Route::get('products/{product_name}', function () {
//     // Cart::destroy();
//     dd(Cart::content(), Cart::subtotal(), Cart::count());
// })->name('products.show');


Route::group([], function () {

});