@extends('layout.layout')
@section('components')
    <purchaseorderpayment-component :rut-user="{{Auth()->user()->rut_user}}"/>
@endsection
@section('content')
<div class="row mt-3">
    {{-- <div class="col-sm-12 col-xl-12 offset-s4 mt-3 mb-4 d-flex flex-row-reverse">
        <a href="{{route('oc-pagadas')}}" class="btn btn-primary">Ver OC pagadas</a>
    </div> --}}
    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 12%">Orden número</th>
                <th>Proveedor</th>
                <th>Monto</th>
                <th>Estado de pago</th>
                <th colspan="2" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{$order->id_purchase_order}}</td>
                <td>{{$order->provider}}</td>
                <td>${{number_format($order->total, 0, ',', '.')}}</td>
                <td>{{$order->status}}</td>
                @if ($order->status_name == "Aprobada")
                   <td class='text-center' style="width: 8%;"><a href="{{route('descargar-orden', ['id_purchase_order' => $order->id_purchase_order])}}"
                   class="btn-sm btn-info orders">Ver</a></td>
                   <td style="width: 8%;">
                   <form action="{{route('update-payment')}}" method="post" class="d-flex justify-content-center">
                       @csrf
                       <input type="text" hidden name="rut_user" id="rut_user" value="{{Auth()->user()->rut_user}}">
                       <input type="text" hidden name="id_purchase_order" id="rut_user" value="{{$order->id_purchase_order}}">
                       <button class="btn btn-success btn-sm">Pagar</button>
                   </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        <span>{{ $orders->total() }}</span> registros |
        página {{ $orders->currentPage() }}
        de {{ $orders->lastPage() }}
        &nbsp &nbsp
    </p>
    {!! $orders->render() !!} --}}
</div>


@endsection