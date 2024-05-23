@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Enter OTP') }}</div>

                    <div class="card-body">
                        <!-- عرض رسالة النجاح أو الخطأ -->
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

<form action="/verifyOTP" method="post" >
    @csrf
                        <div class="row mb-3">
                            <label for="otp">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror" name="OTP" value="{{ old('OTP') }}" required autocomplete="otp" autofocus>

                                @error('otp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
    <input type="submit" class="btn btn-success" value="Verify">
</form>
                        <br>
 <!-- زر لإعادة إرسال OTP -->
                        <form method="POST" action="{{ route('resend.otp') }}" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Resend OTP</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

