@extends('frontend.layouts.common')

@section('title', 'Welcome')

@section('headerscripts')

@stop

@section('content')
<link href="https://fonts.cdnfonts.com/css/heading" rel="stylesheet">
<style>
    .banner-img{
        border-radius: 16px;
    }
    .brows-job-company-img{
    }
    .company_name_sd{
        /* padding: 10px 0px 38px 100px; */
        padding: 0px 0px 38px 0px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
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
                    <h2 style="text-align: left">
                        <span style="
color: transparent;
background: linear-gradient(90deg, #31DECD 0%, #6C37EE 100%);
background-clip: text;">Recent Added</span> <span style="color: transparent;
background: var(--Secondary, rgba(1, 39, 73, 1));
background-clip: text;">Vacancies</span>
                    </h2>
                    <p style="text-align: left; font-size: 20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna.</p>
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
                        <div class="col-md-4 col-sm-6">
                            <a href="{{route('getJobDetail',['id' => $value->slug])}}">
                                <div class="grid-view brows-job-list p-0">
                                    <div class="banner-img lazyload" data-src="{{$company_cover_img}}">
                                        
                                    </div>
                                    <div class="brows-job-company-img company-img-logo mt-0 mb-0">
                                        <img data-src="{{$company_logo}}" class="img-responsive lazyload" alt="">
                                    </div>
                                    
                                    <div class="company_name_sd">
                                        <p class="p-0 m-0"><span>{!! $company_name !!}</span></p>
                                    </div>

                                    <div class="job-position">
                                        <span class="job-num">@if(isset($value->jobcategory1) && !empty($value->jobcategory1)){!! App\Models\JobSectors::JobSectorsName($value->jobcategory1) !!}@endif</span>
                                    </div>
                                    <div class="brows-job-position">
                                        <h3>@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif</h3>
                                    </div>

                                    <div class="location_sd">
                                        <div class="location_first_sd">Location</div>
                                        <div class="location_second_sd">@if(isset($value->altlocation) && !empty($value->altlocation)){!! $value->altlocation !!}@endif</div>
                                    </div>

                                    
                                    <div class="salary_sd">
                                        <div class="salary_first_sd">Offered Salary</div>
                                        <div class="salary_second_sd">UP TO £@if(isset($value->rateupper) && !empty($value->rateupper)){!! App\CustomFunction\CustomFunction::number_format($value->rateupper) !!}@endif DOE</div>
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
                                                <span class="freelanc custom-freelanc">Temporary</span>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="ellipsis">
                                        <div>.</div>
                                        <div>.</div>
                                        <div>.</div>
                                    </div>

                                    
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-md-12 mt-5 text-center">
                    <div class="ur-detail-btn">
                        <a href="{!! route('home.jobList') !!}" class="btn btn-primary mrg-bot-15">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('footerscripts')
@stop
