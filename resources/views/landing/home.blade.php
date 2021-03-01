@extends('layouts.landing')

@section('content')
    <div class="px-4 max-w-6xl mx-auto">
        <div class="py-2">
            <div class="sm:flex -mx-2">
                <div class="px-2 sm:w-1/2 flex items-center">
                    <div class="py-4">
                        <p class="text-gray-500 mb-2">Your best warehouse partner</p>
                        <h1 class="text-2xl font-black leading-tight mb-3 md:text-4xl">
                            Reliable & Express Logistic<br>
                            Solution Saves Your Time!
                        </h1>
                        <h3 class="mb-8">Competitive advantage to some of the largest companies all over the world.</h3>
                        <a href="#" class="button-primary">
                            Discover More
                        </a>
                    </div>
                </div>
                <div class="px-2 sm:w-1/2">
                    <img src="<?= url('img/banner.webp') ?>" alt="Banner" class="md:max-w-xl">
                </div>
            </div>
        </div>

        <div class="mb-10">
            <h3 class="font-bold text-green-500 mb-3">Real Solution, Real Warehouse</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                <div>
                    <h1 class="font-black text-3xl leading-tight mb-3">
                        Deliver the Best Global<br>
                        Logistics Solution
                    </h1>
                </div>
                <div>
                    <p class="text-gray-500">
                        Our global logistic expertise, advanced supply chain technology & customized logistics solutions will help you
                        analyze, develop and implement successful supply chain management strategies from end-to-end.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-16 lg:gap-10">
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-airballoon-outline text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Air Freight</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    We can arrange and provides with the comprehensive service in the sphere of urgent,
                    valuable, fragile or any cargoes conscientious accelerated delivery by air.
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-ferry text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Ocean Freight</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    We provides with the main types of basic conditions International sea transportation is implemented
                    by our partner's vessels, the largest ocean carriers.
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-truck-fast-outline text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Road Freight</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    We provides a wide range of transportation services including international
                    transportation of cargoes & goods from the ports all over the world.
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-forklift text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Warehousing</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    We manage goods with modern and reliable equipment of tools inside our warehouse,
                    with advanced monitoring system keep your stuff in good shape.
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-gift-outline text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Supply Chain</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    High priority flow of goods and services, involves the movement and storage of raw materials
                    from the supplier to the manufacturer through end user.
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="bg-white shadow-lg md:shadow-xl border-t border-green-500 rounded-sm text-center p-5 lg:p-10">
                <i class="mdi mdi-package-variant-closed text-6xl text-green-500 leading-tight mb-3 block"></i>
                <h3 class="font-black text-xl mb-4">Packaging</h3>
                <p class="text-gray-500 leading-tight mb-4 hidden sm:block">
                    We provide handling to manage your goods, including repacking, cleaning, and sealing.
                    Enclosing or protecting products for distribution, storage, sale, and use
                </p>
                <a href="#" class="font-bold py-2 px-5 transition duration-200 rounded-sm bg-gray-100 hover:bg-green-500 hover:text-white inline-block">
                    Read More <i class="mdi mdi-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="px-4 py-10 max-w-6xl mx-auto sm:px-16 sm:py-20 rounded" style="background: url('{{ url('img/forklift.jpg') }}') #F7F7F7 no-repeat right top / auto 100%">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-5">
                <div class="col-span-2 sm:pr-8">
                    <i class="mdi mdi-tag-off-outline text-5xl leading-none mb-5 text-green-500 inline-block"></i>
                    <p class="text-green-500 font-bold mb-3">Affordable Price, Certified Forwarders</p>
                    <h1 class="font-black mb-5 text-3xl leading-tight">
                        Safe Reliable & Express Logistic Solutions That Saves Your Time!
                    </h1>
                    <p class="mb-8 text-sm text-gray-500">
                        We pride ourselves on providing the best transport and shipping
                        services available all over the world. Our skilled personnel, utilising the latest communications,
                        tracking and processing software, combined with decades of experience through integrated supply chain.
                    </p>
                    <a href="#" class="py-3 px-8 rounded-sm bg-green-500 text-white font-bold inline-block transition duration-200 hover:bg-green-600">
                        Schedule An Appointment
                    </a>
                </div>
                <div class="shadow-xl bg-white p-10 rounded col-span-3 lg:col-span-2">
                    <h2 class="font-black text-xl mb-3 leading-none">What We Achieved!</h2>
                    <p class="text-gray-500 text-sm leading-tight mb-5">
                        Fulfill our dedicated promise to deliver innovative & dynamic
                        solutions to our customers to fit their needs.
                    </p>
                    <div class="grid grid-cols-1 gap-5 mb-3">
                        <div>
                            <div class="flex justify-between">
                                <h4 class="font-bold mb-2">Warehousing</h4>
                                <p class="font-bold text-gray-500 text-sm">80%</p>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full hover:bg-green-600" style="width: 80%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <h4 class="font-bold mb-2">Air Freight</h4>
                                <p class="font-bold text-gray-500 text-sm">90%</p>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full hover:bg-green-600" style="width: 90%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <h4 class="font-bold mb-2">Ocean Freight</h4>
                                <p class="font-bold text-gray-500 text-sm">77%</p>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full hover:bg-green-600" style="width: 77%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <h4 class="font-bold mb-2">Road Freight</h4>
                                <p class="font-bold text-gray-500 text-sm">95%</p>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full hover:bg-green-600" style="width: 95%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <h4 class="font-bold mb-2">Supply Chain</h4>
                                <p class="font-bold text-gray-500 text-sm">70%</p>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full hover:bg-green-600" style="width: 70%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 mb-12 max-w-6xl mx-auto text-center">
        <p class="font-bold text-green-500">What People Say!</p>
        <h1 class="text-3xl font-black mb-8">Testimonials</h1>

        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="#" class="text-5xl text-green-500" id="testimony-control-left"><i class="mdi mdi-chevron-left"></i></a>
            <div class="overflow-x-hidden w-full whitespace-no-wrap transition-all duration-200 align-top" id="testimony-wrapper">
                <div class="px-4 md:px-10 inline-block align-middle" style="width: 100%" id="testimony-slide-1">
                    <div class="rounded-full inline-block p-1 border-4 border-green-500 mb-4">
                        <img src="{{ url('img/forklift.jpg') }}" alt="testimony_1" class="object-cover w-16 h-16 rounded-full">
                    </div>
                    <p class="tex-lg md:text-xl mb-4 text-gray-500 whitespace-normal">
                        They are the best of the best, and expertly trained team members who take the extra step and go the extra mile,
                        all to fulfill our dedicated promise to deliver innovative and dynamic solutions to our customers
                        to fit the needs of a rapidly changing global environment.
                    </p>
                    <p class="text-green-500 text-lg">Angga Ari Wijaya</p>
                    <h3 class="font-bold text-xl mb-3">
                        Warehouse Travel.inc
                    </h3>
                </div>
                <div class="px-4 md:px-10 inline-block align-middle" style="width: 100%" id="testimony-slide-2">
                    <div class="rounded-full inline-block p-1 border-4 border-green-500 mb-4">
                        <img src="{{ url('img/forklift.jpg') }}" alt="testimony_1" class="object-cover w-16 h-16 rounded-full">
                    </div>
                    <p class="tex-lg md:text-xl mb-4 text-gray-500 whitespace-normal">
                        Fulfill our dedicated promise to deliver innovative and dynamic solutions to our customers
                        to fit the needs of a rapidly changing global environment.
                    </p>
                    <p class="text-green-500 text-lg">Arya Mikami</p>
                    <h3 class="font-bold text-xl mb-3">
                        Independent Storage.inc
                    </h3>
                </div>
                <div class="px-4 md:px-10 inline-block align-middle" style="width: 100%" id="testimony-slide-3">
                    <div class="rounded-full inline-block p-1 border-4 border-green-500 mb-4">
                        <img src="{{ url('img/forklift.jpg') }}" alt="testimony_1" class="object-cover w-16 h-16 rounded-full">
                    </div>
                    <p class="tex-lg md:text-xl mb-4 text-gray-500 whitespace-normal">
                        Expertly trained team members who take the extra step and go the extra mile,
                        all to fulfill our dedicated promise to deliver innovative and dynamic solutions to our customers
                        to fit the needs of a rapidly changing global environment.
                    </p>
                    <p class="text-green-500 text-lg">Mr. Hariyanto</p>
                    <h3 class="font-bold text-xl mb-3">
                        Cargo One.inc
                    </h3>
                </div>
            </div>
            <a href="#" class="text-5xl text-green-500" id="testimony-control-right"><i class="mdi mdi-chevron-right"></i></a>
        </div>
        <ul class="slider-navigation flex justify-center text-gray-500">
            <li><i class="mdi mdi-circle-medium text-green-500 py-1 px-2 cursor-pointer active testimony-navigation" data-target="testimony-slide-1" data-page="1"></i></li>
            <li><i class="mdi mdi-circle-medium py-1 px-2 cursor-pointer testimony-navigation" data-target="testimony-slide-2" data-page="2"></i></li>
            <li><i class="mdi mdi-circle-medium py-1 px-2 cursor-pointer testimony-navigation" data-target="testimony-slide-3" data-page="3"></i></li>
        </ul>
    </div>
    <script>
        const testimonyControlLeft = document.getElementById('testimony-control-left');
        const testimonyControlRight = document.getElementById('testimony-control-right');
        const testimonyWrapper = document.getElementById('testimony-wrapper');
        const testimonyWidth = testimonyWrapper.clientWidth;
        const totalItems = testimonyWrapper.children.length;
        testimonyWrapper.scrollLeft = 0;
        let currentSlide = 1;
        let currentPos = testimonyWrapper.scrollLeft || 0;
        let timer;

        testimonyControlLeft.addEventListener('click', function(e) {
            e.preventDefault();
            slidePrev();
        });
        testimonyControlRight.addEventListener('click', function(e) {
            e.preventDefault();
            slideNext();
        });
        document.querySelectorAll('.testimony-navigation').forEach(nav => {
            nav.addEventListener('click', function(e) {
                e.preventDefault();
                const page = nav.dataset.page;
                slideTo((page - 1) * testimonyWidth);
                setPaginationActive(page);
            });
        });

        function setPaginationActive(slidePage) {
            document.querySelector('.testimony-navigation.active').classList.remove('active', 'text-green-500');
            document.querySelector(`.testimony-navigation[data-page="${slidePage}"]`).classList.add('active', 'text-green-500');
        }

        function slidePrev() {
            if (currentPos <= 0) {
                currentPos = (totalItems - 1) * testimonyWidth;
                currentSlide = totalItems;
            } else {
                currentPos -= testimonyWidth;
                currentSlide--;
            }
            slideTo(currentPos);
            setPaginationActive(currentSlide);
        }

        function slideNext() {
            if (currentPos >= (totalItems - 1) * testimonyWidth) {
                currentPos = 0;
                currentSlide = 1;
            } else {
                currentPos += testimonyWidth;
                currentSlide++;
            }
            slideTo(currentPos);
            setPaginationActive(currentSlide);
        }

        function slideTo(pos) {
            //testimonyWrapper.scrollLeft = currentPos;
            testimonyWrapper.scroll({
                left: pos,
                behavior: 'smooth'
            });
            initSlideTimer();
        }

        function initSlideTimer() {
            if (timer) {
                clearInterval(timer);
            }
            timer = setInterval(slideNext, 5000);
        }
        initSlideTimer();
    </script>

    <div class="bg-gray-100">
        <div class="relative">
            <div id="map-location" style="height: 450px"></div>
            <div class="absolute bg-white rounded shadow-lg" style="left: 15%; top: 50%; transform: translateY(-50%); min-width: 250px">
                <div class="bg-indigo-900 rounded-t px-4 py-3">
                    <h3 class="text-white font-bold text-lg">Global Locations</h3>
                </div>
                <div class="divide-y">
                    <div class="location-info active">
                        <h4 class="px-4 py-3 font-bold text-green-500 cursor-pointer office-location" data-location="surabaya">
                            <i class="mdi mdi-plus mr-2"></i>Surabaya
                        </h4>
                        <ul class="pl-10 pr-4 py-3 text-sm text-gray-500 border-t office-address">
                            <li>Phone: 085655479868</li>
                            <li>Email: anggadarkprince@gmail.com</li>
                            <li>Address: 342 Surabaya Open Street, East Java</li>
                            <li>Hours: Mon-Fri 08:00 - 17:00</li>
                        </ul>
                    </div>
                    <div class="location-info">
                        <h4 class="px-4 py-3 font-bold cursor-pointer hover:text-green-500 office-location" data-location="gresik">
                            <i class="mdi mdi-plus mr-2"></i>Gresik
                        </h4>
                        <ul class="pl-10 pr-4 py-3 text-sm text-gray-500 border-t office-address hidden">
                            <li>Phone: 085655479868</li>
                            <li>Email: anggadarkprince@gmail.com</li>
                            <li>Address: Gresik Avenue 62, East Java</li>
                            <li>Hours: Mon-Fri 08:30 - 19:00</li>
                        </ul>
                    </div>
                    <div class="location-info">
                        <h4 class="px-4 py-3 font-bold cursor-pointer hover:text-green-500 office-location" data-location="sidoarjo">
                            <i class="mdi mdi-plus mr-2"></i>Sidoarjo
                        </h4>
                        <ul class="pl-10 pr-4 py-3 text-sm text-gray-500 border-t office-address hidden">
                            <li>Phone: 085655479868</li>
                            <li>Email: anggadarkprince@gmail.com</li>
                            <li>Address: Sidoargo Misgard 52, East Java</li>
                            <li>Hours: Mon-Sat 09:00 - 18:30</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <style>
            a[href^="http://maps.google.com/maps"]{display:none !important}
            a[href^="https://maps.google.com/maps"]{display:none !important}

            .gmnoprint a, .gmnoprint span, .gm-style-cc {
                display:none;
            }
        </style>
        <script>
            const locations = {
                surabaya: { lat: -7.2574719, lng: 112.7520883 },
                gresik: { lat: -7.156576, lng: 112.655472 },
                sidoarjo: { lat: -7.472613, lng: 112.667542 },
            }
            let map;
            function initMap() {
                map = new google.maps.Map(document.getElementById("map-location"), {
                    zoom: 14,
                    center: {...locations.surabaya, lng: locations.surabaya.lng - 0.02},
                    controlSize: 24,
                    streetViewControl: false,
                    mapTypeControl: false,
                });
                new google.maps.Marker({
                    position: locations.surabaya,
                    map,
                    title: "Head Quarter",
                });
                new google.maps.Marker({
                    position: locations.gresik,
                    map,
                    title: "Sub Quarter Gresik",
                });
                new google.maps.Marker({
                    position: locations.sidoarjo,
                    map,
                    title: "Sub Quarter Sidoarjo",
                });
            }

            document.querySelectorAll('.office-location').forEach(officeLocation => {
                officeLocation.addEventListener('click', function () {
                    const location = this.dataset.location;
                    const newLocation = locations[location || 'surabaya'];
                    //if (map) map.setCenter({...newLocation, lng: newLocation.lng - 0.02});
                    if (map) map.panTo({...newLocation, lng: newLocation.lng - 0.02});

                    const lastSection = document.querySelector('.location-info.active');
                    lastSection.querySelector('.office-location').classList.remove('text-green-500');
                    lastSection.querySelector('.office-address').classList.add('hidden');
                    lastSection.classList.remove('active');

                    const currentSection = this.closest('.location-info');
                    currentSection.classList.add('active');
                    currentSection.querySelector('.office-location').classList.add('text-green-500');
                    currentSection.querySelector('.office-address').classList.remove('hidden');
                })
            });
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg4esaS2P9dXK7ApOBTdXcnfBy2heCKhw&callback=initMap&libraries=&v=weekly" async></script>
        <div class="px-4 py-8 max-w-6xl mx-auto">
            <div class="flex flex-col text-center md:text-left md:flex-row md:justify-between">
                <div class="mb-5 md:mb-0 md:pr-3">
                    <h3 class="font-bold text-lg">Our News Letter</h3>
                    <p class="leading-tight text-gray-500">Sign up for industry alerts, news & insight</p>
                </div>
                <form action="#" method="post" class="mb-5 md:mb-0">
                    @csrf
                    <div class="block md:inline-block">
                        <input id="name" name="name" type="text" class="bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:w-auto md:mb-0 focus:border-green-500 @error('name') border-red-500 @enderror"
                               placeholder="Your name" value="{{ old('name') }}" required maxlength="100" aria-label="name">
                    </div>
                    <div class="block md:inline-block">
                        <input id="email" name="email" type="email" class="bg-white border-gray-300 appearance-none block border outline-none py-2 px-4 mb-2 rounded-sm w-full md:w-auto md:mb-0 focus:border-green-500 @error('email') border-red-500 @enderror"
                               placeholder="Email address" value="{{ old('email') }}" required maxlength="100" aria-label="email">
                    </div>
                    <div class="block md:inline-block">
                        <button type="submit" class="py-2 px-5 rounded-sm bg-green-500 text-white transition duration-200 hover:bg-green-600">
                            Submit Now!
                        </button>
                    </div>
                </form>
                <div>
                    <a href="#" class="py-2 px-3 inline-block border border-gray-300 rounded-sm hover:bg-blue-700 hover:text-white hover:border-transparent"><i class="mdi mdi-facebook"></i></a>
                    <a href="#" class="py-2 px-3 inline-block border border-gray-300 rounded-sm hover:bg-blue-400 hover:text-white hover:border-transparent"><i class="mdi mdi-twitter"></i></a>
                    <a href="#" class="py-2 px-3 inline-block border border-gray-300 rounded-sm hover:bg-indigo-600 hover:text-white hover:border-transparent"><i class="mdi mdi-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
