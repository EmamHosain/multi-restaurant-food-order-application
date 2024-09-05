<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notification = [
            'alert-type' => 'warning',
            'message' => 'You do not access this page before you logout.'
        ];
        if (Auth::guard('client')->check()) {
            return redirect()->back()->with($notification);
        }
        return $next($request);
    }
}
