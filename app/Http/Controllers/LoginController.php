<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where(['email' => $googleUser->email]);
        if ($user->exists()) {
            $user = $user->first();
        } else {
            $avatarPath = '';
            if (!empty($googleUser->avatar)) {
                $contents = file_get_contents($googleUser->avatar);
                $avatarPath = 'avatars/' . date('Ym') . '/' . basename($googleUser->avatar);
                Storage::disk('public')->put($avatarPath, $contents, 'public');
            }
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random()),
                'avatar' => $avatarPath ?: null,
            ]);
        }

        Auth::login($user);
        return redirect(config('fortify.home'));
    }
}
