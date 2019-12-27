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
Route::get('login','AuthController@login');
Route::post('/doLogin','AuthController@doLogin');
Route::get('/doLogout','AuthController@doLogout');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@index');

    //Kategori
    Route::get('/category','CategoryController@index');
    Route::get('/category/load','CategoryController@loadTable');
    Route::post('/category/insert','CategoryController@insert');
    Route::get('/category/edit/{id}','CategoryController@edit');
    Route::post('/category/update/{id}','CategoryController@update');
    Route::get('/category/delete/{id}','CategoryController@destroy');

    //Config
    Route::get('/config','ConfigController@index');
    Route::post('/config/update','ConfigController@doEdit');
});

