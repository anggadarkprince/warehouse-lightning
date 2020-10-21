<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @return View
     */
    public function index(Request $request)
    {
        $roles = Role::withCount('permissions as permission_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return view('role.index', compact('roles'));
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
                    "message" => "Role {$role->role} successfully created"
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => "Create user role failed"
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
                    "message" => "Role {$role->role} successfully updated"
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => "Update user role failed"
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
                "message" => "Role {$role->role} successfully deleted"
            ]);
        } catch (Throwable $e) {
            return redirect()->back()->with([
                "status" => "failed",
                "message" => "Delete user role failed"
            ]);
        }
    }
}
