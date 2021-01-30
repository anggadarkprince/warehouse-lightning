<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $token = $user->createToken('Login')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login request access and refresh token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $http = new Client();

        try {
            $response = $http->post(env('APP_URL') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                    'username' => $email,
                    'password' => $password,
                    'scope' => '*'
                ],
            ]);

            $tokens = json_decode((string)$response->getBody(), true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                return response()->json('Invalid email/password combination', 401);
            }
            throw $e;
        } catch (GuzzleException $e) {
            return response()->json('Cannot request for authentication', 500);
        }

        return response()->json($tokens);
    }

    /**
     * Login request access and refresh token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function token(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        $http = new Client();

        try {
            $response = $http->post(env('APP_URL') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                    'scope' => '*'
                ],
            ]);

            $tokens = json_decode((string)$response->getBody(), true);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                return response()->json('Refresh token invalid or expired', 401);
            }
            throw $e;
        } catch (GuzzleException $e) {
            return response()->json('Cannot request for authentication', 500);
        }

        return response()->json($tokens);
    }

    /**
     * Returns Authenticated User Details
     *
     * @return JsonResponse
     */
    public function user()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
