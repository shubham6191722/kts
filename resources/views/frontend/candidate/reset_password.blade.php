@extends('frontend.layouts.common')

@section('title', 'Reset Password')

@section('headerscripts')

@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title" style="background-image:url({{url('assets/frontend')}}/img/bn2.jpg);">
        <div class="container">
            <h1>Reset Password</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="tab-sec gray">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                <div class="new-logwrap">
                    <form class="form" action="{{ route('home.submitResetPassword') }}" method="POST" id="client_form">
                        @csrf
                        <div class="form-group">
                            <label>New Password</label>
                            <div class="input-with-icon">
                                <input type="password" class="form-control" placeholder="New Password" name="new_password" autocomplete="off">
                                <i class="theme-cl ti-email"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div class="input-with-icon">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="renew_password" autocomplete="off">
                                <i class="theme-cl ti-email"></i>
                            </div>
                        </div>
                        <div>
                            @include('flash-message')
                        </div>

                        <div class="form-groups">
                            <input type="hidden" name="token" value="{!!$token!!}">
                            {!! RecaptchaV3::field('resetpassword') !!}
                            <button type="submit" class="btn btn-primary theme-bg full-width">Reset Password</button>
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
