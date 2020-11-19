@component('mail::message')
# {{ ucwords(strtolower($jobType)) }} Report

We send you activity report from {{ $dateFrom }} until {{ $dateTo }}.
Please review the data if there are some mistakes.

@component('mail::panel')
    This email may contain attachments.
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Open {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
