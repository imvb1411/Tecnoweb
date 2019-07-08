<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\History;
use App\HistoryVaccination;
use App\Person;
use App\Pet;
use App\Race;
use App\Staff;
use App\Vaccination;
use App\View;
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
        $view=View::where('viewname','=','Historiales')->first();
        $view->views=$view->views+1;
        $view->update();

        $clients=Person::all()->where('type','=','Client');
        $histories=History::all()->where('status',1);
        $races=Race::all()->where('status',1);
        $vaccinations=Vaccination::all()->where('status',1);
        $staffs=Staff::all()->where('status',1);
        return view('clinic.histories.index',compact('clients','histories','races','vaccinations','staffs','view'));
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
            if ($request->ownerExist===true) {
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
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $history=History::findOrFail($request->idhistory);
            $pet = Pet::findOrFail($history->petid);
            $pet->ownerid = $request->ownerid;
            $pet->raceid = $request->raceid;
            $pet->petname=$request->petname;
            $pet->birthdate=$request->birthdate;
            $pet->color=$request->color;
            $pet->userid = 2;
            $pet->update();
            DB::commit();
            Session::put('success', 'Historial de ' . $pet->petname . ' fue actualizado correctamente.');
        }catch (\Exception $e){
            Session::put('danger', 'Ocurrio un problema al actualiar el historial '.$e->getMessage());
            DB::rollBack();
        }
        return redirect()->route('histories.index');
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

    public function addVaccination(Request $request){
        DB::beginTransaction();
        try{
            $historyVaccination=new HistoryVaccination();
            $historyVaccination->historyid=$request->idhistory;
            $historyVaccination->vaccinationid=$request->vaccinationid;
            $historyVaccination->dosisnumber=$request->dosisnumber;
            $historyVaccination->save();
            DB::commit();
            Session::put('success', 'Vacuna agregada correctamente.');
        }catch (\Exception $e){
            DB::rollBack();
            Session::put('danger', 'Ocurrio un problema al agregar la vacuna '.$e->getMessage());
        }
        return redirect()->route('histories.index');
    }

    public function addConsultation(Request $request){
        DB::beginTransaction();
        try{
            $consultation=new Consultation($request->all());
            $consultation->userid=2;
            $consultation->save();
            DB::commit();
            Session::put('success', 'Consultada creada correctamente.');
        }catch (\Exception $e){
            DB::rollBack();
            Session::put('danger', 'Ocurrio un problema al crear la consulta '.$e->getMessage());
        }
        return redirect()->route('histories.index');
    }
}
