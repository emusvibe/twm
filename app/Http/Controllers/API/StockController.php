<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->validate($request,[
            'item' => 'required|string|max:255',
            'opening_stock' => 'required',
            'sdis' => 'required',
            'sios' => 'required',
            'sohn' => 'required',
            'price_unit' => 'required',
            'total' => 'required'
        ]);
         return Product::create([
            'item' => $request['item'],
            'opening_stock' => $request['opening_stock'],
            'sdis' => $request['sdis'],
            'sios' => $request['sios'],
            'sohn' => $request['sohn'],
            'price_unit' => $request['price_unit'],
            'total' => $request['total']            
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->validate($request,[
            'item' => 'required|string|max:255',
            'opening_stock' => 'required',
            'sdis' => 'required',
            'sios' => 'required',
            'sohn' => 'required',
            'price_unit' => 'required',
            'total' => 'required'
        ]);
        $product->update($request->all());
        return ['message' => 'Updated'];
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        //delete product
        $product->delete();
        return ['message'=>'Item Deleted'];
    }
}
