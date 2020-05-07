<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'product_purchase_order';
    protected $primaryKey = 'id_product_purchase_order';

    public function createPODetails($id_purchase_order, $id_product, $quantity, $unit_price, $total){
        $pod = new PurchaseOrderDetail();
        $pod->id_purchase_order     = $id_purchase_order;
        $pod->id_product            = $id_product;
        $pod->quantity              = $quantity;
        $pod->unit_price            = $unit_price;
        $pod->total                 = $total;
        $pod->save();
    }

    public function getPODetails($id_purchase_order){
        return   \DB::table('product_purchase_order as ppod')
                    ->join('product as p', 'p.id_product', '=', 'ppod.id_product')
                    ->select('ppod.id_product_purchase_order', 'p.id_product', 'p.name', 'ppod.quantity', 'ppod.unit_price', 'ppod.total')
                    ->where('id_purchase_order', $id_purchase_order)
                    ->paginate(10);
    }

    public function deletePod($id_pod){
        $pod = PurchaseOrderDetail::where('id_product_purchase_order', $id_pod)->firstOrFail();
        $pod->delete();
    }

    public function getDetail($id_purchase_order) {
        return \DB::table('product_purchase_order as ppo')
                ->join('product as p', 'p.id_product', '=', 'ppo.id_product')
                ->where('id_purchase_order', $id_purchase_order)
                ->get();
    }

}
