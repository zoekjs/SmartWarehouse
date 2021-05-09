@extends('layout.layout')
@section('components')
    <products-component :rut-user="{{Auth()->user()->rut_user}}"></products-component>
@endsection
