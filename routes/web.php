<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::any('/', 'MongodbController@login');
Route::any('/login_search', 'MongodbController@login_search')->name('login_search');
Route::any('/dashboard', 'MongodbController@dashboard')->name('dashboard');
Route::any('/order','MongodbController@order')->name('order');
Route::any('/logout','MongodbController@logout')->name('logout');
Route::any('/get_user/{id}','MongodbController@get_user')->name('get_user');
Route::any('/get_product','MongodbController@get_product')->name('get_product');
Route::any('/order_now','MongodbController@order_now')->name('order_now');
Route::any('/get_order/{id}','MongodbController@get_order')->name('get_order');
Route::any('/product_delete/{id}','MongodbController@product_delete')->name('product_delete');
Route::any('/add_new_order','MongodbController@add_new_order')->name('add_new_order');
Route::any('/order_delete/{id}','MongodbController@order_delete')->name('order_delete');