<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Order - {{ $deliveryOrder->delivery_number }}</title>

    <style type="text/css">
        @page {
            margin: 25px;
        }

        body {
            margin: 25px;
        }

        * {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .table {
            border: 1px solid #333;
            border-collapse: collapse;
            margin: 0 auto 10px;
            width: 740px;
            font-size: 12px;
        }

        .table td, .table tr, .table th {
            padding: 12px;
            border: 1px solid #333;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .table-sm td, .table-sm tr, .table-sm th {
            padding: 5px;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>

</head>
<body>

<table width="100%" style="margin-bottom: 10px">
    <tr>
        <td align="left" style="width: 50%;">
            <h3 style="font-weight: normal">{{ app_setting('app-name', config('app.name')) }}</h3>
            <p style="color: #777777; font-size: 12px; font-weight: normal">{{ app_setting('app-tagline') }}</p>
        </td>
        <td align="right" style="width: 50%;">
            <h3>Delivery Order</h3>
            <p style="color: #777777; font-size: 12px; font-weight: normal">Print Date: {{ date('d F Y') }}</p>
        </td>
    </tr>
</table>

<hr style="border: none; border-top: 1px solid #ccc; margin-bottom: 10px">

<table style="margin-bottom: 10px; font-size: 13px" width="100%">
    <tr>
        <td style="width: 150px">Delivery Order</td>
        <td>{{ $deliveryOrder->type }}</td>
    </tr>
    <tr>
        <td>Reference Number</td>
        <td>{{ $deliveryOrder->booking->reference_number }} - {{ $deliveryOrder->booking->booking_number }}</td>
    </tr>
</table>

<table class="table">
    <tr>
        <th colspan="2">
            <p style="font-weight: bold">Delivery Number</p>
            <p style="color: #444444">{{ $deliveryOrder->delivery_number }}</p>
        </th>
        <th>
            <p style="font-weight: bold">Customer</p>
            <p style="color: #444444">{{ $deliveryOrder->booking->customer->customer_name }}</p>
        </th>
        <th>
            <p style="font-weight: bold">Delivery Date</p>
            <p style="color: #444444">{{ $deliveryOrder->delivery_date->format('d F Y') }}</p>
        </th>
        <td rowspan="2" class="text-center" style="width: 120px">
            <img style="margin: 0;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate($deliveryOrder->delivery_number)) !!} " alt="{{ $deliveryOrder->delivery_number }}">
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-weight: bold">Driver</p>
            <p style="color: #444444">{{ $deliveryOrder->driver_name }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Vehicle</p>
            <p style="color: #444444">{{ $deliveryOrder->vehicle_name }} {{ $deliveryOrder->vehicle_type }}</p>
            <p style="color: #444444">{{ $deliveryOrder->vehicle_plat_number }}</p>
        </td>
        <td colspan="2">
            <p style="font-weight: bold">Destination</p>
            <p style="color: #444444">{{ $deliveryOrder->destination }}</p>
            <p style="color: #444444">{{ $deliveryOrder->destination_address }}</p>
        </td>
    </tr>
</table>

@if($deliveryOrder->deliveryOrderContainers()->count() > 0)
    <h4 style="margin-bottom: 5px; font-weight: normal">Containers</h4>
    <table class="table table-sm">
        <tr>
            <th class="text-left">Container Number</th>
            <th class="text-left">Size</th>
            <th class="text-left">Type</th>
            <th class="text-left">Seal</th>
            <th class="text-left">Is Empty</th>
            <th class="text-left">Description</th>
        </tr>
        @foreach($deliveryOrder->deliveryOrderContainers as $deliveryOrderContainer)
            <tr>
                <td>{{ $deliveryOrderContainer->container->container_number }}</td>
                <td>{{ $deliveryOrderContainer->container->container_size }}</td>
                <td>{{ $deliveryOrderContainer->container->container_type ?: '-' }}</td>
                <td>{{ $deliveryOrderContainer->seal }}</td>
                <td>{{ $deliveryOrderContainer->is_empty ? 'Yes' : 'No' }}</td>
                <td>{{ $deliveryOrderContainer->description ?: '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif

@if($deliveryOrder->deliveryOrderGoods()->count() > 0)
    <h4 style="margin-bottom: 5px; font-weight: normal">Goods</h4>
    <table class="table table-sm">
        <tr>
            <th class="text-left">Item Name</th>
            <th class="text-left">Unit Qty</th>
            <th class="text-left">Unit Name</th>
            <th class="text-left">Package Qty</th>
            <th class="text-left">Package Name</th>
            <th class="text-left">Weight</th>
            <th class="text-left">Description</th>
        </tr>
        @foreach($deliveryOrder->deliveryOrderGoods as $deliveryOrderGoods)
            <tr>
                <td>{{ $deliveryOrderGoods->goods->item_name }}</td>
                <td>{{ numeric($deliveryOrderGoods->unit_quantity) }}</td>
                <td>{{ $deliveryOrderGoods->goods->unit_name ?: '-' }}</td>
                <td>{{ numeric($deliveryOrderGoods->package_quantity) }}</td>
                <td>{{ $deliveryOrderGoods->goods->package_name ?: '-' }}</td>
                <td>{{ numeric($deliveryOrderGoods->weight) }}</td>
                <td>{{ $deliveryOrderGoods->description ?: '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif

<table style="margin-bottom: 20px; font-size: 13px" width="100%">
    <tr>
        <td>
            <p style="font-weight: bold">Description:</p>
            <p style="color: #444444">{{ $deliveryOrder->description ?: '-' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Created At:</p>
            <p style="color: #444444">{{ $deliveryOrder->created_at->format('d F Y H:i') }}</p>
        </td>
    </tr>
</table>

<table width="100%" style="font-size: 12px">
    <tr>
        <td class="text-center">
            <p style="font-weight: bold">Admin</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
        <td class="text-center">
            <p style="font-weight: bold">Driver</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
        <td class="text-center">
            <p style="font-weight: bold">Security</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
        <td class="text-center">
            <p style="font-weight: bold">Customer</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
    </tr>
</table>

<div style="position: absolute; bottom: 0; font-size: 12px">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ app_setting('app-name', config('app.name')) }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%; color: #777777">
                {{ app_setting('app-tagline') }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
