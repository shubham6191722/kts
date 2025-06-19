@extends('frontend.layouts.common')

@section('title', 'Candidate Login')

@section('headerscripts')

@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title" style="background-image:url({{url('assets/frontend')}}/img/bn2.jpg);">
        <div class="container">
            <h1>Candidate Login</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="tab-sec gray">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                <div class="new-logwrap">

                    <form class="form" action="{{ route('candidateLoginCheck') }}" method="POST" id="client_form">
                        @csrf
                        <input type="hidden" name="page" value="home"/>
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-with-icon">
                                <input type="email" class="form-control" placeholder="Enter Your Email" name="c_email" required>
                                <i class="theme-cl ti-email"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-with-icon">
                                <input type="password" class="form-control" placeholder="Enter Your Password" name="c_password" required>
                                <i class="theme-cl ti-lock"></i>
                            </div>
                        </div>

                        <div class="register-account text-center">
                            By hitting the <span class="theme-cl">"Login"</span> button, you agree to the <a class="theme-cl" href="javascript:void(0)" data-toggle="modal" data-target="#terms_conditions">Terms conditions</a> and <a class="theme-cl" href="javascript:void(0)" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a>
                        </div>

                        <div class="form-groups">
                            <button type="submit" class="btn btn-primary theme-bg full-width">Login</button>
                        </div>

                        <div class="register-account text-center mt-5">
                            Don't have an account? <a class="theme-cl" href="{{route('getRegister')}}">Register</a>
                        </div>

                        <div class="register-account text-center mt-5">
                            <a class="theme-cl" href="{{route('user.showForgotPasswordForm')}}">Forgotten Password?</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@stop

@section('footerscripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@stop