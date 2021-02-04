<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Jobs\OptimizeUserAvatar;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'))
            ->paginate();

        return response()->json($users);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param SaveUserRequest $request
     * @return JsonResponse
     */
    public function store(SaveUserRequest $request)
    {
        try {
            $userInput = $request->except('avatar');

            $file = $request->file('avatar');
            if (!empty($file)) {
                $uploadPath = 'avatars/' . date('Ym');
                $path = $file->storePublicly($uploadPath, 'public');
                $userInput['avatar'] = $path;
            }

            return DB::transaction(function () use ($userInput) {
                $user = User::create([
                    'name' => $userInput['name'],
                    'email' => $userInput['email'],
                    'password' => bcrypt($userInput['password']),
                    'avatar' => empty($userInput['avatar']) ? null : $userInput['avatar'],
                ]);
                OptimizeUserAvatar::dispatchAfterResponse($user);

                $user->roles()->attach($userInput['roles']);

                return response()->json([
                    'status' => 'success',
                    'data' => $user->load('roles'),
                    'message' => __("User :name successfully created", [
                        'name' => $user->name
                    ])
                ]);
            });
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Create user :name failed", [
                    'name' => $request->input('name')
                ])
            ], 500);
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json([
            'data' => $user->load('roles.permissions')
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param SaveUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(SaveUserRequest $request, User $user)
    {
        try {
            return DB::transaction(function () use ($request, $user) {
                $request->whenFilled('password', function ($input) use ($request) {
                    $request->merge(['password' => bcrypt($input)]);
                });

                if ($request->isNotFilled('password')) {
                    $request->request->remove('password');
                }

                $userInput = $request->except(['avatar', 'roles', 'password_confirmation']);

                $file = $request->file('avatar');
                if (!empty($file)) {
                    $uploadPath = 'avatars/' . date('Ym');
                    $path = $file->storePublicly($uploadPath, 'public');
                    $userInput['avatar'] = $path;

                    // delete old file
                    if (!empty($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                }

                $user->fill($userInput);
                $user->save();

                $user->roles()->sync($request->roles);

                $this->dispatch((new OptimizeUserAvatar($user))->delay(now()->addSeconds(10)));

                return response()->json([
                    'status' => 'success',
                    'data' => $user->load('roles'),
                    'message' => __("User :name successfully updated", [
                        'name' => $user->name
                    ])
                ]);
            });
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Update user :name failed", [
                    'name' => $user->name
                ])
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => __("User :name successfully deleted", [
                    'name' => $user->name
                ])
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("Delete user :name failed", [
                    'name' => $user->name
                ])
            ], 500);
        }
    }
}
