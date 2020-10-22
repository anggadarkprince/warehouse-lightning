<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGoodsRequest;
use App\Models\Export\CollectionExporter;
use App\Models\Goods;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|BinaryFileResponse
     */
    public function index(Request $request)
    {
        $goods = Goods::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            $exportPath = CollectionExporter::simpleExportToExcel($goods->get(), 'Goods');
            return response()
                ->download(Storage::disk('local')->path($exportPath))
                ->deleteFileAfterSend(true);
        } else {
            $goods = $goods->paginate();
            return view('goods.index', compact('goods'));
        }
    }

    /**
     * Show the form for creating a new goods.
     *
     * @return View
     */
    public function create()
    {
        return view('goods.create');
    }

    /**
     * Store a newly created goods in storage.
     *
     * @param SaveGoodsRequest $request
     * @return RedirectResponse
     */
    public function store(SaveGoodsRequest $request)
    {
        $goods = Goods::create($request->validated());

        return redirect()->route('goods.index')->with([
            "status" => "success",
            "message" => "Goods {$goods->item_name} successfully created"
        ]);
    }

    /**
     * Display the specified goods.
     *
     * @param Goods $goods
     * @return View
     */
    public function show(Goods $goods)
    {
        return view('goods.show', compact('goods'));
    }

    /**
     * Show the form for editing the specified goods.
     *
     * @param Goods $goods
     * @return View
     */
    public function edit(Goods $goods)
    {
        return view('goods.edit', compact('goods'));
    }

    /**
     * Update the specified goods in storage.
     *
     * @param SaveGoodsRequest $request
     * @param Goods $goods
     * @return RedirectResponse
     */
    public function update(SaveGoodsRequest $request, Goods $goods)
    {
        $goods->fill($request->validated());
        $goods->save();

        return redirect()->route('goods.index')->with([
            "status" => "success",
            "message" => "Goods {$goods->item_name} successfully updated"
        ]);
    }

    /**
     * Remove the specified goods from storage.
     *
     * @param Goods $goods
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Goods $goods)
    {
        $goods->delete();

        return redirect()->route('goods.index')->with([
            "status" => "warning",
            "message" => "Goods {$goods->item_name} successfully deleted"
        ]);
    }
}
