@extends('layouts.material-login')
@section('title', 'Verifikasi Akun E-Mail anda')
@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body"> -->
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Kami telah mengirim email berisi link untuk memverifikasi akun Email anda.') }}<br>
                    {{ __('Jika Anda tidak menerima email') }}, <a href="{{ route('verification.resend') }}">{{ __('Klik link ini untuk mengirim ulang email') }}</a>.
                <!-- </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
