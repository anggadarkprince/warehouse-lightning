<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCustomerRequest;
use App\Models\Customer;
use App\Export\CollectionExporter;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the customer.
     *
     * @param Request $request
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $customers = Customer::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($customers->cursor(), [
                'title' => 'Customer Data',
                'fileName' => 'Customers.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
        } else {
            $customers = $customers->paginate();
            return view('customer.index', compact('customers'));
        }
    }

    /**
     * Show the form for creating a new customer.
     *
     * @return View
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param SaveCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(SaveCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return redirect()->route('customers.index')->with([
            "status" => "success",
            "message" => "Customer {$customer->customer_name} successfully created"
        ]);
    }

    /**
     * Display the specified customer.
     *
     * @param  Customer $customer
     * @return View
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  Customer $customer
     * @return View
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     *
     * @param SaveCustomerRequest $request
     * @param  Customer $customer
     * @return RedirectResponse
     */
    public function update(SaveCustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->validated());
        $customer->save();

        return redirect()->route('customers.index')->with([
            "status" => "success",
            "message" => "Customer {$customer->customer_name} successfully updated"
        ]);
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  Customer $customer
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with([
            "status" => "warning",
            "message" => "Customer {$customer->customer_name} successfully deleted"
        ]);
    }
}
