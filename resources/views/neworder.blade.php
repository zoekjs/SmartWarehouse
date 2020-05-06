@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card mt-5">
      <div class="card header bg-dark text-light">
        <p>Crear nueva órden de compra</p>
      </div>
      <div class="card-body">
        <form method="post" action="/po">
          <div class="row">
            <div class="col-md-12">
              <!-- ROW SELECCIÓN PROVEEDOR -->
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="proveedor">Proveedor</label>
                  <select class="form-control" name="proveedor" id=""></select>
                </div>
                <div class="form-group col-md-3">
                </div>
                <div class="form-group col-md-6"></div>
              </div>
              <!-- ROW MONEDAS -->
              <div class="row">
                <div class="form-group col-md-1">
                  <label for="moneda">Moneda</label>
                  <select class="form-control" name="moneda" id="moneda"></select>
                </div>
                <div class="form-group col-md-2">
                  <label for="valor-moneda">Valor moneda</label>
                  <input class="form-control" type="text" id="valor-moneda">
                </div>
              </div>
              <!-- ROW OBSERVACIONES -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="paymentObservations">Observaciones relacionadas al pago</label>
                  <textarea class="form-control" name="" id="" style="resize: none;" rows="3"></textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="observations">Otras observaciones</label>
                  <textarea class="form-control" name="" id="" style="resize: none;" rows="3"></textarea>
                </div>
              </div>
            </div>
            <!-- DIV TABLE PRODUCTS -->
            <div class="col-md-12">
              <div class="card">
                <div class="card-header bg-dark">
                  <div class="row">
                    <div class="col-md text-light">Insumos y Servicios</div>
                    <div class="col-md text-right">
                      <button type="button" data-toggle="modal" data-target="#modal_detail" class="btn btn-primary btn-sm">Agregar</button>
                    </div>
                  </div>
                </div>
                <table id='table_details' class="table table-bordered table-condensed table-sm bg-white mb-0">
                  <thead class="bg-secondary">
                    <tr>
                      <th class='text-center'>Material</th>
                      <th class='text-center'>Cantidad</th>
                      <th class='text-center'>Valor Unitario <span id='div_detail_currency'></span></th>
                      <th class='text-center'>Descuento</th>
                      <th class='text-center'>Total</th>
                      <th class='text-center' style="width:5%"><i class='fas fa-edit'></i></th>
                      <th class='text-center' style="width:5%"><i class='fas fa-trash-alt'></i></th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>




@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection