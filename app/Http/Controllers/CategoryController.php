<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all()->where('status',1);
        return view('params.categories.index',compact('categories'));
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
        $category=new Category($request->all());
        $category->userid=2;
        if($category->save()){
            Session::put('success','Categoria '.$category->categoryname.' creada correctamente');
        }else{
            Session::put('danger','Ocurrio un error al crear la categoria '.$category->categoryname);
        }
        return redirect()->route('categories.index');
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
        $category=Category::findOrFail($request->idproductcategory);
        $category->categoryname=$request->categoryname;
        if($category->update()){
            Session::put('success','Categoria '.$category->categoryname.' actualizada correctamente');
        }else{
            Session::put('danger','Ocurrio un error al actualizar la categoria '.$category->categoryname);
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $category->status=0;
        if($category->update()){
            Session::put('success','Categoria '.$category->categoryname.' eliminada correctamente');
        }else{
            Session::put('danger','Ocurrio un error al eliminar la categoria'.$category->categoryname);
        }
        return redirect()->route('categories.index');
    }
}
