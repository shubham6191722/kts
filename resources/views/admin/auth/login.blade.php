@extends('admin.auth.layouts.common')

@section('title', 'Sign In')

@section('content')
    <div class="login-signin">
        <div class="mb-20">
            <h3>Sign In</h3>
            <div class="text-muted font-weight-bold">Enter your details to login to your account</div>
        </div>

        <form class="form" id="kt_login_signin_form" method="POST" action="{{ route('admin.dologin') }}">
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" autocomplete="off" />
            </div>
            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                <div class="checkbox-inline">
                    <label class="checkbox m-0 text-muted">
                        <input type="checkbox" name="remember_me" id="remember_me" {{ old('remember_me') ? 'checked' : '' }} />
                        <span></span>Remember me</label>
                </div>
                <a href="{{ route('admin.showForgotPasswordForm') }}" id="kt_login_forgot" class="text-muted text-hover-primary">Forgotten Password?</a>
            </div>
            <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
            @csrf
        </form>
    </div>
@stop