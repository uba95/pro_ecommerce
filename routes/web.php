<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {return view('pages.index');});
//auth & user
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'HomeController@changePassword')->name('password.change');
Route::post('/password-update', 'HomeController@updatePassword')->name('password.update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin\\Auth'], function () {

        //admin=======
        Route::get('home', 'AdminController@index');
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


Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

        Route::resource('categories', 'Category\CategoryController')->except('destroy');
        Route::get('categories/{category}/delete', 'Category\CategoryController@destroy')->name('categories.delete');

        Route::resource('subcategories', 'Category\SubCategoryController')->only('index', 'store', 'edit', 'update');
        Route::get('subcategories/{subcategory}/delete', 'Category\SubCategoryController@destroy')->name('subcategories.delete');

        Route::resource('brands', 'Category\BrandController')->only('index', 'store', 'edit', 'update');
        Route::get('brands/{brand}/delete', 'Category\BrandController@destroy')->name('brands.delete');
        
        Route::resource('coupons', 'CouponController')->only('index', 'store', 'edit', 'update');
        Route::get('coupons/{coupon}/delete', 'CouponController@destroy')->name('coupons.delete');

        Route::get('newslaters', 'NewslaterController@index')->name('newslaters.index');
        Route::get('newslaters/{newslater}/delete', 'NewslaterController@destroy')->name('newslaters.delete');

        Route::resource('products', 'ProductController')->except('destroy');
        Route::get('products/{product}/delete', 'ProductController@destroy')->name('products.delete');
        Route::get('products/{product}/status', 'ProductController@changeStatus')->name('products.status');

});

Route::post('newslaters', 'Admin\NewslaterController@store')->name('newslaters.store');









// Route::get('admin/categories', 'Admin\Category\CategoryController@index')->name('admin.categories.index');
// Route::post('admin/categories', 'Admin\Category\CategoryController@store')->name('admin.categories.store');
// Route::get('admin/categories/{category}/edit', 'Admin\Category\CategoryController@edit')->name('admin.categories.edit');
// Route::patch('admin/categories/{category}', 'Admin\Category\CategoryController@update')->name('admin.categories.update');
