<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function () {

    //admin=======
    Route::get('home', 'AdminController@index')->name('admin.home');
    Route::get('/', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('/', 'LoginController@login');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('admin-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('reset/password/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('update/reset', 'ResetPasswordController@reset')->name('admin.reset.update');
    Route::get('Change/Password','AdminController@ChangePassword')->name('admin.password.change');
    Route::post('password/update','AdminController@Update_pass')->name('admin.password.update'); 
    Route::get('logout', 'AdminController@logout')->name('admin.logout');
});


Route::group(['middleware' => 'auth:admin', 'as' => 'admin.'], function () {

    Route::resource('categories', 'Category\CategoryController');

    Route::resource('subcategories', 'Category\SubCategoryController')->except('show', 'create');

    Route::resource('brands', 'Category\BrandController')->except('show', 'create');
    
    Route::resource('coupons', 'CouponController')->except('show', 'create');

    Route::resource('newslaters', 'NewslaterController')->only('index', 'destroy');

    Route::resource('products', 'ProductController');
    Route::get('products/{product}/status', 'ProductController@changeStatus')->name('products.status');

    Route::resource('blog_categories', 'Blog\BlogCategoryController')->except('show', 'create');

    Route::resource('blog_posts', 'Blog\BlogPostController')->except('show');

});
