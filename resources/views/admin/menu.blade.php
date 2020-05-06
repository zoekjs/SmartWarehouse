@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="{{asset('css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="row menu">
  <div class="col-md-3 offset-md-1">
    <div class="card mt-5" style="width: 15rem;">
      <img class="card-img-top" src="{{asset('img/adddoc.png')}}" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title mx-auto"></h5>
        <a href="{{route('categorias')}}" class="btn btn-primary d-flex justify-content-center">Gestionar categorías</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card mt-5" style="width: 15rem;">
      <img class="card-img-top menu" src="{{asset('img/proveedores.png')}}" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title mx-auto"></h5>
        <a href="{{route('proveedores')}}" class="btn btn-primary d-flex justify-content-center">Gestionar Proveedores</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card mt-5" style="width: 15rem;">
      <img class="card-img-top" src="{{asset('img/prod.png')}}" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title mx-auto"></h5>
        <a href="{{route('productos')}}" class="btn btn-primary d-flex justify-content-center">Gestionar Productos</a>
      </div>
    </div>
  </div>
</div>




@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection