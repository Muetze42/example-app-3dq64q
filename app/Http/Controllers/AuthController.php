<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = (bool) $request->input('remember', false);

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);

            return redirect()->back();
        }

        return redirect()->back()->withErrors(['email' => __('auth.failed')]);
    }
}
