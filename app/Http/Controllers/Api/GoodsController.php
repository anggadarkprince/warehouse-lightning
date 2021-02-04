<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveGoodsRequest;
use App\Models\Goods;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GoodsController extends Controller
{
    /**
     * GoodsController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Goods::class);
    }

    /**
     * Display a listing of the goods.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $goods = Goods::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($goods);
    }

    /**
     * Store a newly created goods in storage.
     *
     * @param SaveGoodsRequest $request
     * @return JsonResponse
     */
    public function store(SaveGoodsRequest $request)
    {
        try {
            $goods = Goods::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $goods,
                'message' => "Goods successfully created"
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errorInfo ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified goods.
     *
     * @param Goods $goods
     * @return JsonResponse
     */
    public function show(Goods $goods)
    {
        return response()->json([
            'data' => $goods
        ]);
    }

    /**
     * Update the specified goods in storage.
     *
     * @param SaveGoodsRequest $request
     * @param Goods $goods
     * @return JsonResponse
     */
    public function update(SaveGoodsRequest $request, Goods $goods)
    {
        try {
            $goods->fill($request->input());
            $goods->saveOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $goods,
                'message' => "Goods successfully updated"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified goods from storage.
     *
     * @param Goods $goods
     * @return JsonResponse
     */
    public function destroy(Goods $goods)
    {
        try {
            $goods->delete();
            return response()->json([
                'status' => 'success',
                'data' => $goods,
                'message' => "Goods successfully deleted"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'Something went wrong'
            ], 500);
        }
    }
}
