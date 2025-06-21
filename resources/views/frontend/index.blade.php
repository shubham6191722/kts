@extends('frontend.layouts.common')

@section('title', 'Welcome')

@section('headerscripts')

@stop

@section('content')
    <div class="clearfix"></div>
    {{-- <section class="banner trans banner-custom lazyload" data-src="{{url('assets/frontend')}}/img/slider-1.jpg" data-overlay="6"> --}}
    <div class="lazyload" style="background: #012749">

        {{-- left box --}}

        <div class="container">
            <div class="row">
                <div class="col-md-8 vkleftboxheader">
                    
                    <div class="vacancy-box">
                        <h1><span class="span1">Explore</span class="span2"><br><span class="span3">The Top </span><br><strong><span>Vacancies</span></strong>.</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna.</p>

                        {{-- <form action="{{route('home.jobList')}}" method="GET">
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
                        </form> --}}
                        <form action="{{ route('home.jobList') }}" method="GET" class="vksearch-box">
                            <input type="text"  name="job_title_skill" placeholder="Job title or keyword" class="vkcustominput">

                            <div class="divider"></div>

                            <select name="categoryid[]" class="vkcustomselect">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($job_category as $CKey => $c_value)
                                    <option value="{{ $c_value->category_id }}">{{ $c_value->category }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="search-button">
                                 <i class="ti-search"></i> Search
                            </button>
                        </form>

                    </div>
                </div>
                <div class="col-md-4 vkrightboxheader">
                    <img src="{{url('')}}/uploads/site_setting/homeheaderleft.png" class="fordesktop" >
                    <img src="{{url('')}}/uploads/site_setting/homeheaderleft_mobile.png" class="formobile" style="display: none">
                </div>
            </div>
        </div>

        {{-- our client section --}}

        

        <div class="container">
            <div class="row">
                <div class="vkmain_client">
                    <div class="vkclienttextbox">
                        <h3>Our Clients</h3>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                    <div class="vkclient_logosection">
                        <img src="{{url('')}}/uploads/site_setting/client1.svg" alt=""><img src="{{url('')}}/uploads/site_setting/client2.png" alt=""><img src="{{url('')}}/uploads/site_setting/client3.png" alt=""><img src="{{url('')}}/uploads/site_setting/client4.png" alt=""><img src="{{url('')}}/uploads/site_setting/client5.png" alt="">
                    </div>

                    <div class="slider-area">
                    <div class="wrapper_slider">
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client1.svg" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client2.png" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client3.png" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client4.png" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client5.png" alt=""></div>

                        <!-- Duplicate for seamless scroll -->
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client1.svg" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client2.png" alt=""></div>
                        <div class="item"><img src="{{ url('') }}/uploads/site_setting/client3.png" alt=""></div>
                    </div>
                    </div>


                </div>
            </div>
        </div>
        {{-- our client section --}}


    </div>
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <h2>Our <span>Latest Vacancies</span></h2>
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
                                    <div class="brows-job-position">
                                        <h3>@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif</h3>
                                        <p class="p-0 m-0"><span>{!! $company_name !!}</span></p>
                                    </div>
                                    <div class="job-position">
                                        <span class="job-num">@if(isset($value->jobcategory1) && !empty($value->jobcategory1)){!! App\Models\JobSectors::JobSectorsName($value->jobcategory1) !!}@endif</span>
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
                                    <ul class="grid-view-caption">
                                        <li>
                                            <div class="brows-job-location">
                                                <p><i class="fa fa-map-marker"></i>@if(isset($value->altlocation) && !empty($value->altlocation)){!! $value->altlocation !!}@endif</p>
                                            </div>
                                        </li>
                                        <li>
                                            <p><span class="brows-job-sallery"><i class="fa fa-money"></i>UP TO £@if(isset($value->rateupper) && !empty($value->rateupper)){!! App\CustomFunction\CustomFunction::number_format($value->rateupper) !!}@endif DOE</span></p>
                                        </li>
                                    </ul>
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