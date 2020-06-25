@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row d-flex justify-content-center mt-5">
    <h4>Auditoría</h4>
</div>
<div class="row mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 12%">Rut</th>
                <th>Nombre</th>
                <th>Acción</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
            <tr>
                <td>{{$log->rut_user}}</td>
                <td>{{$log->name.' '.$log->last_name}}</td>
                <td>{{$log->action}}</td>
                <td>{{date('d-m-Y', strtotime($log->created_at))}}</td>
                <td>{{date('H:i A', strtotime($log->created_at))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        <span>{{ $logs->total() }}</span> registros |
        página {{ $logs->currentPage() }}
        de {{ $logs->lastPage() }}
        &nbsp &nbsp
    </p>
    {!! $logs->render() !!}
</div>


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection