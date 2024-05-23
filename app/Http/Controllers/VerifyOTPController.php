<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class VerifyOTPController extends Controller
{


    public function verifyOTP(request $request)
    {

if (request('OTP')==Cache::get('OTP')) {


    auth()->user()->update(['isVerified'=>true]);
    return redirect('/home');
}
    }

    public function showVerifyForm()
    {
return view('OTP.verify');

    }

    public function resendOTP(Request $request)
    {
        $user = auth()->user();
        $result = $user->resendOTP();
        if ($result) {
            // تم إعادة إرسال OTP بنجاح
            return back()->with('message', 'Resend OTP successfully');
        } else {
            // حدث خطأ في إعادة إرسال OTP
            return back()->with('error', 'Error while resend OTP');
        }
    }




}
