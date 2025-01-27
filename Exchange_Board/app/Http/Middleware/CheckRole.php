<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); 

        if ($user->hasRole('admin')) {
            // Log::info('admin');
            return $next($request); 
        } elseif ($user->hasRole('agent')) {
            // Log::info('agent');
            return $next($request); 
        } elseif ($user->hasRole('market')){
            // Log::info('market');
            return $next($request); 
        } elseif ($user->hasRole('client')){
            // Log::info('agent');
            return $next($request); 
        }
        
        return $next($request);
    }
}
