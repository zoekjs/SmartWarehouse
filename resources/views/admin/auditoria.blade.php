@extends('layout.layout')
@section('components')
    <audit-component :rut-user="{{Auth()->user()->rut_user}}" />
@endsection
