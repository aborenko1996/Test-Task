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

Route::get('/login', 'ShipmentsController@login');
Route::post('/auth', 'ShipmentsController@auth');
Route::get('/item/create', 'ShipmentsController@createItemGet');
Route::post('/item/create', 'ShipmentsController@createItemPost');
Route::get('/item/{id}/edit', 'ShipmentsController@editItem');
Route::get('/item/{id}', 'ShipmentsController@item');
Route::put('/item/{id}', 'ShipmentsController@updateItem');
Route::delete('/item/{id}', 'ShipmentsController@deleteItem');
Route::get('/shipment', 'ShipmentsController@shipments');
Route::get('/shipment/create', 'ShipmentsController@createShipmentGet');
Route::post('/shipment/create', 'ShipmentsController@createShipmentPost');
Route::get('/shipment/{id}', 'ShipmentsController@shipment');
Route::put('/shipment/{id}', 'ShipmentsController@updateShipment');
Route::delete('/shipment/{id}', 'ShipmentsController@deleteShipment');
Route::get('/shipment/{id}/edit', 'ShipmentsController@editShipment');
Route::post('/shipment/{id}/send', 'ShipmentsController@sendShipment');
