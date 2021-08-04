@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="/css/responsive.bootstrap4.min.css">
@endsection
@section('content')
  <div class="col-md-12">
    <div class="card">
      <div class="card header bg-dark text-light">
        <p>Crear nueva órden de compra</p>
      </div>
      <div class="card-body">
        <form method="post" action="">
          <div class="row">
            <div class="col-md-12">
              <!-- ROW SELECCIÓN PROVEEDOR -->
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="proveedor">Proveedor</label>
                  <select class="form-control" name="proveedor" id="">
                    <option selected>Seleccionar</option>
                    @foreach ($providers as $provider)
                    <option value="{{$provider->rut_provider}}">{{$provider->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-3">
                </div>
                <div class="form-group col-md-6"></div>
              </div>
              <!-- ROW MONEDAS -->
             <!-- <div class="row">
                <div class="form-group col-md-1">
                  <label for="moneda">Moneda</label>
                  <select class="form-control" name="moneda" id="moneda"></select>
                </div>
                <div class="form-group col-md-2">
                  <label for="valor-moneda">Valor moneda</label>
                  <input class="form-control" type="text" id="valor-moneda">
                </div>
              </div>-->
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
                      <button type="button" data-toggle="modal" data-target="#modal1" class="btn btn-primary btn-sm">Agregar</button>
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
                      <th class='text-center' style="width:15%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-success" type="submit">Ingresar orden</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
<!-- MODAL AÑADIR PRODUCTOS OC -->
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
                      <div class="form-group">
                        <div class="input-field col-sm-12">
                            <label for="product">Producto</label>
                            <select class="custom-select" id="product">
                              <option selected>Seleccionar</option>
                              @foreach ($products as $product)
                              <option value="{{$product->id_product}}">{{$product->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                                <label for="name">Cantidad</label>
                                <input class="form-control" type="text" name="name" id="quantity">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label for="name">Precio</label>
                              <input class="form-control" type="text" name="name" id="value">
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                              <label for="name">Descuento</label>
                              <input class="form-control" type="text" name="name" id="value">
                          </div>
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



@endsection

@section('scripts')
<script src="/js/PO/productData.js"></script>
@endsection
