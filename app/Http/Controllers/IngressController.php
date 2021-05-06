<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingress;
use App\Log;

class IngressController extends Controller
{

    public function listIngress(){
        $ingress = new Ingress();
        $allIngresses = $ingress->getAllIngresses();
        $providers = \App\Provider::all();  
        $doctypes = \DB::table('type_document')->get();
        
        return view('products/ingress', compact('allIngresses', 'providers', 'doctypes'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        try{
            $log = new Log();
            $ingress = new Ingress();

            $rut_user              = $request->rut_user;
            $id_type_document      = $request->id_type_document;
            $document_number       = $request->document_number;
            $observation           = $request->observation;
            $rut_provider          = $request->rut_provider;

            $action = 'Recibió productos en bodega';
            $log->productLog($rut_user, $action);
            $ingress->storeIngress($rut_user, $id_type_document, $document_number, $observation, $rut_provider);

            return redirect()->back();
        }catch(Exception $e){
            throw new Exception;
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
    public function update(Request $request, $id)
    {
        //
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
