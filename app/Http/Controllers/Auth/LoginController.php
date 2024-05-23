<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

    /**
    * @param \Illuminate\Http\Request

     * @return bool
     */

    protected function attemptLogin(Request $request)
    {

        $result= $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
        if ($result) {
            $user = auth()->user();

            // تحقق مما إذا كان المستخدم موجودًا وتم التحقق منه
            if ($user->isVerified==0) {
                // أرسل OTP إذا كان المستخدم قد تم التحقق منه
                auth()->user()->sentOTP();
            }
        }

return $result;
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
