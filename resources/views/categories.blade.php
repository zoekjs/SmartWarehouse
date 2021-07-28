@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="/css/responsive.bootstrap4.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-12 offset-s4 mt-5 d-flex flex-row-reverse">
        <button type="button" class="btn btn-primary p-2" data-toggle="modal" data-target="#modal1">Añadir
            Categoría</button>
        <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Añadir Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="categoryForm">
                            @csrf
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="rut_provider">Nombre categoría</label>
                                    <input class="form-control" type="text" name="name" id="name">
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
                        <h4>Modificar Categoría</h4>
                    </div>
                    <div class="modal-body">
                        <form class="col-sm-12" action="" method="post" id="categoryFormEdit">
                            @csrf
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <label for="rut_provider">Nombre</label>
                                    <input class="form-control" type="text" name="name" id="nameEdit">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-field col-sm-12">
                                    <input class="form-control" type="text" name="id_category" id="idEdit" hidden>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" value=" Send" id="sendForm"
                                    class="btn btn-success">Modificar</button>
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

<table id="categories" class="table table-striped table-bordered table-dark dt-bootstrap4" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th class="actions">Acciones</th>
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
<script src="/js/categories/categoriesTable.js"></script>
<script src="/js/dataTables.min.js"></script>
<script src="/js/categories/categories.js"></script>
@endsection