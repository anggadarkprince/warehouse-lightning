@component('mail::message')
# {{ ucwords(strtolower($workOrder->job_type)) }} Assignment

## Hi, {{ $workOrder->user->name }}
You are assigned to handle job {{ $workOrder->job_type }}.
Please start to work immediately. If something wrong with this assignation please contact your Supervisor or Manager.

## Note:
{{ $workOrder->description ?: 'No additional note' }}

@component('mail::panel')
    Don't forget to work safe and precise.
@endcomponent

@component('mail::button', ['url' => route('tally.index', ['locale' => app_setting('app-language', app()->getLocale())])])
Open Queue
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
