<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Http\Request;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    /*
    public function boot(): void
    {
        Auth::viaRequest('hashId', function (Request $request) {
            $hashId = $request->input('hash_id');
            $user = User::where('hash_id', $hashId)->first();
            Log::info('found user', [$user]);
            return $user;
        });
    }
    */
}
