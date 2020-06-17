<?php
use App\PurchaseOrderDetail;
use App\PurchaseOrder;
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
})->name('productos')->middleware(['auth']);

Route::match(array('GET', 'POST', 'PUT'), '/proveedores', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('proveedores')->middleware(['auth', 'roles:Administrador,Supervisor']);

Route::match(array('GET', 'POST', 'PUT'), '/oc', function () {
    $countrys = \DB::table('country')
            ->orderBy('name', 'asc')
            ->get();
    return view('providers', compact('countrys'));
})->name('OC')->middleware(['auth', 'roles:Administrador,Supervisor']);

Route::match(array('GET', 'POST', 'PUT'), '/categorias', function () {
    return view('categories');
})->name('categorias')->middleware(['auth', 'roles:Administrador,Supervisor']);

Route::match(array('GET', 'POST', 'PUT'), '/menu', function () {
    return view('user/menu');
})->name('menu')->middleware(['auth']);

Route::match(array('GET', 'POST', 'PUT'),'/nueva-orden', 'PurchaseOrderController@listOrders')->name('nueva-orden')->middleware('auth');
Route::match(array('GET', 'POST', 'PUT'),'/ordenes', 'PurchaseOrderController@listOrders')->name('listorders')->middleware('auth');
Route::get('/detalles/{id_purchase_order}', 'PurchaseOrderDetailController@create')->name('detalles')->middleware('auth');
Route::post('/detalles', 'PurchaseOrderDetailController@store')->name('add-detalles')->middleware('auth');
Route::post('/create-order', 'PurchaseOrderController@store')->name('create-order')->middleware('auth');
Route::post('/update-order', 'PurchaseOrderDetailController@update')->name('update-order')->middleware('auth');
Route::get('/ver-orden/{id_purchase_order}', 'PurchaseOrderController@show')->name('ver-orden')->middleware('auth');
Route::post('/estado-orden', 'PurchaseOrderController@update')->name('estado-orden')->middleware(['auth', 'roles:Administrador,Supervisor']);
Route::get('/descargar/{id_purchase_order}', 'PurchaseOrderController@download')->name('descargar-orden')->middleware('auth');

Route::get('/admin', function () {
    return view('admin/menu');
})->name('admin')->middleware(['auth', 'roles:Administrador,Supervisor']);

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);
/*Route::get('roles', function(){
    return \App\Role::with('user')->get();
});*/

Route::get('/order', function(){
    $orderDetail = new PurchaseOrderDetail();
    $details = $orderDetail->getDetail(9);
    $order = new PurchaseOrder();
    $orderData = $order->getOrder(9);
    $pdf = PDF::loadView('PO/order', compact('details', 'orderData'));
    return $pdf->stream('archivo.pdf');
})->name('order');

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
//Auth::routes();

