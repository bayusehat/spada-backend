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
//API
Route::get('/api/service','ApiController@serviceData');
Route::get('/api/product','ApiController@productData');
Route::get('/api/category','ApiController@categoryData');
Route::get('/api/product/category/{categoryId}','ApiController@productByCategory');
Route::get('/api/static','ApiController@staticData');
Route::get('/api/banner','ApiController@bannerData');
Route::get('/api/testimoni','ApiController@testimoniData');
//BACKEND
Route::get('/', 'HomeController@index');
