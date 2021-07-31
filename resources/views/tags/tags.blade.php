@extends('layout.layout')
@section('css')
<link rel="stylesheet" href="/css/responsive.bootstrap4.min.css">
@endsection
@section('content')

<table id='table_details' class="table table-bordered table-condensed table-sm bg-dark">
    <thead class="">
        <tr>
        <th class='text-center' style="width: 10%;">ID Tag</th>
        <th class='text-center' style="width: 10%;">ID Product</th>
        <th class='text-center' style="width: 10%;">Enable</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tags as $tag)
        <tr>
            <td class='text-center'>{{$tag->id_tag}}</td>
            <td class='text-center'>{{$tag->id_product}}</td>
            <td class='text-center'>{{$tag->enable}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>

@endsection
@section('scripts')

@endsection