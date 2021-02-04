<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $roles = Role::withCount('permissions as permission_total')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($roles);
    }

    /**
     * Store a newly created role in storage.
     *
     * @param SaveRoleRequest $request
     * @return JsonResponse
     */
    public function store(SaveRoleRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $role = Role::create($request->except('permissions'));

                $role->permissions()->attach(
                    $request->input('permissions')
                );

                return response()->json([
                    'status' => 'success',
                    'data' => $role->load('permissions'),
                    'message' => __("Role :role successfully created", [
                        'role' => $role->role
                    ])
                ]);
            });
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Create role :role failed", [
                    'role' => $request->input('role')
                ])
            ], 500);
        }
    }

    /**
     * Display the specified role.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role)
    {
        return response()->json([
            'data' => $role
        ]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param SaveRoleRequest $request
     * @param Role $role
     * @return JsonResponse
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

                return response()->json([
                    'status' => 'success',
                    'data' => $role->with('permissions'),
                    'message' => __("Role :role successfully updated", [
                        'role' => $role->role
                    ])
                ]);
            });
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Update role :role failed", [
                    'role' => $role->role
                ])
            ], 500);
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return response()->json([
                'status' => 'success',
                'data' => $role,
                'message' => __("Role :role successfully deleted", [
                    'role' => $role->role
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete role :role failed", [
                    'role' => $role->role
                ])
            ], 500);
        }
    }
}
