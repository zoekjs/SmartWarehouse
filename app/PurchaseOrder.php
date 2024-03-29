<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
    protected $primaryKey = 'id_purchase_order';

    public function getPOrders(){
        return \DB::table('purchase_order as po')
                    ->join('status as s', 's.id_status', '=', 'po.id_status')
                    ->join('money as m', 'm.id_money', '=', 'po.id_money')
                    ->join('provider as pro', 'pro.rut_provider', '=', 'po.rut_provider')
                    ->join('payment_status as ps', 'po.id_payment_status', '=', 'ps.id_payment_status')
                    ->select('po.id_purchase_order', 'pro.name as provider', 's.name as status_name', 'po.created_at', 'ps.status', 'po.total')
                    ->orderBy('po.id_purchase_order', 'desc')
                    ->paginate(10);
    }

    public function getAprovedPOrders(){
        return \DB::table('purchase_order as po')
        ->join('status as s', 's.id_status', '=', 'po.id_status')
        ->join('money as m', 'm.id_money', '=', 'po.id_money')
        ->join('provider as pro', 'pro.rut_provider', '=', 'po.rut_provider')
        ->join('payment_status as ps', 'po.id_payment_status', '=', 'ps.id_payment_status')
        ->select('po.id_purchase_order', 'pro.name as provider', 's.name as status_name', 'po.created_at', 'ps.status', 'po.total')
        ->orderBy('po.id_purchase_order', 'desc')
        ->where('po.id_status', 3)
        ->where('po.id_payment_status', 0)
        ->paginate(10);
    }

    public function getPayedPOrders(){
        return \DB::table('purchase_order as po')
        ->join('status as s', 's.id_status', '=', 'po.id_status')
        ->join('money as m', 'm.id_money', '=', 'po.id_money')
        ->join('provider as pro', 'pro.rut_provider', '=', 'po.rut_provider')
        ->join('payment_status as ps', 'po.id_payment_status', '=', 'ps.id_payment_status')
        ->select('po.id_purchase_order', 'pro.name as provider', 's.name as status_name', 'po.created_at', 'po.updated_at', 'ps.status', 'po.total')
        ->orderBy('po.id_purchase_order', 'desc')
        ->where('po.id_status', 3)
        ->where('po.id_payment_status', 1)
        ->paginate(10);
    }

    public function createOrder($id_money, $id_payment, $rut_provider, $observation, $observation_payment) {
        $order = new PurchaseOrder();
        $order->rut_user            = Auth::User()->rut_user;
        $order->id_money            = $id_money;
        $order->id_status           = 1;
        $order->id_payment          = $id_payment;
        $order->rut_provider        = $rut_provider;
        $order->observation         = $observation;
        $order->observation_payment = $observation_payment;
        $order->save();
    }

    public function updateStatus($id_purchase_order){
        $order = PurchaseOrder::where('id_purchase_order', $id_purchase_order)->firstOrFail();
        if($order->id_status == 1){
            $order->id_status   = 2;
            $order->save();            
        }   
    }

    public function updatePaymentStatus($id_purchase_order){
        $order = PurchaseOrder::where('id_purchase_order', $id_purchase_order)->firstOrFail();
        if($order->id_payment_status == 0){
            $order->id_payment_status = 1;
            $order->save();
        }
    }

    public function getOrder($id_purchase_order){
        return \DB::table('purchase_order as po')
            ->join('status as s', 's.id_status', '=', 'po.id_status')
            ->join('money as m', 'm.id_money', '=', 'po.id_money')
            ->join('payment_method as met', 'met.id_payment', '=', 'po.id_payment')
            ->join('provider as pro', 'pro.rut_provider', '=', 'po.rut_provider')
            ->join('users as u', 'u.rut_user', '=', 'po.rut_user')
            ->select('po.id_purchase_order', 's.name as status_name', 'pro.rut_provider', 'pro.name as provider_name', 'pro.address', 'pro.telephone', 'pro.email',  'met.name as method', 'po.observation', 'po.observation_payment', 'po.created_at', 'po.total', 'u.name', 'u.last_name', 'po.reason', 's.id_status')
            ->where('po.id_purchase_order', $id_purchase_order)
            ->get();
    }

    public function updateOrder($id_purchase_order, $neto, $iva, $total, $id_status, $reason){
        $order = PurchaseOrder::where('id_purchase_order', $id_purchase_order)->firstOrFail();
        $order->neto    = $neto;
        $order->iva     = $iva;
        $order->total   = $total;
        $order->id_status  = $id_status;
        $order->reason = $reason;
        $order->save();
    }

    
    


}
