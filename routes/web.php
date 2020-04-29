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

Route::match(array('GET', 'POST', 'PUT'), '/', function () {
    return view('products');
})->name('main');

Route::match(array('GET', 'POST', 'PUT'), '/proveedores', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('proveedores');