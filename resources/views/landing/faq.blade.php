@extends('layouts.landing')

@section('content')
    <div class="bg-gray-100 pt-10 pb-20">
        <div class="px-4 max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="font-bold text-3xl">Frequently Asked Questions</h1>
                <p class="text-gray-500">A list of commonly asked questions and answers </p>
            </div>

            <div class="bg-white p-20">
                <div class="border rounded divide-y" id="accordion-faq">
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer section-active text-green-500" data-toggle="collapse" data-target="#collapse-1" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> Which Plan Is Right For Me?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 item-visible" id="collapse-1">
                            With any financial product that you buy, it is important that you know you are getting the best
                            advice from a reputable company as often you will have to provide sensitive information online
                            or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-2" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> Do I have to commit to a contract?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-2">
                            With any financial product that you buy, it is important that you know you are getting the best
                            advice from a reputable company as often you will have to provide sensitive information online
                            or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-3" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> What Payment Methods Are Available?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-3">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-4" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> What if I pick the wrong plan?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-4">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-5" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> Any contracts or commitments?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-5">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-6" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> What are my payment options?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-6">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-7" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> How does the free trial work?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-7">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-8" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> When should I receive my Shipment?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-8">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-9" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> How do I cancel my Shipment?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-9">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-10" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> Why does my Shipment take so long?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-10">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-11" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> What do you mean by Tracking?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-11">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold py-3 px-4 cursor-pointer" data-toggle="collapse" data-target="#collapse-12" data-parent="#accordion-faq" data-active-class="text-green-500">
                            <i class="mdi mdi-chevron-down mr-2"></i> Is my Shipment safe?
                        </h3>
                        <div class=" px-12 mb-5 text-gray-500 hidden" id="collapse-12">
                            With any financial product that you buy, it is important that you know you are getting the
                            best advice from a reputable company as often you will have to provide sensitive information
                            online or over the internet.
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.querySelectorAll('[data-toggle="collapse"]').forEach(collapsibleItem => {
                    collapsibleItem.addEventListener('click', function () {
                        const target = this.dataset.target;
                        const parent = this.dataset.parent;
                        const activeClass = this.dataset.activeClass || 'active';
                        const targetItem = document.querySelector(target);
                        const parentContainer = document.querySelector(parent);
                        if (targetItem.classList.contains('hidden')) {
                            parentContainer.querySelectorAll('.item-visible').forEach(showingItem => {
                                showingItem.classList.add('hidden');
                                showingItem.classList.remove('item-visible');
                                showingItem.classList.remove(activeClass);
                            });
                            parentContainer.querySelectorAll('.section-active').forEach(activeItem => {
                                activeItem.classList.remove('section-active');
                                activeItem.classList.remove(activeClass);
                            });
                            targetItem.classList.remove('hidden');
                            targetItem.classList.add('item-visible');
                            this.classList.add('section-active');
                            this.classList.add(activeClass);
                        }
                    });
                });
            </script>
        </div>
    </div>
@endsection
