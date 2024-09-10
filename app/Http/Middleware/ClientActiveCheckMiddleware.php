<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientActiveCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = Auth::guard('client')->user();
        $notification = [
            'message' => 'Please wait for a minute. Admin will activate your account.',
            'alert-type' => 'warning'
        ];

        if ($client->status == 0) {
            return redirect()->route('client.dashboard')->with($notification);
        }
        return $next($request);
    }
}
