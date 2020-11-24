<?php

namespace App\Http\Controllers;

use App\Exports\CollectionExporter;
use App\Http\Requests\SaveBookingRequest;
use App\Models\Booking;
use App\Models\BookingContainer;
use App\Models\BookingType;
use App\Models\Container;
use App\Models\Customer;
use App\Models\Goods;
use App\Models\Upload;
use App\Utilities\XmlBookingParser;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    /**
     * BookingTypeController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Booking::class);
    }

    /**
     * Display a listing of the booking.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $bookings = Booking::withCount('bookingContainers as container_total')
            ->withCount('bookingGoods as goods_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($bookings->cursor(), [
                'title' => 'Booking Data',
                'fileName' => 'Bookings.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $bookings = $bookings->paginate();
            return view('bookings.index', compact('bookings'));
        }
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return View
     */
    public function create()
    {
        $customers = Customer::all();
        $uploads = Upload::doesnthave('booking')->validated()->get();
        $bookingTypes = BookingType::all();
        $containers = Container::all();
        $goods = Goods::all();

        return view('bookings.create', compact('customers', 'bookingTypes', 'uploads', 'containers', 'goods'));
    }

    /**
     * Show form import booking from formatted XML
     */
    public function import()
    {
        $customers = Customer::all();
        $uploads = Upload::doesnthave('booking')->validated()->get();

        return view('bookings.import', compact('customers', 'uploads'));
    }

    /**
     * Upload and show preview xml file content
     * @param Request $request
     * @param XmlBookingParser $bookingParser
     * @return RedirectResponse|View
     * @throws ValidationException
     */
    public function importPreview(Request $request, XmlBookingParser $bookingParser)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, ['xml' => ['required', 'file', 'max:2000', 'mimes:xml']]);

            $file = $request->file('xml');
            $path = $file->store('temp');
            if ($path === false) {
                return redirect()->back()->with([
                    'status' => 'failed',
                    'message' => __('Upload file failed, try again later')
                ]);
            }
            return redirect()->route('bookings.xml-preview', ['file' => base64_encode($path)]);
        } else {
            $uploads = Upload::doesnthave('booking')->validated()->get();

            $path = base64_decode($request->get('file'));
            $booking = $bookingParser->parse(storage_path('app/' . $path));

            if (!empty($booking)) {
                if (Booking::where('reference_number', $booking['reference_number'])->count()) {
                    return redirect()->route('bookings.import')->with([
                        'status' => 'failed',
                        'message' => __('Booking with reference ' . $booking['reference_number'] . ' already exist')
                    ]);
                }

                return view('bookings.preview', compact('booking', 'uploads'));
            } else {
                return redirect()->route('bookings.import')->with([
                    'status' => 'failed',
                    'message' => __('Invalid xml file')
                ]);
            }
        }
    }

    /**
     * Save imported xml.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function storeImport(Request $request)
    {
        $xml = base64_decode($request->input('xml'));
        $moveXmlTo = 'xml/' . date('Y/m/') . basename($xml);
        if (Storage::exists($moveXmlTo)) {
            Storage::delete($moveXmlTo);
        }
        if (Storage::copy($xml, $moveXmlTo)) {
            $request->merge(['xml_file' => $moveXmlTo]);
        } else {
            abort(500, __('Move xml file failed'));
        }

        return DB::transaction(function () use ($request) {
            $upload = Upload::find($request->input('upload_id'));
            $request->merge([
                'customer_id' => $upload->customer_id,
                'booking_type_id' => $upload->booking_type_id,
            ]);
            $booking = Booking::create($request->input());

            if ($request->filled('containers')) {
                $containers = collect($request->input('containers'))->map(function ($data) {
                    $container = Container::firstOrCreate(
                        ['container_number' => $data['container_number']],
                        ['container_type' => $data['container_type'], 'container_size' => $data['container_size']]
                    );
                    return [
                        'container_id' => $container->id,
                        'is_empty' => 0,
                    ];
                });
                $booking->bookingContainers()->createMany($containers->toArray());
            }

            if ($request->filled('goods')) {
                $goods = collect($request->input('goods'))->map(function ($data) {
                    $item = Goods::firstOrCreate(
                        ['item_number' => $data['item_number']],
                        [
                            'item_name' => $data['item_name'],
                            'unit_name' => $data['unit_name'],
                            'package_name' => $data['package_name'],
                            'unit_weight' => $data['weight'] / $data['unit_quantity'],
                            'unit_gross_weight' => $data['weight'] / $data['unit_quantity'],
                        ]
                    );
                    return [
                        'goods_id' => $item->id,
                        'unit_quantity' => $data['unit_quantity'],
                        'package_quantity' => $data['package_quantity'],
                        'weight' => $data['weight'],
                        'gross_weight' => $data['weight'],
                    ];
                });
                $booking->bookingGoods()->createMany($goods->toArray());
            }

            $booking->statusHistories()->create([
                'status' => Booking::STATUS_DRAFT,
                'description' => 'Initial imported booking'
            ]);

            return redirect()->route('bookings.index')->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully created"
            ]);
        });
    }

    /**
     * Return uploaded xml file.
     *
     * @param Booking $booking
     * @return BinaryFileResponse
     */
    public function xml(Booking $booking)
    {
        return response()->file(storage_path('app/' . $booking->xml_file));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param SaveBookingRequest $request
     * @return Response|RedirectResponse
     */
    public function store(SaveBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $request->merge([
                'total_gross_weight' => numeric(array_sum(array_column($request->input('goods', []), 'weight'))),
                'total_weight' => numeric(array_sum(array_column($request->input('goods', []), 'gross_weight'))),
            ]);
            $booking = Booking::create($request->input());

            $booking->bookingContainers()->createMany($request->input('containers', []));
            $booking->bookingGoods()->createMany($request->input('goods', []));

            $booking->statusHistories()->create([
                'status' => Booking::STATUS_DRAFT,
                'description' => 'Initial booking'
            ]);

            return redirect()->route('bookings.index')->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully created"
            ]);
        });
    }

    /**
     * Display the specified booking.
     *
     * @param Booking $booking
     * @return View
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param Booking $booking
     * @return View
     */
    public function edit(Booking $booking)
    {
        $customers = Customer::all();
        $uploads = Upload::doesnthave('booking')->validated()->orWhere('id', $booking->upload_id)->get();
        $bookingTypes = BookingType::all();
        $containers = Container::all();
        $goods = Goods::all();

        return view('bookings.edit', compact('booking', 'customers', 'uploads', 'bookingTypes', 'containers', 'goods'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param SaveBookingRequest $request
     * @param Booking $booking
     * @return Response|RedirectResponse
     */
    public function update(SaveBookingRequest $request, Booking $booking)
    {
        return DB::transaction(function () use ($request, $booking) {
            $request->merge([
                'total_weight' => numeric(array_sum(array_column($request->input('goods', []), 'weight'))),
                'total_gross_weight' => numeric(array_sum(array_column($request->input('goods', []), 'gross_weight'))),
            ]);
            $booking->fill($request->input());
            $booking->save();

            // sync booking containers
            $excluded = collect($request->input('containers', []))->filter(function ($container) {
                return !empty($container['id']);
            });
            $booking->bookingContainers()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('containers', []) as $container) {
                $booking->bookingContainers()->updateOrCreate(
                    ['id' => data_get($container, 'id')],
                    $container
                );
            }

            // sync booking goods
            $excluded = collect($request->input('goods', []))->filter(function ($item) {
                return !empty($item['id']);
            });
            $booking->bookingGoods()->whereNotIn('id', $excluded->pluck('id'))->delete();
            foreach ($request->input('goods', []) as $item) {
                $booking->bookingGoods()->updateOrCreate(
                    ['id' => data_get($item, 'id')],
                    $item
                );
            }

            return redirect()->route('bookings.index')->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully updated"
            ]);
        });
    }

    /**
     * Validate booking.
     *
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function validateBooking(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking->status = Booking::STATUS_VALIDATED;
            $booking->save();

            $booking->statusHistories()->create([
                'status' => Booking::STATUS_VALIDATED,
                'description' => 'Validate booking'
            ]);

            return redirect()->back()->with([
                "status" => "success",
                "message" => "Booking {$booking->booking_number} successfully validated and ready to deliver"
            ]);
        });
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param Booking $booking
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->back()->with([
            "status" => "warning",
            "message" => "Booking {$booking->booking_number} successfully deleted"
        ]);
    }
}
