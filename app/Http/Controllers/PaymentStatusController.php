<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\Log;

class PaymentStatusController extends Controller
{
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

    public function updatePaymentStatus(Request $request){
        $log = new Log();
        $id_purchase_order  = $request->id_purchase_order;
        $rut_user           = $request->rut_user;
        
        $po = new PurchaseOrder();
        $po->updatePaymentStatus($id_purchase_order);
        $action = 'Cambió el estado de pago de la orden '.$id_purchase_order.' a Pagada';

        $log->productLog($rut_user, $action);

        return redirect()->back();
    }

    public function getPayed(){
        $po = new PurchaseOrder();
        $orders = $po->getPayedPOrders();

        return view('PO.payed', compact('orders'));
    }

}
