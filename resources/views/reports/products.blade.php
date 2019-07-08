@extends('layouts.master')
@section('title', 'Reporte de procutos mas comprados')
@section('header-title','Grafico en barras')

@section('header-content')
@endsection

@section('content')

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    {!! Charts::assets() !!}
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}
</head>

<body>

<div class="container">


    {!! $chart->html() !!}

</div>

</body>

</html>
@endsection

