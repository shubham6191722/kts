@extends('frontend.job_layouts.common')

@section('title', $job_data->jobtitle)

@section('headerscripts')

@stop

@section('content')
    @php
        if(isset($job_data->sub_company) && !empty($job_data->sub_company)){
            $client_data = App\Models\SubCompany::getSubCompanyData($job_data->sub_company);
        }else{
            $client_data = App\Models\User::clientData($job_data->user_select);
        }
        // $client_data = App\Models\User::clientData($job_data->user_select);
        $company_name = 'Company Name';
        $bg_image = url('assets/frontend').'/img/banner-10.jpg';
        $company_logo = url('assets/frontend').'/img/com-2.png';
        if(isset($client_data->company_name) && !empty($client_data->company_name)){
            $company_name = $client_data->company_name;
        }
        if(isset($client_data->cover_image) && !empty($client_data->cover_image)){
            $bg_image = url('uploads').'/client_profile/'.$client_data->cover_image;
        }
        if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
            $company_logo = url('uploads').'/client_profile/'.$client_data->company_logo;
        }

        $address = null;
        if(isset($client_data->address) && !empty($client_data->address)){
            $address = $client_data->address;
        }

        $border_color_class = null;
        $border_color = null;
        if(isset($client_detail->border_color) && !empty($client_detail->border_color)){
            $border_color = $client_detail->border_color;
            $border_color_class = 'header_border_color';
        }

        $background_color_class = null;
        $background_color = null;
        if(isset($client_detail->background_color) && !empty($client_detail->background_color)){
            $background_color = $client_detail->background_color;
            $background_color_class = 'menu_background_color';
        }

        $background_text_color_class = null;
        $background_text_color = null;
        if(isset($client_detail->background_text_color) && !empty($client_detail->background_text_color)){
            $background_text_color = $client_detail->background_text_color;
            $background_text_color_class = 'menu_background_text_color';
        }

        $button_color_class = null;
        $button_color = null;
        if(isset($client_detail->button_color) && !empty($client_detail->button_color)){
            $button_color = $client_detail->button_color;
            $button_color_class = 'button_color';
        }

        $button_text_color = null;
        if(isset($client_detail->button_text_color) && !empty($client_detail->button_text_color)){
            $button_text_color = $client_detail->button_text_color;
        }

        $footer_background_color_class = null;
        $footer_background_color = null;
        if(isset($client_detail->footer_background_color) && !empty($client_detail->footer_background_color)){
            $footer_background_color = $client_detail->footer_background_color;
            $footer_background_color_class = 'footer_background_color';
        }

        $footer_icon_color_class = null;
        $footer_icon_color = null;
        if(isset($client_detail->footer_icon_color) && !empty($client_detail->footer_icon_color)){
            $footer_icon_color = $client_detail->footer_icon_color;
            $footer_icon_color_class = 'footer_icon_color';
        }

        $social_media = 'd-none';
        if((isset($client_detail->facebook_url) && !empty($client_detail->facebook_url)) || (isset($client_detail->linkedin_url) && !empty($client_detail->linkedin_url)) || (isset($client_detail->youtube_url) && !empty($client_detail->youtube_url)) || (isset($client_detail->instagram_url) && !empty($client_detail->instagram_url)) || (isset($client_detail->twitter_url) && !empty($client_detail->twitter_url))){
            $social_media = 'd-block';
        }

    @endphp
    <style>
        /* .footer_background_color{
            background: {{$footer_background_color}} !important;
        }
        .footer_icon_color{
            color: {{$footer_icon_color}} !important;
        }
        .footer_icon_color:hover{
            color: {{$footer_icon_color}} !important;
            opacity: 0.6 !important;
        } */
        nav.navbar.navbar-light.bootsnav {
            background-color: #ffffff !important;
        }
        .navbar-light .navbar-toggler {
            color: #000000 !important;
        }
        nav.navbar.bootsnav ul.nav > li > a {
            color: #000000 !important;
        }
        nav.navbar.nav-tzanfer ul.nav > li > a i {
            color: #000000 !important;
        }
        @media screen and (max-width: 767px){
            nav.navbar.navbar-light.bootsnav {
                background-color: #ffffff !important;
            }
            .navbar-light .navbar-toggler {
                color: #000000 !important;
            }
            nav.navbar.bootsnav ul.nav > li > a {
                color: #000000 !important;
            }
            nav.navbar.nav-tzanfer ul.nav > li > a i {
                color: #000000 !important;
            }
        }
    </style>
    <style>
        .header_border_color{
            border-color: {!! $border_color!!} !important;
        }
        .menu_background_color{
            background-color: {!! $background_color!!} !important;
        }
        .menu_background_text_color{
            color: {!! $background_text_color!!} !important;
        }
        a.menu_background_text_color:hover{
            color: {!! $background_text_color!!} !important;
            box-shadow: 0 -1px 0 0 {!! $background_text_color!!} inset, 0 -3px 0 0 {!! $background_text_color!!} inset;
        }
        .button_color{
            border-color: {{$button_color}} !important;
            background: {{$button_color}} !important;
            color: {{$button_text_color}} !important;
        }
        .button_color{
            opacity: 1;
        }
    </style>


    @include('frontend.job_layouts.header')
    <div class="clearfix"></div>
    <section class="inner-header-title {{$border_color_class}} lazyload" data-src="{{$bg_image}}">
        <div class="container">
            {{-- <h1>{!! $company_name !!}</h1> --}}
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="detail-desc">
        <div class="container">
            <div class="ur-detail-wrap top-lay flex-direction-column top-lay-custom {{$border_color_class}}" id="job_detail_main">
                <div class="job-flex align-items-center w-100" id="job_detail_sub_1">
                    <div class="ur-detail-box">
                        <div class="ur-thumb">
                            <img src="{{ $company_logo }}" class="img-fluid" alt="" />
                        </div>
                        <div class="ur-caption">
                            <h4 class="ur-title">@if(isset($job_data->jobtitle) && !empty($job_data->jobtitle)){!! $job_data->jobtitle !!}@endif</h4>
                            @if(isset($company_name) && !empty($company_name))<p class="ur-location"><i class="fa fa-building mrg-r-5"></i>{!! $company_name !!}</p>@endif
                            <p class="ur-location"><i class="ti-location-pin mrg-r-5"></i>
                                @if(isset($job_data->altlocation) && !empty($job_data->altlocation)){!! $job_data->altlocation !!}, @endif @if(isset($job_data->locatedregion) && !empty($job_data->locatedregion)){!! App\Models\Region::regionName($job_data->locatedregion) !!}, @endif @if(isset($job_data->locatedcountry) && !empty($job_data->locatedcountry)){!! App\Models\Country::countryName($job_data->locatedcountry) !!}@endif
                            </p>
                        </div>
                    </div>

                    @if(Auth::check())
                        @if(Auth::user()->role == 5)
                            <div class="ur-detail-btn">
                                <button type="button" class="btn btn-primary mrg-bot-15 full-width {{$button_color_class}}" id="applyjob_open" data-bs-toggle="modal" data-bs-target="#applyjob">Apply</button>
                            </div>
                        @endif
                    @else
                        <div class="ur-detail-btn">
                            <button type="button" class="btn btn-primary mrg-bot-15 full-width {{$button_color_class}}" data-bs-toggle="modal" data-bs-target="#login">Apply</button>
                        </div>
                    @endif
                </div>
                <div class="job-menu-detail {{$background_color_class}}" id="job_detail_sub_2">
                    <ul class="navbar-nav ml-auto flex-direction-row justify-content-center" id="mainNav">
                        @if(isset($job_data->video) && !empty($job_data->video))
                            <li class="nav-item">
                                <a class="nav-link-scroll {{$background_text_color_class}}" href="javascript:void(0)" data-class="job_vacancy_video">Vacancy video</a>
                            </li>
                        @endif
                        @if(isset($job_data->jobdescription) && !empty($job_data->jobdescription))
                            <li class="nav-item">
                                <a class="nav-link-scroll {{$background_text_color_class}}" href="javascript:void(0)" data-class="the_vacancy">The Vacancy</a>
                            </li>
                        @endif
                        @if(isset($client_detail->about) && !empty($client_detail->about))
                            <li class="nav-item">
                                <a class="nav-link-scroll {{$background_text_color_class}}" href="javascript:void(0)" data-class="about_Us">About Us</a>
                            </li>
                        @endif
                        @if(isset($client_detail->video) && !empty($client_detail->video))
                            <li class="nav-item">
                                <a class="nav-link-scroll {{$background_text_color_class}}" href="javascript:void(0)" data-class="job_video">Company Video</a>
                            </li>
                        @endif
                        @if(isset($job_data->benefits_image) && !empty($job_data->benefits_image))
                            <li class="nav-item">
                                <a class="nav-link-scroll {{$background_text_color_class}}" href="javascript:void(0)" data-class="benefits">Benefits</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="detail-desc">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('flash-message-success')
                </div>
            </div>
        </div>
    </section>

    <section class="full-detail-description full-detail" id="job_detail">
        <div class="container">
            <div class="row">

                <div class="col-12 full-sidebar-m-display">
                    <div class="full-sidebar-wrap">
                        <div class="sidebar-widgets">
                            <div class="ur-detail-wrap">
                                <div class="ur-detail-wrap-header">
                                    <h4>Job Overview</h4>
                                </div>
                                <div class="ur-detail-wrap-body">
                                    <ul class="ove-detail-list">

                                        @if(isset($job_data->rateupper) && !empty($job_data->rateupper))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Offered Salary</h5>
                                                <span>UP TO £{!! App\CustomFunction\CustomFunction::number_format($job_data->rateupper) !!} DOE</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->jobcategory1) && !empty($job_data->jobcategory1))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Sector</h5>
                                                <span>{!! App\Models\JobSectors::JobSectorsName($job_data->jobcategory1) !!}</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->jobtenure) && !empty($job_data->jobtenure))
                                            @if($job_data->jobtenure == 'fixed-term-contract')
                                                <li>
                                                    <i class="ti-hand-point-right"></i>
                                                    <h5>Contract Length</h5>
                                                    @if($job_data->jobtenure == 'fixed-term-contract')
                                                        <span>@if(isset($job_data->lengthofcontract) && !empty($job_data->lengthofcontract)){!! $job_data->lengthofcontract !!}@endif @if(isset($job_data->durationperiod) && !empty($job_data->durationperiod)){!! $job_data->durationperiod !!}@endif</span>
                                                    @endif
                                                </li>
                                            @elseif($job_data->jobtenure == 'temporary')
                                                <li>
                                                    <i class="ti-hand-point-right"></i>
                                                    <h5>Contract Length</h5>
                                                    @if($job_data->jobtenure == 'temporary')
                                                        <span>@if(isset($job_data->lengthofcontract) && !empty($job_data->lengthofcontract)){!! $job_data->lengthofcontract !!}@endif @if(isset($job_data->durationperiod) && !empty($job_data->durationperiod)){!! $job_data->durationperiod !!}@endif</span>
                                                    @endif
                                                </li>
                                            @endif
                                        @endif

                                        @if(isset($job_data->benefits) && !empty($job_data->benefits))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Benefits</h5>
                                                @php
                                                    $str     = $job_data->benefits;
                                                    $order   = array("\r\n", "\n", "\r");
                                                    $replace = '<br/>';
                                                    $benefits = str_replace($order, $replace, $str);
                                                @endphp
                                                <span class="d-flex">{!! $benefits !!}</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->work_base_preference) && !empty($job_data->work_base_preference))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Work base preference</h5>
                                                @php
                                                    $work_base_preference  = $job_data->work_base_preference;
                                                    $work_base_preference_v = explode(",", $work_base_preference);
                                                @endphp
                                                <div>
                                                    <ul class="detail-list qualification">
                                                        @foreach ($work_base_preference_v as $work_base_preference_v_1)
                                                            <li>{{ $work_base_preference_v_1 }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif

                                        @if(isset($job_data->skillsrequired) && !empty($job_data->skillsrequired))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Key Skills</h5>
                                                @php
                                                    $skillsrequired  = $job_data->skillsrequired;
                                                    $skillsrequired_v = explode(",", $skillsrequired);
                                                @endphp
                                                <div>
                                                    <ul class="detail-list qualification">
                                                        @foreach ($skillsrequired_v as $skillsrequired_v_1)
                                                            <li>{{ App\Models\JobSkill::getSkillName($skillsrequired_v_1) }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8">
                    @if(isset($job_data->video) && !empty($job_data->video))
                        <div class="row-bottom" id="job_vacancy_video">
                            <h2 class="detail-title {{$background_color_class}} {{$border_color_class}} {{$background_text_color_class}}">Vacancy Video</h2>
                            <div class="jobdescription text-center">
                                @php
                                    $video = url('uploads').'/job_vacancy/'.$job_data->video;
                                @endphp
                                <video class="slider-banner-video-paly " playsinline controlsList="nodownload" width="100%" controls>
                                    <source src="{{$video}}#t=0.001" type="video/mp4">
                                    Your browser does not support HTML video.
                                </video>
                            </div>
                        </div>
                    @endif

                    @if(isset($job_data->jobdescription) && !empty($job_data->jobdescription))
                        <div class="row-bottom" id="the_vacancy">
                            <h2 class="detail-title {{$background_color_class}} {{$border_color_class}} {{$background_text_color_class}}">Job Description</h2>
                            <div class="jobdescription">
                                {!! $job_data->jobdescription !!}
                            </div>
                        </div>
                    @endif
                    @if(isset($client_detail->about) && !empty($client_detail->about))
                        <div class="row-bottom" id="about_Us">
                            <h2 class="detail-title {{$background_color_class}} {{$border_color_class}} {{$background_text_color_class}}">About Us</h2>
                            <div class="jobdescription">
                                {!! $client_detail->about !!}
                            </div>
                        </div>
                    @endif

                    @if(isset($client_detail->video) && !empty($client_detail->video))
                        <div class="row-bottom" id="job_video">
                            <h2 class="detail-title {{$background_color_class}} {{$border_color_class}} {{$background_text_color_class}}">Company Video</h2>
                            <div class="jobdescription text-center">
                                @php
                                    $video = url('uploads').'/client_profile/'.$client_detail->video;
                                @endphp
                                <video class="slider-banner-video-paly " playsinline controlsList="nodownload" width="100%" controls>
                                    <source src="{{$video}}#t=0.001" type="video/mp4">
                                    Your browser does not support HTML video.
                                </video>
                            </div>
                        </div>
                    @endif

                    @if(isset($job_data->benefits_image) && !empty($job_data->benefits_image))
                        <div class="row-bottom" id="benefits">
                            <h2 class="detail-title {{$background_color_class}} {{$border_color_class}} {{$background_text_color_class}}">Benefits</h2>
                            <div class="jobdescription">
                                @php
                                    $benefits_image = url('uploads').'/job_vacancy/'.$job_data->benefits_image;
                                @endphp
                                <img class="img-responsive lazyload" data-src="{!! $benefits_image !!}">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="full-sidebar-wrap full-sidebar-d-display">
                        <div class="sidebar-widgets">
                            <div class="ur-detail-wrap">
                                <div class="ur-detail-wrap-header">
                                    <h4>Job Overview</h4>
                                </div>
                                <div class="ur-detail-wrap-body">
                                    <ul class="ove-detail-list">

                                        @if(isset($job_data->rateupper) && !empty($job_data->rateupper))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Offered Salary</h5>
                                                <span>UP TO £{!! App\CustomFunction\CustomFunction::number_format($job_data->rateupper) !!} DOE</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->jobcategory1) && !empty($job_data->jobcategory1))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Sector</h5>
                                                <span>{!! App\Models\JobSectors::JobSectorsName($job_data->jobcategory1) !!}</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->jobtenure) && !empty($job_data->jobtenure))
                                            @if($job_data->jobtenure == 'fixed-term-contract')
                                                <li>
                                                    <i class="ti-hand-point-right"></i>
                                                    <h5>Contract Length</h5>
                                                    @if($job_data->jobtenure == 'fixed-term-contract')
                                                        <span>@if(isset($job_data->lengthofcontract) && !empty($job_data->lengthofcontract)){!! $job_data->lengthofcontract !!}@endif @if(isset($job_data->durationperiod) && !empty($job_data->durationperiod)){!! $job_data->durationperiod !!}@endif</span>
                                                    @endif
                                                </li>
                                            @elseif($job_data->jobtenure == 'temporary')
                                                <li>
                                                    <i class="ti-hand-point-right"></i>
                                                    <h5>Contract Length</h5>
                                                    @if($job_data->jobtenure == 'temporary')
                                                        <span>@if(isset($job_data->lengthofcontract) && !empty($job_data->lengthofcontract)){!! $job_data->lengthofcontract !!}@endif @if(isset($job_data->durationperiod) && !empty($job_data->durationperiod)){!! $job_data->durationperiod !!}@endif</span>
                                                    @endif
                                                </li>
                                            @endif
                                        @endif

                                        @if(isset($job_data->benefits) && !empty($job_data->benefits))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Benefits</h5>
                                                @php
                                                    $str     = $job_data->benefits;
                                                    $order   = array("\r\n", "\n", "\r");
                                                    $replace = '<br/>';
                                                    $benefits = str_replace($order, $replace, $str);
                                                @endphp
                                                <span class="d-flex">{!! $benefits !!}</span>
                                            </li>
                                        @endif

                                        @if(isset($job_data->work_base_preference) && !empty($job_data->work_base_preference))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Work base preference</h5>
                                                @php
                                                    $work_base_preference  = $job_data->work_base_preference;
                                                    $work_base_preference_v = explode(",", $work_base_preference);
                                                @endphp
                                                <div>
                                                    <ul class="detail-list qualification">
                                                        @foreach ($work_base_preference_v as $work_base_preference_v_1)
                                                            <li>{{ $work_base_preference_v_1 }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif

                                        @if(isset($job_data->skillsrequired) && !empty($job_data->skillsrequired))
                                            <li>
                                                <i class="ti-hand-point-right"></i>
                                                <h5>Key Skills</h5>
                                                @php
                                                    $skillsrequired  = $job_data->skillsrequired;
                                                    $skillsrequired_v = explode(",", $skillsrequired);
                                                @endphp
                                                <div>
                                                    <ul class="detail-list qualification">
                                                        @foreach ($skillsrequired_v as $skillsrequired_v_1)
                                                            <li>{{ App\Models\JobSkill::getSkillName($skillsrequired_v_1) }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="full-sidebar-wrap">

                        <div class="sidebar-widgets">

                            <div class="ur-detail-wrap p-0">
                                <div class="ur-detail-wrap-body p-0">
                                    <div id="googleMap" style="width:100%;height:400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="job-footer skin-dark-footer {{$footer_background_color_class}}">
        <div>
            <div class="container">
                <div class="row justify-content-center text-center">

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-widget pt-3 pb-3">
                            <img src="{!! $company_logo !!}" class="img-footer" alt="" width="200" height="200"/>
                            <div class="footer-add mt-4 {!! $social_media !!}">
                                <ul class="footer-bottom-social">
                                    @if(isset($client_detail->facebook_url) && !empty($client_detail->facebook_url))
                                        <li>
                                            <a href="{!! $client_detail->facebook_url !!}" target="_blank" class="{{$footer_icon_color_class}}"><i class="ti-facebook"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($client_detail->linkedin_url) && !empty($client_detail->linkedin_url))
                                        <li>
                                            <a href="{!! $client_detail->linkedin_url !!}" target="_blank" class="{{$footer_icon_color_class}}"><i class="ti-linkedin"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($client_detail->youtube_url) && !empty($client_detail->youtube_url))
                                        <li>
                                            <a href="{!! $client_detail->youtube_url !!}" target="_blank" class="{{$footer_icon_color_class}}"><i class="ti-youtube"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($client_detail->instagram_url) && !empty($client_detail->instagram_url))
                                        <li>
                                            <a href="{!! $client_detail->instagram_url !!}" target="_blank" class="{{$footer_icon_color_class}}"><i class="ti-instagram"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if(isset($client_detail->twitter_url) && !empty($client_detail->twitter_url))
                                        <li>
                                            <a href="{!! $client_detail->twitter_url !!}" target="_blank" class="{{$footer_icon_color_class}}"><i class="ti-twitter"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    @if(Auth::check())
        @if(Auth::user()->role == 5)
            <div class="modal fade" id="applyjob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content new-logwrap new-logwrap-custom w-100 new-logwrap-login new-logwrap-l-j-a">
                                <div class="modal-header custom-modal-header-close-btn position-relative justify-content-center">
                            @if(isset($job_applied_val) && !empty($job_applied_val))
                                    <h4 class="modal-h4">Please complete the job application form</h4>
                            @endif
                                    <button type="button" class="btn-close" id="applyjob_close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                            @if(isset($job_applied_val) && !empty($job_applied_val))
                                <form action="{{ route('candidateJobApplied') }}"  method="POST" id="job_applied" enctype="multipart/form-data">

                                    @csrf
                                    <div class="m-b-20">
                                        <div class="input-group d-block form-group position-relative mb-0">
                                            <div class="custom-file">
                                                <label>Upload CV*</label>
                                                <div class="fileUpload d-flex align-items-center overflow-visible">
                                                    <input type="file" class="upload" name="cv_file" id="cv_file" accept="application/pdf,application/msword,.doc, .docx" required data-parsley-required-message="Please select CV"/>
                                                    <span class="cursor-pointer">Upload</span>
                                                    <div class="fileName d-contents">
                                                        <span id="fileName_display"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-grey"><small>Note:- (.pdf, .docx, .doc)</small></div>
                                    </div>

                                    <div class="form-group position-relative m-b-25">
                                        <label>Notice Period*</label>
                                        @php
                                            $notice_period_old = null;
                                            if(old('notice_period')){
                                                $notice_period_old = old('notice_period');
                                            }
                                        @endphp
                                        <select class="form-control p-0 padd-l-15 padd-r-10" name="notice_period" required data-parsley-required-message="Please select notice period">
                                            <option value="" selected disabled>Please Select</option>
                                            <option value="Available Now" @if('Available Now' == $notice_period_old) selected @endif>Available Now</option>
                                            <option value="1 Weeks Notice" @if('1 Weeks Notice' == $notice_period_old) selected @endif>1 Weeks Notice</option>
                                            <option value="2 Weeks Notice" @if('2 Weeks Notice' == $notice_period_old) selected @endif>2 Weeks Notice</option>
                                            <option value="1 Months Notice" @if('1 Months Notice' == $notice_period_old) selected @endif>1 Months Notice</option>
                                            <option value="2 Months Notice" @if('2 Months Notice' == $notice_period_old) selected @endif>2 Months Notice</option>
                                            <option value="3 Months Notice" @if('3 Months Notice' == $notice_period_old) selected @endif>3 Months Notice</option>
                                            <option value="6 months Notice" @if('6 months Notice' == $notice_period_old) selected @endif>6 months Notice</option>
                                        </select>
                                    </div>
                                    <div class="form-group position-relative m-b-25">
                                        <label>Salary Expectations*</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="number" class="form-control padd-r-10" name="salary_expectations" placeholder="eg £45000" value="{{ old('salary_expectations') }}" required data-parsley-required-message="Please enter salary expectations">
                                            <i class="theme-cl fa fa-pound-sign"></i>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative m-b-25">
                                        <label>Location*</label>
                                        <div class="input-with-icon  display-eeror-msg">
                                            <input type="text" class="form-control" placeholder="Location where you live" name="j_town" id="j_town" value="{{ old('j_town') }}" required data-parsley-required-message="Please Enter Your Town">
                                            <i class="theme-cl ti-home"></i>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative m-b-25 register_select_2 register_select">
                                        <label>Work Base Preferences*</label>
                                        @php
                                            $workbasepreference_old = null;
                                            if(old('work_base_preferences')){
                                                $workbasepreference_old = old('work_base_preferences');
                                            }
                                        @endphp
                                        <select class="form-control p-0 padd-l-15 padd-r-10" name="work_base_preferences" required data-parsley-required-message="Please select work base preferences">
                                            <option value="" selected disabled>Please Select</option>
                                            <option value="Office" @if('Office' == $workbasepreference_old) selected @endif>Office</option>
                                            <option value="Remote" @if('Remote' == $workbasepreference_old) selected @endif>Remote</option>
                                            <option value="Hybrid" @if('Hybrid' == $workbasepreference_old) selected @endif>Hybrid</option>
                                        </select>
                                    </div>

                                    @if(isset($optionList) && !empty($optionList))
                                        @if(isset($optionListCount) && !empty($optionListCount))
                                            <div class="form-group position-relative m-b-25">
                                                <label>where did you see the job advertised?*</label>
                                                <select class="form-control p-0 padd-l-15 padd-r-10 cursor-pointer" name="job_advertised" required data-parsley-required-message="Please select job advertised">
                                                    <option value="" selected disabled>Please Select</option>
                                                    @foreach($optionList as $SKey => $optionList_value)
                                                        <option value="{!! $optionList_value->id !!}">{!! $optionList_value->option_name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    @endif

                                    {{-- <div class="form-group position-relative m-b-25">
                                        <label>Do you hold a British passport?*</label>
                                        <select class="form-control p-0 padd-l-15 padd-r-10 cursor-pointer" id="british_passport" name="british_passport" required data-parsley-required-message="This value is required">
                                            <option value="" selected disabled>Please Select</option>
                                            <option value="2">Yes</option>
                                            <option value="1">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group position-relative m-b-25 british_passport_no" style="display: none;">
                                        <label>What rights to work in the UK do you hold?*</label>
                                        <div class="display-eeror-msg">
                                            <input type="text" class="form-control padd-r-10 padd-l-10" id="work_in_the_uk_do_you_hold" name="work_in_the_uk_do_you_hold" placeholder="What rights to work in the UK do you hold?" value="" data-parsley-required-message="This field requied.">
                                        </div>
                                    </div>

                                    <div class="form-group position-relative m-b-25 british_passport_no" style="display: none;">
                                        <label>When does your visa expire?*</label>
                                        <div class="display-eeror-msg">
                                            <input type="text" class="form-control padd-r-10 padd-l-10" id="visa_expire_date" name="visa_expire_date" placeholder="When does your visa expire?" value="" data-parsley-required-message="This field requied." readonly>
                                        </div>
                                    </div>

                                    <div class="form-group position-relative m-b-25 british_passport_no" style="display: none;">
                                        <label>do you require VISA sponsorship?*</label>
                                        <select class="form-control p-0 padd-l-15 padd-r-10 cursor-pointer" id="require_visa_sponsorship" name="require_visa_sponsorship" data-parsley-required-message="This value is required.">
                                            <option value="" selected disabled>Please Select</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group position-relative m-b-25 border-none require_visa_sponsorship" id="div_require_visa_sponsorship" style="display: none;">
                                        <div class="text-center">
                                            <p class="color-red mrg-0">
                                                The company unfortunately doesn’t sponsor VISA’s so they cannot apply.
                                            </p>
                                        </div>
                                    </div> --}}

                                    <input type="hidden" name="job_id" value="@if(isset($job_data->id) && !empty($job_data->id)){!! $job_data->id !!}@endif">
                                    <input type="hidden" name="client_id" value="@if(isset($job_data->user_select) && !empty($job_data->user_select)){!! $job_data->user_select !!}@endif">
                                    <input type="hidden" name="managed_by" value="@if(isset($job_data->managed_by) && !empty($job_data->managed_by)){!! $job_data->managed_by !!}@endif">
                                    <input type="hidden" name="job_workflow_id" value="@if(isset($job_data->jobworkflow_id) && !empty($job_data->jobworkflow_id)){!! $job_data->jobworkflow_id !!}@endif">
                                    @if(Auth::check())
                                        <input type="hidden" name="user_id" value="{!! Auth::user()->id !!}">
                                    @endif
                                    {!! RecaptchaV3::field('jobapplied') !!}

                                    @php
                                        $user_data = App\Models\User::where('id','=',$job_data->user_select)->first();
                                        $company_name = null;
                                        if(isset($user_data->company_name) && !empty($user_data->company_name)){
                                            $company_name = $user_data->company_name;
                                        };

                                        $client_slug_name = null;
                                        if(isset($user_data->client_slug) && !empty($user_data->client_slug)){
                                            $client_slug_name = $user_data->client_slug;
                                        };

                                        $route_name = App\CustomFunction\CustomFunction::role_name();
                                        $url = "home.termsCondition";
                                        // $route = route($url,['id' => $client_slug_name]);
                                        $route = route($url);
                                    @endphp

                                    <div class="error-message error_message"></div>

                                    <div class="c-checkbox">
                                        <input type="checkbox" id="job_condition" name="job_condition" value="1" required checked>
                                        <label for="job_condition" class="custom-label"> I agree to the re:Source Talent <a href="{!! $route !!}" target="_blank">Terms & Conditions View terms of use</a></label>
                                    </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary theme-bg full-width" id="form_btn_application">Submit</button>
                                </div>
                            </form>
                        @else
                                <div class="text-center">
                                    <p class="color-red mrg-0">
                                        It looks like you have already applied for this job.
                                    </p>
                                </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        @endif
    @endif

@stop

@section('footerscripts')
    <script src="{{url('assets/frontend')}}/js/parsley.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY_MAP')}}&callback=initMap&v=weekly" defer></script>
    <script>
        $("form#job_applied").parsley();
        $( "#visa_expire_date" ).datepicker();
    </script>
    <script>
        $('#applyjob').on('show.bs.modal', function() {
            getRecaptchajobapplied();
        });

        function getRecaptchajobapplied() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{env('RECAPTCHAV3_SITEKEY')}}', {action: 'jobapplied'}).then(function(token) {
                    $('input[name=g-recaptcha-response]').val(token); // here i set value to hidden field
                });
            });
        }
    </script>
    <script defer>
        var latitude_data = '{{$job_data->latitude}}';
        var latitude_value = parseFloat(latitude_data);
        var longitude_data = '{{$job_data->longitude}}';
        var longitude_value = parseFloat(longitude_data);

        var job_title = '{{$job_data->jobtitle}}';

        function initMap() {
            // The location of Uluru
            const uluru = { lat: latitude_value, lng: longitude_value };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("googleMap"), {
                zoom: 15,
                center: uluru,
            });

            const contentString =
            '<div id="content">' +
                '<div id="siteNotice">' +
                "</div>" +
                '<h3 id="firstHeading" class="firstHeading">'+job_title+'</h3>' +
                '<div id="bodyContent">' +
                    "<p>" +

                    "</p>" +
                "</div>" +
            "</div>";

            const infowindow = new google.maps.InfoWindow({
                content: contentString,
                ariaLabel: "Uluru",
            });

            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });

            // marker.addListener("click", () => {
            //     infowindow.open({
            //         anchor: marker,
            //         map,
            //     });
            // });
        }
        window.initMap = initMap;
    </script>
    <script>
        // $('body').on('change', '#british_passport', function() {
        //     var british_passport_val = $(this).val();
        //     if(british_passport_val == 1){
        //         $('.british_passport_no').show();
        //         $('#work_in_the_uk_do_you_hold').attr("required", true);
        //         $('#visa_expire_date').attr("required", true);
        //         $('#require_visa_sponsorship').attr("required", true);
        //     }
        //     if(british_passport_val == 2){
        //         $('.british_passport_no').hide();
        //         $('#work_in_the_uk_do_you_hold').attr("required", false);
        //         $('#visa_expire_date').attr("required", false);
        //         $('#require_visa_sponsorship').attr("required", false);
        //     }
        // });
        // $('body').on('change', '#require_visa_sponsorship', function() {
        //     var require_visa_sponsorship_val = $(this).val();
        //     if(require_visa_sponsorship_val == 1){
        //         $('#form_btn_application').attr("disabled", true);
        //         $('#div_require_visa_sponsorship').show();
        //     }
        //     if(require_visa_sponsorship_val == 2){
        //         $('#form_btn_application').attr("disabled", false);
        //         $('#div_require_visa_sponsorship').hide();
        //     }
        // });
        // $('body').on('change', '#visa_expire_date', function() {
        //     $("form#job_applied").parsley().validate();
        // });
    </script>
@stop
