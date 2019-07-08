<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Charts;
use phpDocumentor\Reflection\Types\Array_;

class ProductReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=DB::table('inv_product_purchase')
            ->join('inv_products','idproduct','=','productid')
            ->select(DB::raw('inv_products.productname, sum(inv_product_purchase.quantity) as cantidad'))
            ->groupBy('inv_products.productname')
            ->orderBy('cantidad','desc')
            ->take(5)
            ->get();
        //dd($product);
        if(count($product)>0 ){
                $nombre=array();
                $cantidad=array();
        foreach ($product as $p){
            array_push($nombre, $p->productname);
            array_push($cantidad, $p->cantidad);
        }
            //dd($nombre);
            $chart = Charts::create('bar', 'highcharts')
                ->title('Productos mas comprados')
                ->elementlabel("Total cantidad comprada")
                ->labels($nombre)
                ->values($cantidad)
                ->dimensions(1000,500)
                ->responsive(true)
            ;
            return view('reports.products', compact('chart'));
        }else{
            $chart=Charts::create('bar','highcharts')
                ->title('No se registraron datos para mostrar en este grafico');
            return  view('reports.products',compact('chart'));
        }



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
        //
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
