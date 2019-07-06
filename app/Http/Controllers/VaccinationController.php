<?php

namespace App\Http\Controllers;

use App\Vaccination;
use App\VaccinationPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vaccinations=Vaccination::all()->where('status',1);
        return view('params.vaccinations.index',compact('vaccinations'));
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
            $vaccination=new Vaccination();
            $vaccination->vaccinationname=$request->vaccinationname;
            $vaccination->userid=2;
            $vaccination->price=$request->price;
            $vaccination->save();
            $i=0;
            while($i<count($request->dosis)){
                $plan=new VaccinationPlan();
                $plan->dosisnumber=$request->dosis[$i];
                $plan->daysnumber=$request->days[$i];
                $plan->vaccinationid=$vaccination->idvaccination;
                $plan->save();
                $i++;
            }
            DB::commit();
            Session::put('success','Vacuna '.$vaccination->vaccinationname.' creada correctamente');
        }catch (\Exception $e){
            DB::rollBack();
            Session::put('danger','Ocurrio un problema al crear la vacuna '.$e->getMessage());
        }
        return redirect()->route('vaccinations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccination $vaccination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaccination $vaccination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vaccination $vaccination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vaccination  $vaccination
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $vaccionation = Vaccination::findOrFail($id);
            $vaccionation->status = 0;
            $vaccionation->update();
            Session::put('success', 'Vacuna ' . $vaccionation->vaccinationname . ' eliminada correctamente');
        }catch (\Exception $e){
            Session::put('danger','Ocurrio un problema al crear la vacuna '.$e->getMessage());
        }
        return redirect()->route('vaccinations.index');
    }
}
