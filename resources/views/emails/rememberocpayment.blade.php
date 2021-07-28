<!DOCTYPE html>
<html lang="en" style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">
<head style="box-sizing: border-box;">
    <meta charset="UTF-8" style="box-sizing: border-box;">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" style="box-sizing: border-box;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" style="box-sizing: border-box;">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" style="box-sizing: border-box;">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" style="box-sizing: border-box;">
    <link rel="stylesheet" href="/css/main.css" style="box-sizing: border-box;">
    <title style="box-sizing: border-box;">Recordatorio de pago</title>
</head>
<body style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #fff;min-width: 992px!important;">
    <div class="container" style="box-sizing: border-box;width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;min-width: 992px!important;">
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <h4 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.5rem;">Estimado Usuario</h4>
            <br style="box-sizing: border-box;">
            <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;">Le recordamos que mantiene las siguientes ordenes de compra impagas</p>
        </div>
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <table class="table table-bordered table-condensed table-sm bg-white" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;border: 1px solid #dee2e6;background-color: #fff!important;">
                <thead style="box-sizing: border-box;display: table-header-group;">
                    <tr style="box-sizing: border-box;page-break-inside: avoid;">
                        <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important; width: 10%;">Orden N°</th>
                        <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">Estado</th>
                        <th style="box-sizing: border-box;text-align: inherit;padding: .3rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">Fecha de emisión</th>
                    </tr>
                </thead>
                <tbody style="box-sizing: border-box;">
                    @foreach ($orders as $order)
                    <tr style="box-sizing: border-box;page-break-inside: avoid;">
                        <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">{{$order->id_purchase_order}}</td>
                        <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">{{$order->status}}</td>
                        <td style="box-sizing: border-box;padding: .3rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">{{date('d-m-Y', strtotime($order->created_at))}}</td>
                    </tr>
                    @endforeach
                        

                </tbody>
            </table>
        </div>
    </div>
</body>
</html>