@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="css/responsive.bootstrap4.min.css"">
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
        <p>Nuevo ingress de productos</p>
      </div>
      <div class="card-body">
        <form method="post" action="{{action('IngressController@store')}}">
          @csrf
          <input type="text" hidden name="rut_user" value="{{Auth()->user()->rut_user}}">
          <div class="row">
            <div class="col-md-12">
              <!-- ROW SELECCIÓN PROVEEDOR -->
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="rut_provider">Proveedor</label>
                  <select class="form-control" name="rut_provider" id="rut_provider" required>
                    <option selected>Selecccionar</option>
                    @foreach ($providers as $provider)
                    <option value="{{$provider->rut_provider}}">{{$provider->name}}</option>
                    @endforeach 
                  </select>
                </div>
                <div class="form-group col-md-3">
                </div>
                <div class="form-group col-md-6">
                  <label for="payment_condition">Tipo documento</label>
                  <select class="form-control" name="id_type_document" id="" required>
                    <option selected>Selecccionar</option>
                    @foreach ($doctypes as $doctype)
                    <option value="{{$doctype->id_type_document}}">{{$doctype->name}}</option>
                    @endforeach 
                  </select>
                </div>
              </div>
              <!-- ROW NUMERO DOCUMENTO -->
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="docNumber">Número de documento</label>
                        <input type="text" name="document_number" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="paymentObservations">Observaciones</label>
                        <textarea class="form-control" name="observation" required id="" style="resize: none;" rows="3"></textarea>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
              <button class="btn btn-success" type="submit">Registrar ingress</button>
            </div>
          </form>
            <!-- DIV TABLE PRODUCTS -->
            <div class="col-md-12 mt-5">
              <div class="card">
                <div class="card-header bg-dark">
                  <div class="row">
                    <div class="col-md text-light">ingresos recientes</div>
                  </div>
                </div>

                  <table id='table_details' class="table table-bordered table-condensed table-sm bg-white">
                    <thead class="">
                      <tr>
                        <th class='text-center' style="width: 10%;">Número de ingress</th>
                        <th class='text-center' style="width: 10%;">Fecha</th>
                        <th class='text-center'>Proveedor</th>
                        <th class='text-center' style="width: 10%;">Estado<span id='div_detail_currency'></span></th>
                        <th class='text-center'>Detalle</th>
                        <th class='text-center' style="width:15%">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($allIngresses as $ingress)   
                        <tr>
                          <td class='text-center'>{{$ingress->id_ingress}}</td>
                          <td class='text-center'>{{date('d-m-Y', strtotime($ingress->created_at))}}</td>
                          <td class='text-center'>{{$ingress->provider_name}}</td>
                          <td class='text-center'>{{$ingress->status_name}}</td>
                          @if ($ingress->status_name == "Borrador")
                            <td class='text-center' style="width: 15%;"><a href="{{route('ingress-details', ['id_ingress' => $ingress->id_ingress])}}"
                            class="btn-sm btn-warning">Añadir productos</a></td>
                          @else
                            <td class='text-center' style="width: 15%;"><a class="btn-sm btn-secondary">Añadir productos</a></td>
                          @endif
                          @if ($ingress->status_name == "Aprobada")
                          <td class='text-center' style="width: 15%;"><a href=""
                          class="btn-sm btn-success">Ver</a> <a href=""
                            class="btn-sm btn-success">Descargar</a></td>
                          @endif

                        </tr>                 
                      @endforeach
                    </tbody>
                  </table>
                  <p>
                    <span>{{ $allIngresses->total() }}</span> registros |
                    página {{ $allIngresses->currentPage() }}
                    de {{ $allIngresses->lastPage() }}
                  </p>
                  {!! $allIngresses->render() !!}
                <div class="row">

                </div>
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



@section('content')
    <div class="row">
        <form action="">
            <div class="form-group">
                <label for="">Provider</label>
                <select name="docTipe" id="">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Tipo documento</label>
                <select name="docTipe" id="">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label for="docNumber">Número de documento</label>
                <input type="text" name="docNumber" class="form-control">
            </div>
            <div class="form-group">
                <label for="observation">Observación</label>
                <textarea name="observation" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn-success">Guardar</button>
            </div>
        </form>
    </div>
@endsection