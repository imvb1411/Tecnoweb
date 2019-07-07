<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Person;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view=View::where('viewname','=','Empleados')->first();
        $view->views=$view->views+1;
        $view->update();

        $staffs=Staff::all()->where('status',1);
        return view('security.staffs.index',compact('staffs','view'));
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
        $staff=new Staff($request->all());
        $person=new Person($request->all());
        $person->type='Staff';
        if($person->save()){
            $staff->personid=$person->idperson;
            if($staff->save()){
                Session::put('success','Empleado '.$person->firstname.' '.$person->lastname.' creado correctamente');
            }else{
                Session::put('danger','Ocurrio un error al crear el empleado '.$person->firstname.' '.$person->lastname);
            }
        }
        return redirect()->route('staffs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $staff=Staff::findOrFail($request->idstaff);
        $staff->occupation=$request->occupation;
        $person=Person::findOrFail($staff->personid);
        $person->firstname=$request->firstname;
        $person->lastname=$request->lastname;
        $person->phone=$request->phone;
        DB::beginTransaction();
        try{
            $person->update();
            $staff->update();
            DB::commit();
            Session::put('success','Empleado '.$person->firstanme.' actualizado correctamente');
        }catch (\Exception $e){
            DB::rollBack();
            Session::put('success','Ocurrio un problema al actualizar: '.$e->getMessage());
        }
        return redirect()->route('staffs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
