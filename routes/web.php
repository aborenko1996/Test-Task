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

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['prefix'=>'login', 'middleware'=>'token'], function(){
    Route::get('/', 'UserController@login');
    Route::post('/', 'UserController@auth');
});

Route::group(['prefix'=>'item', 'middleware'=>'token'], function(){
    Route::get('/create', 'ItemsController@getCreateItem');
    Route::post('/create', 'ItemsController@postCreateItem');
    Route::get('/{id}/edit', 'ItemsController@editItem');
    Route::put('/{id}', 'ItemsController@updateItem');
    Route::get('/{id}', 'ItemsController@getItem');
    Route::delete('/{id}', 'ItemsController@deleteItem');
});

Route::group(['prefix'=>'shipment', 'middleware'=>'token'], function(){
    Route::get('list', 'ShipmentsController@getShipments');
    Route::get('create', 'ShipmentsController@getCreateShipment');
    Route::post('create', 'ShipmentsController@postCreateShipment');
    Route::get('{id}', 'ShipmentsController@getShipment');
    Route::put('{id}', 'ShipmentsController@updateShipment');
    Route::get('{id}/edit', 'ShipmentsController@editShipment');
    Route::delete('{id}', 'ShipmentsController@deleteShipment');
    Route::post('{id}/send', 'ShipmentsController@sendShipment');
});