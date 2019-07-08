<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Charts;
class RegularClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { $client=DB::table('clinic_medical_history')
        ->leftJoin('clinic_history_vaccinations','clinic_history_vaccinations.historyid','=','clinic_medical_history.idhistory')
        ->leftJoin('clinic_consultations','clinic_consultations.historyid','=','clinic_medical_history.idhistory')
        ->leftJoin('clinic_history_surgery','clinic_history_surgery.historyid','=','clinic_medical_history.idhistory')
        ->leftJoin('params_pets','params_pets.idpet','=','clinic_medical_history.petid')
        ->leftJoin('params_people','params_people.idperson','=','params_pets.ownerid')
        ->select(DB::raw('params_people.firstname,count(clinic_consultations.historyid) as consultas,count(clinic_history_vaccinations.historyid) as vacunas,count(clinic_history_surgery.historyid)as cirugias'))
        ->groupBy('params_people.idperson','params_people.firstname','clinic_consultations.historyid','clinic_history_vaccinations.historyid','clinic_history_surgery.historyid')
        //->orderBy('cantidad','desc')
        ->take(5)
        ->get();
        //dd($client);
        if(count($client)>0 ){
            $nombre=array();
            $cabeceras=array('Consultas','Vacunas','Cirugias');
            $cant=array();/*
            $cantidadConsutlas=array();
            $cantidadVacunas=array();
            $cantidadCirugias=array();*/
            foreach ($client as $p){
                array_push($nombre, $p->firstname);/*
                array_push($cantidadConsutlas, $p->consultas);
                array_push($cantidadVacunas, $p->vacunas);
                array_push($cantidadCirugias, $p->cirugias);*/
                array_push($cant, $p->cirugias,$p->vacunas,$p->cirugias);
            }
            //dd($cant);
            $chart = Charts::create('bar', 'highcharts')
                ->title('Cliente mas frecuente')
                ->elementlabel("Cantidad total")
                ->labels($cabeceras)
                ->values($cant)
                ->dimensions(1000,500)
                ->responsive(true)
            ;
            return view('reports.regularclient', compact('chart','nombre'));
        }else{
            $chart=Charts::create('bar','highcharts')
                ->title('No se registraron datos para mostrar en este grafico');
            return  view('reports.regularclient',compact('chart','nombre'));
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
