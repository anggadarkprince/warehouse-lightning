<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Stock - {{ $takeStock->take_stock_number }}</title>

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

        .text-primary {
            color: #548235;
        }

        table {
            width: 100%;
        }

        .table {
            border: 1px solid #548235;
            border-collapse: collapse;
            margin: 0 auto 10px;
            width: 740px;
            font-size: 12px;
        }

        .table td, .table tr, .table th {
            padding: 5px;
        }

        .table th {
            background-color: #548235;
            color: white;
        }

        .table-sm td, .table-sm tr, .table-sm th {
            padding: 5px;
            font-size: 11px;
        }

        .table-strip tr:nth-child(odd) {
            background-color: #F4F9F1;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-sm {
            font-size: 11px;
        }

        hr {
            border: none; border-top: 1px solid #ddd; margin-bottom: 10px;
        }
    </style>

</head>
<body>

<table style="margin-bottom: 10px">
    <tr>
        <td class="text-left" style="width: 50%;">
            <h3 style="font-weight: normal">{{ app_setting('app-name', config('app.name')) }}</h3>
            <p style="color: #777777; font-size: 12px; font-weight: normal">{{ app_setting('app-tagline') }}</p>
        </td>
        <td class="text-right" style="width: 50%;">
            <h4 class="text-primary">TAKE STOCK</h4>
            <p style="color: #777777; font-size: 12px; font-weight: normal">Print Date: {{ date('d M Y') }}</p>
        </td>
    </tr>
</table>

<hr>

<table class="table">
    <tr>
        <td>
            <p style="font-weight: bold">Take Stock Number</p>
            <p style="font-weight: normal">{{ $takeStock->take_stock_number }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Description</p>
            <p style="font-weight: normal">{{ $takeStock->description ?: 'No description' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Created At</p>
            <p style="font-weight: normal">{{ $takeStock->created_at->format('d F Y H:i') }}</p>
        </td>
        <td class="text-center" style="width: 90px; border-left: 1px solid #548235">
            <img style="margin: 0;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(80)->generate($takeStock->take_stock_number)) !!} " alt="{{ $takeStock->take_stock_number }}">
        </td>
    </tr>
</table>

@if($takeStock->takeStockContainers()->exists())
    <h4 style="margin-bottom: 5px; font-weight: normal">Containers</h4>
    <table class="table table-sm table-strip">
        <tr>
            <th class="text-left">Reference</th>
            <th class="text-left">Container Number</th>
            <th class="text-left">Size</th>
            <th class="text-left">Type</th>
            <th class="text-left">Seal</th>
            <th class="text-left">Is Empty</th>
            <th class="text-left">Rev Qty</th>
            <th class="text-left">Rev Desc</th>
        </tr>
        @foreach($takeStock->takeStockContainers as $takeStockContainer)
            <tr>
                <td>
                    <p>{{ $takeStockContainer->booking->customer->customer_name }}</p>
                    <small style="color: #444444">{{ $takeStockContainer->booking->reference_number }}</small>
                </td>
                <td>{{ $takeStockContainer->container->container_number }}</td>
                <td>{{ $takeStockContainer->container->container_size }}</td>
                <td>{{ $takeStockContainer->container->container_type ?: '-' }}</td>
                <td>{{ $takeStockContainer->seal ?: '-' }}</td>
                <td>{{ $takeStockContainer->is_empty ? 'Yes' : 'No' }}</td>
                <td>{{ $takeStockContainer->revision_quantity ?: '' }}</td>
                <td>{{ $takeStockContainer->revision_description ?: '' }}</td>
            </tr>
        @endforeach
    </table>
@endif

@if($takeStock->takeStockGoods()->exists())
    <h4 style="margin-bottom: 5px; font-weight: normal">Goods</h4>
    <table class="table table-sm table-strip">
        <tr>
            <th class="text-left">Reference</th>
            <th class="text-left">Item Name</th>
            <th class="text-left">Rev Qty</th>
            <th class="text-left">Rev Package</th>
            <th class="text-left">Rev Weight</th>
            <th class="text-left">Rev Gross Weight</th>
            <th class="text-left">Rev Desc</th>
        </tr>
        @foreach($takeStock->takeStockGoods as $takeStockItem)
            <tr>
                <td>
                    <p>{{ $takeStockItem->booking->customer->customer_name }}</p>
                    <small style="color: #444444">{{ $takeStockItem->booking->reference_number }}</small>
                </td>
                <td>
                    {{ $takeStockItem->goods->item_name }}<br>
                    <small style="color: #aaaaaa">{{ $takeStockItem->goods->item_number }}</small>
                </td>
                <td>{{ numeric($takeStockItem->revision_unit_quantity) ?: '' }}</td>
                <td>{{ numeric($takeStockItem->revision_package_quantity) ?: '' }}</td>
                <td>{{ numeric($takeStockItem->revision_weight) ?: '' }}</td>
                <td>{{ numeric($takeStockItem->revision_gross_weight) ?: '' }}</td>
                <td>{{ $takeStockItem->description ?: '' }}</td>
            </tr>
        @endforeach
    </table>
@endif

<table class="text-sm">
    <tr>
        <td class="text-center">
            <p style="font-weight: bold">Admin</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
        <td class="text-center">
            <p style="font-weight: bold">Checker</p>
            <br>
            <br>
            <br>
            ( .......................... )
        </td>
        <td class="text-center">
            <p style="font-weight: bold">Supervisor</p>
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
