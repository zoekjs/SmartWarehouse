<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $this->validate(request(), [
                'id_product' => 'required|int',
                'name' => 'required|string',
                'description' => 'string',
                'quantity' => 'required|int',
                'unit_price' => 'required|int' 
            ]);

            $product = new Product();
            $id_product     = $request->id_product;
            $name           = $request->name;
            $description    = $request->description;
            $quantity       = $request->quantity;
            $unit_price     = $request->unit_price;

            $product->createProduct($id_product, $name, $description, $quantity, $unit_price);

        }catch(\Illuminate\Database\QueryException $ex){
            //
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
    public function update(Request $request, $id)
    {
        //
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
