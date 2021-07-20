<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="order">
        <div class="row mt-0 mb-0">
            <div class="col-md-6">
                <img src="img/Logo.jpg" alt="" srcset="" style="width: 35%;">
            </div>
            <div class="col-md-6">
                <p class="text-right mb-0">Grafisoft Chile Ltda.</p>
                <p class="text-right mb-0">Avenida Quilín 2640 B</p>
                <p class="text-right mb-0">Macul Santiago - Chile</p>
                <p class="text-right mb-0">Rut 73.202.350-4</p>
            </div>
        </div>
        <div class="row mt-0 mb-1">
            <div class="row">

            </div>
            <div class="col-md-2">
                    <div class="col-md-3">
                        <p>Order to:</p>
                    </div>
                    <div class="col-md-3">
                        @foreach ($orderData as $order)
                        <p class="text-left mb-0">{{$order->provider_name}}</p>
                        <p class="text-left mb-0">{{$order->rut_provider}}</p>
                        <p class="text-left mb-0">{{$order->address}}</p>
                        <p class="text-left mb-0">{{$order->telephone}}</p>
                        @endforeach
                    </div>
                </div>
            <div class="col-md-2">
                    <div class="col-md-4">
                        @foreach ($orderData as $order)
                        <p class="mb-0 mr-0 text-right">Order N°: {{$order->id_purchase_order}}</p>
                        <p class="mb-0 mr-0 text-right">Date: {{date('d-m-Y', strtotime($order->created_at))}}</p>
                        @endforeach

                    </div>
                    <!--<div class="col-md-6">
                        @foreach ($orderData as $order)
                        <p class="text-center mb-0" style="border-style: solid; border: 1px solid black;">{{$order->id_purchase_order}}</p>
                        <p class="text-right mb-0">{{date('d-m-Y', strtotime($order->created_at))}}</p>
                        @endforeach
                    </div>-->
                </div>
        </div>
        <div class="row mt-0">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">CODE</th>
                        <th scope="col">DESCRIPTION</th>
                        <th scope="col">QTY.</th>
                        <th scope="col">UNIT PRICE</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                    <tr>
                        <th>{{$detail->id_product}}</th>
                        <th>{{$detail->name}}</th>
                        <th>{{$detail->quantity}}</th>
                        <th>{{$detail->unit_price}}</th>
                        <th>{{number_format($detail->total, 0, ",", ".")}}</th>
                    </tr>
                    @endforeach
                    <!--<tr>
                        <th class="text-right" colspan="4">SUBTOTAL</th>
                        <th>470.4</th>
                    </tr>-->
                    <tr>
                        <th class="text-right" colspan="4">TOTAL</th>
                        @foreach ($orderData as $order)
                        <th>{{number_format($order->total, 0, ",", ".")}}</th>
                        @endforeach

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"scope="col" class="text-center">BILL TO ADRESS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>NOMBRE:</th>
                        <th>Grafisoft Chile Ltda.</th>
                    </tr>
                    <tr>
                       <th style="width: 10%;">RUT:</th>
                       <th>76.202.350-4</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">DIRECCIÓN:</th>
                        <th>Avenida Quilin 2640 B, Macul. Santiago, Chile</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">TELEFONO:</th>
                        <th>+56 22 7526051</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">CONTACT:</th>
                        <th>Matías Fernández</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">MAIL CONTACT:</th>
                        <th>matias@grafisoft.cl</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--<div class="row mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"scope="col" class="text-center">FINAL USER OF LICENCE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderData as $order)
                    <tr>
                        <th>NOMBRE:</th>
                        <th>{{$order->provider_name}}</th>
                    </tr>
                    <tr>
                       <th style="width: 10%;">RUT:</th>
                       <th>{{$order->rut_provider}}</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">DIRECCIÓN:</th>
                        <th>{{$order->address}}</th>
                    </tr>
                    <tr>
                        <th style="width: 10%;">TELEFONO:</th>
                        <th>{{$order->telephone}}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>-->
        <div class="row mt-2 mb-0">
            <div class="col-md-4">
                <p class="text-left">Email: Ordenes@grafisoft.cl</p>
            </div>
            <div class="col-md-4">
                <p class="text-center">WWW.GRAFISOFT.CL</p>
            </div>
            <div class="col-md-4">
                <P class="text-right">Tel. +56227526051</P>
            </div>
        </div>
</body>
</html>
