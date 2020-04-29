@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row">
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
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="rut_provider">Rut proveedor</label>
                                    <input class="form-control" type="text" name="rut_provider" id="rut_provider">
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
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Teléfono</label>
                                    <input class="form-control" type="text" name="telephone" id="telephone">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="quantity">Dirección</label>
                                    <input class="form-control" type="text" name="address" id="address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm-12">
                                    <label for="unit_price">Correo de contacto</label>
                                    <input class="form-control" type="text" name="email" id="email">
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
    </div>
    <div class="col-sm-12 col-xl-12 offset-s4 mt-5 d-flex flex-row-reverse">
        <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Modificar Proveedor</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="providerFormEdit">
                            @csrf
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="rut_provider">Rut proveedor</label>
                                    <input class="form-control" type="text" name="rut_provider" id="rut_provider">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="id_country">País</label>
                                    <select class="custom-select" id="id_country">
                                        <option selected id="id_select">Selecccionar</option>
                                        @foreach ($countrys as $country)
                                        <option value="{{$country->id_country}}">{{$country->name}}</option>
                                        @endforeach    
                                    </select>
                                </div>
                              </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Nombre proveedor</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Teléfono</label>
                                    <input class="form-control" type="text" name="telephone" id="telephone">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="quantity">Dirección</label>
                                    <input class="form-control" type="text" name="address" id="address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm-12">
                                    <label for="unit_price">Correo de contacto</label>
                                    <input class="form-control" type="text" name="email" id="email">
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
    </div>
</div>

<table id="providers" class="table table-striped table-bordered table-dark dt-bootstrap4" style="width:100%">
    <thead>
        <tr>
            <th>Rut proveedor</th>
            <th>Nombre</th>
            <th>País</th>
            <th>telefono</th>
            <th>dirección</th>
            <th>Contacto</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        </tr>
    </tbody>
</table>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/providers/providerTable.js')}}"></script>
<script src="{{ asset('js/dataTables.min.js')}}"></script>
<script src="{{asset('js/providers/providers.js')}}"></script>
@endsection