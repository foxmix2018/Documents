<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'taxnumber' => ['required', 'string', 'max:255'],
            'mobnumber' => ['required', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'taxnumber' => $data['taxnumber'],
            'mobnumber' => $data['mobnumber'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        // بعد تسجيل الدخول، إرسال OTP
        $user->sentOTP();

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function registered(Request $request, $user)
    {
        // يمكنك إضافة أي منطق إضافي هنا بعد التسجيل
    }
}

