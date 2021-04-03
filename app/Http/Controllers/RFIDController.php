<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RFIDController extends Controller
{
    Public function index(Request $request){
        
        if (empty($request->tag)) {
            return response()->json(['response' => 'False'],200);
        }
        
        $tag = $request->tag;
        
        $tag_status = DB::table('tags')->select(DB::raw('tags.enable'))
            ->where('id_tag', '=', $tag)->get();

        if ($tag_status[0]->enable == 0){
            return response()->json(['response' => 'False'],200);
        }

        $product = DB::table('tags')->select(DB::raw('tags.id_product'))->where([
            ['tags.enable', '1'],
            ['id_tag', $tag],
        ])->get();

        $quantity = DB::table('product')->select(DB::raw('product.quantity'))
            ->where('product.id_product', '=', $product[0]->id_product)->get();

        if ($quantity[0]->quantity > 0) {
            DB::table('product')->where('product.id_product', '=', $product[0]->id_product)->decrement('quantity', 1);
            return response()->json(['response' => 'True'],222);
        } else {
            return response()->json(['response' => 'False'],200);
        }
    }
}
