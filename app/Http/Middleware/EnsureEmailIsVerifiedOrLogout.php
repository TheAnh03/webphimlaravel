<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerifiedOrLogout
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return redirect()->back()
                ->with('error', 'Chức năng này bị hạn chế do bạn chưa xác minh tài khoản.');
        }

        return $next($request);
    }
}
