<?php

namespace App\Http\Controllers;

use App\Product;
use App\Unit;
use App\Category;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view=View::where('viewname','=','Productos')->first();
        $view->views=$view->views+1;
        $view->update();

        $products=Product::all()->where('status',1);
        $units=Unit::all()->where('status',1);
        $categories=Category::all()->where('status',1);
        return view('purchases.products.index',compact('products','units','categories','view'));
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
        $product=new Product($request->all());
        $product->userid=2;
        $product->categoryid=$request->categoryid;
        $product->unitid=$request->unitid;
        if($product->save()){
            Session::put('success','Producto '.$product->productname.' creado correctamente');
        }else{
            Session::put('danger','Ocurrio un error al crear el producto '.$product->productname);
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product=Product::findOrFail($request->idproduct);
        $product->unitid=$request->unitid;
        $product->categoryid=$request->categoryid;
        $product->productname=$request->productname;
        $product->price=$request->price;
        $product->cost=$request->cost;
        if($product->update()){
            Session::put('success','Producto '.$product->productname.' actualizado correctamente');
        }else{
            Session::put('danger','Ocurrio un error al actualizar el producto '.$product->productname);
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->status=0;
        if($product->update()){
            Session::put('success','Producto '.$product->productname.' eliminado correctamente');
        }else{
            Session::put('danger','Ocurrio un error al eliminar el producto '.$product->productname);
        }
    }
}
