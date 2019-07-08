<?php

namespace App\Http\Controllers;

use App\HistoryVaccination;
use App\Vaccination;
use Charts;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class VaccinationReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $namevaccination=DB::table('clinic_history_vaccinations')
            ->join('params_clinic_vaccinations','vaccinationid','=','idvaccination')
            ->select(DB::raw('params_clinic_vaccinations.vaccinationname, count(params_clinic_vaccinations.vaccinationname) as cantidad'))
            ->groupBy('params_clinic_vaccinations.vaccinationname')
            ->get();

        if(count($namevaccination)>0 ){
            $array=array();
            $array1=array();
        foreach ($namevaccination as $vacuna){
            array_push($array, $vacuna->vaccinationname);
            array_push($array1, $vacuna->cantidad);
        }

        $chart = Charts::create('bar', 'highcharts')
            ->title('Vacunas mas utilizadas')
            ->elementlabel("Total Vacunas")
            ->labels($array)
            ->values($array1)
            ->dimensions(1000,500)
            ->responsive(true)
            ;
        return view('reports.vaccinations', compact('chart'));
        }else{
            $chart=Charts::create('bar','highcharts')
                ->title('No se registraron datos para mostrar en este grafico');
                return  view('reports.vaccinations', compact('chart'));
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
