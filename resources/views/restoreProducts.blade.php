@extends('layout.layout')
@section('components')
    <restore-products-component :rut-user="{{Auth()->user()->rut_user}}" />
@endsection