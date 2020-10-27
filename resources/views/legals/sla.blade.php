@extends('layouts.static')

@section('content')
    <article>
        <h3 class="font-bold text-xl">Website Disclaimer</h3>
        <p class="text-gray-500 mb-5">Last updated 20 December 2020</p>

        <ol class="list-decimal list-outside pl-3">
            <li class="text-lg">
                <h5 class="inline-block font-bold mb-1">Preamble</h5>
                <p class="text-base">
                    {{ config('app.name', app_setting('app-title')) }}, hereafter referred to as {{ config('app.name', app_setting('app-title')) }}, undertakes to maintain
                    the client’s content stored in the cloud available to third parties for 99.9% of the
                    quantified time, and the objective of {{ config('app.name', app_setting('app-title')) }}’s service will be to achieve 100%
                    access availability.
                </p>
                <p class="text-base">
                    {{ config('app.name', app_setting('app-title')) }} cannot guarantee 100% service availability due to Internet problems,
                    technical problems, or problems arising from the misuse by another CLIENT. Therefore, Sales Layer
                    shall not be liable for the data loss, business interruption, or economic losses that the non-
                    availability may cause the CLIENT.
                </p>
            </li>
            <li class="text-lg">
                <h5 class="mt-4 inline-block font-bold mb-1">Definitions and calculations</h5>
                <ol class="text-base">
                    <li>General query: There are no breakdowns and the CLIENT is requesting information.</li>
                    <li>Breakdown: The service at issue is still attainable, but it is limited.</li>
                    <li>Urgent breakdown: The service hired cannot be attained.</li>
                    <li>
                        Response time: Period of time in which the CLIENT receives a qualified statement from an
                        employee of Sales Layer in response to his/her request/report, as long as the report arrives
                        through the correct way of communication.
                    </li>
                    <li>
                        Availability [%]: Total time minus time of inactivity divided by total time (Refer to Appendix A).
                    </li>
                    <li>
                        Repair time: Time from the receipt of a fault report for a service selected from the CLIENT in
                        the correct communication channel until the repair of the breakdown so that the hardware or
                        service is available again.
                    </li>
                </ol>
            </li>
            <li class="text-lg">
                <h5 class="mt-4 inline-block font-bold mb-1">General service level</h5>
                <ol class="text-base">
                    <li>
                        <h5 class="mt-3">Availability guarantee of data center</h5>
                        <p>
                            The availability of Sales Layer’s data centers is determined by its supplier, Amazon Web
                            Services, which ensures an availability of the data centers of 99.9% as monthly average.
                        </p>
                    </li>
                </ol>
            </li>
            <li class="text-lg">
                <h5 class="mt-4 inline-block font-bold mb-1">Maintenance tasks</h5>
                <p class="text-base">
                    Maintenance intervals shall be required for regular scheduled and unscheduled maintenance works in
                    the systems of Sales Layer and its suppliers, required to ensure the ongoing operation and to carry
                    out updates or improvements. Every limitation to the availability through this type of necessary
                    works shall not be computed in the Service Availability.
                </p>
                <p class="text-base">
                    As a general rule, system maintenance requiring a temporary service interruption shall be carried
                    out on the weekends during the time that involves less impact for Sales Layer’s CLIENTS. In
                    exceptional cases, system maintenance with service interruption may be carried out at any other
                    time.
                </p>
                <p class="text-base">
                    Sales Layer shall inform the CLIENT of the system maintenance scheduled as soon as possible,
                    indicating the estimated time of the service outage and the time when it will occur
                </p>
                <p class="text-base">
                    Sales Layer shall indicate the estimated time of the service outage and the approximate time when
                    such outage will occur. This time will be considered beyond the guarantee of the service
                    availability, i.e., it will not affect 99.9 of the availability ensured.
                </p>
                <p class="text-base">
                    The system maintenance and update tasks that do not require service interruption may be carried out
                    at any time, as they do not affect the availability and use of the system by Sales Layer’s CLIENTS.
                </p>
            </li>
        </ol>

        <div class="text-center mt-5 mb-2">
            <h5 class="font-bold text-lg">APPENDIX A </h5>
            <h4 class="lead text-fade">Product-specific service level</h4>
        </div>

        <h4 class="font-bold">Unregistered Accounts</h4>
        <p class="mb-2">Guaranteed availability of the interface of the service 95%. Queries and breakdowns:</p>
        <table class="w-full">
            <thead>
            <tr>
                <th class="border-b-2 px-4 py-1"></th>
                <th class="border-b-2 px-4 py-1">General query</th>
                <th class="border-b-2 px-4 py-1">Breakdown</th>
                <th class="border-b-2 px-4 py-1">Urgent breakdown</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border-b py-1">Support schedule (WIB time zone)</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
            </tr>
            <tr>
                <td class="border-b py-1">
                    Maximum response time<br>
                    <small>(by any of the means specified above)</small>
                </td>
                <td class="border-b py-1">48 hours</td>
                <td class="border-b py-1">12 hours</td>
                <td class="border-b py-1">8 hours</td>
            </tr>
            <tr>
                <td class="border-b py-1">Maximum repair time</td>
                <td class="border-b py-1">N/A</td>
                <td class="border-b py-1">72 hours</td>
                <td class="border-b py-1">24 hours</td>
            </tr>
            </tbody>
        </table>

        <h4 class="mt-5 font-bold">Registered Accounts</h4>
        <p class="mb-2">Guaranteed availability of the interface of the service 97%. Queries and breakdowns:</p>
        <table class="w-full">
            <thead>
            <tr>
                <th class="border-b-2 px-4 py-1"></th>
                <th class="border-b-2 px-4 py-1">General query</th>
                <th class="border-b-2 px-4 py-1">Breakdown</th>
                <th class="border-b-2 px-4 py-1">Urgent breakdown</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border-b py-1">Support schedule (WIB time zone)</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
                <td class="border-b py-1">Monday to Friday<br>9:00 AM – 1:00 PM<br>4:00 PM – 7:00 PM</td>
            </tr>
            <tr>
                <td class="border-b py-1">
                    Maximum response time<br>
                    <small>(by any of the means specified above)</small>
                </td>
                <td class="border-b py-1">12 hours</td>
                <td class="border-b py-1">12 hours</td>
                <td class="border-b py-1">2 hours</td>
            </tr>
            <tr>
                <td class="border-b py-1">Maximum repair time</td>
                <td class="border-b py-1">N/A</td>
                <td class="border-b py-1">48 hours</td>
                <td class="border-b py-1">12 hours</td>
            </tr>
            </tbody>
        </table>

        <p class="my-5">
            If you have any questions or suggestions about our Privacy Policy, do not hesitate to
            <a href="mailto:<?= app_setting('email-support') ?>" class="text-link">Contact Us</a> or learn more in
            <a href="<?= url('help') ?>" class="text-link">Help Page</a>.
        </p>
    </article>
@endsection
