<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCustomerRequest;
use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

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
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $customers = Customer::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($customers);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param SaveCustomerRequest $request
     * @return JsonResponse
     */
    public function store(SaveCustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $customer,
                'message' => "Customer successfully created"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified customer.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param SaveCustomerRequest $request
     * @param Customer $customer
     * @return JsonResponse
     */
    public function update(SaveCustomerRequest $request, Customer $customer)
    {
        try {
            $customer->fill($request->validated());
            $customer->saveOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $customer,
                'message' => "Customer successfully updated"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json([
                'status' => 'success',
                'data' => $customer,
                'message' => "Customer successfully deleted"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
