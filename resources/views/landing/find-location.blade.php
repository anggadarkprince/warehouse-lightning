@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-20">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-green-500 font-bold">Our Locations</p>
                <h1 class="font-bold text-3xl">Around The World</h1>
                <p class="text-gray-500">
                    We understand the importance of approaching each work integrally and believe<br>
                    in the power of simple and easy communication.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                <div class="bg-white rounded-lg text-center shadow-lg px-6 py-8 md:px-8 md:pr-5">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/07/united-states.png" class="mx-auto mb-3" alt="united-states">
                    <h3 class="text-xl font-bold mb-2">United States</h3>
                    <ul class="mb-6 text-gray-500">
                        <li>Phone: 010612457410</li>
                        <li>Email: Logisti@farost.com</li>
                        <li>Address: 2307 Beverley Rd Brooklyn, NY</li>
                        <li>Hours: Mon-Fri: 8am – 7pm</li>
                    </ul>
                    <a href="{{ route('landing.contact') }}" class="block w-full py-3 px-5 rounded bg-indigo-800 text-white transition duration-200 hover:bg-indigo-700">
                        Contact Us
                    </a>
                </div>
                <div class="bg-white rounded-lg text-center shadow-lg px-6 py-8 md:px-8 md:pr-5">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/07/germany.png" class="mx-auto mb-3" alt="united-states">
                    <h3 class="text-xl font-bold mb-2">Germany</h3>
                    <ul class="mb-6 text-gray-500">
                        <li>Phone: 010612457410</li>
                        <li>Email: Logisti@farost.com</li>
                        <li>Address: 2307 Beverley Rd Brooklyn, NY</li>
                        <li>Hours: Mon-Fri: 8am – 7pm</li>
                    </ul>
                    <a href="{{ route('landing.contact') }}" class="block w-full py-3 px-5 rounded bg-indigo-800 text-white transition duration-200 hover:bg-indigo-700">
                        Contact Us
                    </a>
                </div>
                <div class="bg-white rounded-lg text-center shadow-lg px-6 py-8 md:px-8 md:pr-5">
                    <img src="http://7oroof.com/tfdemos/optime/wp-content/uploads/2019/07/canada.png" class="mx-auto mb-3" alt="united-states">
                    <h3 class="text-xl font-bold mb-2">Germany</h3>
                    <ul class="mb-6 text-gray-500">
                        <li>Phone: 010612457410</li>
                        <li>Email: Logisti@farost.com</li>
                        <li>Address: 2307 Beverley Rd Brooklyn, NY</li>
                        <li>Hours: Mon-Fri: 8am – 7pm</li>
                    </ul>
                    <a href="{{ route('landing.contact') }}" class="block w-full py-3 px-5 rounded bg-indigo-800 text-white transition duration-200 hover:bg-indigo-700">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
