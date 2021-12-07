<?php

use App\Enums\ReturnOrderStatus;
use App\Mail\CancelOrderMail;
use App\Models\Address;
use App\Models\CancelOrderRequest;
use App\Models\Coupon;
use App\Models\LandingPageItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\ReturnOrderRequest;
use App\Models\User;
use App\Services\AjaxDatatablesService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

// Route::get('/', function () {return view('pages.landing_page.index');});
//auth & user



Route::group(['namespace' => 'Frontend'], function () {
    
    Auth::routes(['verify' => true]);
    Route::get('/redirect/{service}', 'Auth\LoginController@redirectService')->name('loginWith');
    Route::get('/callback/{service}', 'Auth\LoginController@callbackService');
    
    Route::get('/', 'LandingPageController')->name('pages.landing_page.index');

    Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
        Route::get('/', 'CartController@show')->name('show');
        Route::post('{product}', 'CartController@store')->name('store');
        Route::delete('{cartItem}', 'CartController@destroy')->name('destroy');
        Route::patch('{cartItem}', 'CartController@update')->name('update');
        Route::delete('/', 'CartController@destroyAll')->name('destroyAll');
    });

    Route::get('blog', 'BlogController@index')->name('blog.index');
    Route::get('blog/posts/{blog_post}', 'BlogController@show')->name('blog.show');
    Route::get('blog/categories/{blog_category}', 'BlogController@showCategory')->name('blog.category');

    Route::get('shop', 'ShopController@index')->name('shop.index');
    Route::get('shop/search', 'ShopController@search')->name('shop.search');

    Route::resource('contact', 'ContactController')->only('index','store');
    Route::get('return-policy', 'ReturnPolicyController')->name('return_policy');
    
    Route::post('newslaters', 'NewslaterController@store')->name('newslaters.store');
    Route::delete('newslaters', 'NewslaterController@destroy')->name('newslaters.destroy');
    

    Route::group(['middleware' => ['auth:web', 'verified']], function () {

        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/home/edit', 'HomeController@edit')->name('home.edit');
        Route::put('/home', 'HomeController@update')->name('home.update')->middleware('password.confirm');
        Route::get('/home/password', 'HomeController@password')->name('home.password');
        Route::put('/home/password/update', 'HomeController@updatePassword')->name('home.password.update');
        
        Route::get('wishlist', 'WishlistController@index')->name('wishlist.index');
        Route::post('wishlist/{product}', 'WishlistController@store')->name('wishlist.store');
        
        Route::get('checkout', 'CheckoutController@index')->name('checkout.index')->middleware('prevent-back-history');
        Route::post('checkout/coupon', 'CheckoutController@coupon')->name('checkout.coupon');
        Route::delete('checkout/coupon/delete', 'CheckoutController@couponDelete')->name('checkout.coupon.destroy');
        
        Route::post('payment/store', 'PaymentController@store')->name('payment.store');
        Route::get('payment/paypal', 'PaymentController@paypal')->name('payment.paypal');
        Route::get('payment/paypal/order', 'PaypalController')->name('payment.paypal.order');
        
        Route::resource('addresses', 'AddressController')->except('show');
        
        Route::get('orders/{order}/invoice', 'OrderController@showInvoice')->name('orders.invoice');
        Route::resource('orders', 'OrderController')->only('index', 'show');
        
        Route::resource('cancel_orders', 'CancelOrderRequestController')->except('edit', 'update');
        
        Route::resource('return_orders', 'ReturnOrderRequestController')->except('edit', 'update');

        Route::post('products/ratings/{product}', 'ProductRatingController@store')->name('rating.store');
        Route::delete('products/ratings/{product}', 'ProductRatingController@destroy')->name('rating.destroy');

        Route::get('products/reviews', 'ProductReviewController@index')->name('reviews.index');
        Route::post('products/reviews/{product}', 'ProductReviewController@store')->name('reviews.store');
        Route::get('products/reviews/{product_slug}', 'ProductReviewController@edit')->name('reviews.edit');
        Route::put('products/reviews/{product}', 'ProductReviewController@update')->name('reviews.update');
        Route::delete('products/reviews/{product}', 'ProductReviewController@destroy')->name('reviews.destroy');

    });

    Route::get('products/{product_slug}', 'ShowProductController')->name('products.show');

    // Auth::guard('web')->loginUsingId(7);
    //Route::get('ss', function () {
        //  $faker = Faker\Factory::create(); 
    //});

});
