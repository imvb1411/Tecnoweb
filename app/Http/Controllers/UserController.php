<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Person;
use App\Staff;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all()->where('status',1);
        $people = Staff::
            wherenotin('personid',
            function($query){
                $query->select('personid')
                    ->from('system_security_users')
                    ->where('status', '=', 1);
            })->get();
        return view('security.users.index',compact('users','people'));
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
        $user=new User($request->all());
        $user->personid=$request->personid;
        if($user->save()){
            Session::put('success','Usuario '.$user->nick.' creado correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al crear el usuario '.$user->nick);
        }
        return redirect()->route('users.index');
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
        $user=User::findOrFail($request->iduser);
        $user->nick=$request->nick;
        $user->password=$request->password;
        $user->personid=$request->personid;
        if($user->update()){
            Session::put('success','Usuario '.$user->nick.' actualizado correctamente');
        }else{
            Session::put('danger','Ocurrio un problema al actualizar al usuario '.$user->nick);
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $person=Person::findOrFail($user->personid);
        $person->status=0;
        if($person->update()){
            $user->status=0;
            $user->update();
        }
        return redirect()->route('users.index');
    }
}