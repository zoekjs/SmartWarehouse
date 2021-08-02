@extends('layout.layout')
@section('components')
    <tags-component :rut-user="{{Auth()->user()->rut_user}}"></tags-component>
@endsection
