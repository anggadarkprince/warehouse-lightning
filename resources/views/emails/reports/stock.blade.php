@component('mail::message')
# Stock Report

We send you stock report at {{ $stockDate }}.
Please review the data if there are some mistakes.

| Container | Type | Size |
|:----------|:-----|:----:|
@forelse($containers as $container)
| {{ $container->container_number }} | {{ $container->container_type }} | {{ $container->container_size }} |
@empty
| No containers           |
@endforelse

<br>

| Goods |  Quantity  |  Weight  |
|:------|:----------:|:--------:|
@forelse($goods as $item)
| {{ $item->item_name }} |  {{ numeric($item->unit_quantity) }}  |  {{ numeric($item->weight) }}  |
@empty
| No goods                      |
@endforelse

@component('mail::panel')
This email may contain attachments.
@endcomponent

@component('mail::button', ['url' => route('reports.stock-summary')])
Open Stock Summary
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
