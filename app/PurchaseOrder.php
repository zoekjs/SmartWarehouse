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
                    ->select('po.id_purchase_order', 'pro.name as provider', 's.name as status_name', 'po.created_at')
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

    public function getOrder($id_purchase_order){
        return \DB::table('purchase_order as po')
            ->join('status as s', 's.id_status', '=', 'po.id_status')
            ->join('money as m', 'm.id_money', '=', 'po.id_money')
            ->join('payment_method as met', 'met.id_payment', '=', 'po.id_payment')
            ->join('provider as pro', 'pro.rut_provider', '=', 'po.rut_provider')
            ->join('users as u', 'u.rut_user', '=', 'po.rut_user')
            ->select('po.id_purchase_order', 's.name as status_name', 'pro.rut_provider', 'pro.name as provider_name', 'pro.address', 'pro.telephone', 'pro.email',  'met.name as method', 'po.observation', 'po.observation_payment', 'po.created_at', 'u.name', 'u.last_name')
            ->where('po.id_purchase_order', $id_purchase_order)
            ->get();
    }

    public function updateOrder($id_purchase_order, $neto, $iva, $total, $id_status){
        $order = PurchaseOrder::where('id_purchase_order', $id_purchase_order)->firstOrFail();
        $order->neto    = $neto;
        $order->iva     = $iva;
        $order->total   = $total;
        $order->id_status  = $id_status;
        $order->save();
    }

    public function validarRut($rut, $dvForm){
        $dv;
        $numero;
        $constante = 2;
        $suma = 0;
        $largo = strlen($rut);

        if(strlen($rut) > 0){
            for($i = $largo -1; $i>=0 ; $i--){
                (int)$numero = (int) substr($rut,(int) $i, 1);
                $suma = $suma + ($numero*$constante);
                $constante +=1;
                if ($constante == 8){
                    $constante = 2;
                }
            }
        }else{
            return false;
        }
            $dv=(11-((int)$suma%11));
            if($dv == 10){
                $dv = "K";
            }
            if($dv == 11){
                $dv = "0";
            }
            if($dv == $dvForm){
                return true;
            }else if(strcasecmp($dv, $dvForm) == 0){
                return true;
            }
            else{
                return false;
            }
        }
    


}
