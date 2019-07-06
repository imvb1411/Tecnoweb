<?php

namespace App\Http\Controllers;

use App\Race;
use App\Specie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $races=Race::all()->where('status',1);
        $species=Specie::all()->where('status',1);
        return view('params.races.index',compact('races','species'));
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
        $race=new Race($request->all());
        $race->userid=2;
        $race->specieid=$request->specieid;
        if($race->save()){
            Session::put('success','Raza '.$race->racename.' creada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al crear la raza '.$race->racename);
        }
        return redirect()->route('races.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $race=Race::findOrFail($request->idrace);
        $race->racename=$request->racename;
        $race->specieid=$request->specieid;
        if($race->update()){
            Session::put('success','Raza '.$race->racename.' actualizada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al actualizar la raza '.$race->racename);
        }
        return redirect()->route('races.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $race=Race::findOrFail($id);
        $race->status=0;
        if($race->update()){
            Session::put('success','Raza '.$race->racename.' eliminada correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al eliminar la raza '.$race->racename);
        }
        return redirect()->route('races.index');
    }
}
