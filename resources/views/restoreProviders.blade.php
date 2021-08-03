@extends('layout.layout')
@section('components')
    <restore-providers-component :rut-user="{{Auth()->user()->rut_user}}" />
@endsection