<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Laravel\Socialite\Facades\Socialite;
// use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('google-login'),
                     // placeholder
                ]);
                $user->assignRole('user');
            }

            Auth::login($user);

            if ($user->hasRole('admin')) {
                return redirect()->route('home')->with('success', 'Đăng nhập Google thành công!');
            }
    
            return redirect('/')->with('success', 'Đăng nhập Google thành công!');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}
