<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // LoginController.php
protected function authenticated(Request $request, $user)
{
    if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
        // Auth::logout();
        // Không dùng redirect()->route() vì nó cần auth
        return redirect('email/verify' )->with('message', 'Bạn cần xác minh email trước khi đăng nhập.');
    }

    return $user->hasRole('admin') ? redirect('/home') : redirect('/');
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
