<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Work Order - {{ $workOrder->job_number }}</title>

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
            <h4 class="text-primary">WORK ORDER</h4>
            <p style="color: #777777; font-size: 12px; font-weight: normal">Print Date: {{ date('d M Y') }}</p>
        </td>
    </tr>
</table>

<hr>

<table style="margin-bottom: 10px; font-size: 13px" width="100%">
    <tr>
        <td style="width: 150px">Job Type</td>
        <td style="font-weight: bold" class="text-primary">{{ $workOrder->job_type }}</td>
        <td style="width: 150px">Booking Name</td>
        <td>{{ $workOrder->booking->bookingType->booking_name ?: '-' }}</td>
    </tr>
    <tr>
        <td>Reference Number</td>
        <td>{{ $workOrder->booking->reference_number }}</td>
        <td style="width: 150px">Booking Number</td>
        <td>{{ $workOrder->booking->booking_number ?: '-' }}</td>
    </tr>
</table>

<table class="table">
    <tr>
        <th>
            <p style="font-weight: bold">Job Number</p>
            <p style="color: #E2EFDA; font-weight: normal">{{ $workOrder->job_number }}</p>
        </th>
        <th>
            <p style="font-weight: bold">Customer</p>
            <p style="color: #E2EFDA; font-weight: normal">{{ $workOrder->booking->customer->customer_name }}</p>
        </th>
        <th>
            <p style="font-weight: bold">Assigned To</p>
            <p style="color: #E2EFDA; font-weight: normal">{{ $workOrder->user->name }}</p>
        </th>
        <td rowspan="2" class="text-center" style="width: 120px; border-left: 1px solid #548235">
            <img style="margin: 0;" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate($workOrder->job_number)) !!} " alt="{{ $workOrder->job_number }}">
        </td>
    </tr>
    <tr style="text-align: center">
        <td>
            <p style="font-weight: bold">Taken At</p>
            <p style="color: #444444">{{ optional($workOrder->taken_at)->format('d F Y H:i') ?: 'Not Yet Taken' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Completed At</p>
            <p style="color: #444444">{{ optional($workOrder->completed_at)->format('d F Y H:i') ?: 'Not Yet Completed' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Status</p>
            <p style="color: #444444">{{ $workOrder->status }}</p>
        </td>
    </tr>
</table>

@if($workOrder->workOrderContainers()->exists())
    <h4 style="margin-bottom: 5px; font-weight: normal">Containers</h4>
    <table class="table table-sm table-strip">
        <tr>
            <th class="text-left">Container Number</th>
            <th class="text-left">Size</th>
            <th class="text-left">Type</th>
            <th class="text-left">Seal</th>
            <th class="text-left">Is Empty</th>
            <th class="text-left">Description</th>
        </tr>
        @foreach($workOrder->workOrderContainers as $workOrderContainer)
            <tr>
                <td>{{ $workOrderContainer->container->container_number }}</td>
                <td>{{ $workOrderContainer->container->container_size }}</td>
                <td>{{ $workOrderContainer->container->container_type ?: '-' }}</td>
                <td>{{ $workOrderContainer->seal ?: '-' }}</td>
                <td>{{ $workOrderContainer->is_empty ? 'Yes' : 'No' }}</td>
                <td>{{ $workOrderContainer->description ?: '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif

@if($workOrder->workOrderGoods()->exists())
    <h4 style="margin-bottom: 5px; font-weight: normal">Goods</h4>
    <table class="table table-sm table-strip">
        <tr>
            <th class="text-left">Item Name</th>
            <th class="text-left">Unit Qty</th>
            <th class="text-left">Package Qty</th>
            <th class="text-left">Weight</th>
            <th class="text-left">Gross Weight</th>
            <th class="text-left">Description</th>
        </tr>
        @foreach($workOrder->workOrderGoods as $workOrderGoods)
            <tr>
                <td>
                    {{ $workOrderGoods->goods->item_name }}<br>
                    <small style="color: #aaaaaa">{{ $workOrderGoods->goods->item_number }}</small>
                </td>
                <td>{{ numeric($workOrderGoods->unit_quantity) }} {{ $workOrderGoods->goods->unit_name ?: '-' }}</td>
                <td>{{ numeric($workOrderGoods->package_quantity) }} {{ $workOrderGoods->goods->package_name ?: '-' }}</td>
                <td>{{ numeric($workOrderGoods->weight) }} Kg</td>
                <td>{{ numeric($workOrderGoods->gross_weight) }} Kg</td>
                <td>{{ $workOrderGoods->description ?: '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif

<table style="margin-bottom: 20px;" class="text-sm">
    <tr>
        <td style="width: 50%">
            <p style="font-weight: bold">Description:</p>
            <p style="color: #444444">{{ $workOrder->description ?: '-' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Created At:</p>
            <p style="color: #444444">{{ $workOrder->created_at->format('d F Y H:i') ?: '-' }}</p>
        </td>
        <td>
            <p style="font-weight: bold">Updated At:</p>
            <p style="color: #444444">{{ optional($workOrder->updated_at)->format('d F Y H:i') ?: '-' }}</p>
        </td>
    </tr>
</table>

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
            <p style="font-weight: bold">Tally</p>
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
