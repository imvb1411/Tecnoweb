@extends('layouts.master')
@section('title', 'Reporte de procutos mas comprados')
@section('header-title','Grafico en barras')

@section('header-content')
@endsection

@section('content')

<div class="form-group">
    {!! Charts::assets() !!}
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}

    {!! $chart->html() !!}
</div>
@endsection

