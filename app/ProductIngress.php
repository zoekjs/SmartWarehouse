<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\log;

class ProductIngress extends Model
{
    protected $table = 'product_ingress';
    protected $primaryKey = 'id_product_ingress';


    public function storeIngressDetail($id_ingress, $id_product, $quantity){
        //Reistrar el ingreso de productos
        $productIngress = new ProductIngress();
        $productIngress->id_ingress = $id_ingress;
        $productIngress->id_product = $id_product;
        $productIngress->quantity = $quantity;
        $productIngress->save();
        //Actualizar cantidad del producto
        $product = Product::where('id_product', $id_product)->firstOrFail();
        $cantidad = $product->quantity;
        $product->quantity = $cantidad += $quantity;
        $product->save();

    }

    public function getIngressDetail($id_ingress){
        return \DB::table('product_ingress as pi')
            ->join('product as p', 'p.id_product', '=', 'pi.id_product')
            ->select('pi.id_ingress', 'p.id_product','p.name as product_name', 'pi.quantity', 'pi.created_at')
            ->where('pi.id_ingress', $id_ingress)
            ->paginate(10);
    }
}
