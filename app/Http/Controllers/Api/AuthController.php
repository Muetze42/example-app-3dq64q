<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Get Sanctum token for API usage
     *
     * @param Request $request
     * @return array|Application|Translator|string|null
     */
    public function getToken(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api');

            return response([
                'token' => $token->plainTextToken,
                'user'  => $user
            ], Response::HTTP_CREATED);
        }

        return __('auth.failed');
    }
}
