@extends('frontend.layouts.common')

@section('title', 'Welcome')

@section('headerscripts')

@stop

@section('content')
<link href="https://fonts.cdnfonts.com/css/heading" rel="stylesheet">
<style>

    @import url('https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@100..900&family=Lunasima:wght@400;700&display=swap');
    .banner-img{
        border-radius: 22px;
    }
    .anton-regular {
        font-family: "Anton", sans-serif !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    .inter-class{
        font-family: "Inter", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
    }

    .brows-job-company-img{
    }
    .company_name_sd{
        /* padding: 10px 0px 38px 100px; */
        padding: 0px 0px 38px 135px;
        text-align: left;
        font-weight: bold;
        font-size: 18px;
        margin-top: -10px;
    }
    .location_sd{
        display: flex;
        padding: 12px 15px 15px;
        text-align: left;
        /* gap: 76px; */
    }
    .location_sd > .location_first_sd {
        text-align: left;
        color: black;
        font-weight: bold;
        font-size: 20px;
        font-family: heading;
        /* width: 200px; */
    }
    .location_sd > .location_second_sd {
        font-size: 18px;
        color: #797979;
        font-weight: 400;
    }
    .salary_sd{
        display: flex;
        padding: 12px 15px 15px;
        text-align: left;
        /* gap: 27px; */
    }
    .salary_sd > .salary_first_sd {
        text-align: left;
        color: black;
        font-weight: bold;
        font-size: 20px;
        font-family: heading;
        /* width: 200px; */
    }
    .salary_sd > .salary_second_sd {
        font-size: 18px;
        color: #797979;
        font-weight: 400;
    }
    .ellipsis {
        display: flex;
        justify-content: center;
        gap: 6px;
        padding: 20px 0px 44px 0px;
        font-size: 30px;
        color: #00e1d8;
    }

    .job-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        text-align: left;
        padding: 12px 18px 15px;
        font-family: 
    }

    .job-info-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .job-info-label {
        font-weight: 400;
        color: #000;
        font-size: 18px;
        white-space: nowrap;
        width: 145px;
    }

    .job-info-value {
        color: #666;
        line-height: 1.4;
        font-size: 16px;
    }
    

    .view-all-button-main{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .view-all-button {
        background-color: #3DE5DA;
        color: white;
        font-weight: bold;
        padding: 16px 32px;
        border: none;
        border-radius: 50px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        box-shadow: 0 8px 20px rgba(61, 229, 218, 0.3);
        transition: background-color 0.3s ease, transform 0.2s ease;
        text-decoration: none;
    }

    .view-all-button:hover {
        /* background-color: #2fd7cd; */
        transform: translateY(-2px);
        /* color: white; */
    background: var(--Secondary, rgba(1, 39, 73, 1));
    color: white;
    }

    .recent-added{
        color: transparent !important;
        background: linear-gradient(90deg, #31DECD 0%, #6C37EE 100%);
        background-clip: text;
    }
    .vacancies{
        color: transparent !important;
        background: var(--Secondary, rgba(1, 39, 73, 1));
        background-clip: text;
    }
.main-block {
    position: relative;
    overflow: hidden;
}

.main-block:hover {
    box-shadow: 0px 0px 10px #adaaaa;
}

/* Hide ellipsis on hover */
.main-block:hover .ellipsis {
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

/* Base button styling */
.custom-button {
    position: absolute;
    bottom: 16px;
    left: 50%;
    transform: translate(-50%, 20px); /* start hidden */
    opacity: 0;
    transition: transform 0.4s ease, opacity 0.4s ease;
    width: 93%;
    background-color: #3DE5DA;

    
    color: white;
    font-weight: bold;
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    text-align: center;
    text-decoration: none;
    font-size: 22px;
    box-shadow: 0 8px 20px rgba(61, 229, 218, 0.3);
    margin: 0 auto;
    
    /* other styles as you had */
}
/* Hover effect to slide and show the button */
.main-block:hover .custom-button {
    transform: translate(-50%, 0); /* slide up into view */
    opacity: 1;
}

/* Button hover effect */
.custom-button:hover {
    /* background-color: #2fd7cd; */
    background: var(--Secondary, rgba(1, 39, 73, 1));
    color: white;

    transform: translateY(-2px);
}

</style>
    <div class="clearfix"></div>
    <section class="banner trans banner-custom lazyload" data-src="{{url('assets/frontend')}}/img/slider-1.jpg" data-overlay="6">
        <div class="container position-relative p-b-25 m-p-b-0">
            <div class="banner-caption">
                <div class="col-md-12 col-sm-12 banner-text">
                    <div class="full-search-2 eclip-search italian-search hero-search-radius">
                        <div class="hero-search-content">
                            <form action="{{route('home.jobList')}}" method="GET">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-12 small-padd b-r m-b-b">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <input type="text" class="form-control" placeholder="Job Title or Keywords" name="job_title_skill">
                                                <i class="ti-search"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 small-padd m-b-b">
                                        <div class="form-group">
                                            <div class="input-with-icon">
                                                <select class="form-control select2" id="s-category" name="categoryid[]">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($job_category as $CKey => $c_value)
                                                        <option value="{!! $c_value->category_id !!}">{!! $c_value->category !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-12 small-padd m-m-t-10">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <button class="btn btn-primary search-btn">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <h2 style="text-align: left; font-size: 50px;" class="anton-regular">
                        <span class="recent-added">Recent Added</span> <span class="vacancies">Vacancies</span>
                    </h2>
                    <div class="view-all-button-main">
                        <p style="text-align: left; font-size: 20px; width: 50%;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna.</p>
                        <div>
                            <a href="{!! route('home.jobList') !!}" class="view-all-button">View All
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.293 7.29298C17.6591 6.92686 18.2381 6.90427 18.6309 7.22462L18.707 7.29298L22.707 11.293L22.7754 11.3692C23.0957 11.7619 23.0731 12.3409 22.707 12.707L18.707 16.707C18.3165 17.0976 17.6835 17.0976 17.293 16.707C16.9024 16.3165 16.9024 15.6835 17.293 15.293L19.5859 13H2C1.44772 13 1 12.5523 1 12C1 11.4477 1.44772 11 2 11H19.5859L17.293 8.70704L17.2246 8.63087C16.9043 8.2381 16.9269 7.65909 17.293 7.29298Z" fill="white"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row extra-mrg">
                @if(!empty($job_data))
                    @foreach($job_data as $key => $value)
                        @php
                            if(isset($value->sub_company) && !empty($value->sub_company)){
                                $client_data = App\Models\SubCompany::getSubCompanyData($value->sub_company);
                            }else{
                                $client_data = App\Models\User::clientData($value->user_select);
                            }
                            // $client_data = App\Models\User::clientData($value->user_select);

                            $company_name = 'Company Name';
                            $company_logo = url('assets/frontend').'/img/com-2.png';
                            $company_cover_img = url('assets/frontend').'/img/bn2.jpg';

                            if(isset($client_data->company_name) && !empty($client_data->company_name)){
                                $company_name = $client_data->company_name;
                            }
                            if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                $company_logo = url('uploads').'/client_profile/'.$client_data->company_logo;
                            }
                            if(isset($client_data->cover_image) && !empty($client_data->cover_image)){
                                $company_cover_img = url('uploads').'/client_profile/'.$client_data->cover_image;
                                
                            }
                        @endphp
                        <div class="col-xl-4 col-md-6 col-12">
                            <a href="{{route('getJobDetail',['id' => $value->slug])}}">
                                <div class="grid-view brows-job-list p-0  main-block" style="border-radius:35px;">
                                    <div class="banner-img lazyload" data-src="{{$company_cover_img}}" style="margin: 15px 15px 0px 15px;">
                                        <div class="brows-job-company-img company-img-logo mt-0 mb-0">
                                            <img data-src="{{$company_logo}}" class="img-responsive lazyload" alt="">
                                        </div>                                        
                                    </div>
                                    
                                    <div class="company_name_sd">
                                        <p class="p-0 m-0"><span class="inter-class">{!! $company_name !!}</span></p>
                                    </div>

                                    <div class="job-position">
                                        <span class="job-num">@if(isset($value->jobcategory1) && !empty($value->jobcategory1)){!! App\Models\JobSectors::JobSectorsName($value->jobcategory1) !!}@endif</span>
                                    </div>
                                    <div class="brows-job-position">
                                        <h3>@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif</h3>
                                    </div>


                                    <div class="job-details">
                                        <div class="job-info-row">
                                            <div class="job-info-label anton-regular">Location</div>
                                            <div class="job-info-value inter-class">
                                                @if(isset($value->altlocation) && !empty($value->altlocation))
                                                    {!! $value->altlocation !!}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="job-info-row">
                                            <div class="job-info-label anton-regular">Offered Salary</div>
                                            <div class="job-info-value inter-class">
                                                UP TO £
                                                @if(isset($value->rateupper) && !empty($value->rateupper))
                                                    {!! App\CustomFunction\CustomFunction::number_format($value->rateupper) !!}
                                                @endif
                                                DOE
                                            </div>
                                        </div>
                                    </div>




                                    <div class="brows-job-type">
                                        @if(isset($value->jobtenure) && !empty($value->jobtenure))
                                            @if($value->jobtenure == 'permanent')
                                                <span class="full-time custom-full-time">Permanent</span>
                                            @endif
                                            @if($value->jobtenure == 'part-time')
                                                <span class="part-time  custom-part-time">Part Time</span>
                                            @endif
                                            @if($value->jobtenure == 'fixed-term-contract')
                                                <span class="full-time  custom-full-time">Fixed term contract</span>
                                            @endif
                                            @if($value->jobtenure == 'temporary')
                                                <span class="freelanc custom-freelanc" style="background: rgba(253, 251, 202, 1);">Temporary</span>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="ellipsis">
                                        <div>.</div>
                                        <div>.</div>
                                        <div>.</div>
                                    </div>

                                    <a href="{{route('getJobDetail',['id' => $value->slug])}}" class="custom-button">Find Out More</a>

                                    {{-- <div class="custom-button-wrapper">
    <a href="{{route('getJobDetail',['id' => $value->slug])}}" class="custom-button">Find Out More</a>
</div> --}}



                                    
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-md-12 mt-5 text-center">
                </div>
            </div>
        </div>
    </section>

@stop

@section('footerscripts')
@stop
