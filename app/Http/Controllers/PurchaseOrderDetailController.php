<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\PurchaseOrderDetail;
use App\PurchaseOrder;
use App\Log;
use Illuminate\Support\Facades\DB;

class PurchaseOrderDetailController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->except('destroy');
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
        $product = new Product();
        $products = $product->productsList();
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
            $log = new Log();

            $id_purchase_order  = $request->id_purchase_order;
            $id_product         = $request->id_product;
            $quantity           = $request->quantity;
            $unit_price         = $request->unit_price;
            $total              = (float)$quantity*(float)$unit_price;
            $rut_user           = $request->rut_user;

            $product = \DB::table('product')->where('id_product', $id_product)->first();
            $action = 'Añadió '.$quantity.' '.$product->name.' a la orden de compra número '.$id_purchase_order;

            $log->productLog($rut_user, $action);
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
        $log = new Log();

        $rut_user = $request->rut_user;
        $id_purchase_order  = $request->id_purchase_order;
        $action = 'Emitió la orden de compra N°: '.$id_purchase_order.' la cual está lista para su revisión.';
        $log->productLog($rut_user, $action);

        $order->updateStatus($id_purchase_order);
        return redirect('nueva-orden');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id_pod, $rut_user)
    {
        try {
            $pod = new PurchaseOrderDetail();
            $log = new Log();

            $products = DB::table('product_purchase_order as ppo')
                ->join('product as p', 'p.id_product', '=', 'ppo.id_product')
                ->select('ppo.quantity', 'p.name', 'ppo.id_purchase_order')
                ->where('ppo.id_product_purchase_order', (int)$id_pod)->get();
            foreach($products as $product){
                $action = 'Quitó '.$product->quantity.' '.$product->name.' a la orden de compra número '.$product->id_purchase_order;
            }

            $log->productLog($rut_user, $action);
            $pod->deletePod((int)$id_pod);
            $data = array(
                'status'    => 'success',
                'code'      => '200',
                'message'   => 'Detalle eliminado correctamente del sistema ;)'
            );
            return response()->json($data, $data['code']);
        } catch(Exception $e) {
            return $e;
            /*$data = array(
                'status'    => 'error',
                'code'      => '400',
                'message'   => 'No se pudo eliminar el detalle, intente nuevamente'
            );*/
            //return response()->json($data, $data['code']);
        }
    }
}
