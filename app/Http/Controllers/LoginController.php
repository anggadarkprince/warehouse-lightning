<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $googleUser = $this->getProviderUser('google');

        Auth::login($googleUser);

        return redirect(config('fortify.home'));
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     */
    public function handleFacebookCallback()
    {
        $facebookUser = $this->getProviderUser('facebook');

        Auth::login($facebookUser);

        return redirect(config('fortify.home'));
    }

    /**
     * Get user from returned provider.
     *
     * @param $provider
     * @return mixed
     */
    private function getProviderUser($provider)
    {
        $userProvider = Socialite::driver($provider)->user();

        $user = User::where(['email' => $userProvider->email]);
        if ($user->exists()) {
            $user = $user->first();
        } else {
            $avatarPath = '';
            if (!empty($userProvider->avatar)) {
                $contents = file_get_contents($userProvider->getAvatar());
                $avatarPath = 'avatars/' . date('Ym') . '/' . $userProvider->getId() . '.jpg';
                Storage::disk('public')->put($avatarPath, $contents, 'public');
            }
            $user = User::create([
                'name' => $userProvider->name,
                'email' => $userProvider->email,
                'password' => bcrypt(Str::random()),
                'avatar' => $avatarPath ?: null,
            ]);
        }

        return $user;
    }
}
