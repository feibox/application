<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Krucas\Notification\Facades\Notification;

class LogoutIfBannedOrTerminated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!is_null($user) && ($user->is_terminated || $user->is_banned)) {
            Auth::logout();
            Notification::error('Your account has been '.(($user->is_banned) ? 'banned' : 'terminated').'.');

            return redirect('login');
        }

        return $next($request);
    }
}
