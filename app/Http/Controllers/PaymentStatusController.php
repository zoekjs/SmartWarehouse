<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\Log;

class PaymentStatusController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->except(['index', 'update', 'getPayedOrders']);    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $po = new PurchaseOrder();
        $orders = $po->getAprovedPOrders();
        return view('PO/unpayed', compact('orders'));
    } 

    public function index()
    {
        $purchaseOrder = new PurchaseOrder();
        $aprovedOrders = $purchaseOrder->getAprovedPOrders();
        return response()->json($aprovedOrders);
    }

    public function update($id_purchase_order, Request $request)
    {
        try{
            $log = new Log();
            $rut_user = $request->header('x-rut-user');
            $po = new PurchaseOrder();
            $action = 'Cambió el estado de pago de la orden ' . $id_purchase_order . ' a Pagada';
            $log->productLog($rut_user, $action);
            $po->updatePaymentStatus($id_purchase_order);

            $data = array(
                'status' => 'updated',
                'code' => '200',
                'message' => 'Orden pagada con éxito'
            );

            return response()->json($data, $data['code']);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function getPayedView()
    {
        $po = new PurchaseOrder();
        $orders = $po->getPayedPOrders();
        return view('PO.payed', compact('orders'));
    }

    public function getPayedOrders(){
        $po = new PurchaseOrder();
        $orders = $po->getPayedPOrders();

        return response()->json($orders);
    }
}
