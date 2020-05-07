<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\PurchaseOrderDetail;
use App\PurchaseOrder;

class PurchaseOrderDetailController extends Controller
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

    public function showPOrders(){
        return view('PO/preview-order');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products = Product::all();
        $id_purchase_order = $request->id_purchase_order;
        $pdo = new PurchaseOrderDetail();
        $details = $pdo->getPODetails($id_purchase_order);
        return view('PO/details', compact('products', 'id_purchase_order', 'details'));
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
            $pdo = new PurchaseOrderDetail();
            $order = new PurchaseOrder();

            $id_purchase_order  = $request->id_purchase_order;
            $id_product         = $request->id_product;
            $quantity           = $request->quantity;
            $unit_price         = $request->unit_price;
            $total           = (float)$quantity*(float)$unit_price;

            $pdo->createPODetails($id_purchase_order, $id_product, $quantity, $unit_price, $total);
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
    public function show($id)
    {
        //
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
        $order = new PurchaseOrder();

        $id_purchase_order  = $request->id_purchase_order;
        $order->updateStatus($id_purchase_order);
        return redirect('nueva-orden');
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
