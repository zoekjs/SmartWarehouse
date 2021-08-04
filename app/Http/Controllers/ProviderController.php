<?php

namespace App\Http\Controllers;

use App\Log;
use App\Provider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{

    function __construct()
    {
        $this->middleware('auth')->except(['index', 'update', 'destroy', 'show', 'getDeletedProviders', 'restoreProvider', 'store', 'getProvider']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        $query = DB::table('provider as p')->select('p.rut_provider', 'p.name', 'p.telephone', 'p.address', 'p.email', 'c.name as country_name')
            ->join('country as c', 'c.id_country', '=', 'p.id_country')
            ->whereNull('deleted_at')
            ->get();
        return DataTables()->of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $countrys = DB::table('country')->orderBy('name', 'asc')->get();
        return view('providers', compact('countrys'));
    }

    public function restoreView() {
        return view('restoreProviders');
    }

    public function getDeletedProviders()
    {
        $provider = new Provider();
        $search = $provider->getDeletedProviders();

        return response()->json($search);
    }

    public function restoreProvider($rut_provider, Request $request)
    {
        $data = null;
        $log = new Log();
        $rut_user = $request->header('x-rut-user');
        $provider = new Provider();
        $res = $provider->restoreProvider($rut_provider);
        $search = $provider->searchProvider($rut_provider);

        if (!$res) {
            $data = array(
                'status' => 'Internal server error',
                'code' => '500',
                'message' => 'No se pudo restaurar el proveedor :('
            );
    
            return response()->json($data, $data['code']);
        }

        $action = 'Restauró el proveedor "'.$search->name.'" con rut número "'.$search->rut_provider.'" en el sistema.';
        $log->productLog($rut_user, $action);

        $data = array(
            'status' => 'success',
            'code' => '200',
            'message' => 'Proveedor restaurado correctamente :)',
        );
        
        return response()->json($data, $data['code']);
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
            $json = $request->input('json', null);
            $params = json_decode($json);
        } else {
            $json = $request->all();
            $params = json_decode(json_encode($json));
        }

        try {
            $provider = new Provider();
            $exist = $provider->exist($params->rut_provider.$params->dv);
            $user = new User();
            $log = new Log();

            $validaRut = $user->validarRut((int)$params->rut_provider, (int)$params->dv);

            if($validaRut) {
                if(!$exist) {
                    $rut_provider   = $params->rut_provider.$params->dv;
                    $id_pais        = (int)$params->id_pais;
                    $name           = $params->name;
                    $telephone      = $params->telephone;
                    $address        = $params->address;
                    $email          = $params->email;
                    $rut_user       =  $params->rut_user;

                    $action = 'Añadió el proveedor "'.$name.'" RUT: '.$rut_provider.' al sistema';
                    $log->productLog($rut_user, $action);
                    $provider->createProvider($rut_provider, $id_pais, $name, $telephone, $address, $email);

                    $data = array(
                        'status'    => 'created',
                        'code'      => '201',
                        'message'   => 'El proveedor fue registrado correctamente en el sistema :)'
                    );

                    return response()->json($data, $data['code']);
                } else {
                    $data = array(
                        'status'    => 'Unprocessable Entity',
                        'code'      => '422',
                        'message'   => 'El proveedor que intenta registrar ya existe en el sistema.'
                    );

                    return response()->json($data, $data['code']);
                }
            } else if(!$validaRut) {
                $data = array(
                    'status'    => 'error en el rut',
                    'code'      => '409',
                    'message'   => 'El rut ingresado no es válido, intente nuevamente'
                );
                return response()->json($data, $data['code']);
            }

        } catch(\Exception $e) {
            $data = array(
                'status'    => 'error',
                'code'      => '400',
                'message'   => 'No se ha podido registrar el proveedor :('
            );
            return response($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $rut_provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $rut_provider)
    {
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
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $rut_provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProvider(Request $request, $rut_provider)
    {
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
            return $provider->getProvider($rut_provider);
        }else {
            $data = array(
                'status'    => 'error',
                'code'      => '404',
                'message'   => 'El proveedor que intenta buscar, no se encuentra registrado en el sistema :('
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
     * @param \Illuminate\Http\Request $request
     * @param $rut_provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $rut_provider)
    {
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
            $log = new Log();

            if($exist){

                $id_country    = $params->id_country;
                $name          = $params->name;
                $telephone     = $params->telephone;
                $address       = $params->address;
                $email         = $params->email;
                $rut_user      = $params->rut_user;

                $action = 'Modificó el proveedor "'.$name.'", RUT: '.$rut_provider.' en el sistema';
                $log->productLog($rut_user, $action);
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

        } catch(\Exception $e) {
            $data = array(
                'status'    => 'error',
                'code'      => '400',
                'message'   => 'no se pudo modificar el proveedor :('
            );
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $rut_provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($rut_provider)
    {
        $provider = new Provider();
        $exist = $provider->exist($rut_provider);

        try {
            if($exist) {
                $provider->deleteProvider($rut_provider);
                $data = array(
                    'status'   => 'success',
                    'code'     => '200',
                    'message'  => 'El proveedor ha sido eliminado correctamente del sistema'
                );
                return response()->json($data, $data['code']);
            } else {
                $data = array(
                    'status'    => 'error',
                    'code'      => '404',
                    'message'   => 'El proveedor que intenta eliminar no está registrado en el sistema'
                );
            }
        } catch(\Exception $e) {
            $data = array(
                'status'   => 'error',
                'code'     => '400',
                'message'  => 'No se ha podido eliminar el proveedor :('
            );
            return response()->json($data, $data['code']);
        }
    }

}
