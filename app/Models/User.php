<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\OTPMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isVerified',
        'taxnumber',
        'mobnumber',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function OTP(){
        return Cache::get($this->OTPKey());
    }

public function OTPKey()
{
return "OTP_for_{$this->id}";
}
public function cashTheOTP()
{
    $OTP = rand(100000, 999999);
    Cache::put(['OTP'=>$OTP], now()->addMinute(1));
return $OTP;
}


    public function sentOTP()
    {
$email = $this->email;


        Mail::to($email)->send(new OTPMail($this->cashTheOTP()));

    }

    public function Document()
    {
        return $this->hasOne('App\Models\Document');
    }

    public function resendOTP()
    {
        $email = $this->email;
        Mail::to($email)->send(new OTPMail($this->cashTheOTP()));
        return true;
    }


}
