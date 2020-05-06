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
})->name('productos')->middleware('auth');

Route::match(array('GET', 'POST', 'PUT'), '/proveedores', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('proveedores')->middleware('auth');

Route::match(array('GET', 'POST', 'PUT'), '/oc', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('OC')->middleware('auth');

Route::match(array('GET', 'POST', 'PUT'), '/categorias', function () {
    return view('categories');
})->name('categorias')->middleware('auth');

Route::match(array('GET', 'POST', 'PUT'), '/menu', function () {
    return view('user/menu');
})->name('menu')->middleware('auth');

Route::get('/nueva-orden', function () {
    return view('neworder');
})->name('nueva-orden')->middleware('auth');

Route::get('/admin', function () {
    return view('admin/menu');
})->name('admin')->middleware('auth');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
/*Route::get('roles', function(){
    return \App\Role::with('user')->get();
});*/

//ruta para crear usuario
Route::get('test_user', function(){
    $user = new App\User;
    $user->rut_user = '181912111';
    $user->name = 'Felipe';
    $user->last_name = 'Espinoza';
    $user->email = 'Felipe@email.cl';
    $user->password = bcrypt('123456');
    $user->save();
    return $user;
});
Auth::routes();

