<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/" href="{!!site_favicon!!}">
    <title>@yield('title') | {!!site_title!!}</title>

    <link rel="stylesheet" href="{{url('assets/frontend')}}/plugins/css/plugins.css">
    <link href="{{url('assets/frontend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('assets/frontend')}}/css/intlTelInput.css" rel="stylesheet">
    <link href="{{url('assets/frontend')}}/css/fontawesome.min.css" rel="stylesheet">
    <link href="{{url('assets/frontend')}}/css/jquery-ui.min.css" rel="stylesheet">
    <link href="{{url('assets/frontend')}}/css/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="{{url('assets/frontend')}}/css/style.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" id="jssDefault" href="{{url('assets/frontend')}}/css/colors/green-style.css">
    <link type="text/css" rel="stylesheet" href="{{url('assets/frontend')}}/css/custom.css">
    {!! RecaptchaV3::initJs() !!}

    @yield('headerscripts')
</head>

@php
    $routename = \Request::route()->getName();
    $menuExpanded = (($routename=='home.index' ) ? true:false);
@endphp


<body>
    <div class="Loader"></div>
    <div class="wrapper">
        @yield('content')
    </div>

    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/jquery-ui.min.js"></script>
    <script src="{{url('assets/frontend')}}/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/viewportchecker.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/bootsnav.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/select2.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/datedropper.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/dropzone.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/loader.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/slick.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/gmap3.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/jquery.easy-autocomplete.min.js"></script>
    <script src="{{url('assets/frontend')}}/js/custom.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/plugins/js/counterup.min.js"></script>
    <script src="{{url('assets/frontend')}}/js/jQuery.style.switcher.js"></script>
    <script src="{!!url('assets/backend')!!}/js/loadingoverlay.min.js"></script>
    <script src="{!!url('assets/backend')!!}/js/loadingoverlay_progress.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/parsley.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/intlTelInput.min.js"></script>
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/jquery.mask.js"></script>
    <script>
        function openRightMenu() {
            document.getElementById("rightMenu").style.display = "block";
        }

        function closeRightMenu() {
            document.getElementById("rightMenu").style.display = "none";
        }
    </script>

    <link href="{{url('assets/frontend')}}/css/toastr.css" rel="stylesheet"/>
    <script src="{{url('assets/frontend')}}/js/toastr.js"></script>

    @if(Auth::check())

    @else

        <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content new-logwrap new-logwrap-custom w-100 new-logwrap-login new-logwrap-l-j-r">
                    <div class="modal-header custom-modal-header-close-btn position-relative justify-content-center">
                        <h4>Login</h4>
                        <button type="button" class="btn-close" id="applyjob_close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="login_form"  method="POST" enctype="multipart/form-data">
                            <div>
                            @csrf
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-with-icon">
                                            <input type="email" class="form-control" placeholder="Enter Your Email" name="c_email" id="l_email" required autocomplete="off">
                                            <i class="theme-cl ti-email"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-with-icon">
                                            <input type="password" class="form-control" placeholder="Enter Your Password" name="c_password" id="l_password" required autocomplete="off">
                                            <input type="hidden" name="job_id" id="job_id" value="@if(isset($id) && !empty($id)){!! $id !!}@endif">
                                            <i class="theme-cl ti-lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="login_otp">
                                    <div class="m-b-20 d-flex justify-content-start ">
                                        <div class="text-custom-dark">We have sent a 6 digit one time passcode to your mobile phone</div>
                                    </div>
                                    <div class="input-group d-block form-group position-relative mb-0">
                                        <div class="custom-file">
                                            <label>One time passcode *</label>
                                            <div class="input-with-icon  display-eeror-msg">
                                                <input type="number" class="form-control" placeholder="OTP" name="otp" id="otp_login" value="" data-parsley-required-message="Please Enter Your OTP" data-parsley-remote-validator="otpRegister" data-parsley-multiple-of="6" maxlength = "6" data-parsley-length="[6,6]" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autocomplete="off">
                                                <i class="theme-cl ti-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-space-between m-b-25">
                                        <div>
                                        Time left <span id="logintimer"></span>
                                        </div>
                                        <div>
                                            <button type="button" onclick="loginReSendOtp()" class="resendOtp" id="login_resendOtp" disabled> Resend OTP </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="error-message error_message"></div>

                                <div class="form-groups">
                                    <input type="hidden" name="page" value="back">
                                    <button type="button" class="btn btn-primary theme-bg full-width text-capitalize" id="login_submit_otp">Login</button>
                                    <button type="button" class="btn btn-primary theme-bg full-width text-capitalize" id="login_submit" style="display: none;">Login</button>
                                </div>
                            </div>
                        </form>

                        <div class="forget-account text-center">
                            <a class="theme-cl" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#forgot_password" data-bs-dismiss="modal">Forgotten Password?</a>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-center pb-0">
                        <div class="register-account text-center m-0">
                            Don't have an account? <a class="theme-cl" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#register" data-bs-dismiss="modal" id="register_btn_1">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content new-logwrap new-logwrap-register w-100 new-logwrap-l-j-r">
                    <div class="modal-header custom-modal-header-close-btn position-relative justify-content-center">
                        <h4>Register</h4>
                        <button type="button" class="btn-close" id="applyjob_close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register_form" action="{{route('candidateRegister')}}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="job_id" id="job_id" value="@if(isset($id) && !empty($id)){!! $id !!}@endif">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <div class="input-with-icon display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Enter Your First Name" name="c_username" id="c_username" value="{{ old('c_username') }}" required data-parsley-required-message="Please Enter Your First Name">
                                            <i class="theme-cl ti-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Enter Your Last Name" name="c_lastname" id="c_lastname" value="{{ old('c_lastname') }}" required data-parsley-required-message="Please Enter Your Last Name">
                                            <i class="theme-cl ti-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="tel" class="form-control" placeholder="Enter Your Phone Number" name="c_number" id="c_number" value="{{ old('c_number') }}" required data-parsley-required-message="Please Enter Your Phone Number" data-parsley-type="number">
                                            {{-- <i class="theme-cl fa fa-phone"></i> --}}
                                        </div>
                                        <input type="hidden" id="c_code" name="c_code" value="44">
                                        <input type="hidden" id="country_code" name="country_code" value="gb">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="email" class="form-control" placeholder="Enter Your Email" name="c_email" id="c_email" value="{{ old('c_email') }}" required data-parsley-required-message="Please Enter Your Email">
                                            <i class="theme-cl ti-email"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="password" class="form-control" placeholder="Enter Your Password" name="c_password" id="c_password" required data-parsley-required-message="Please Enter Your Password" data-parsley-minlength="6">
                                            <i class="theme-cl ti-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="c-checkbox m-b-10">
                                <input type="checkbox" id="talent_pool" name="talent_pool" value="1" checked>
                                <label for="talent_pool" class="custom-label"> Show as active on the talent pool</label>
                            </div>
                            <div class="c-checkbox m-b-10">
                                @php
                                    $url = "home.termsCondition";
                                    $route = route($url);
                                @endphp
                                <input type="checkbox" id="job_condition" name="job_condition" value="1" required checked>
                                <label for="job_condition" class="custom-label"> I agree to the re:Source Talent <a href="{!! $route !!}" target="_blank">Terms & Conditions View terms of use</a></label>
                            </div>

                            <div class="error-message error_message"></div>

                            <div class="form-groups text-center">
                                <button type="submit" class="btn btn-primary theme-bg w-100 text-capitalize mt-2" id="register_submit_otp">Register</button>
                            </div>
                        </form>
                        <div class="register-account text-center mrg-top-20 mb-0">
                            Already have an account? <a class="theme-cl" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#login" data-bs-dismiss="modal">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade bd-example-modal-lg" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content new-logwrap new-logwrap-register w-100 new-logwrap-l-j-r">
                    <div class="modal-header custom-modal-header-close-btn position-relative justify-content-center">
                        <h4>Register</h4>
                        <button type="button" class="btn-close" id="applyjob_close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="register_form" action="{{route('candidateRegister')}}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="job_id" id="job_id" value="@if(isset($id) && !empty($id)){!! $id !!}@endif">
                            <div class="row">
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <div class="input-with-icon display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Enter Your First Name" name="c_username" id="c_username" value="{{ old('c_username') }}" required data-parsley-required-message="Please Enter Your First Name">
                                            <i class="theme-cl ti-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Enter Your Last Name" name="c_lastname" id="c_lastname" value="{{ old('c_lastname') }}" required data-parsley-required-message="Please Enter Your Last Name">
                                            <i class="theme-cl ti-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-8 col-md-8 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="tel" class="form-control" placeholder="Enter Your Phone Number" name="c_number" id="c_number" value="{{ old('c_number') }}" required data-parsley-required-message="Please Enter Your Phone Number" data-parsley-type="number">
                                        </div>
                                        <input type="hidden" id="c_code" name="c_code" value="44">
                                        <input type="hidden" id="country_code" name="country_code" value="gb">
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="email" class="form-control" placeholder="Enter Your Email" name="c_email" id="c_email" value="{{ old('c_email') }}" required data-parsley-required-message="Please Enter Your Email">
                                            <i class="theme-cl ti-email"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="password" class="form-control" placeholder="Enter Your Password" name="c_password" id="c_password" required data-parsley-required-message="Please Enter Your Password" data-parsley-minlength="6">
                                            <i class="theme-cl ti-lock"></i>
                                        </div>
                                    </div>
                                </div>


                                <!-- hide start -->
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group register_select">
                                        <label>Location</label>
                                        <div class="input-with-icon line-height-0">
                                            @php
                                                $r_region = App\Models\Region::getSelectValue();
                                                $r_region_old = '';
                                                if(old('c_loction')){
                                                    $r_region_old = old('c_loction');
                                                }
                                            @endphp
                                            <select class="form-control select2" name="c_loction" id="c_loction" required data-parsley-required-message="Please Seletc Your Loction">
                                                <option selected></option>
                                                @if(!empty($r_region))
                                                    @foreach($r_region as $SKey => $r_value)
                                                        <option value="{!! $r_value->region_id !!}" @if($r_value->region_id == $r_region_old) selected @endif>{!! $r_value->region !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <i class="theme-cl fa fa-map-marker z-index-9999"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Town</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Enter Your Town" name="c_town" id="c_town" value="{{ old('c_town') }}" required data-parsley-required-message="Please Enter Your Town">
                                            <i class="theme-cl ti-home"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Salary</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="number" class="form-control" placeholder="eg £45000" name="salary" id="c_salary" value="{{ old('salary') }}" required data-parsley-required-message="Please Enter Your Salary">
                                            <i class="theme-cl fa fa-pound-sign"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group register_select">
                                        <label>Notice Period</label>
                                        <div class="input-with-icon line-height-0">
                                            @php
                                                $noticeperiod_old = '';
                                                if(old('noticeperiod')){
                                                    $noticeperiod_old = old('noticeperiod');
                                                }
                                            @endphp
                                            <select class="form-control select2" id="r_noticeperiod" name="noticeperiod" required data-parsley-required-message="Please Select Your Notice Period">
                                                <option>&nbsp;</option>
                                                <option value="Available Now"  @if('Available Now' == $noticeperiod_old) selected @endif>Available Now</option>
                                                <option value="1 Weeks Notice" @if('1 Weeks Notice' == $noticeperiod_old) selected @endif>1 Weeks Notice</option>
                                                <option value="2 Weeks Notice" @if('2 Weeks Notice' == $noticeperiod_old) selected @endif>2 Weeks Notice</option>
                                                <option value="1 Months Notice" @if('1 Months Notice' == $noticeperiod_old) selected @endif>1 Months Notice</option>
                                                <option value="2 Months Notice" @if('2 Months Notice' == $noticeperiod_old) selected @endif>2 Months Notice</option>
                                                <option value="3 Months Notice" @if('3 Months Notice' == $noticeperiod_old) selected @endif>3 Months Notice</option>
                                                <option value="6 months Notice" @if('6 months Notice' == $noticeperiod_old) selected @endif>6 months Notice</option>
                                            </select>
                                            <i class="theme-cl fa fa-tasks z-index-9999"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group register_select register_select_2">
                                        <label>Work preference</label>
                                        <div class="input-with-icon line-height-0">
                                            @php
                                                $workbasepreference_old = array();
                                                if(old('workbasepreference')){
                                                    $workbasepreference_old = old('workbasepreference');
                                                }
                                            @endphp
                                            <select class="form-control select2" id="r_workbasepreference" name="workbasepreference[]" multiple required data-parsley-required-message="Please Select Your Work preference">
                                                <option value="Office" @if(in_array('Office', $workbasepreference_old)) selected @endif>Office</option>
                                                <option value="Remote" @if(in_array('Remote', $workbasepreference_old)) selected @endif>Remote</option>
                                                <option value="Hybrid" @if(in_array('Hybrid', $workbasepreference_old)) selected @endif>Hybrid</option>
                                            </select>
                                            <i class="theme-cl fa fa-tasks z-index-9999"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                    <div class="form-group register_select">
                                        <label>Job Specialism</label>
                                        <div class="input-with-icon line-height-0">
                                            @php
                                                $r_job_category = App\Models\JobCategory::getAll();
                                                $sector_old = '';
                                                if(old('sector')){
                                                    $sector_old = old('sector');
                                                }
                                            @endphp
                                            <select class="form-control select2" id="r_categoryid" name="sector" required data-parsley-required-message="Please Select Your Job Specialism">
                                                <option>&nbsp;</option>
                                                @foreach($r_job_category as $CKey => $r_c_value)
                                                    <option value="{!! $r_c_value->category_id !!}" @if($r_c_value->category_id == $sector_old) selected @endif>{!! $r_c_value->category !!}</option>
                                                @endforeach
                                            </select>
                                            <i class="theme-cl fa fa-tasks z-index-9999"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="form-group register_select register_select_2">
                                        <label>Skill</label>
                                        <div class="input-with-icon line-height-0">
                                            <select class="form-control select2" id="r_c_s_categoryid" name="skillsrequired[]" multiple>
                                            </select>
                                            <i class="theme-cl fa fa-cogs z-index-9999"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="m-b-10">
                                        <div class="input-group d-block form-group position-relative mb-0">
                                            <div class="custom-file">
                                                <label>CV*</label>
                                                <div class="fileUpload d-flex align-items-center overflow-visible">
                                                    <input type="file" class="upload" name="cv_file" id="cv_file" accept="application/pdf,application/msword" required data-parsley-required-message="Please select CV"/>
                                                    <span class="cursor-pointer">Upload</span>
                                                    <div class="fileName d-contents">
                                                        <span id="fileName_display"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-grey"><small>Note:- (.pdf, .docx, .doc)</small></div>
                                    </div>
                                </div>
                                <!-- hide end -->
                            </div>

                            <div class="c-checkbox m-b-10">
                                <input type="checkbox" id="talent_pool" name="talent_pool" value="1" checked>
                                <label for="talent_pool" class="custom-label"> Show as active on the talent pool</label>
                            </div>
                            <div class="c-checkbox m-b-10">
                                @php
                                    $url = "home.termsCondition";
                                    $route = route($url);
                                @endphp
                                <input type="checkbox" id="job_condition" name="job_condition" value="1" required checked>
                                <label for="job_condition" class="custom-label"> I agree to the re:Source Talent <a href="{!! $route !!}" target="_blank">Terms & Conditions View terms of use</a></label>
                            </div>
                            <!-- hide start -->
                            <div class="row justify-content-center">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" id="register_otp">
                                    <div class="m-t-25 m-b-10 d-flex justify-content-start ">
                                        <div class="text-custom-dark">We have sent a 6 digit one time passcode to your mobile phone</div>
                                    </div>
                                    <div class="m-b-25">
                                        <div class="input-group d-block form-group position-relative mb-0">
                                            <div class="custom-file">
                                                <label>One time passcode *</label>
                                                <div class="input-with-icon  display-eeror-msg">
                                                    <input type="number" class="form-control" placeholder="OTP" name="otp" id="otp_register" value="" data-parsley-required-message="Please Enter Your OTP" data-parsley-remote-validator="otpRegister" data-parsley-multiple-of="6" maxlength = "6" data-parsley-length="[6,6]" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                    <i class="theme-cl ti-lock"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-space-between">
                                            <div>
                                            Time left <span id="timer"></span>
                                            </div>
                                            <div>
                                                <button type="button" onclick="registerReSendOtp()" class="resendOtp" id="register_resendOtp" disabled> Resend OTP </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- hide end -->

                            <div class="error-message error_message"></div>

                            <div class="form-groups text-center">
                                <!-- hide start -->
                                <input type="hidden" name="page" value="back">
                                <input type="hidden" name="register_sid" id="register_sid" value="">
                                <input type="hidden" name="register_serviceSid" id="register_serviceSid" value="">
                                <input type="hidden" name="register_accountSid" id="register_accountSid" value="">
                                <!-- hide end -->
                                <button type="submit" class="btn btn-primary theme-bg w-50 text-capitalize" id="register_submit_otp">Register</button>
                                <!-- hide start -->
                                <button type="button" class="btn btn-primary theme-bg w-50 text-capitalize" id="register_submit" style="display: none;">Register</button>
                                <!-- hide end -->
                            </div>
                        </form>
                        <div class="register-account text-center mrg-top-20 mb-0">
                            Already have an account? <a class="theme-cl" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#login" data-bs-dismiss="modal">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="forgot_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-0">
                    <div class="new-logwrap w-100 new-logwrap-forgot-password new-logwrap-l-j-r">
                        <div class="modal-header custom-modal-header-close-btn position-relative justify-content-center">
                            <h4>Forgot Password</h4>
                            <button type="button" class="btn-close" id="applyjob_close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('home.sendForgotPasswordRequest') }}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <div class="input-with-icon">
                                    <input type="email" class="form-control" placeholder="Enter Your Email" name="email" id="email" value="{{ old('email') }}" required>
                                    <i class="theme-cl ti-email"></i>
                                </div>
                                {!! RecaptchaV3::field('forgotpassword') !!}
                            </div>
                            <div>
                                @include('flash-message')
                            </div>

                            <div class="form-groups">
                                <button type="submit" class="btn btn-primary theme-bg full-width">Forgot Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif



    @yield('footerscripts')

    <script src="{{url('assets/frontend')}}/js/jquery.lazy.min.js"></script>
    <script src="{{url('assets/frontend')}}/js/jquery.lazy.plugins.min.js"></script>
    <script defer>
        function imageLazy() {
            $(function () {
                $(".lazyload").Lazy({
                    enableThrottle: true
                });
            });
        }
        imageLazy();
    </script>

    <script>
        $('#forgot_password').on('show.bs.modal', function() {
            getRecaptchaforgotpassword();
        });

        function getRecaptchaforgotpassword() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{env('RECAPTCHAV3_SITEKEY')}}', {action: 'forgotpassword'}).then(function(token) {
                    $('input[name=g-recaptcha-response]').val(token); // here i set value to hidden field
                });
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#cv_file').change(function(e) {
                var file = e.target.files[0].name;
                $('#fileName_display').text('');
                $('#fileName_display').text(file);
            });

            var register_form = $("form#register_form").parsley();

            var register_otp_send = $('#register_otp_send').val();

            window.Parsley.addValidator('maxFileSize', {
                validateString: function(_value, maxSize, parsleyInstance) {
                    if (!window.FormData) {
                        alert('You are making all developpers in the world cringe. Upgrade your browser!');
                        return true;
                    }
                    var files = parsleyInstance.$element[0].files;
                    return files.length != 1  || files[0].size <= maxSize * 1024;
                },
                requirementType: 'integer',
                messages: {
                    en: 'This file should not be larger than %s Kb',
                    fr: 'Ce fichier est plus grand que %s Kb.'
                }
            });

            // $( "#register_submit_otp" ).on( "click", function() {
            //     if(register_form.isValid()){
            //         var number = $('#c_number').val();
            //         var otp_send = 'register_otp_send';
            //         var hide_submit_otp = 'register_submit_otp';
            //         var show_submit_otp = 'register_submit';
            //         var otp = 'register_otp';
            //         var field_name = 'otp';
            //         var modal_name = 'register';
            //         var CountryData = $('#c_code').val();
            //         formOTPSend(number,otp_send,hide_submit_otp,show_submit_otp,otp,field_name,modal_name,CountryData);
            //     }else{
            //         register_form.validate();
            //     }
            // });

            // $( "#register_submit" ).on( "click", function() {
            //     if(register_form.isValid()){
            //         var number = $('#c_number').val();
            //         var otp_send = 'register_otp_send';
            //         var modal_name = 'register';
            //         var value = $('#otp_register').val();
            //         var CountryData = $('#c_code').val();
            //         verify(number,modal_name,otp_send,value,CountryData);
            //     }else{
            //         register_form.validate();
            //     }
            // });


        });

        $(document).ready(function() {
            var login_form = $("form#login_form").parsley();

            $( "#login_submit_otp" ).on( "click", function() {
                if(login_form.isValid()){
                    var c_email = $('#l_email').val();
                    var c_password = $('#l_password').val();
                    var hide_submit_otp = 'login_submit_otp';
                    var show_submit_otp = 'login_submit';
                    var otp = 'login_otp';
                    var modal_name = 'login';
                    var job_id = $('#job_id').val();
                    loginFormOTPSend(c_email,c_password,hide_submit_otp,show_submit_otp,otp,modal_name,job_id);
                }else{
                    login_form.validate();
                }
            });

            $( "#login_submit" ).on( "click", function() {
                if(login_form.isValid()){
                    var c_email = $('#l_email').val();
                    var c_password = $('#l_password').val();
                    var hide_submit_otp = 'login_submit_otp';
                    var show_submit_otp = 'login_submit';
                    var otp = 'login_otp';
                    var modal_name = 'login';
                    var otp_value = $('#otp_login').val();
                    var job_id = $('#job_id').val();
                    loginVerify(c_email,c_password,hide_submit_otp,show_submit_otp,otp,modal_name,otp_value,job_id);
                }else{
                    login_form.validate();
                }
            });

        });
    </script>
    <script>
        function loginFormOTPSend(c_email,c_password,hide_submit_otp,show_submit_otp,otp,modal_name,job_id) {
            
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{route('loginSendOTP')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    c_email: c_email,
                    c_password: c_password,
                    hide_submit_otp: hide_submit_otp,
                    show_submit_otp: show_submit_otp,
                    otp: otp,
                    modal_name: modal_name,
                    job_id: job_id,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    $('#'+hide_submit_otp).html('Please wait... ');
                },
                success: function(data) {
                    if (data.code == 1) {
                        // var show_submit_otp = data.show_submit_otp;
                        // var hide_submit_otp = data.hide_submit_otp;
                        // var modal_name = data.modal_name;
                        // var otp = data.otp;

                        // $('#'+otp).show();
                        // $('#'+hide_submit_otp).hide();
                        // $('#'+show_submit_otp).show();
                        // $('#otp_login').prop('required',true);

                        // logInTimer(60);
                        location.reload(true); 
                    } else if(data.code == 2) {
                        window.location.href = data.url;
                    }else {
                        $('#login_submit_otp').html('Login');
                        $('#login_submit_otp').prop('disabled',false);
                        var modal_name = data.modal_name;
                        var msg = data.msg;
                        var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>'+msg+'</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                        $('#login .error_message').html(html_data);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    $('#login_submit_otp').html('Login');
                    $('#login_submit_otp').prop('disabled',false);
                    var modal_name = data.modal_name;
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Please reload. Please try again!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#login .error_message').html(html_data);
                }
            });
        }

        function loginVerify(c_email,c_password,hide_submit_otp,show_submit_otp,otp,modal_name,otp_value,job_id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{route('loginVerifyOTP')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    c_email: c_email,
                    c_password: c_password,
                    hide_submit_otp: hide_submit_otp,
                    show_submit_otp: show_submit_otp,
                    otp: otp,
                    modal_name: modal_name,
                    otp_value: otp_value,
                    job_id: job_id,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    var button_show = modal_name+'_submit';
                    $('#'+button_show).html('Please wait... ');
                    $('#'+button_show).prop('disabled',true);
                },
                success: function(data) {
                    if (data.code == 1) {
                        if(job_id){
                            location.reload();
                        }else{
                            location.reload();
                        }
                    } else {
                        var modal_name = data.modal_name;
                        var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Invalid verification code entered!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                        $('#'+modal_name+' .error_message').html(html_data);

                        var button_show = modal_name+'_submit';
                        $('#'+button_show).html('Login');
                        $('#'+button_show).prop('disabled',false);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    var modal_name = data.modal_name;
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Invalid verification code entered!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#'+modal_name+' .error_message').html(html_data);

                    var button_show = modal_name+'_submit';
                    $('#'+button_show).html('Login');
                    $('#'+button_show).prop('disabled',false);
                }
            });
        }

        function loginReSendOtp() {
            $('#otp_login').prop('required',false);
            $( "#login_submit_otp" ).trigger( "click" );
        }

        let loginTimerOn = true;

        function logInTimer(remaining) {
            $('#login_resendOtp').prop('disabled',true);
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('logintimer').innerHTML = m + ':' + s;
            remaining -= 1;

            if(remaining >= 0 && loginTimerOn) {
                setTimeout(function() {
                    logInTimer(remaining);
                }, 1000);
                return;
            }

            if(!loginTimerOn) {
                // Do validate stuff here
                return;
            }

            // Do timeout stuff here
            $('#login_resendOtp').prop('disabled',false);
        }
    </script>

    {{-- <script>
        function formOTPSend(number,otp_send,hide_submit_otp,show_submit_otp,otp,field_name,modal_name,CountryData) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{route('sendOTP')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    number: number,
                    otp_send: otp_send,
                    hide_submit_otp: hide_submit_otp,
                    show_submit_otp: show_submit_otp,
                    otp: otp,
                    field_name: field_name,
                    modal_name: modal_name,
                    CountryData: CountryData,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    $('#'+hide_submit_otp).html('Please wait... ');
                    $('#'+hide_submit_otp).prop('disabled',true);
                },
                success: function(data) {
                    if (data.code == 1) {
                        var number = data.number;
                        var otp_send = data.otp_send;
                        var hide_submit_otp = data.hide_submit_otp;
                        var show_submit_otp = data.show_submit_otp;
                        var otp = data.otp;
                        var field_name = data.field_name;
                        var modal_name = data.modal_name;

                        var otp_field = modal_name+'_'+field_name;
                        var otp_field_required = field_name+'_'+modal_name;

                        $('#'+otp_field).show();
                        $('#'+hide_submit_otp).hide();
                        $('#'+show_submit_otp).show();
                        $('#'+otp_field_required).prop('required',true);

                        timer(60);

                    } else {
                        $('#'+hide_submit_otp).html('Register');
                        $('#'+hide_submit_otp).prop('disabled',false);
                        var modal_name = data.modal_name;
                        var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Please reload. Please try again!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                        $('#register .error_message').html(html_data);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    $('#'+hide_submit_otp).html('Register');
                    $('#'+hide_submit_otp).prop('disabled',false);
                    var modal_name = data.modal_name;
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Please reload. Please try again!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#register .error_message').html(html_data);
                }
            });
        }

        function verify(number,modal_name,otp_send,value,CountryData) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{route('verifyOTP')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    number: number,
                    modal_name: modal_name,
                    otp_send: otp_send,
                    value: value,
                    CountryData: CountryData,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    var button_show = modal_name+'_submit';
                    $('#'+button_show).html('Please wait... ');
                    $('#'+button_show).prop('disabled',true);
                },
                success: function(data) {
                    if (data.code == 1) {
                        var number = data.number;
                        var otp_send = data.otp_send;
                        var modal_name = data.modal_name;

                        var otp_field = modal_name+'_'+otp_send;

                        $('#'+otp_field).val('1');
                        registerSubmit();
                    } else {
                        var modal_name = data.modal_name;
                        var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Invalid verification code entered!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                        $('#'+modal_name+' .error_message').html(html_data);

                        var button_show = modal_name+'_submit';
                        $('#'+button_show).html('Register');
                        $('#'+button_show).prop('disabled',false);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    var modal_name = data.modal_name;
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Invalid verification code entered!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#'+modal_name+' .error_message').html(html_data);

                    var button_show = modal_name+'_submit';
                    $('#'+button_show).html('Register');
                    $('#'+button_show).prop('disabled',false);
                }
            });
        }

        function registerSubmit() {
            var data = new FormData(document.getElementById("register_form"));
            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('candidateRegister')}}",
                dataType: 'json',
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function() {
                },
                success: function(data) {
                    if (data.code == 1) {
                        location.reload();
                    } else {
                        var modal_name = data.modal_name;
                        var msg = data.msg;
                        var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>'+msg+'</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                        $('#'+modal_name+' .error_message').html(html_data);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    var modal_name = data.modal_name;
                    var msg = data.msg;
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>Please reload. Please try again!</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#'+modal_name+' .error_message').html(html_data);
                }
            });


        }

        function registerReSendOtp() {
            $('#otp_register').prop('required',false);
            $( "#register_submit_otp" ).trigger( "click" );
        }

        let timerOn = true;

        function timer(remaining) {
            $('#register_resendOtp').prop('disabled',true);
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML = m + ':' + s;
            remaining -= 1;

            if(remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if(!timerOn) {
                // Do validate stuff here
                return;
            }

            // Do timeout stuff here
            $('#register_resendOtp').prop('disabled',false);
        }
    </script> --}}

    <script>
        $('body').on('change', '#r_categoryid', function() {
            var id = $(this).val();
            rcategoryIdAction(id);
        });

        function rcategoryIdAction(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{route('rCategoryidGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    $('#r_c_s_categoryid').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {
                        if (data.stage_data !='') {
                            var option = '';
                            var html1 = '';
                            $(data.skillList).each(function(index,item) {
                                html1 += '<option value="' + item.id +'" >' +item.skill_name +'</option>';
                            });

                            $('#r_c_s_categoryid').append(html1).trigger('change');
                            $('#r_c_s_categoryid').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            html1 += '';
                            $('#r_c_s_categoryid').append(html1).trigger('change');
                            $('#r_c_s_categoryid').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        }

                    } else {
                        show_toastr('error',data.msg, '');
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                }
            });
        }
    </script>

    @if(Auth::check())

    @else
        <script>
            let input = document.querySelector("#c_number");

            let iti = intlTelInput(input, {
                initialCountry: "gb",
                separateDialCode: true,
                nationalMode: false,
            });

            $(window).on("load", function() {
                intlTelInputGlobals.loadUtils("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.1/js/utils.js");
            });

            input.addEventListener("countrychange", function() {
                var code = iti.getSelectedCountryData().dialCode;
                var c_code = iti.getSelectedCountryData().iso2;
                $('#c_code').val(code);
                $('#country_code').val(c_code);
            });

        </script>
    @endif

    {{-- <script>
        $(function() {

            @if(Session::get('info'))
                show_toastr("info", "{{ Session::get('info') }}", "");
                <?php Session::forget('info'); ?>
            @endif

            @if(Session::get('warning'))
                show_toastr("warning", "{{ Session::get('warning') }}", "");
                <?php Session::forget('warning'); ?>
            @endif

            @if(Session::get('success'))
                show_toastr("success", "{{ Session::get('success') }}", "");
                <?php Session::forget('success'); ?>
            @endif

            @if(Session::get('error'))
                show_toastr("error", "{{ Session::get('error') }}", "");
                <?php Session::forget('error'); ?>
            @endif

            @if($errors->any())
                show_toastr("error", "{{$errors-> first()}}", "");
            @endif

        });
    </script> --}}
    @if(Session::get('open_application') && Session::get('open_application') == "On")
    <script>

        $(function () {

                var modal_name = '{{Session::get("modal_name")}}';
                var error_message = '{{Session::get("error_msg")}}';
                var success_message = '{{Session::get("success_msg")}}';
                if(error_message != ''){
                    var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>'+error_message+'</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#'+modal_name+' .error_message').html(html_data);
                }
                if(success_message != ''){
                    var html_data = '<div class="alert alert-success alert-block d-flex justify-content-space-between"><strong>'+success_message+'</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                    $('#'+modal_name+' .error_message').html(html_data);
                }
                var myModal = new bootstrap.Modal(document.getElementById(modal_name));
                myModal.show();

                setTimeout(function () {
                    var categoryid = "{{old('sector')}}";
                    rcategoryIdAction(categoryid);

                    $('#r_categoryid').select2({
                        placeholder: "Please Select...",
                    });
                    $('#r_c_s_categoryid').select2({
                        placeholder: "Please Select...",
                    });
                    $('#c_loction').select2({
                        placeholder: "Please Select...",
                    });
                    $('#r_workbasepreference').select2({
                        placeholder: "Please Select...",
                    });
                    $('#r_noticeperiod').select2({
                        placeholder: "Please Select...",
                    });

                }, 200);
                <?php Session::forget('open_application'); Session::forget('success_msg'); Session::forget('modal_name'); Session::forget('error_msg'); ?>
        });
    </script>
    @endif

    @if(!empty(Session::get('open_application_job')) && Session::get('open_application_job') == "On")
        <script>
            $(function () {
                var error_message = '{{Session::get("error_msg")}}';
                var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>'+error_message+'</strong><button type="button" class="close fl-right border-0 position-absolute right-10" data-bs-dismiss="alert">×</button></div>';
                $('#applyjob .error_message').html(html_data);

                var myModal = new bootstrap.Modal(document.getElementById("applyjob"));
                myModal.show();
                <?php Session::forget('open_application_job'); Session::forget('error_msg'); ?>
            });
        </script>
    @endif

    @if(Session::get('modalOpen') && Session::get('modalOpen') == "yes")
        <script>

            $(function () {
                var myModal = new bootstrap.Modal(document.getElementById('applyjob'));
                myModal.show();
                <?php Session::forget('modalOpen'); Session::forget('modal_name'); Session::forget('error_msg'); ?>
            });
        </script>
    @endif

</body>

</html>
