<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\PaymentMethod;
use App\PurchaseOrderDetail;
use App\Log;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{

    function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $countrys = DB::table('country')->orderBy('name', 'asc')->get();
        return view('providers', compact('countrys'));
    }

    public function download($id_purchase_order){
        $orderDetail = new PurchaseOrderDetail();
        $details = $orderDetail->getDetail($id_purchase_order);
        $order = new PurchaseOrder();
        $orderData = $order->getOrder($id_purchase_order);
        $pdf = \PDF::loadView('PO/order', compact('details', 'orderData'));
        return $pdf->stream('Orden-'.$id_purchase_order.'.pdf');
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
            $log = new Log();
            $id_money               = $request->id_money;
            $id_payment             = $request->id_payment;
            $rut_provider           = $request->rut_provider;
            $observation            = $request->observation;
            $observation_payment    = $request->observation_payment;
            $rut_user               = $request->rut_user;

            $order->createOrder($id_money, $id_payment, $rut_provider, $observation, $observation_payment);
            $last = \DB::table('purchase_order')->orderBy('id_purchase_order', 'DESC')->first();
            $action = 'Añadió una orden de compra al sistema, el numero de orden es: '.$last->id_purchase_order;
            $log->productLog($rut_user, $action);

            return redirect()->back();
        }catch(Exception $e){
            return response()->back();
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
            $log =  new Log();
            if($request->estado == 'aprobada'){
                $id_status          = 3;
                $id_purchase_order  = $request->id_purchase_order;
                $neto               = $request->neto;
                $iva                = $request->iva;
                $total              = $request->total;
                $reason             = $request->reason;
                $rut_user           = $request->rut_user;

                $action = 'aprobó la orden de compra N°: '.$id_purchase_order;
                $log->productLog($rut_user, $action);
                $order->updateOrder($id_purchase_order, $neto, $iva, $total, $id_status, $reason);
                return redirect('/ordenes');
            }else if($request->estado == 'rechazada') {
                $id_status          = 4;
                $id_purchase_order  = $request->id_purchase_order;
                $neto               = $request->neto;
                $iva                = $request->iva;
                $total              = $request->total;
                $reason             = $request->reason;
                $rut_user           = $request->rut_user;

                $action = 'rechazó la orden de compra N°: '.$id_purchase_order;
                $log->productLog($rut_user, $action);
                $order->updateOrder($id_purchase_order, $neto, $iva, $total, $id_status, $reason);
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
