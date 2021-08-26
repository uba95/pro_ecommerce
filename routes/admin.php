<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], fn() => Auth::routes(['register' => false, 'verify' => true]));
Route::post('login', 'Auth\LoginController@login')->name('');

Route::group(['middleware' => ['auth:admin', 'verified'], 'as' => 'admin.'], function () {
    
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('admins', 'AdminController');
    Route::put('admins/{admin}/password/update','AdminController@updatePassword')->name('admins.password.update'); 

    Route::resource('roles', 'RoleController');

    Route::resource('permissions', 'PermissionController')->except('show', 'create');
    
    Route::resource('categories', 'Category\CategoryController')->except('show', 'create');

    Route::resource('subcategories', 'Category\SubCategoryController')->except('show', 'create');

    Route::resource('brands', 'Category\BrandController')->except('show', 'create');
    
    Route::resource('coupons', 'CouponController')->except('show', 'create');

    Route::resource('newslaters', 'NewslaterController')->only('index', 'destroy');

    Route::resource('products', 'ProductController');
    Route::get('products/{product}/status', 'ProductController@changeStatus')->name('products.status');
    Route::delete('products/images/{productImage}/delete', 'ProductController@destroyImage')->name('products.images.destroy');

    Route::resource('blog_categories', 'Blog\BlogCategoryController')->except('show', 'create');

    Route::resource('blog_posts', 'Blog\BlogPostController')->except('show');

    Route::resource('orders', 'Order\OrderController')->only('index', 'show', 'update');

    Route::resource('cancel_orders', 'Order\CancelOrderRequestController')->only('index', 'show', 'update');

    Route::resource('return_orders', 'Order\ReturnOrderRequestController')->only('index', 'show', 'update');

    Route::get('stocks', 'StockController')->name('stocks.index');
    
    Route::get('reports', 'ReportController@index')->name('reports.index');

    Route::get('reports/salesBy', 'SalesByController@index')->name('reports.salesBy');
    Route::post('reports/salesBy', 'SalesByController@index')->name('reports.salesBy');
    
    Route::resource('customers', 'CustomerController')->only('index', 'show', 'destroy');

    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::resource('messages', 'ContactController')->only('index', 'show', 'update', 'destroy');
        Route::get('messages/{message}/reply', 'ContactController@reply')->name('messages.reply');    
    });

    Route::get('site-settings', 'SiteSettingsController@index')->name('site_settings.index');
    Route::get('site-settings/edit', 'SiteSettingsController@edit')->name('site_settings.edit');
    Route::put('site-settings', 'SiteSettingsController@update')->name('site_settings.update');
});
