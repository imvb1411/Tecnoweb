<?php

namespace App\Http\Controllers;

use App\Specie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SpecieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $species=Specie::all()->where('status',1);
        return view('params.species.index',compact('species'));
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
        $specie=new Specie($request->all());
        $specie->userid=2;
        if($specie->save()){
            Session::put('success','Especie '.$specie->speciename.' creada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al crear la especie '.$specie->speciename);
        }
        return redirect()->route('species.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function show(Specie $specie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function edit(Specie $specie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $specie=Specie::findOrFail($request->idspecie);
        $specie->speciename=$request->speciename;
        if($specie->update()){
            Session::put('success','Especie '.$specie->speciename.' actualizada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al actualizar la especie '.$specie->speciename);
        }
        return redirect()->route('species.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specie  $specie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specie=Specie::findOrFail($id);
        $specie->status=0;
        if($specie->update()){
            Session::put('success','Especie '.$specie->speciename.' eliminada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al eliminar la especie '.$specie->speciename);
        }
        return redirect()->route('species.index');
    }
}
