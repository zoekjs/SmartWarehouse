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
})->name('main')->middleware('auth');

Route::match(array('GET', 'POST', 'PUT'), '/proveedores', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('proveedores')->middleware('auth');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
/*Route::get('roles', function(){
    return \App\Role::with('user')->get();
});*/

//ruta para crear usuario
/*Route::get('test_user', function(){
    $user = new App\User;
    $user->rut_user = '191730984';
    $user->name = 'Javier';
    $user->last_name = 'Romero';
    $user->email = 'Javier@email.cl';
    $user->password = bcrypt('123456');
    $user->save();
    return $user;
});*/