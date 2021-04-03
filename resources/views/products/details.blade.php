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
      <div class="card header bg-dark text-light d-flex">
        <div class="row">
          <p class="ml-4">Agregar productos</p>
          <div class="col-md 3 d-flex justify-content-end mr-4">
            <form action="{{action('PurchaseOrderDetailController@update')}}" method="post">
              @csrf
              <input type="text" hidden name="rut_user" id="rut_user" value="{{Auth()->user()->rut_user}}">
              <button type="submit" value=" Send" id="sendForm"
              class="btn btn-info">Emitir OC</button>
              <input class="form-control" type="text" name="id_purchase_order" id="" hidden value="{{$id_purchase_order}}">
            </form>
          </div>
        </div>
      </div>
      <div class="card-body">
        <form method="post" id="podForm" action="{{action('PurchaseOrderDetailController@store')}}">
          @csrf
          <input type="text" hidden name="rut_user" id="rut_user" value="{{Auth()->user()->rut_user}}">
          <div class="row">
            <div class="col-md-12">
              <!-- ROW SELECCIÓN PROVEEDOR -->
              <div class="row">
              <input class="form-control" type="text" name="id_purchase_order" id="" hidden value="{{$id_purchase_order}}">
                <div class="form-group col-md-12">
                  <div class="form-group">
                    <div class="input-field col-sm-12">
                        <label for="id_product">Producto</label>
                        <select class="custom-select" name="id_product" id="id_product" onchange="getPrice();">
                          <option selected>Selecccionar</option>
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
                            <input class="form-control" type="text" name="quantity" id="quantity">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label for="name">Precio</label>
                          <input class="form-control" type="text" name="unit_price" id="price" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" value=" Send" id="sendForm"
                          class="btn btn-success">Agregar</button>           
                      <a href="{{route('nueva-orden')}}" class="btn btn-danger">Cancelar</a>
                  </div>
          </form>
            <!-- DIV TABLE PRODUCTS -->
            <div class="col-md-12 mt-5">
              <div class="card">
                <div class="card-header bg-dark">
                  <div class="row">
                    <div class="col-md text-light">Productos a ingresar</div>
                  </div>
                </div>
                 <table id='table_details' class="table table-bordered table-condensed table-sm bg-white">
                    <thead class="">
                      <tr>
                        <th class='text-center' style="width: 10%;">Código</th>
                        <th class='text-center' >Nombre</th>
                        <th class='text-center' style="width: 10%;">Cantidad</th>
                        <th class='text-center' style="width: 10%;">Precio unitario<span id='div_detail_currency'></span></th>
                        <th class='text-center'>Subtotal</th>
                        <th class='text-center' style="width:15%">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($details as $detail)
                        <tr>
                          <td class='text-center' hidden>{{$detail->id_product_purchase_order}}</td>
                          <td class='text-center'>{{$detail->id_product}}</td>
                          <td class='text-center'>{{$detail->name}}</td>
                          <td class='text-center'>{{$detail->quantity}}</td>
                          <td class='text-center'>{{number_format($detail->unit_price, 0, ",", ".")}}</td>
                          <td class='text-center'>{{number_format($detail->total, 0, ",", ".")}}</td>
                          <td class='text-center'><button class="btn btn-danger delete">quitar</button></td>        
                      @endforeach
                    </tbody>
                  </table>
                  <p>
                    <span>{{ $details->total() }}</span> registros |
                    página {{ $details->currentPage() }}
                    de {{ $details->lastPage() }}
                  </p>
                  {!! $details->render() !!}
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
  <script src="{{asset('js/PO/pod.js')}}"></script>
@endsection