@extends('adminlte::page')

@section('title', 'Employees edit')

@section('content')
    {!! dd($employees ?? null) !!}
@stop