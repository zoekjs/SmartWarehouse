@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-12 offset-s4 mt-5 d-flex flex-row-reverse">
        <button type="button" class="btn btn-primary p-2" data-toggle="modal" data-target="#modal1">Añadir
            producto</button>
        <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Añadir producto</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="productForm">
                            @csrf
                            <input type="text" hidden name="rut_user" value="{{Auth()->user()->rut_user}}">
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="id_product">Código de producto</label>
                                    <input class="form-control" type="text" name="id_product" id="id_product">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Nombre producto</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="description">Descripción</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-sm-6">
                                    <label for="quantity">Cantidad</label>
                                    <input class="form-control" type="text" name="quantity" id="quantity">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="unit_price">Precio Unitario</label>
                                    <input class="form-control" type="text" name="unit_price" id="unit_price">
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
                        <h4>Modificar producto</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="productFormEdit">
                            @csrf
                            <input type="text" hidden name="rut_user" value="{{Auth()->user()->rut_user}}">
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="id_product">Código de producto</label>
                                    <input class="form-control" type="text" name="id_product" id="id_product" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="name">Nombre producto</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="description">Descripción</label>
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-sm-6">
                                    <label for="quantity">Cantidad</label>
                                    <input class="form-control" type="text" name="quantity" id="quantity">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="unit_price">Precio Unitario</label>
                                    <input class="form-control" type="text" name="unit_price" id="unit_price">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" value=" Send" id="sendForm"
                                    class="btn btn-success">Modificar</button>
                                <button type="button" id="formEditClear" data-dismiss="modal"
                                    class="btn btn-danger">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12 col-xl-12 col-lg-12">
    <table id="products" class="table table-dark">
        <thead>
            <tr>
                <th>Código producto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        <tbody>
            <td>hola</td>
        </tbody>
        </thead>
    </table>
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/productTable.js')}}"></script>
<script src="{{ asset('js/dataTables.min.js')}}"></script>
<script src="{{asset('js/products.js')}}"></script>
@endsection