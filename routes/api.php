<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/******************************* PRODUCTS SECTION *******************************/
Route::resource('products', 'ProductController');


/******************************* PROVIDERS SECTION ******************************/
Route::resource('providers', 'ProviderController');
Route::get('countrys', function() {
    return datatables()->eloquent(App\Country::query())->toJson();
});


/******************************* CATEGORIES SECTION ******************************/
Route::resource('categories', 'CategoryController');
Route::delete('pods/{id_pod}/{rut_user}', 'PurchaseOrderDetailController@destroy');


/********************************* RFID SECTION **********************************/
Route::post('rfid', 'RFIDController@index');
