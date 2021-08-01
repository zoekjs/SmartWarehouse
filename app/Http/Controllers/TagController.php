<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Log;

class TagController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = new Tag();
        $tags = $tag->getAllTags();
        return view('tags.tags', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('json', null)) {
            $json = $request->input('json', null);
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }
        
        $tag = new Tag();
        $log = new Log();
        $exist = $tag->exist($params->id_tag);
        if (!$exist) {
            $id_tag = $params->id_tag;
            $rut_user = $params->rut_user;

            $action = 'Añadió tag "'.$id_tag.'" al sistema';
            $log->productLog($rut_user, $action);
            $tag->createTag($id_tag);

            $data = array(
                'status'    =>  'Created',
                'code'      =>  '201',
                'message'   =>  'Tag registrado exitosamente ! :)'
            );
            return response()->json($data, $data['code']);

        } elseif ($exist) {
            $data = array(
                'status'    => 'Unprocessable Entity',
                'code'      => '422',
                'message'   => 'El tag ya existe en el sistema'
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_tag)
    {
        if($request->input('json', null)) {
            $json = $request->input('json', null);
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }
        try {
            //dd($params);
            $tag = new Tag();
            $log = new Log();

            $id_tag = $id_tag;
            $id_product = $params->id_product;
            $rut_user = $params->rut_user;

            $action = 'Asoció tag "'.$id_tag.'" con producto "'.$id_product.'" en el sistema';
            $log->productLog($rut_user, $action);
            $tag->saveTagProduct($id_tag, $id_product);

            $data = array(
                'status'    =>  'Created',
                'code'      =>  '201',
                'message'   =>  'Tag actualizado exitosamente ! :)'
            );
            return response()->json($data, $data['code']);
            
        } catch (Exception $e) {
            $data = array(
                'status'    => 'Unprocessable Entity',
                'code'      => '422',
                'message'   => 'El tag que intenta modificar no está registrado en el sistema.'
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
