<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';

    public function createProduct($id_product, $name, $description, $quantity, $unit_price)
    {
        $product = new Product();
        $product->id_product = $id_product;
        $product->name = $name;
        $product->description = $description;
        $product->quantity = $quantity;
        $product->unit_price = $unit_price;
        $product->save();
    }

    public function productsList()
    {
        return DB::table('product')
            ->select('*')
            ->orderByDesc('created_at')
            ->get();
    }

    public function productsAll()
    {
        return DB::table('product')
            ->select('*')
            ->orderByDesc('created_at')
            ->get();
    }
    
    public function getProduct($id_product) {
        return DB::table('product')
            ->where('id_product', $id_product)
            ->first();
    }

    public function exist($id_product)
    {
        $count = Product::where('id_product', $id_product)->count();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($id_product, $name, $description, $quantity, $unit_price)
    {
        $product = Product::where('id_product', $id_product)->firstOrFail();
        $product->name = $name;
        $product->description = $description;
        $product->quantity = $quantity;
        $product->unit_price = $unit_price;
        $product->save();
    }

    public function deleteProduct($id_product)
    {
        $product = Product::where('id_product', $id_product)->firstOrFail();
        $product->delete();
    }

}
