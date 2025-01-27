<?php

namespace App\Http\Middleware;

use App\Events\MarketStatusUpdated;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $user->last_seen = Carbon::now();
    //         $user->save();
    //         // Log::info();
    //         event(new MarketStatusUpdated($user, true));
    //     }
    //     return $next($request);
    // }
}
