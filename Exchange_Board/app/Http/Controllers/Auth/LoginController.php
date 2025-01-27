<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    public function login(Request $request){
        Log::info('startedLoginCustom');
        $hashId = $request->input('hash_id');
        $password = $request->input('password');
        $user = User::where('hash_id', $hashId)->firstOrFail();
        $isSuccess = password_verify($password, $user->password);
        Log::info('passCustom', [$isSuccess]);
        if($isSuccess){
            Auth::login($user);
        }
        return  $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());        
    }
    
}
