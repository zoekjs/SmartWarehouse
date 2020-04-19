<?php

use Illuminate\Http\Request;
use App\Product;
use RealRashid\SweetAlert\Facades\Alert;

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

Route::get('products', function(){
    //return json_encode(DB::table('product')->get()->toArray());
    return datatables()
        ->eloquent(App\Product::query())
        ->toJson();

});

Route::get('products/{id}', function($id_product) {
    //Validar datos
    if(!is_numeric($id_product)){
        return response()->json('Los datos ingresados no son correctos', 400);
    }
    
    try{
        //buscar producto
        $search = Product::where('id_product', $id_product)->firstOrFail();
        //devover producto como json
        return response()->json($search);

    }catch(Exception $ex){
        $data = array(
            'status'    => 'Error',
            'code'      => 404,
            'message'   => 'El producto que busca, no está registrado en el sistema :('
        );

        return response()->json($data, $data['code']);
    }
});

Route::post('products', function(Request $request){
    
   
    if($request->input('json', null)){
        //Recoger datos del json
        $json = $request->input('json', null);
        //decodificar json
        $params = json_decode($json);
    }else{
        $json = $request->all();
        $params = json_decode(json_encode($json));
    }   
    
    //crear un nuevo producto
    $product = new Product();
    $exist = $product->exist((int)$params->id_product);
    if(!$exist){
        $id_product = (int)$params->id_product;
        $name       = $params->name;
        $description = $params->description;
        $quantity   = (int)$params->quantity;
        $unit_price = (int)$params->unit_price;
    
        $product->createProduct($id_product, $name, $description, $quantity, $unit_price);

        $data = array(
            'status'    =>  'Created',
            'code'      =>  '201',
            'message'   =>  'Producto registrado exitosamente ! :)'  
        );
        return response()->json($data, $data['code']);
    }elseif ($exist) {
        $data = array(
            'status'    => 'Unprocessable Entity',
            'code'      => '422',
            'message'   => 'El producto ya existe en el sistema'
        );
        
        return response()->json($data, $data['code']);
    }

});

route::put('products/{id}', function(Request $request, $id_product) {
    
    if($request->input('json', null)){
        //Recoger datos del json
        $json = $request->input('json', null);
        //decodificar json
        $params = json_decode($json);
    }else{
        $json = $request->all();
        $params = json_decode(json_encode($json));
    }   


    try{
        $product = new Product();

        $id_product     = (int)$id_product;        
        $name           = $params->name;
        $description    = $params->description;
        $quantity       = (int)$params->quantity;
        $unit_price     = (int)$params->unit_price;

        $product->updateProduct($id_product, $name, $description, $quantity, $unit_price);

        $data = array(
            'status'    => 'success',
            'code'      => '201',
            'message'   =>  'El producto fue actualizado exitosamente ! :)'       
        );

        return response()->json($data, $data['code']);
    }catch(Exception $e){
        $data = array(
            'status'    => 'not found',
            'code'      => '404',
            'message'   => 'El producto que intenta modificar no está registrado en el sistema.'
        )
        return response()->json($data, $data['code']);
    }
});

route::delete('products/{id}', function($id_product) {
    try{
        $product = new Product();
        $product->deleteProduct((int)$id_product);

        $data = array(
            'status'    => 'success',
            'code'      => '200',
            'message'   => 'Producto eliminado correctamente del sistema ;)'
        );
        return response()->json($data, $data['code']);
    }catch(Exception $e) {
        $data = array(
            'status'    => 'error',
            'code'      => '400',
            'message'   => 'No se pudo eliminar el producto, intente nuevamente'
        );
        return response()->json($data, $data['code']);
    }
});