@extends('layout.layout')
@section('components')
    <providers-component />
@endsection
@section('content')
<!--<div class="row">
    <div class="col-sm-12 col-xl-12 offset-s4 mt-5 d-flex flex-row-reverse">
        <button type="button" class="btn btn-primary p-2" data-toggle="modal" data-target="#modal1">Añadir
            proveedor</button>
        <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Añadir Proveedor</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="providerForm">
                            @csrf
                            <input type="text" hidden name="rut_user" value="{{Auth()->user()->rut_user}}">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="input-field">
                                        <label for="rut_provider">Rut proveedor</label>
                                        <input class="form-control" type="text" name="rut_provider" id="rut_provider" maxlength="8">
                                    </div>
                                </div>
                                <div class="form-group col-sm-2">
                                    <div class="input-field ">
                                        <label for="rut_provider">Dv</label>
                                        <input class="form-control" type="text" name="dv" id="dv" maxlength="1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="id_pais">País</label>
                                    <select class="custom-select" id="id_pais">
                                        <option selected>Selecccionar</option>
                                        @foreach ($countrys as $country)
                                        <option value="{{$country->id_country}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Nombre proveedor</label>
                                    <input class="form-control" type="text" name="name" id="name" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Teléfono</label>
                                    <input class="form-control" type="text" name="telephone" id="telephone" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="quantity">Dirección</label>
                                    <input class="form-control" type="text" name="address" id="address" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm-12">
                                    <label for="unit_price">Correo de contacto</label>
                                    <input class="form-control" type="text" name="email" id="email" maxlength="25">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" value=" Send" id="sendForm"
                                    class="btn btn-success">Agregar</button>
                                <button type="button" id="formClear" data-dismiss="modal"
                                    class="btn btn-danger">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
@endsection
