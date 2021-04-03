<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductIngress;
use App\Ingress;
use App\Log;

class IngressDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_ingress)
    {
        $products = Product::all();
        $id = new ProductIngress();
        $details = $id->getIngressDetail($id_ingress);
        return view('products/proddetails', compact('products', 'id_ingress', 'details'));
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
            $ingressDetail = new productIngress();

            $id_ingress = $request->id_ingress;
            $id_product = $request->id_product;
            $quantity = $request->quantity;

            $product = Product::where('id_product', $id_product)->firstOrFail();
            $productIngress = $product->name;
            $log = new Log();
            $action = 'Recibió '.$quantity.' '.$productName.' en bodega';
            $log->productLog($rut_user, $action);
            $ingressDetail->storeIngressDetail($id_ingress, $id_product, $quantity);

            return redirect()->back();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
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
    public function update(Request $request)
    {
        $ingress = new Ingress();
        $log = new Log();

        $rut_user = $request->rut_user;
        $id_ingress  = $request->id_ingress;
        $action = 'Recibió productos con detalle en el documento N° '.$id_ingress;
        $log->productLog($rut_user, $action);

        $ingress->updateStatus($id_ingress);
        return redirect('ingresos');
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
