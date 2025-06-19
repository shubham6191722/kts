@extends('auth.layouts.common')

@section('title', 'Sign Up')

@section('content')
    <div class="login-signup">
        <div class="mb-20">
            <h3>Sign Up</h3>
            <div class="text-muted font-weight-bold">Enter your details to create your account</div>
        </div>
        <form class="form" id="kt_login_signup_form" method="POST" action="{{ route('register') }}">
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Your Firstname" name="fname" value="{{ old('fname') }}" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Your Lastname" name="lname" value="{{ old('lname') }}" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" value="{{ old('email') }}" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" autocomplete="off" />
            </div>
            <div class="form-group mb-5">
                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="password_confirmation" autocomplete="off" />
            </div>
            <div class="form-group mb-5 text-left">
                <div class="checkbox-inline">
                    <label class="checkbox m-0">
                        <input type="checkbox" name="agree" />
                        <span></span>I Agree the
                        <a href="#" class="font-weight-bold ml-1">terms and conditions</a>.</label>
                </div>
                <div class="form-text text-muted text-center"></div>
            </div>
            <div class="form-group d-flex flex-wrap flex-center mt-10">
                @csrf
                <button type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
                <a href="{!!url('/')!!}" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2" >Cancel</a>
            </div>
        </form>
    </div>
@stop