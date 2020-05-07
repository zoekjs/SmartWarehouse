@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row mt-5">
  <div class="col-md-12">

  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card mt-5">
      <div class="card header bg-dark text-light">
        <p>Crear nueva órden de compra</p>
      </div>
      <div class="card-body">
        <form method="post" action="{{action('PurchaseOrderController@store')}}">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <!-- ROW SELECCIÓN PROVEEDOR -->
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="rut_provider">Proveedor</label>
                  <select class="form-control" name="rut_provider" id="rut_provider">
                    <option selected>Selecccionar</option>
                    @foreach ($providers as $provider)
                    <option value="{{$provider->rut_provider}}">{{$provider->name}}</option>
                    @endforeach 
                  </select>
                </div>
                <div class="form-group col-md-3">
                </div>
                <div class="form-group col-md-6">
                  <label for="payment_condition">Condición de pago</label>
                  <select class="form-control" name="id_payment" id="">
                    <option selected>Selecccionar</option>
                    @foreach ($payment_methods as $payment_method)
                    <option value="{{$payment_method->id_payment}}">{{$payment_method->name}}</option>
                    @endforeach 
                  </select>
                </div>
              </div>
              <!-- ROW MONEDAS -->
                <div class="row">
                <div class="form-group col-md-3">
                  <label for="money">Moneda</label>
                  <select class="form-control" name="id_money" id="money">
                    @foreach ($moneys as $money)
                    <option value="{{$money->id_money}}">{{$money->name}}</option>
                    @endforeach 
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="valor_moneda">Valor moneda</label>
                  <input class="form-control" type="text" name="valor_moneda" id="valor-moneda">
                </div>
              </div>
              <!-- ROW OBSERVACIONES -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="paymentObservations">Observaciones relacionadas al pago</label>
                  <textarea class="form-control" name="observation" id="" style="resize: none;" rows="3"></textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="observations">Otras observaciones</label>
                  <textarea class="form-control" name="observation_payment" id="" style="resize: none;" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <button class="btn btn-success" type="submit">Ingresar orden</button>
            </div>
          </form>
            <!-- DIV TABLE PRODUCTS -->
            <div class="col-md-12 mt-5">
              <div class="card">
                <div class="card-header bg-dark">
                  <div class="row">
                    <div class="col-md text-light">Órdenes emitidas</div>
                  </div>
                </div>

                  <table id='table_details' class="table table-bordered table-condensed table-sm bg-white">
                    <thead class="">
                      <tr>
                        <th class='text-center' style="width: 10%;">Número de órden</th>
                        <th class='text-center' style="width: 10%;">Fecha</th>
                        <th class='text-center'>Proveedor</th>
                        <th class='text-center' style="width: 10%;">Estado<span id='div_detail_currency'></span></th>
                        <th class='text-center'>Detalle</th>
                        <th class='text-center' style="width:15%">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)   
                        <tr>
                          <td class='text-center'>{{$order->id_purchase_order}}</td>
                          <td class='text-center'>{{date('d-m-Y', strtotime($order->created_at))}}</td>
                          <td class='text-center'>{{$order->provider}}</td>
                          <td class='text-center'>{{$order->status_name}}</td>
                          @if ($order->status_name == "Borrador")
                            <td class='text-center' style="width: 15%;"><a href="{{route('detalles', ['id_purchase_order' => $order->id_purchase_order])}}"
                            class="btn-sm btn-warning">Añadir productos</a></td>
                          @else
                            <td class='text-center' style="width: 15%;"><a class="btn-sm btn-secondary">Añadir productos</a></td>
                          @endif
                          @if ($order->status_name == "Por aprobar")
                            <td class='text-center' style="width: 15%;"><a href="{{route('ver-orden', ['id_purchase_order' => $order->id_purchase_order])}}"
                            class="btn-sm btn-success">Ver</a></td>
                          @endif
                          @if ($order->status_name == "Aprobada")
                          <td class='text-center' style="width: 15%;"><a href="{{route('ver-orden', ['id_purchase_order' => $order->id_purchase_order])}}"
                          class="btn-sm btn-success">Ver</a></td>
                          @endif
                          @if ($order->status_name == "Rechazada")
                          <td class='text-center' style="width: 15%;"><a href="{{route('ver-orden', ['id_purchase_order' => $order->id_purchase_order])}}"
                          class="btn-sm btn-success">Ver</a></td>
                        @endif
                        </tr>                 
                      @endforeach
                    </tbody>
                  </table>
                  <p>
                    <span>{{ $orders->total() }}</span> registros |
                    página {{ $orders->currentPage() }}
                    de {{ $orders->lastPage() }}
                  </p>
                  {!! $orders->render() !!}
                <div class="row">

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
  <div id="modal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4>Añadir producto</h4>
              </div>
              <div class="modal-body">
                  <form class="col-sm-12" action="" method="post" id="addForm">
                      @csrf
                      <div class="form-group">
                        <div class="input-field col-sm-12">
                            <label for="product">Producto</label>
                            <select class="custom-select" id="product">
                              <option selected>Selecccionar</option>
                                
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection