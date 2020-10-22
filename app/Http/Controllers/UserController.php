<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UpdateUser;
use App\Models\Export\CollectionExporter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
     * @return View|BinaryFileResponse
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->q($request->get('q'))
            ->sort($request->get('sort_by'), $request->get('sort_method'))
            ->dateFrom($request->get('date_from'))
            ->dateTo($request->get('date_to'));

        if ($request->get('export')) {
            $exportPath = CollectionExporter::simpleExportToExcel($users->get(), 'Users');
            return response()
                ->download(Storage::disk('local')->path($exportPath))
                ->deleteFileAfterSend(true);
        } else {
            $users = $users->paginate();
            return view('user.index', compact('users'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create()
    {
        $roles = Role::all();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param SaveUserRequest $request
     * @return RedirectResponse
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

                $user->roles()->attach($userInput['roles']);

                return redirect()->route('users.index')->with([
                    "status" => "success",
                    "message" => "User {$user->name} successfully created"
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => "Create user failed"
            ]);
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param SaveUserRequest $request
     * @param User $user
     * @return RedirectResponse
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
                    if (!empty($user['avatar'])) {
                        Storage::disk('public')->delete($user['avatar']);
                    }
                }

                $user->fill($userInput);
                $user->save();

                $user->roles()->sync($request->roles);

                return redirect()->route('users.index')->with([
                    "status" => "success",
                    "message" => "User {$user->name} successfully updated"
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => "Update user failed"
            ]);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('users.index')->with([
                "status" => "warning",
                "message" => "User {$user->name} successfully deleted"
            ]);
        } catch (Throwable $e) {
            return redirect()->back()->with([
                "status" => "failed",
                "message" => "Delete user failed"
            ]);
        }
    }
}
