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

//admin=======
Route::get('admin/home', 'AdminController@index');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin', 'Admin\LoginController@login');
        // Password Reset Routes...
Route::get('admin/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/reset/password/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/update/reset', 'Admin\ResetPasswordController@reset')->name('admin.reset.update');
Route::get('/admin/Change/Password','AdminController@ChangePassword')->name('admin.password.change');
Route::post('/admin/password/update','AdminController@Update_pass')->name('admin.password.update'); 
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

        Route::resource('categories', 'Admin\Category\CategoryController', ['as' => 'admin'])->only('index', 'store', 'edit', 'update');
        Route::get('admin/categories/{category}/delete', 'Admin\Category\CategoryController@destroy')->name('admin.categories.delete');

        Route::resource('subcategories', 'Admin\Category\SubCategoryController', ['as' => 'admin'])->only('index', 'store', 'edit', 'update');
        Route::get('admin/subcategories/{subcategory}/delete', 'Admin\Category\SubCategoryController@destroy')->name('admin.subcategories.delete');

        Route::resource('brands', 'Admin\Category\BrandController', ['as' => 'admin'])->only('index', 'store', 'edit', 'update');
        Route::get('admin/brands/{brand}/delete', 'Admin\Category\BrandController@destroy')->name('admin.brands.delete');
});










// Route::get('admin/categories', 'Admin\Category\CategoryController@index')->name('admin.categories.index');
// Route::post('admin/categories', 'Admin\Category\CategoryController@store')->name('admin.categories.store');
// Route::get('admin/categories/{category}/edit', 'Admin\Category\CategoryController@edit')->name('admin.categories.edit');
// Route::patch('admin/categories/{category}', 'Admin\Category\CategoryController@update')->name('admin.categories.update');
