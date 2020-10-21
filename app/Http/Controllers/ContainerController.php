<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveContainerRequest;
use App\Models\Container;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return View
     */
    public function index(Request $request)
    {
        $containers = Container::q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return view('container.index', compact('containers'));
    }

    /**
     * Show the form for creating a new container.
     *
     * @return View
     */
    public function create()
    {
        return view('container.create');
    }

    /**
     * Store a newly created container in storage.
     *
     * @param  SaveContainerRequest $request
     * @return RedirectResponse
     */
    public function store(SaveContainerRequest $request)
    {
        $container = Container::create($request->validated());

        return redirect()->route('containers.index')->with([
            "status" => "success",
            "message" => "Container {$container->container_number} successfully created"
        ]);
    }

    /**
     * Display the specified container.
     *
     * @param  Container $container
     * @return View
     */
    public function show(Container $container)
    {
        return view('container.show', compact('container'));
    }

    /**
     * Show the form for editing the specified container.
     *
     * @param  Container $container
     * @return View
     */
    public function edit(Container $container)
    {
        return view('container.edit', compact('container'));
    }

    /**
     * Update the specified container in storage.
     *
     * @param  SaveContainerRequest $request
     * @param  Container $container
     * @return RedirectResponse
     */
    public function update(SaveContainerRequest $request, Container $container)
    {
        $container->fill($request->validated());
        $container->save();

        return redirect()->route('containers.index')->with([
            "status" => "success",
            "message" => "Container {$container->container_number} successfully updated"
        ]);
    }

    /**
     * Remove the specified container from storage.
     *
     * @param  Container $container
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Container $container)
    {
        $container->delete();

        return redirect()->route('containers.index')->with([
            "status" => "warning",
            "message" => "Container {$container->container_number} successfully deleted"
        ]);
    }
}
