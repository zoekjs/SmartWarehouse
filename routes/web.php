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

Route::match(array('GET', 'POST', 'PUT'), '/', 'ProductController@create')->name('productos');

Route::match(array('GET', 'POST', 'PUT'),'/proveedores', 'ProviderController@create')->name('proveedores')->middleware(['auth', 'roles:Administrador,Supervisor']);

Route::match(array('GET', 'POST', 'PUT'),'/oc', 'PurchaseOrderController@index')->name('oc')->middleware('roles:Administrador,Supervisor');

Route::match(array('GET', 'POST', 'PUT'),'/categorias', 'CategoryController@create')->name('categorias')->middleware('roles:Administrador,Supervisor');

/**************************** USERS MENU **********************************/
Route::match(array('GET', 'POST', 'PUT'), '/menu', function () {
    return view('user/menu');
})->name('menu')->middleware(['auth']);

/****************************  PAYMENT STATUS ***********************************/
route::get('/status', 'PaymentStatusController@create')->name('estado-oc');
route::post('update-payment/', 'PaymentStatusController@updatePaymentStatus')->name('update-payment');
route::get('oc-pagadas', 'PaymentStatusController@getPayed')->name('oc-pagadas');

/***************************** PURCHASE ORDER ***********************************/
Route::match(array('GET', 'POST', 'PUT'),'/nueva-orden', 'PurchaseOrderController@listOrders')->name('nueva-orden');
Route::match(array('GET', 'POST', 'PUT'),'/ordenes', 'PurchaseOrderController@listOrders')->name('listorders');
Route::get('/detalles/{id_purchase_order}', 'PurchaseOrderDetailController@create')->name('detalles');
Route::post('/detalles', 'PurchaseOrderDetailController@store')->name('add-detalles');
Route::post('/create-order', 'PurchaseOrderController@store')->name('create-order');
Route::post('/update-order', 'PurchaseOrderDetailController@update')->name('update-order');
Route::get('/ver-orden/{id_purchase_order}', 'PurchaseOrderController@show')->name('ver-orden');
Route::post('/estado-orden', 'PurchaseOrderController@update')->name('estado-orden')->middleware('roles:Administrador,Supervisor');
Route::get('/descargar/{id_purchase_order}', 'PurchaseOrderController@download')->name('descargar-orden');

Route::get('/admin', function () {
    return view('admin/menu');
})->name('admin')->middleware(['auth', 'roles:Administrador,Supervisor']);

/****************************** AUDIT ROUTES **********************************/
Route::get('auditoria', 'AuditController@create')->name('auditoria');

/***************************** PASSWORD ROUTES ********************************/
Route::get('cambio-contraseña', 'Auth\ResetPasswordController@index')->name('cambio-contraseña')->middleware('auth');
Route::put('update-contraseña/{id}', 'Auth\ResetPasswordController@update')->name('update-contraseña')->middleware('auth');
Route::get('reset-contraseña', 'Auth\ResetPasswordController@email')->name('reset-contraseña');
Route::get('password-reset','Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');
Route::get('logout','Auth\LoginController@logout')->name('logout');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);
/*Route::get('roles', function(){
    return \App\Role::with('user')->get();
});*/

/******************************* ORDER TO PDF *******************************/
Route::get('/order', function(){
    $orderDetail = new PurchaseOrderDetail();
    $details = $orderDetail->getDetail(9);
    $order = new PurchaseOrder();
    $orderData = $order->getOrder(9);
    $pdf = PDF::loadView('PO/order', compact('details', 'orderData'));
    return $pdf->stream('archivo.pdf');
})->name('order');

/*********************** INGRESS REGISTER ************************************/
Route::match(array('GET', 'POST', 'PUT'),'/ingresos', 'IngressController@listIngress')->name('ingresos');
Route::post('/ingreso', 'IngressController@store');
Route::get('/detalles/{id_ingress}', 'IngressDetailController@create')->name('ingress-details');
Route::get('/details/{id_ingress}', 'IngressDetailController@create')->name('ingress-details');
Route::post('/details', 'IngressDetailController@store')->name('add-details');
Route::post('/update-details', 'IngressDetailController@update')->name('update-details');

/****************************** TEST ROUTE TO ADD USERS *********************/
//ruta para crear usuario
/*Route::get('test_user', function(){
    $user = new App\User;
    $user->rut_user = '181912111';
    $user->name = 'Felipe';
    $user->last_name = 'Espinoza';
    $user->email = 'Felipe@email.cl';
    $user->password = bcrypt('123456');
    $user->save();
    return $user;
});*/
//Auth::routes();

