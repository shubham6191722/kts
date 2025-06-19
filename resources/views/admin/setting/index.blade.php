@extends('admin.layouts.common')

@section('title', 'Settings')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
@stop

@section('content')

@php
    $route_name = App\CustomFunction\CustomFunction::role_name();
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                            <li class="nav-item mr-3">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tab_my_account_setting">
                                    <span class="nav-icon">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-text font-size-lg">My Account</span>
                                </a>
                            </li>
                            <li class="nav-item mr-3">
                                <a class="nav-link" data-toggle="tab" href="#kt_tab_user_change_password">
                                    <span class="nav-icon">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476" />
                                                    <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) " />
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-text font-size-lg">Change Password</span>
                                </a>
                            </li>

                            @if(Auth::check())
                                @if(Auth::user()->role == 1)
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_user_settings">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Site Settings</span>
                                        </a>
                                    </li>

                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_user_social">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z" fill="#000000"/>
                                                            <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="11" rx="1"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Social Link</span>
                                        </a>
                                    </li>

                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_footer">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M3.5,3 L5,3 L5,19.5 C5,20.3284271 4.32842712,21 3.5,21 L3.5,21 C2.67157288,21 2,20.3284271 2,19.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z" fill="#000000"/>
                                                            <path d="M6.99987583,2.99995344 L19.754647,2.99999303 C20.3069317,2.99999474 20.7546456,3.44771138 20.7546439,3.99999613 C20.7546431,4.24703684 20.6631995,4.48533385 20.497938,4.66895776 L17.5,8 L20.4979317,11.3310353 C20.8673908,11.7415453 20.8341123,12.3738351 20.4236023,12.7432941 C20.2399776,12.9085564 20.0016794,13 19.7546376,13 L6.99987583,13 L6.99987583,2.99995344 Z" fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Footer</span>
                                        </a>
                                    </li>

                                @endif
                            @endif

                            @if(Auth::check())
                                @if(Auth::user()->role == 2)
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_user_profile">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Logo</span>
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if(Auth::check())
                                @if(Auth::user()->role == 2)
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_user_membership">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Membership Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_my_job_detail_setting">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Job Detail Settings</span>
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if(Auth::check())
                                @if(Auth::user()->role != 4)
                                    <li class="nav-item mr-3">
                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_outlook_set_up">
                                            <span class="nav-icon">
                                                <span class="svg-icon">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </span>
                                            <span class="nav-text font-size-lg">Outlook Integration</span>
                                        </a>
                                    </li>
                                @endif
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab-content">
                        <div class="show active tab-pane px-7" id="kt_tab_my_account_setting" role="tabpanel">
                            <form class="form" method="POST" action="{{ route($route_name.'.accountSetting')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="fname" value="{!! old('fname',Auth::user()->name) !!}" placeholder="First Name" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-at"></i>
                                                            </span>
                                                        </div>
                                                        <input type="email" name="email" class="form-control form-control-lg form-control-solid" value="{!! old('email',Auth::user()->email) !!}" placeholder="Email" @if(Auth::check()) @if(Auth::user()->role != 1) readonly @endif @endif />
                                                    </div>
                                                    <span class="form-text text-muted">Email will not be publicly displayed.</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid" value="{!! old('phone',Auth::user()->phone) !!}" placeholder="Phone Number"/>
                                                    </div>
                                                </div>
                                                @if(Auth::check())
                                                    @if(Auth::user()->role == 1)
                                                        <div class="form-group">
                                                            <label>Company Name</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <input type="text" name="company_name" class="form-control form-control-lg form-control-solid" value="{!! old('company_name',Auth::user()->company_name) !!}" placeholder="Company Name"/>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer pb-0 mt-10 pl-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane px-7" id="kt_tab_user_change_password" role="tabpanel">
                            <form class="form" method="POST" action="{{ route($route_name.'.changePassword')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Current Password</label>
                                                    <div>
                                                        <input type="password" class="form-control form-control-lg form-control-solid mb-2" name="current_password" placeholder="Current password" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <div>
                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="new_password" placeholder="New password" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <div>
                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="confirm_password" placeholder="Confirm Password" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer pb-0 mt-10 pl-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait... 
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if(Auth::check())
                            @if(Auth::user()->role == 1)
                                <div class="tab-pane px-7" id="kt_tab_user_settings" role="tabpanel">
                                    <form class="form" method="POST" action="{{ route($route_name.'.site.setting')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Site Title</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="site_title" value="{!!old('site_title', $siteSetting->site_title)!!}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Site Notification Email</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="site_notification_email" value="{!!old('site_notification_email', $siteSetting->site_notification_email)!!}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Site Header Logo <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="site_header_logo_file" accept="image/png, image/jpeg" id="site_header_logo_file" />
                                                                <label class="custom-file-label" for="site_header_logo_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($siteSetting->site_header_logo) && file_exists('uploads/site_setting/'.$siteSetting->site_header_logo))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="site_header_logo" value="{!!$siteSetting->site_header_logo!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f; width: 30%;">
                                                                    <img src="{!!url('uploads').'/site_setting/'.$siteSetting->site_header_logo!!}" class="img-fluid" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label>Site Favicon <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="site_favicon_file" accept="image/png, image/jpeg" id="site_favicon_file" />
                                                                <label class="custom-file-label" for="site_favicon_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($siteSetting->site_favicon) && file_exists('uploads/site_setting/'.$siteSetting->site_favicon))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="site_favicon" value="{!!$siteSetting->site_favicon!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f; width: 30%;">
                                                                    <img src="{!!url('uploads').'/site_setting/'.$siteSetting->site_favicon!!}" class="img-fluid"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label>User Manual</label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="user_user_manual" accept="application/pdf" id="user_user_manual" />
                                                                <label class="custom-file-label" for="user_user_manual">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($siteSetting->user_manual) && file_exists('uploads/site_setting/'.$siteSetting->user_manual))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="user_manual" value="{!!$siteSetting->user_manual!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <a href="{!!url('uploads').'/site_setting/'.$siteSetting->user_manual!!}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 icon-bold" target="_blank" data-theme="dark" data-html="true" title="File" data-toggle="tooltip"> 
                                                                    <span class="svg-icon svg-icon-md">
                                                                        <i class="icon toast-title text-dark flaticon-download"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label>Email Logo <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="site_email_file" accept="image/png, image/jpeg" id="site_email_file" />
                                                                <label class="custom-file-label" for="site_email_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" value="{!!$siteSetting->id!!}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($siteSetting->site_email_logo) && file_exists('uploads/site_setting/'.$siteSetting->site_email_logo))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="site_email_logo" value="{!!$siteSetting->site_email_logo!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f; width: 30%;">
                                                                    <img src="{!!url('uploads').'/site_setting/'.$siteSetting->site_email_logo!!}" class="img-fluid"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label>Resource Talent Logo <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="site_talent_file" accept="image/png, image/jpeg" id="site_talent_file" />
                                                                <label class="custom-file-label" for="site_talent_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" value="{!!$siteSetting->id!!}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($siteSetting->site_talent_logo) && file_exists('uploads/site_setting/'.$siteSetting->site_talent_logo))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="site_talent_logo" value="{!!$siteSetting->site_talent_logo!!}" />
                                                        <div class="col-md-12 col-12 mt-1">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f; width: 30%;">
                                                                    <img src="{!!url('uploads').'/site_setting/'.$siteSetting->site_talent_logo!!}" class="img-fluid"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane px-7" id="kt_tab_user_social" role="tabpanel">
                                    <form class="form" method="POST" action="{{ route($route_name.'.social.setting')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Facebook Link</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="facebook_link" value="{!!old('facebook_link', $siteSetting->facebook_link)!!}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Instagram Link</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="lnstagram_link" value="{!!old('lnstagram_link', $siteSetting->lnstagram_link)!!}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>LinkedIn Link</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="twitter_link" value="{!!old('twitter_link', $siteSetting->twitter_link)!!}" />
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" value="{!!$siteSetting->id!!}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane px-7" id="kt_tab_footer" role="tabpanel">
                                    <form class="form" method="POST" action="{{ route('rats-5768.footerSave')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="footer_address" value="{!!old('footer_address', $siteSetting->footer_address)!!}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Copyright Text</label>
                                                            <div>
                                                                <input type="text" class="form-control form-control-lg form-control-solid mb-2" name="footer_copy_text" value="{!!old('footer_copy_text', $siteSetting->footer_copy_text)!!}" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Site Footer Logo <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="site_footer_logo_file" accept="image/png, image/jpeg" id="site_footer_logo_file" />
                                                                <label class="custom-file-label" for="site_footer_logo_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                        @if(!empty($siteSetting->site_footer_logo) && file_exists('uploads/site_setting/'.$siteSetting->site_footer_logo))
                                                            <div class="row justify-content-center align-items-center">
                                                                <input type="hidden" name="site_footer_logo" value="{!!$siteSetting->site_footer_logo!!}" />
                                                                <div class="col-md-12 col-12">
                                                                    <div class="text-left">
                                                                        <div class="d-inline-block" style="padding: 25px;background: #9f9f9f;">
                                                                            <img src="{!!url('uploads').'/site_setting/'.$siteSetting->site_footer_logo!!}" class="img-fluid" style="width: 150px;"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <input type="hidden" name="id" value="{!!$siteSetting->id!!}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if(Auth::check())
                            @if(Auth::user()->role == 2)
                                <div class="tab-pane px-7" id="kt_tab_user_profile" role="tabpanel">
                                    <form class="form" method="POST" action="{{ route($route_name.'.clientProfile')}}" enctype="multipart/form-data">
                                        @csrf
                                        @php
                                            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                                $id = Auth::user()->created_user_id;
                                            }else{
                                                $id = Auth::user()->id;
                                            }
                                            $client_data = App\Models\user::find($id);
                                            $company_logo = $client_data->company_logo;
                                            $cover_image = $client_data->cover_image;
                                        @endphp
                                        <input type="hidden"name="id" value="{!! $id !!}"/>
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Company Logo <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 150px,height 75px)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="company_logo_file" accept="image/png, image/jpeg" id="site_header_logo_file" />
                                                                <label class="custom-file-label" for="company_logo_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($company_logo) && file_exists('uploads/client_profile/'.$company_logo))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="company_logo" value="{!!$company_logo!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f;width: 30%;">
                                                                    <img src="{!!url('uploads').'/client_profile/'.$company_logo!!}" class="img-fluid"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-xl-7">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-3">
                                                            <label>Cover Image <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 1920px,height 600px)</small></label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="cover_image_file" accept="image/png, image/jpeg" id="cover_image_file" />
                                                                <label class="custom-file-label" for="cover_image_file">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                @if(!empty($cover_image) && file_exists('uploads/client_profile/'.$cover_image))
                                                    <div class="row justify-content-center align-items-center h-100">
                                                        <input type="hidden" name="cover_image" value="{!!$cover_image!!}" />
                                                        <div class="col-md-12 col-12">
                                                            <div class="text-center">
                                                                <div class="d-inline-block" style="padding: 15px;background: #9f9f9f;width: 30%;">
                                                                    <img src="{!!url('uploads').'/client_profile/'.$cover_image!!}" class="img-fluid"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if(Auth::check())
                            @if(Auth::user()->role == 2)
                                <div class="tab-pane px-7" id="kt_tab_user_membership" role="tabpanel">
                                    <div class="row recruiter-data-span">

                                        @php
                                            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                                $id = Auth::user()->created_user_id;
                                            }else{
                                                $id = Auth::user()->id;
                                            }
                                            $client_data = App\Models\user::find($id);
                                            $sub_model = $client_data->sub_model;
                                            $sub_created = $client_data->sub_created;
                                            $sub_expires = $client_data->sub_expires;
                                            $sub_cost = $client_data->sub_cost;
                                            $sub_payment_terms = $client_data->sub_payment_terms;
                                            $company_credits = $client_data->company_credits;
                                            $credits_expire = $client_data->credits_expire;
                                            $user_manual = $client_data->user_manual;
                                        @endphp

                                        @if(isset($sub_model) && !empty($sub_model))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Subscription Model</span>
                                                    <div class="fw-semibold text-gray-400">{!! $sub_model !!}</div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(isset($sub_created) && !empty($sub_created))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Subscription Created</span>
                                                    <div class="fw-semibold text-gray-400">{!! $sub_created !!}</div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(isset($sub_expires) && !empty($sub_expires))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Subscription Expires</span>
                                                    <div class="fw-semibold text-gray-400">{!! $sub_expires !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($sub_cost) && !empty($sub_cost))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Subscription Cost</span>
                                                    <div class="fw-semibold text-gray-400">£{!! $sub_cost !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($sub_payment_terms) && !empty($sub_payment_terms))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Payment Terms</span>
                                                    <div class="fw-semibold text-gray-400">{!! $sub_payment_terms !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($company_credits) && !empty($company_credits))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Credits Remaining</span>
                                                    <div class="fw-semibold text-gray-400">{!! $company_credits !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($credits_expire) && !empty($credits_expire))
                                            <div class="col-md-3">
                                                <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                    <span class="fs-4 text-gray-700 fw-bold">Credits Expire</span>
                                                    <div class="fw-semibold text-gray-400">{!! $credits_expire !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($siteSetting->user_manual) && !empty($siteSetting->user_manual))
                                            <div class="col-md-3">
                                                <a href="{!!url('uploads').'/site_setting/'.$siteSetting->user_manual!!}" target="_blank">
                                                    <div class="border border-gray-300 border-dashed rounded py-2 px-4 mb-3">
                                                        <span class="fs-4 text-gray-700 fw-bold text-body">User Manual</span>
                                                        <div class="fw-semibold text-gray-400">{!! $siteSetting->user_manual !!} <span class="svg-icon svg-icon-md ml-1"><i class="icon toast-title text-gray-400 flaticon-download"></i></span></div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif
                        @endif
                        @if(Auth::check())
                            @if(Auth::user()->role == 2)
                                @php
                                    if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                        $id = Auth::user()->created_user_id;
                                    }else{
                                        $id = Auth::user()->id;
                                    }
                                    $client_data = App\Models\ClientDetail::getData($id);
                                @endphp
                                <div class="tab-pane px-7" id="kt_tab_my_job_detail_setting" role="tabpanel">
                                    <form class="form" method="POST" action="{{ route($route_name.'.clientJobDetailSetting')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Border Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $border_color = "#ec613a";
                                                                    if(isset($client_data->border_color) && !empty($client_data->border_color)){
                                                                        $border_color = $client_data->border_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="border_color" id="border_color" class="form-control form-control-lg form-control-solid" value="{!! old('border_color',$border_color) !!}" placeholder="000000"/>
                                                                <input type="hidden" name="id" value="{!! $id !!}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Background Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $background_color = "#f5f6f7";
                                                                    if(isset($client_data->background_color) && !empty($client_data->background_color)){
                                                                        $background_color = $client_data->background_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="background_color" id="background_color" class="form-control form-control-lg form-control-solid" value="{!! old('background_color',$background_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Background Text Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $background_text_color = "#000000";
                                                                    if(isset($client_data->background_text_color) && !empty($client_data->background_text_color)){
                                                                        $background_text_color = $client_data->background_text_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="background_text_color" id="background_text_color" class="form-control form-control-lg form-control-solid" value="{!! old('background_text_color',$background_text_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Button Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $button_color = "#ec613a";
                                                                    if(isset($client_data->button_color) && !empty($client_data->button_color)){
                                                                        $button_color = $client_data->button_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="button_color" id="button_color" class="form-control form-control-lg form-control-solid" value="{!! old('button_color',$button_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Button Text Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $button_text_color = "#ffffff";
                                                                    if(isset($client_data->button_text_color) && !empty($client_data->button_text_color)){
                                                                        $button_text_color = $client_data->button_text_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="button_text_color" id="button_text_color" class="form-control form-control-lg form-control-solid" value="{!! old('button_text_color',$button_text_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Footer Background Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $footer_background_color = "#ffffff";
                                                                    if(isset($client_data->button_text_color) && !empty($client_data->footer_background_color)){
                                                                        $footer_background_color = $client_data->footer_background_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="footer_background_color" id="footer_background_color" class="form-control form-control-lg form-control-solid" value="{!! old('footer_background_color',$footer_background_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Footer Icon Color</label>
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        <i class="la la-hashtag"></i>
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    $footer_icon_color = "#ffffff";
                                                                    if(isset($client_data->footer_icon_color) && !empty($client_data->footer_icon_color)){
                                                                        $footer_icon_color = $client_data->footer_icon_color;
                                                                    }
                                                                @endphp
                                                                <input type="color" name="footer_icon_color" id="footer_icon_color" class="form-control form-control-lg form-control-solid" value="{!! old('footer_icon_color',$footer_icon_color) !!}" placeholder="000000"/>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if(Auth::check())
                            @if(Auth::user()->role != 4)
                                <div class="tab-pane px-7" id="kt_tab_outlook_set_up" role="tabpanel">
                                    @php
                                        $outlook_check = false;
                                        $user_id = App\Models\Token::getUserData(Auth::user()->id);
                                        if(isset($user_id) && !empty($user_id)){
                                            $outlook_check = true;
                                        }else{
                                            $outlook_check = false;
                                        }
                                    @endphp
                                    @if($outlook_check)
                                        <div class="d-md-flex d-block align-items-center mb-9 border rounded p-5 gap-10 text-md-left text-center">
                                            <div class="symbol symbol-50 symbol-light">
                                                <span class="symbol-label bg-transparent-i">
                                                    <img src="{!!url('assets/backend')!!}/img/outlook.png" class="img-fluid">
                                                </span>
                                            </div>
                                            @php
                                                $outlook_user = App\Models\Token::getUserData(Auth::user()->id);
                                                $outlook_email = $outlook_user->userEmail;
                                            @endphp
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <span class="font-weight-bold text-dark-75 font-size-h4 mb-1">Outlook Calender</span>
                                                <span class="font-weight-bold text-muted font-size-lg mb-1">{!! $outlook_email !!} <span class="label label-xl label-light-green label-inline ml-2">Connected</span></span>
                                                <span class="text-muted font-weight-bold">Syncs events to ReSource ATS Platform Calendar.</span>
                                            </div>
                                            <span class="font-weight-bolder text-warning py-1 font-size-lg">
                                                <a href="javascript:;" class="btn btn-light-danger disconnected_this" data-id="{!!Auth::user()->id!!}">
                                                    <i class="fas fa-trash-alt font-weight-normal icon-md mr-2"></i> Remove
                                                </a>
                                                <form action="{{ route('outlook.signOut')}}" method="post" >
                                                    <input type="hidden" name="id" value="{!!Auth::user()->id!!}" />
                                                    @csrf
                                                </form>
                                            </span>
                                        </div>
                                    @else
                                        <div class="d-md-flex d-block align-items-center mb-9 border rounded p-5 gap-10 text-md-left text-center">
                                            <div class="symbol symbol-50 symbol-light">
                                                <span class="symbol-label bg-transparent-i">
                                                    <img src="{!!url('assets/backend')!!}/img/outlook.png" class="img-fluid">
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1 mr-2">
                                                <span class="font-weight-bold text-dark-75 font-size-lg mb-1">Outlook Calender</span>
                                                <span class="text-muted font-weight-bold">View your secheduled ReSource ATS Platform tasks inside your calender with one-way sync.</span>
                                            </div>
                                            <span class="font-weight-bolder text-warning py-1 font-size-lg">
                                                <a href="{{ route('outlook.signin')}}" class="btn btn-primary font-weight-bolder" data-id="{!!Auth::user()->id!!}">
                                                    Connect
                                                </a>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="separator separator-solid separator-border-2 my-7"></div>
                                    @php
                                        $schedule_time = App\Models\ScheduleTime::findUserData(Auth::user()->id);

                                        $start_time = '';
                                        if(isset($schedule_time->start_time) && !empty($schedule_time->start_time)){
                                            $start_time = $schedule_time->start_time;
                                        }

                                        $end_time = '';
                                        if(isset($schedule_time->end_time) && !empty($schedule_time->end_time)){
                                            $end_time = $schedule_time->end_time;
                                        }
                                        
                                        $time_distance = '';
                                        if(isset($schedule_time->time_distance) && !empty($schedule_time->time_distance)){
                                            $time_distance = $schedule_time->time_distance;
                                        }
                                    @endphp
                                    <form class="form" method="POST" action="{{ route($route_name.'.businessHoursSave')}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{!! Auth::user()->id !!}">
                                        <div class="form-group row">
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="card-title">
                                                            <h3 class="card-label">Business Hours</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <label>Start</label>
                                                        <div>
                                                            <select class="form-control select2" name="start_time">
                                                                <option value="01:00" @if($start_time == '01:00') selected @endif>01:00</option>
                                                                <option value="02:00" @if($start_time == '02:00') selected @endif>02:00</option>
                                                                <option value="03:00" @if($start_time == '03:00') selected @endif>03:00</option>
                                                                <option value="04:00" @if($start_time == '04:00') selected @endif>04:00</option>
                                                                <option value="05:00" @if($start_time == '05:00') selected @endif>05:00</option>
                                                                <option value="06:00" @if($start_time == '06:00') selected @endif>06:00</option>
                                                                <option value="07:00" @if($start_time == '07:00') selected @endif>07:00</option>
                                                                <option value="08:00" @if($start_time == '08:00') selected @endif>08:00</option>
                                                                <option value="09:00" @if($start_time == '09:00') selected @endif>09:00</option>
                                                                <option value="10:00" @if($start_time == '10:00') selected @endif>10:00</option>
                                                                <option value="11:00" @if($start_time == '11:00') selected @endif>11:00</option>
                                                                <option value="12:00" @if($start_time == '12:00') selected @endif>12:00</option>
                                                                <option value="13:00" @if($start_time == '13:00') selected @endif>13:00</option>
                                                                <option value="14:00" @if($start_time == '14:00') selected @endif>14:00</option>
                                                                <option value="15:00" @if($start_time == '15:00') selected @endif>15:00</option>
                                                                <option value="16:00" @if($start_time == '16:00') selected @endif>16:00</option>
                                                                <option value="17:00" @if($start_time == '17:00') selected @endif>17:00</option>
                                                                <option value="18:00" @if($start_time == '18:00') selected @endif>18:00</option>
                                                                <option value="19:00" @if($start_time == '19:00') selected @endif>19:00</option>
                                                                <option value="20:00" @if($start_time == '20:00') selected @endif>20:00</option>
                                                                <option value="21:00" @if($start_time == '21:00') selected @endif>21:00</option>
                                                                <option value="22:00" @if($start_time == '22:00') selected @endif>22:00</option>
                                                                <option value="23:00" @if($start_time == '23:00') selected @endif>23:00</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                        <label>End</label>
                                                        <div>
                                                            <select class="form-control select2" name="end_time">
                                                                <option value="01:00" @if($end_time == '01:00') selected @endif>01:00</option>
                                                                <option value="02:00" @if($end_time == '02:00') selected @endif>02:00</option>
                                                                <option value="03:00" @if($end_time == '03:00') selected @endif>03:00</option>
                                                                <option value="04:00" @if($end_time == '04:00') selected @endif>04:00</option>
                                                                <option value="05:00" @if($end_time == '05:00') selected @endif>05:00</option>
                                                                <option value="06:00" @if($end_time == '06:00') selected @endif>06:00</option>
                                                                <option value="07:00" @if($end_time == '07:00') selected @endif>07:00</option>
                                                                <option value="08:00" @if($end_time == '08:00') selected @endif>08:00</option>
                                                                <option value="09:00" @if($end_time == '09:00') selected @endif>09:00</option>
                                                                <option value="10:00" @if($end_time == '10:00') selected @endif>10:00</option>
                                                                <option value="11:00" @if($end_time == '11:00') selected @endif>11:00</option>
                                                                <option value="12:00" @if($end_time == '12:00') selected @endif>12:00</option>
                                                                <option value="13:00" @if($end_time == '13:00') selected @endif>13:00</option>
                                                                <option value="14:00" @if($end_time == '14:00') selected @endif>14:00</option>
                                                                <option value="15:00" @if($end_time == '15:00') selected @endif>15:00</option>
                                                                <option value="16:00" @if($end_time == '16:00') selected @endif>16:00</option>
                                                                <option value="17:00" @if($end_time == '17:00') selected @endif>17:00</option>
                                                                <option value="18:00" @if($end_time == '18:00') selected @endif>18:00</option>
                                                                <option value="19:00" @if($end_time == '19:00') selected @endif>19:00</option>
                                                                <option value="20:00" @if($end_time == '20:00') selected @endif>20:00</option>
                                                                <option value="21:00" @if($end_time == '21:00') selected @endif>21:00</option>
                                                                <option value="22:00" @if($end_time == '22:00') selected @endif>22:00</option>
                                                                <option value="23:00" @if($end_time == '23:00') selected @endif>23:00</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="card-title">
                                                            <h3 class="card-label">Time Distance</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label>Start</label>
                                                        <div>
                                                            <select class="form-control select2" name="time_distance">
                                                                <option value="10" @if($time_distance == '10') selected @endif>10</option>
                                                                <option value="15" @if($time_distance == '15') selected @endif>15</option>
                                                                <option value="30" @if($time_distance == '30') selected @endif>30</option>
                                                                <option value="60" @if($time_distance == '60') selected @endif>60</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <input type="hidden" name="time_distance" value="0">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-light-primary font-weight-bold" id="kt_form_submit_button">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait... 
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footerScripts')
<script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
<script>
    $('body').on('click', '.disconnected_this', function() {
        var id = $(this).attr('data-id');
        var this_button = $(this);
        Swal.fire({
            title: "Are you sure to disconnect your outlook calendar ?",
            text: "",
            icon: "warning",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes, Disconnect it!"
        }).then(function(result) {
            if (result.value) {
                this_button.next().submit();
            }
        });
    });
    
    var KTSelect2 = function() {
        var demos = function() {
            $('.select2').select2({placeholder: "Please Select"});
        }
        return {
            init: function() {
                demos();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTSelect2.init();
    });

</script>
@stop
