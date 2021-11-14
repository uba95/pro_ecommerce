<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], fn() => Auth::routes(['register' => false, 'verify' => true]));
Route::post('login', 'Auth\LoginController@login')->name('');

Route::group(['middleware' => ['auth:admin', 'verified'], 'as' => 'admin.'], function () {
    
    Route::get('/', 'HomeController@index')->name('home');

    Route::put('admins/{admin}/password/update','AdminController@updatePassword')->name('admins.password.update'); 
    Route::resource('admins', 'AdminController');

    Route::resource('roles', 'RoleController');

    Route::delete('permissions', 'PermissionController@destroyAll')->name('permissions.destroyAll');
    Route::resource('permissions', 'PermissionController')->except('show', 'create');
    
    Route::resource('categories', 'Category\CategoryController')->except('create');

    Route::resource('subcategories', 'Category\SubCategoryController')->except('show', 'create');

    Route::resource('brands', 'Category\BrandController')->except('show', 'create');
    
    Route::resource('coupons', 'CouponController')->except('show', 'create');

    Route::resource('newslaters', 'NewslaterController')->only('index', 'destroy');

    Route::get('products/hot_deals', 'HotDealProductController@index')->name('products.hot_deals.index');
    Route::get('products/{product}/hot_deals/create', 'HotDealProductController@create')->name('products.hot_deals.create');
    Route::post('products/{product}/hot_deals', 'HotDealProductController@store')->name('products.hot_deals.store');
    Route::get('products/{product}/hot_deals/edit', 'HotDealProductController@edit')->name('products.hot_deals.edit');
    Route::put('products/{product}/hot_deals', 'HotDealProductController@update')->name('products.hot_deals.update');
    Route::delete('products/{product}/hot_deals', 'HotDealProductController@destroy')->name('products.hot_deals.destroy');
    
    Route::get('products/{product}/status', 'ProductController@changeStatus')->name('products.status');
    Route::delete('products/images/{productImage}/delete', 'ProductController@destroyImage')->name('products.images.destroy');
    Route::resource('products', 'ProductController');
    

    Route::resource('blog_categories', 'Blog\BlogCategoryController')->except('show', 'create');

    Route::resource('blog_posts', 'Blog\BlogPostController')->except('show');

    Route::resource('orders', 'Order\OrderController')->only('index', 'show', 'update');

    Route::resource('cancel_orders', 'Order\CancelOrderRequestController')->only('index', 'show', 'update');

    Route::resource('return_orders', 'Order\ReturnOrderRequestController')->only('index', 'show', 'update');

    Route::get('stocks', 'StockController')->name('stocks.index');
    
    Route::get('reports', 'ReportController@index')->name('reports.index');

    Route::get('reports/salesBy', 'SalesByController@index')->name('reports.salesBy');
    Route::get('reports/salesBy/products', 'SalesByController@index')->name('reports.salesBy.products');

    Route::group(['prefix' => 'landing-page', 'as' => 'landing_page_'], function () {
        Route::get('items/{item}/status', 'LandingPageController@changeStatus')->name('items.status');
        Route::resource('items', 'LandingPageController');
    });

    Route::resource('customers', 'CustomerController')->only('index', 'show', 'destroy');

    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::resource('messages', 'ContactController')->only('index', 'show', 'update', 'destroy');
        Route::get('messages/{message}/reply', 'ContactController@reply')->name('messages.reply');    
    });

    Route::get('site-settings', 'SiteSettingsController@index')->name('site_settings.index');
    Route::get('site-settings/edit', 'SiteSettingsController@edit')->name('site_settings.edit');
    Route::put('site-settings', 'SiteSettingsController@update')->name('site_settings.update');
});
