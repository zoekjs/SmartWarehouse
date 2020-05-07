<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\PaymentMethod;
use App\PurchaseOrderDetail;

class PurchaseOrderController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listOrders(){
        $order = new PurchaseOrder();
        $orders = $order->getPOrders();
        $providers = \App\Provider::all();
        $moneys =     \DB::table('money')->get();
        $payment_methods = PaymentMethod::all();
        return view('PO/listorders', compact('orders', 'providers', 'moneys', 'payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = \App\Product::all();
        $providers = \App\Provider::all();
        return view('neworder', compact('products', 'providers'));
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
            
            $order = new PurchaseOrder();
            $id_money               = $request->id_money;
            $id_payment             = $request->id_payment;
            $rut_provider           = $request->rut_provider;
            $observation            = $request->observation;
            $observation_payment    = $request->observation_payment;

            $order->createOrder($id_money, $id_payment, $rut_provider, $observation, $observation_payment);
            return redirect()->back();
        }catch(Exception $e){
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_purchase_data)
    {
        $order = new PurchaseOrder();
        $orderData = $order->getOrder($id_purchase_data);
        $orderDetail = new PurchaseOrderDetail();
        $details = $orderDetail->getDetail($id_purchase_data);
        $neto = 0;
        foreach($details as $detail){
            $neto += $detail->total;
        }

        $iva = $neto * .19;
        $total = $neto+$iva;
        return view('PO/preview-order', compact('orderData', 'details', 'neto', 'iva', 'total'));
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
        try{
            $order = new PurchaseOrder();
            if($request->estado == 'aprobada'){
                $id_status          = 3;
                $id_purchase_order  = $request->id_purchase_order;
                $neto               = $request->neto;
                $iva                = $request->iva;
                $total              = $request->total;
    
                $order->updateOrder($id_purchase_order, $neto, $iva, $total, $id_status);
                return redirect('/ordenes');
            }else if($request->estado == 'rechazada') {
                $id_status          = 4;
                $id_purchase_order  = $request->id_purchase_order;
                $neto               = $request->neto;
                $iva                = $request->iva;
                $total              = $request->total;
    
                $order->updateOrder($id_purchase_order, $neto, $iva, $total, $id_status);
                return redirect('/ordenes');
            }

        }catch(Exception $e){
            return $e;
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
