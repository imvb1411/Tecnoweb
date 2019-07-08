@extends('layouts.master')
@section('title', 'Reporte de Cliente mas frecuente')
@section('header-title','Grafico en barras')

@section('header-content')
@endsection

@section('content')
<div>
    @foreach($nombre as $n)
    <td>El cliente mas frecuente para la veterinaria es: {{$n}}</td>
    @endforeach
</div>
<div >
{!! Charts::assets() !!}
{!! Charts::scripts() !!}
{!! $chart->script() !!}
{!! $chart->html() !!}
</div>
@endsection

