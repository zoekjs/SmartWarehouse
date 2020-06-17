@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row mt-3">
  <div class="col-md-8 mx-auto">
    <div class="card mt-2 py-2 px-2">
      <div class="row">
        <div class="col-md">
        <a href="{{route('nueva-orden')}}" class="btn btn-info">volver</a>
        </div>
        @if (auth()->user()->hasRoles(['Administrador']))
        <div class="col-md-2">
          @foreach ($orderData as $order)
          @if ($order->id_status != 3 and $order->id_status != 4)
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalRefuse">Rechazar</button>
          @endif
          @endforeach
          <div id="modalRefuse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Rechazar orden</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{action('PurchaseOrderController@update')}}" method="post">
                        @csrf
                        <input type="text" hidden name="rut_user" id="rut_user" value="{{Auth()->user()->rut_user}}">                        <div class="form-group">
                          <label for="reason">Motivo de rechazo: </label>
                          <textarea class="form-control" name="reason" id="" rows="2" style="resize: none;" required></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                          <button class="btn btn-danger">Rechazar orden</button>
                        </div>
                        @foreach($orderData as $order)
                        <input type="text" name="id_purchase_order" id="" value='{{$order->id_purchase_order}}' hidden readonly>
                        @endforeach
                        <input type="text" name="neto" id="" value='{{$neto}}' hidden readonly>
                        <input type="text" name="iva" id="" value='{{$iva}}' hidden readonly>
                        <input type="text" name="total" id="" value='{{$total}}' hidden readonly>
                        <input type="text" name="estado" id="" value='rechazada' hidden readonly>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-3">
          @foreach ($orderData as $order)
          @if ($order->id_status != 3 and $order->id_status != 4)
          <button class="btn btn-success" data-toggle="modal" data-target="#modalApproved">Aprobar</button>
          @endif
          @endforeach
          <div id="modalApproved" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Aprobar orden</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{action('PurchaseOrderController@update')}}" method="post">
                        @csrf
                        <input type="text" hidden name="rut_user" id="rut_user" value="{{Auth()->user()->rut_user}}">
                        <div class="form-group">
                          <label for="reason">Comentarios de aprobación: </label>
                          <textarea class="form-control" name="reason" id="" rows="2" style="resize: none;" required></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                          <button class="btn btn-success">Aprobar orden</button>
                        </div>
                        @foreach($orderData as $order)
                        <input type="text" name="id_purchase_order" id="" value='{{$order->id_purchase_order}}' hidden readonly>
                        @endforeach
                        <input type="text" name="neto" id="" value='{{$neto}}' hidden readonly>
                        <input type="text" name="iva" id="" value='{{$iva}}' hidden readonly>
                        <input type="text" name="total" id="" value='{{$total}}' hidden readonly>
                        <input type="text" name="estado" id="" value='aprobada' hidden readonly>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-md-8 mx-auto">
    <div class="card">
      @foreach ($orderData as $order)
      <h3>Orden de compra N° {{$order->id_purchase_order}}</h3>
      <h4>
        <label for="Estado:">Estado:</label>
        {{$order->status_name}}
      </h4>
      @if ($order->reason != null and $order->reason != "")
      @if ($order->id_status == 3)
      <h5 class="alert alert-success col-md">
        <label for="reason">Razón: </label>
        {{$order->reason}}
      </h5>
      @endif
      @if ($order->id_status == 4)
      <h5 class="alert alert-danger col-md">
        <label for="reason">Razón: </label>
        {{$order->reason}}
      </h5>
      @endif
      @endif
      <table class="table table-striped table-sm">
        <tbody>
          <tr>
            <th><label for="Proveedor">Proveedor</label></th>
            <td>{{Str::upper($order->provider_name)}}</td>
          </tr>
          <tr>
            <th><label for="RUT">RUT</label></th>
            <td>{{$order->rut_provider}}</td>
          </tr>
          <tr>
            <th><label for="Dirección">Dirección</label></th>
            <td>{{Str::upper($order->address)}}</td>
          </tr>
          <tr>
            <th><label for="Contacto">Contacto</label></th>
            <td>{{Str::upper($order->email)}}</td>
          </tr>
          <tr>
            <th><label for="Fono">Fono</label></th>
            <td>{{$order->telephone}}</td>
          </tr>
        </tbody>
      </table>
      @endforeach
    </div>
  </div>
</div>
<div class="row mt-3">
  <div class="col-md-8 mx-auto">
    <div class="card">
      <table class="table table-striped table-sm">
        <tbody>
          <tr>
            <th><label for="Producto">Producto</label></th>
            <th class="text-right"><label for="Cantidad">Cantidad</label></th>
            <th class="text-right"><label for="Precio Unitario">Precio unitario</label></th>
            <th class="text-right"><label for="Valor total">Valor Total</label></th>
          </tr>
          @foreach ($details as $detail)
          <tr>
            <td>{{$detail->name}}</td>
            <td class="text-right">{{$detail->quantity}}</td>
            <td class="text-right">{{number_format($detail->unit_price, 0, ',', '.')}}</td>
            <td class="text-right">{{number_format($detail->total,0, ',', '.')}}</td>
          </tr>
          @endforeach
          <tr>                 
            <th colspan="3"class="text-right" >NETO</th>
          <td class="text-right" style="width: 15%">{{number_format($neto,0, ',', '.')}}</td>          
          </tr>
          <tr>                 
            <th colspan="3" class="text-right" >IVA</th>
            <td class="text-right" style="width: 15%">{{number_format($iva,0, ',', '.')}}</td>          
          </tr>
          <tr>                 
            <th colspan="3" class="text-right" >TOTAL</th>
            <td class="text-right" style="width: 15%">{{number_format($total,0, ',', '.')}}</td>          
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="row mt-3 mb-5">
  <div class="col-md-8 mx-auto">
    <div class="card">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($orderData as $order)
          <tr>
            <th>Condición de pago</th>
            <td>{{Str::upper($order->method)}}</td>
          </tr>
          <tr>
            <th>Observaciones condición de pago</th>
            <td>{{Str::upper($order->observation_payment)}}</td>
          </tr>
          <tr>
            <th>Otras observaciones</th>
            <td>{{Str::upper($order->observation)}}</td>
          </tr>
          <tr>
            <th>Creado por</th>
            <td>{{Str::upper($order->name.' '.$order->last_name)}}</td>
          </tr>
          <tr>
            <th>Fecha</th>
            <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection