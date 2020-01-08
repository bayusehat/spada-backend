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
Route::get('/','AuthController@login');
Route::post('/doLogin','AuthController@doLogin');
Route::get('/doLogout','AuthController@doLogout');

Route::group(['prefix' => 'admin','middleware' => ['authLogin']], function () {
    Route::get('/dashboard', 'HomeController@index');

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

    //Menu
    Route::get('menu','MenuController@index');
    Route::get('menu/load','MenuController@loadData');
    Route::post('menu/insert','MenuController@insert');
    Route::get('menu/edit/{id}','MenuController@edit');
    Route::post('menu/update/{id}','MenuController@update');
    Route::get('menu/delete/{id}','MenuController@destroy');

    //Admin
    Route::get('admin','AdminController@index');
    Route::get('admin/load','AdminController@loadData');
    Route::post('admin/insert','AdminController@insert');
    Route::get('admin/edit/{id}','AdminController@edit');
    Route::post('admin/update/{id}','AdminController@update');
    Route::get('admin/delete/{id}','AdminController@destroy');

    //Banner
    Route::get('banner','BannerController@index');
    Route::get('banner/load','BannerController@loadData');
    Route::get('banner/create','BannerController@create');
    Route::post('banner/insert','BannerController@insert');
    Route::get('banner/edit/{id}','BannerController@edit');
    Route::post('banner/update/{id}','BannerController@update');
    Route::get('banner/delete/{id}','BannerController@destroy');

    //Service
    Route::get('service','ServiceController@index');
    Route::get('service/load','ServiceController@loadData');
    Route::post('service/insert','ServiceController@insert');
    Route::get('service/edit/{id}','ServiceController@edit');
    Route::post('service/update/{id}','ServiceController@update');
    Route::get('service/delete/{id}','ServiceController@destroy');

    //Product
    Route::get('product','ProductController@index');
    Route::get('product/load','ProductController@loadData');
    Route::get('product/create','ProductController@create');
    Route::post('product/insert','ProductController@insert');
    Route::get('product/edit/{id}','ProductController@edit');
    Route::post('product/update/{id}','ProductController@update');
    Route::get('product/delete/{id}','ProductController@destroy');
});

