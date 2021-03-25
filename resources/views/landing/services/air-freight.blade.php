@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-20 top-0">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-green-500 font-bold">Our Services</p>
                <h1 class="font-bold text-3xl">Air Freight</h1>
            </div>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-6">
                <div class="col-span-2 hidden md:block">
                    @include('landing.services.partials._sidenav')
                    @include('landing.partials._cta_card_appointment')
                </div>
                <div class="col-span-4">
                    <div class="px-10 py-8 bg-white rounded mb-10">
                        <h1 class="text-2xl font-bold mb-2">Overview</h1>
                        <p class="text-gray-600 mb-6">
                            Our warehousing staff attaches great importance to customizing the booking process for our
                            customers. That’s why we strive to find the air freight solution that best suits your needs.
                            We’ll ask you when the freight is available, what the required delivery date is, and if
                            there’s potential to save on time or cost. Your answers to these and other questions help us
                            decide if you should book the air freight as direct. We’ll also see if our sea-air service
                            is a better solution for you.
                        </p>
                        <p class="text-gray-600 mb-6">
                            We have more than twenty years of experience. During that time, we’ve become expert in
                            freight transportation by air and all its related services. We work closely with all major
                            airlines around the world. Ongoing negotiations ensure that we always have the cargo space
                            we need and the ability to offer you competitive rates – even during the high season.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Where possible, we’ll erect and dismantle Unit Load Devices (ULDs), reducing significantly
                            the risk of damage to your shipment and saving you time and expense. We can do this because
                            many of our freight stations have their own ground transportation at or around the airport.
                        </p>
                        <h1 class="text-2xl font-bold mb-2">Stats & Charts</h1>
                        <p class="text-gray-600 mb-6">
                            Our mix of company-owned and contractor assets allows us to retain optimal levels of control
                            whilst expanding our reach to over 96% of towns in Australia. With 40 years of LTL
                            experience, we are now a trusted LTL freight provider for shippers of all sizes and
                            commodity types.
                        </p>
                        <p class="text-gray-600 mb-6">
                            Our LTL service extends to all states and territories, and includes multiple per-week
                            services to places many others only serve occasionally, including Darwin, Alice Springs,
                            Newman, Mt. Isa, Launceston and Burnie.
                        </p>

                        <h1 class="text-2xl font-bold mb-2">How It Works?</h1>
                        <p class="text-gray-600 mb-6">
                            We have more than twenty years of experience. During that time, we’ve become expert in
                            freight transportation by air and all its related services. We work closely with all major
                            airlines around the world. Ongoing negotiations ensure that we always have the cargo space
                            we need and offer you competitive rates.
                        </p>

                        <h1 class="text-2xl font-bold mb-2">Why Us!</h1>
                        <p class="text-gray-600 mb-6">
                            We continue to pursue that same vision in today’s complex, uncertain world, working every day to
                            earn our customers’ trust! During that time, we’ve become expert in freight transportation by air
                            and all its related services. We work closely with all major airlines around the world.
                        </p>
                    </div>

                    @include('landing.partials._card_case_study')
                </div>
            </div>
        </div>
    </div>
@endsection
