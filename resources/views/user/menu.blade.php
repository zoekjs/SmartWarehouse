@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="css/responsive.bootstrap4.min.css"">
@endsection
@section('content')
<div class="row menu">
  <div class="col-md-3 offset-md-3">
    <div class="card mt-5" style="width: 15rem;">
      <img class="card-img-top" src="img/prod.png'" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title mx-auto"></h5>
        <a href="{{route('productos')}}" class="btn btn-primary d-flex justify-content-center">Gestionar Productos</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card mt-5" style="width: 15rem;">
      <img class="card-img-top" src="img/adddoc.png" alt="Card image cap">
      <div class="card-body">
        <h5 class="card-title mx-auto"></h5>
        <a href="{{route('nueva-orden')}}" class="btn btn-primary d-flex justify-content-center">Nueva órden de compra</a>
      </div>
  </div>
  </div>
</div>




@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection