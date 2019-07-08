@extends('layouts.master')
@section('title', 'Reporte de procutos mas comprados')
@section('header-title','Grafico en barras')

@section('header-content')
@endsection

@section('content')


    {!! Charts::assets() !!}
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}



    {!! $chart->html() !!}

@endsection

