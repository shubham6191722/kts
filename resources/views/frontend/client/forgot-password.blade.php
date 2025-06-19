@extends('frontend.layouts.common')

@section('title', 'Forgot Password')

@section('headerscripts')

@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title" style="background-image:url({{url('assets/frontend')}}/img/bn2.jpg);">
        <div class="container">
            <h1>Forgot Password</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="tab-sec gray">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                <div class="new-logwrap">
                    <form class="form" action="{{ route('home.sendForgotPasswordRequest') }}" method="POST" id="client_form">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-with-icon">
                                <input type="email" class="form-control" placeholder="Enter Your Email" name="email">
                                <i class="theme-cl ti-email"></i>
                            </div>
                        </div>

                        <div class="form-groups">
                            <button type="submit" class="btn btn-primary theme-bg full-width">Request</button>
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
