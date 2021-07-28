@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="/css/responsive.bootstrap4.min.css">
@endsection
@section('content')
<div class="row">
    <div class="card mt-5" style="width: 18rem;">
        <img class="card-img-top" src="/img/adddoc.png" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title mx-auto"></h5>
          <a href="{{route('nueva-orden')}}" class="btn btn-primary d-flex justify-content-center">Nueva órden de compra</a>
        </div>
    </div>
</div>




@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@endsection