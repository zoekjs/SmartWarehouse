<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        return datatables()->eloquent(Category::query())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
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
        } catch(Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($name)
    {
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
    public function update(Request $request, $id)
    {
        if($request->input('json', null)) {
            $json = $request->input('json', null);
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }

        try {
            $category = new Category();
            $exist = $category->existId($params->id_category);

            if($exist) {
                $name = $params->name;
                $id_category = $params->id_category;
                $category->updateCategory($id_category, $name);

                $data = array(
                    'status'   => 'modified',
                    'code'     => '201',
                    'message'  => 'La categoría ha sido modificada exitosamente :)'
                );
                return response()->json($data, $data['code']);
            } else {
                $data = array(
                    'status'   => 'not found',
                    'code'     => '404',
                    'message'  => 'La categoría que desea editar no se encuentra registrada en el sistema :('
                );
                return response()->json($data, $data['code']);
            }
        } catch(Exception $e) {
            $data = array(
                'status'    => 'bad request',
                'code'      => '400',
                'message'   => 'No se pudo actualizar la categoría :('
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($name)
    {
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
        } catch(Exception $e) {
            /* $data = array(
                 'status'   => 'error',
                 'code'     => '400',
                 'message'  => 'No se ha podido eliminar la categoría :('
             );
             return response()->json($data, $data['code']);*/
            return $e;
        }
    }
}
