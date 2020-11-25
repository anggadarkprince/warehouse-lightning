<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Setting;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class SettingController extends Controller
{
    /**
     * Show setting form.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('edit-setting', Setting::class);

        $roles = Role::all();

        return view('setting.index', compact('roles'));
    }

    /**
     * Update setting controller.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('edit-setting', Setting::class);

        $rules = [
            Setting::APP_TITLE => ['required'],
            Setting::APP_TAGLINE => ['required'],
            Setting::APP_DESCRIPTION => ['required'],
            Setting::APP_KEYWORDS => ['required'],
            Setting::APP_LANGUAGE => ['required'],
            Setting::MANAGEMENT_REGISTRATION => ['nullable'],
            Setting::DEFAULT_MANAGEMENT_GROUP => ['nullable'],
            Setting::EMAIL_SUPPORT => ['required', 'email'],
            Setting::EMAIL_BUG_REPORT => ['required', 'email'],
            Setting::MAINTENANCE_FRONTEND => ['nullable'],
        ];
        $validated = $this->validate($request, $rules);

        if (!key_exists(Setting::MANAGEMENT_REGISTRATION, $validated)) {
            $validated[Setting::MANAGEMENT_REGISTRATION] = 'off';
        }
        if (!key_exists(Setting::MAINTENANCE_FRONTEND, $validated)) {
            $validated[Setting::MAINTENANCE_FRONTEND] = 'off';
        }

        try {
            return DB::transaction(function () use ($request, $validated) {
                foreach ($validated as $key => $value) {
                    Cache::forget($key);

                    if ($value == 'on') {
                        $value = 1;
                    }
                    if ($value == 'off') {
                        $value = 0;
                    }
                    Setting::updateOrCreate(
                        ['setting_key' => $key],
                        ['setting_value' => $value],
                    );
                }
                return redirect()->route('settings')->with([
                    "status" => "success",
                    "message" => "Setting successfully updated"
                ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with([
                "status" => "failed",
                "message" => 'Update setting failed'
            ]);
        }

    }
}
