@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-20 top-0">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-green-500 font-bold">Our Consumer</p>
                <h1 class="font-bold text-3xl">Power Generation</h1>
            </div>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-6">
                <div class="col-span-2 hidden md:block">
                    @include('landing.consumer.partials._sidenav')
                    @include('landing.partials._cta_card_appointment')
                </div>
                <div class="col-span-4">
                    <div class="px-10 py-8 bg-white rounded mb-10">
                        <h1 class="text-2xl font-bold mb-2">Overview</h1>
                        <p class="text-gray-600 mb-6">
                            Our staff attaches great importance to customizing the booking process for our customers.
                            That’s why we strive to find the air freight solution that best suits your needs.
                            We’ll ask you when the freight is available, what the required delivery date is, and if there’s
                            potential to save on time or cost. Your answers to these and other questions help us decide if
                            you should book the air freight as direct.
                        </p>
                        <h1 class="text-2xl font-bold mb-2">Stats & Charts</h1>
                        <p class="text-gray-600 mb-6">
                            We pride ourselves on providing the best transport and shipping services currently available in
                            Australia. Our skilled personnel, utilising the latest communications, tracking and processing
                            software, combined with decades of experience, ensure all freight is are shipped, trans-shipped
                            and delivered as safely, securely, and promptly as possible.
                        </p>

                        <div class="grid grid-cols-2">
                            <div>
                                <h3 class="text-lg font-bold mb-2">Our Solutions</h3>
                                <p class="text-gray-600 mb-6">
                                    Our primary Less-Than-Truckload service is completed using mezzanine floor tautliners and
                                    drop-deck open trailers, allowing us to maximise driver and vehicle utilisation.
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Production techniques</h3>
                                <p class="text-gray-600 mb-6">
                                    Your answers to these and other questions help us decide if you should book the air freight,
                                    we’ll also see if service is a better solution for you.
                                </p>
                            </div>
                        </div>

                        <h1 class="text-2xl font-bold mb-2">Why Us!</h1>
                        <p class="text-gray-600 mb-6">
                            We continue to pursue that same vision in today’s complex, uncertain world, working every day to
                            earn our customers’ trust! During that time, we’ve become expert in freight transportation by air
                            and all its related services. We work closely with all major airlines around the world.
                        </p>
                    </div>

                    @include('landing.consumer.partials._cta_card_contact')
                </div>
            </div>
        </div>
    </div>
@endsection
