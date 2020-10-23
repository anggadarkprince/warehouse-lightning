<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGoodsRequest;
use App\Export\CollectionExporter;
use App\Models\Goods;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * @param CollectionExporter $exporter
     * @return View|BinaryFileResponse|StreamedResponse
     */
    public function index(Request $request, CollectionExporter $exporter)
    {
        $goods = Goods::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            return $exporter->streamDownload($goods->cursor(), [
                'title' => 'Goods Data',
                'fileName' => 'Goods.xlsx',
                'excludes' => ['id', 'deleted_at'],
            ]);
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
