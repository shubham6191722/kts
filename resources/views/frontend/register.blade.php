@extends('frontend.layouts.common')

@section('title', 'Register')

@section('headerscripts')

@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title lazyload" data-src="{{url('assets/frontend')}}/img/bn2.jpg" data-overlay="6">
        <div class="container">
            <h1>Create And Account</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="tab-sec gray">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-12 m-auto">
                <div class="new-logwrap">
                    <div class="tab-content">
                        <div id="candidate" class="tab-pane fade in active">
                            <form class="form" action="{{ route('candidateRegister') }}" method="POST" id="candidate_form">
                                @csrf
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <div class="input-with-icon">
                                        <input type="text" class="form-control" placeholder="Enter Your Full Name" name="c_username" id="c_username" value="{{ old('c_username') }}" required>
                                        <i class="theme-cl ti-user"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-with-icon">
                                        <input type="email" class="form-control" placeholder="Enter Your Email" name="c_email" id="c_email" value="{{ old('c_email') }}" required>
                                        <i class="theme-cl ti-email"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-with-icon">
                                        <input type="number" class="form-control" placeholder="Enter Your Phone Number" name="c_number" id="c_number" value="{{ old('c_number') }}" required>
                                        <i class="theme-cl fa fa-phone"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Town</label>
                                    <div class="input-with-icon">
                                        <input type="text" class="form-control" placeholder="Enter Your Town" name="c_town" id="c_town" value="{{ old('c_town') }}" required>
                                        <i class="theme-cl ti-home"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-with-icon">
                                        <input type="password" class="form-control" placeholder="Enter Your Password" name="c_password" id="c_password" required>
                                        <i class="theme-cl ti-lock"></i>
                                    </div>
                                </div>

                                <label class="checkbox-custom mb-3">
                                    <input type="checkbox" name="c_terms" name="c_terms" id="c_terms" required>Terms & Conditions
                                </label>

                                <div class="register-account text-center">
                                    By hitting the <span class="theme-cl">"Register"</span> button, you agree to the <a class="theme-cl" href="javascript:void(0)" data-toggle="modal" data-target="#terms_conditions">Terms conditions</a> and <a class="theme-cl" href="javascript:void(0)" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a>
                                </div>

                                <div class="form-groups">
                                    <input type="submit" id="submitbtn" class="btn btn-primary theme-bg full-width" value="Register">
                                </div>

                                <div class="register-account text-center mt-5">
                                    Already have an account? <a class="theme-cl" href="{{route('candidateLogin')}}">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footerscripts')
    <script>
        $(document).ready(function() {

            $("#candidate_form").validate();
            $("#client_form").validate();
        });
    </script>
@stop