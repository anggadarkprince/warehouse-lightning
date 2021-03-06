<?php

namespace App\Http\Controllers;

use App\Exports\Exporter;
use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the role.
     *
     * @param Request $request
     * @return View|BinaryFileResponse
     */
    public function index(Request $request)
    {
        $roles = Role::withCount('permissions as permission_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            $exportPath = Exporter::simpleExportToExcel($roles->get(), [
                'title' => 'Role data',
                'excludes' => ['id', 'deleted_at']
            ]);
            return response()
                ->download(Storage::disk('local')->path($exportPath), 'Role.xlsx')
                ->deleteFileAfterSend(true);
        } else {
            $roles = $roles->paginate();
            return view('role.index', compact('roles'));
        }
    }

    /**
     * Show the form for creating a new role.
     *
     * @return View
     */
    public function create()
    {
        $permissions = Permission::orderBy('module')->orderBy('feature')->get()->groupBy([
            'module',
            function ($item) {
                return $item['feature'];
            }
        ]);
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param SaveRoleRequest $request
     * @return RedirectResponse
     */
    public function store(SaveRoleRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $role = Role::create($request->except('permissions'));

                $role->permissions()->attach(
                    $request->input('permissions')
                );

                return redirect()->route('roles.index')->with([
                    "status" => "success",
                    "message" => __("Role :role successfully created", ['role' => $role->role])
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => __("Create role :role failed", ['role' => $request->input('role')])
            ]);
        }
    }

    /**
     * Display the specified role.
     *
     * @param Role $role
     * @return View
     */
    public function show(Role $role)
    {
        $permissions = $role->permissions->groupBy([
            'module',
            function ($item) {
                return $item['feature'];
            }
        ]);
        return view('role.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param Role $role
     * @return View
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('module')->orderBy('feature')->get()->groupBy([
            'module',
            function ($item) {
                return $item['feature'];
            }
        ]);
        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param SaveRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(SaveRoleRequest $request, Role $role)
    {
        try {
            return DB::transaction(function () use ($request, $role) {
                $role->fill($request->except('permissions'));
                $role->save();

                $role->permissions()->sync(
                    $request->input('permissions')
                );

                return redirect()->route('roles.index')->with([
                    "status" => "success",
                    "message" => __("Role :role successfully updated", ['role' => $role->role])
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => __("Update role :role failed", ['role' => $role->role])
            ]);
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with([
                "status" => "warning",
                "message" => __("Role :role successfully deleted", ['role' => $role->role])
            ]);
        } catch (Throwable $e) {
            return redirect()->back()->with([
                "status" => "failed",
                "message" => __("Delete role :role failed", ['role' => $role->role])
            ]);
        }
    }
}
