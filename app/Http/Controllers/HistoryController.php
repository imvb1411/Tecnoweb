<?php

namespace App\Http\Controllers;

use App\History;
use App\HistoryVaccination;
use App\Person;
use App\Pet;
use App\Race;
use App\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients=Person::all()->where('type','=','Client');
        $histories=History::all()->where('status',1);
        $races=Race::all()->where('status',1);
        $hvaccinations=HistoryVaccination::all()->where('status',1);
        $vaccinations=Vaccination::all()->where('status',1);
        return view('clinic.histories.index',compact('clients','histories','races','hvaccinations','vaccinations'));
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
        try {
            if ($request->ownerid > 0) {
                $owner_id = $request->ownerid;
            } else {
                $client = new Person($request->all());
                $client->type = 'Client';
                $client->save();
                $owner_id = $client->idperson;
            }
            $pet = new Pet($request->all());
            $pet->ownerid = $owner_id;
            $pet->raceid = $request->raceid;
            $pet->userid = 2;
            if ($pet->save()) {
                $history = new History();
                $history->petid = $pet->idpet;
                if ($history->save()) {
                    DB::commit();
                    Session::put('success', 'Historial de ' . $pet->petname . ' creado correctamente');
                } else {
                    Session::put('danget', 'Ocurrio un problema al crear un historial de ' . $pet->petname);
                    DB::rollBack();
                }
            }
        }catch (\Exception $e){
            Session::put('danger', 'Ocurrio un problema al crear el historial '.$e->getMessage());
            DB::rollBack();
        }
        return redirect()->route('histories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        //
    }
}
