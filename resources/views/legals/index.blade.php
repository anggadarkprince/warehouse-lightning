@extends('layouts.static')

@section('content')
    <article>
        <h3 class="font-bold text-xl">Website Legal</h3>
        <p class="text-gray-500 mb-5">Last updated 20 December 2020</p>

        <ul class="list-disc list-inside">
            <li><a href="<?= route('legals.privacy') ?>" class="text-link">Privacy & Policy</a></li>
            <li><a href="<?= route('legals.agreement') ?>" class="text-link">User Agreement</a></li>
            <li><a href="<?= route('legals.cookie') ?>" class="text-link">Cookie Usage</a></li>
            <li><a href="<?= route('legals.sla') ?>" class="text-link">SLA</a></li>
        </ul>

        <p class="my-5">
            Need more assistance about this information? contact
            <a href="mailto:<?= app_setting('email-support') ?>" class="text-link">Our Support</a> or learn more in
            <a href="<?= url('help') ?>" class="text-link">Help Page</a>.
        </p>
    </article>
@endsection
