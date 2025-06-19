@extends('admin.auth.layouts.common')

@section('title', 'Reset Password')

@section('content')
    <div class="login-forgot">
        <div class="mb-20">
            <h3>Reset Password</h3>
            <div class="text-muted font-weight-bold">Enter your new password to reset.</div>
        </div>
        <form class="form" id="kt_login_forgot_form" method="POST" action="{{ route('admin.submitResetPassword') }}">
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="New Password" name="new_password" autocomplete="off" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="renew_password" autocomplete="off" />
            </div>
            <div class="form-group d-flex flex-wrap flex-center mt-10">
                <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Reset Password</button>
            </div>
            <input type="hidden" name="token" value="{!!$token!!}">
            @csrf
        </form>
    </div>
@stop