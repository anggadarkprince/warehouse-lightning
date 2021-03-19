@extends('layouts.landing')

@section('content')
    <div class="bg-white pt-10 pb-10">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="mb-10">
                <h1 class="text-4xl font-bold leading-tight mb-2">
                    Affordable Price, <br>
                    Certified Experts & <br>
                    Innovative Solutions.
                </h1>
                <p class="text-lg">
                    Competitive advantages to some of the larges companies all over the world.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-4">
                <div class="py-5 px-8 border sm:border-r-0">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/03/Wallet-Icon.png" alt="Walet" class="mb-3">
                    <h2 class="text-lg font-bold text-indigo-800 mb-2">Affordable Pricing</h2>
                    <p class="text-gray-500">International supply chain invokes challenging regulations.</p>
                </div>
                <div class="py-5 px-8 border md:border-r-0">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/03/015-search.png" alt="Search" class="mb-3">
                    <h2 class="text-lg font-bold text-indigo-800 mb-2">Real-Time Tracking</h2>
                    <p class="text-gray-500">Ensure customer's supply chains are fully compliant by practices.</p>
                </div>
                <div class="py-5 px-8 border sm:border-r-0">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/03/Trolley-Icon.png" alt="Search" class="mb-3">
                    <h2 class="text-lg font-bold text-indigo-800 mb-2">Warehouse Storage</h2>
                    <p class="text-gray-500">Depending on user requirement space for storage of goods and containers.</p>
                </div>
                <div class="py-5 px-8 border">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/03/Security-Icon.png" alt="Search" class="mb-3">
                    <h2 class="text-lg font-bold text-indigo-800 mb-2">Security For Cargo</h2>
                    <p class="text-gray-500">We cover your delivery and make sure your stuffs right in front your door.</p>
                </div>
            </div>
            <div class="mt-20">
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-10">
                    <div>
                        <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/08/shutterstock_722794939.jpg" alt="Cover" class="md:mr-5 rounded-lg">
                    </div>
                    <div>
                        <p class="text-green-500">Affordable Price, Certified Logistics</p>
                        <h1 class="text-3xl font-semibold mb-5">
                            Safe, Reliable & Express
                            Logistic Solutions That
                            Saves Your Time!
                        </h1>
                        <p class="mb-2 text-gray-600">
                            Our global logistics expertise, advanced supply chain technology & customized logistics
                            solutions will help you analyze, develop and implement successful supply chain
                            management strategies from end-to-end.
                        </p>

                        <ul class="list-disc list-inside mb-5 text-gray-600">
                            <li>Transparent Pricing, Environmental Sensitivity</li>
                            <li>24/7 Hours Support, Professional and Qualified</li>
                            <li>Real Time Tracking, Fast & Efficient Delivery</li>
                            <li>Warehouse Storage, Personalised solutions</li>
                        </ul>

                        <div>
                            <a href="{{ route('landing.contact') }}" class="button-primary mr-3">
                                More About Us
                            </a>
                            <a href="#" class="text-link px-3 py-2">Find your solution</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
