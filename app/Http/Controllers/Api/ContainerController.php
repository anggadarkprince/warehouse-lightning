<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveContainerRequest;
use App\Models\Container;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ContainerController extends Controller
{
    /**
     * ContainerController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Container::class);
    }

    /**
     * Display a listing of the container.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $containers = Container::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($containers);
    }

    /**
     * Store a newly created container in storage.
     *
     * @param SaveContainerRequest $request
     * @return JsonResponse
     */
    public function store(SaveContainerRequest $request)
    {
        try {
            $container = Container::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $container,
                'message' => "Container successfully created"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified container.
     *
     * @param Container $container
     * @return JsonResponse
     */
    public function show(Container $container)
    {
        return response()->json([
            'data' => $container
        ]);
    }

    /**
     * Update the specified container in storage.
     *
     * @param SaveContainerRequest $request
     * @param Container $container
     * @return JsonResponse
     */
    public function update(SaveContainerRequest $request, Container $container)
    {
        try {
            $container->update($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $container,
                'message' => "Container successfully updated"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified container from storage.
     *
     * @param Container $container
     * @return JsonResponse
     */
    public function destroy(Container $container)
    {
        try {
            $container->delete();
            return response()->json([
                'status' => 'success',
                'data' => $container,
                'message' => "Container successfully deleted"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
