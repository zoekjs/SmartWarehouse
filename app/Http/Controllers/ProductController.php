<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
      return datatables()->eloquent(Product::query()->orderByDesc('created_at'))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if($request->input('json', null)) {
            //Recoger datos del json
            $json = $request->input('json', null);
            //decodificar json
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }

        //crear un nuevo producto
        $product = new Product();
        $log = new Log();
        $exist = $product->exist((int)$params->id_product);
        if(!$exist) {
            $id_product = (int)$params->id_product;
            $name       = $params->name;
            $description = $params->description;
            $quantity   = (int)$params->quantity;
            $unit_price = (int)$params->unit_price;
            $rut_user   =  $params->rut_user;

            $action = 'Añadió producto "'.$name.'" al sistema';
            $log->productLog($rut_user, $action);
            $product->createProduct($id_product, $name, $description, $quantity, $unit_price);

            $data = array(
                'status'    =>  'Created',
                'code'      =>  '201',
                'message'   =>  'Producto registrado exitosamente ! :)'
            );
            return response()->json($data, $data['code']);
        } elseif ($exist) {
            $data = array(
                'status'    => 'Unprocessable Entity',
                'code'      => '422',
                'message'   => 'El producto ya existe en el sistema'
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id_product)
    {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id_product)
    {
        if($request->input('json', null)) {
            //Recoger datos del json
            $json = $request->input('json', null);
            //decodificar json
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }

        try {
            $product = new Product();
            $log = new Log();

            $id_product     = $request->$id_product;
            $name           = $params->name;
            $description    = $params->description;
            $quantity       = (int)$params->quantity;
            $unit_price     = (int)$params->unit_price;
            $rut_user       = $params->rut_user;

            $action = 'Modificó producto "'.$name.'" con código "'.$id_product.'" en el sistema';
            $log->productLog($rut_user, $action);
            $product->updateProduct($id_product, $name, $description, $quantity, $unit_price);

            $data = array(
                'status'    => 'success',
                'code'      => '201',
                'message'   =>  'El producto fue actualizado exitosamente ! :)'
            );

            return response()->json($data, $data['code']);
        } catch(Exception $e) {
            $data = array(
                'status'    => 'not found',
                'code'      => '404',
                'message'   => 'El producto que intenta modificar no está registrado en el sistema.'
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id_product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id_product, Request $request)
    {
        try {
            if(!is_numeric($id_product)){
                return response()->json('Los datos ingresados no son correctos', 400);
            }
            $product = new Product();
            $search = Product::where('id_product', $id_product)->firstOrFail();
            $log = new Log();
            $rut_user = $request->header('X-Rut-User');
            $action = 'Eliminó el producto "'.$search->name.'" con código "'.$search->id_product.'" del sistema';
            $log->productLog($rut_user, $action);
            $product->deleteProduct((int)$id_product);

            $data = array(
                'status'    => 'success',
                'code'      => '200',
                'message'   => 'Producto eliminado correctamente del sistema ;)'
            );
            return response()->json($data, $data['code']);
        } catch(Exception $e) {
            $data = array(
                'status'    => 'error',
                'code'      => '400',
                'message'   => 'No se pudo eliminar el producto, intente nuevamente'
            );
            return response()->json($data, $data['code']);
        }
    }
}
