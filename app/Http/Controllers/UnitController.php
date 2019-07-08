<?php

namespace App\Http\Controllers;

use App\Unit;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view=View::where('viewname','=','Unidades')->first();
        $view->views=$view->views+1;
        $view->update();

        $units=Unit::all()->where('status',1);
        return view('params.units.index',compact('units','view'));
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
        $unit=new Unit($request->all());
        $unit->userid=2;
        if($unit->save()){
            Session::put('success','Unidad '.$unit->unitname.' creada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al crear la unidad '.$unit->unitname);
        }
        return redirect()->route('units.index');
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
        $unit=Unit::findOrFail($request->idproductunit);
        $unit->unitname=$request->unitname;
        $unit->unitabbreviation=$request->unitabbreviation;
        if($unit->update()){
            Session::put('success','Unidad '.$unit->unitname.' actualizada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al actualizar la unidad '.$unit->unitname);
        }
        return redirect()->route('units.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit=Unit::findOrFail($id);
        $unit->status=0;
        if($unit->update()){
            Session::put('success','Unidad '.$unit->unitname.' eliminada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al eliminar la unidad '.$unit->unitname);
        }
        return redirect()->route('units.index');
    }
}
