<?php

use Illuminate\Http\Request;
use App\Product;
use App\Provider;
use App\Category;
use App\PurchaseOrderDetail;

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

/**********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************
 * ***********************************************                 PRODUCTS SECTION                                ****************************************************
 * ********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************/

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
        );
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

/**********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************
 * ***********************************************                 END PRODUCTS SECTION                            ****************************************************
 * ********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************/


/**********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************
 * ***********************************************                 PROVIDERS SECTION                               ****************************************************
 * ********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************/

 route::get('providers', function() {
     $query = DB::table('provider as p')->select('p.rut_provider', 'p.name', 'p.telephone', 'p.address', 'p.email', 'c.name as country_name')
                ->join('country as c', 'c.id_country', '=', 'p.id_country')
                ->get();
     return DataTables()
                ->of($query)
                ->toJson();
 });

 route::get('countrys', function() {
    return datatables()
    ->eloquent(App\Country::query())
    ->toJson();
});

 route::post('providers', function(Request $request) {

    if($request->input('json', null)){
        $json = $request->input('json', null);
        $params = json_decode($json);
    }else{
        $json = $request->all();
        $params = json_decode(json_encode($json));
    }

    try{
        $provider = new Provider();
        $exist = $provider->exist($params->rut_provider);

        if(!$exist) {
            $rut_provider   = $params->rut_provider;
            $id_pais        = (int)$params->id_pais;
            $name           = $params->name;
            $telephone      = $params->telephone;
            $address        = $params->address;
            $email          = $params->email;
    
            $provider->createProvider($rut_provider, $id_pais, $name, $telephone, $address, $email);
    
            $data = array(
                'status'    => 'created',
                'code'      => '201',
                'message'   => 'El proveedor fue registrado correctamente en el sistema :)' 
            );
    
            return response()->json($data, $data['code']);
        }else{
            $data = array(
                'status'    => 'Unprocessable Entity',
                'code'      => '422',
                'message'   => 'El proveedor que intenta registrar ya existe en el sistema.'
            );

            return response()->json($data, $data['code']);
        }
    }catch(Exception $e) {
        $data = array(
            'status'    => 'error',
            'code'      => '400',
            'message'   => 'No se ha podido registrar el proveedor :('
        );
        return response($e);
    }
 });

 route::get('providers/{rut_provider}', function(Request $request, $rut_provider) {
    if($request->input('json', null)) {
        $json = $request->input('json', null);
        $params = json_decode($json);
    }else{
        $json = $request->all();
        $params = json_decode(json_encode($json));
    }

    $provider = new Provider();
    $exist = $provider->exist($rut_provider);
    if($exist){
        return $provider->searchProvider($rut_provider);
    }else {
        $data = array(
            'status'    => 'error',
            'code'      => '404',
            'message'   => 'El proveedor que intenta buscar, no se encuentra registrado en el sistema :('
        );
        return response()->json($data, $data['code']);
    }
    
 });

 route::put('providers/{rut_provider}', function(Request $request, $rut_provider) {
    if($request->input('json', null)) {
        $json = $request->input('json', null);
        $params = json_decode($json);
    }else{
        $json = $request->all();
        $params = json_decode(json_encode($json));
    }

    try{
        $provider = new Provider();
        $exist = $provider->exist($rut_provider);

        if($exist){
            
            $id_country    = $params->id_country;
            $name          = $params->name;
            $telephone     = $params->telephone;
            $address       = $params->address;
            $email         = $params->email;
    
            $provider->updateProvider($rut_provider, $id_country, $name, $telephone, $address, $email);
    
            $data = array(
                'status'   => 'success',
                'code'     => '201',
                'message'  => 'El proveedor ha sido modificado exitosamente :)'
            );

            return response()->json($data, $data['code']);
        }else{
            $data = array(
                'status'    => 'error',
                'code'      => '404',
                'message'   => 'El proveedor que intenta modificar no se encuentra registrado en el sistema'
            );

            return response()->json($data, $data['code']);
        }
   
    }catch(Exception $e){
        $data = array(
            'status'    => 'error',
            'code'      => '400',
            'message'   => 'no se pudo modificar el proveedor :('
        );
        return response()->json($data, $data['code']);
    }


     
 });

 route::delete('providers/{rut_provider}', function($rut_provider){
     $provider = new Provider();
     $exist = $provider->exist($rut_provider);

     try{
        if($exist) {
            $provider->deleteProvider($rut_provider);
   
            $data = array(
                'status'   => 'success',
                'code'     => '200',
                'message'  => 'El proveedor ha sido eliminado correctamente del sistema'
            );
   
            return response()->json($data, $data['code']);
        }else {
            $data = array(
               'status'    => 'error',
               'code'      => '404',
               'message'   => 'El proveedor que intenta eliminar no está registrado en el sistema'     
           );
        }
     }catch(Exception $e) {
         $data = array(
             'status'   => 'error',
             'code'     => '400',
             'message'  => 'No se ha podido eliminar el proveedor :('
         );
         return response()->json($data, $data['code']);
     } 
 });

