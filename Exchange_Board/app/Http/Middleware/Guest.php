<?php

namespace App\Http\Middleware;

use App\Models\Guest as ModelsGuest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $request->merge(['user_id' => $request->user()->hash_id]);
        } else {
            $ip = $request->ip();
            $guest = ModelsGuest::where('ip', $ip)->first();
            
            if (!$guest) {
                $guest = ModelsGuest::create([
                    'hash_id' => Str::random(10),
                    'ip' => $ip,
                ]);
            }
            
            $request->merge(['user_id' => $guest->hash_id]);
        }

        return $next($request);
    }
}
