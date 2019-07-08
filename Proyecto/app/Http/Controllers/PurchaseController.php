<?php

namespace App\Http\Controllers;

use App\Product;
use App\Purchase;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view=View::where('viewname','=','Compras')->first();
        $view->views=$view->views+1;
        $view->update();

        $purchases=Purchase::all()->where('status',1);
        $products=Product::all()->where('status',1);
        return view('purchases.purchases.index',compact('purchases','products','view'));
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
        DB::beginTransaction();
        try{
            $purchase=new Purchase();
            $purchase->date=$request->date;
            $purchase->save();

            $products=$request->products;
            $costs=$request->costs;
            $quantities=$request->quantities;
            $total=0;
            $i=0;
            while($i<count($products)){
                $purchase->products()->attach($purchase->idpurchase,['productid'=>$products[$i],'cost'=>$costs[$i],'quantity'=>$quantities[$i]]);
                $product=Product::findOrFail($products[$i]);
                $product->currentstock=$product->currentstock+$quantities[$i];
                $product->save();
                $total+=$costs[$i]*$quantities[$i];
                $i++;
            }
            $purchase->total=$total;
            $purchase->save();
            DB::commit();
            Session::put('success','Compra guardada correctamente');
        }catch (\Exception $e){
            DB::rollBack();
            Session::put('danger','Ocurrio un problema al guardar la compra '.$e->getMessage());
        }
        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase=Purchase::findOrFail($id);
        $purchase->status=0;
        if($purchase->update()){
            Session::put('success','Compra eliminada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al eliminar la compra');
        }
        return redirect()->route('purchases.index');
    }
}