/**********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************
 * ***********************************************                 CATEGORIES SECTION                              ****************************************************
 * ********************************************************************************************************************************************************************
 * ********************************************************************************************************************************************************************/

 route::get('categories', function() {
    return datatables()
    ->eloquent(\App\Category::query())
    ->toJson();
 });

 route::post('categories', function(Request $request) {
     if($request->input('json', null)){
        $json = $request->input('json', null);
        $params = json_decode($json);
     }else{
         $json = $request->all();
         $params = json_decode(json_encode($json));
     }

     try{
        $category = new Category();
        $exist = $category->exist($params->name);

        if(!$exist) {
            $name = $params->name;
            $category->createCategory($name);

            $data = array(
                'status'    => 'created',
                'code'      => '201',
                'message'   => 'La categoría ha sido agregada correctamente :)'
            );
            return response()->json($data, $data['code']);
        }else{
            $data = array(
                'status'    => 'error',
                'code'      => '422',
                'message'   => 'La categoría que intenta registrar, ya existe en el sistema :('
            );
            return response()->json($data, $data['code']);
        }
     }catch(Exception $e) {
         return $e;
     }
 });

 route::get('categories/{name}', function($name) {
     $category = new Category();
     $exist = $category->exist($name);

     if($exist){
         return $category->searchCategory($name);
     }else{
         $data = array(
             'status'   => 'not found',
             'code'     => '404',
             'message'  => 'La categoría que desea editar no está registrada en el sistema'
         );

         return response()->json($data, $data['code']);
     }
 });

 route::put('categories/{id_category}', function(Request $request) {
    if($request->input('json', null)){
        $json = $request->input('json', null);
        $params = json_decode($json);
     }else{
         $json = $request->all();
         $params = json_decode(json_encode($json));
     }

     try{
         $category = new Category();
         $exist = $category->existId($params->id_category);

         if($exist){
             $name = $params->name;
             $id_category = $params->id_category;
             $category->updateCategory($id_category, $name);

             $data = array(
                 'status'   => 'modified',
                 'code'     => '201',
                 'message'  => 'La categoría ha sido modificada exitosamente :)'
             );
             return response()->json($data, $data['code']);
         }else{
             $data = array(
                 'status'   => 'not found',
                 'code'     => '404',
                 'message'  => 'La categoría que desea editar no se encuentra registrada en el sistema :('
             );
             return response()->json($data, $data['code']);
         }
     }catch(Exception $e){
        $data = array(
            'status'    => 'bad request',
            'code'      => '400',
            'message'   => 'No se pudo actualizar la categoría :('
        );
        return response()->json($data, $data['code']);
    }
 });

 route::delete('categories/{name}', function(Request $request, $name) {
    $category = new Category();
    $exist = $category->exist($name);

    try{
       if($exist) {
           $category->deleteCategory($name);
  
           $data = array(
               'status'   => 'success',
               'code'     => '200',
               'message'  => 'La categoría ha sido eliminado correctamente del sistema'
           );
  
           return response()->json($data, $data['code']);
       }else {
           $data = array(
              'status'    => 'error',
              'code'      => '404',
              'message'   => 'La categoría que intenta eliminar no está registrado en el sistema'     
          );
       }
    }catch(Exception $e) {
       /* $data = array(
            'status'   => 'error',
            'code'     => '400',
            'message'  => 'No se ha podido eliminar la categoría :('
        );
        return response()->json($data, $data['code']);*/
        return $e;
    } 
 });

 route::delete('pods/{id_pod}', function($id_pod) {
    try{
        $pod = new PurchaseOrderDetail();
        $pod->deletePod((int)$id_pod);

        $data = array(
            'status'    => 'success',
            'code'      => '200',
            'message'   => 'Detalle eliminado correctamente del sistema ;)'
        );
        return response()->json($data, $data['code']);
    }catch(Exception $e) {
        $data = array(
            'status'    => 'error',
            'code'      => '400',
            'message'   => 'No se pudo eliminar el detalle, intente nuevamente'
        );
        return response()->json($data, $data['code']);
    }
});
