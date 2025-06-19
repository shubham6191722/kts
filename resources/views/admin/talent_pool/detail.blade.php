@extends('admin.layouts.common')

@section('title', 'Talent Pool')

@section('headerScripts')

@stop

@section('content')
    @php
        $route_name = App\CustomFunction\CustomFunction::role_name();
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="card card-custom">
                    @if(Auth::user()->role != 1)
                        <div class="card-header flex-wrap py-5 justify-content-end">
                            <div class="card-toolbar">
                                <a href="{{route($route_name.'.telantPootList')}}" class="btn btn-primary font-weight-bolder">
                                    <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                            </g>
                                        </svg>
                                    </span>List Talent Pool
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row justify-content-center inner-header-page p-t-50 bg-none">
                            <div class="col-md-8 col-sm-8 w-sm-90">
                                <div class="left-side-container d-flex align-items-center">
                                    @php
                                        $company_logo = site_header_logo;
                                        $class_name = "no-image";

                                        if(isset($candidate_data->cover_image) && !empty($candidate_data->cover_image)){
                                            $company_logo = url('uploads').'/candidate/'.$candidate_data->id.'/'.$candidate_data->cover_image;
                                            $class_name = 'candidate-thumb';
                                        }
                                    @endphp
                                    <div class="freelance-image d-flex align-items-center">
                                        <div class="top-candidate-box-thumb candidate-thumb bg-trans-default d-flex align-items-center justify-content-center m-0">
                                            <img src="{{$company_logo}}" class="img-fluid img-circle m-0" alt="">
                                        </div>
                                    </div>
                                    <div class="header-details m-0">

                                        @if(isset($candidate_data->name) && !empty($candidate_data->name))
                                            <h4>{!! $candidate_data->name !!} @if(isset($candidate_data->lname) && !empty($candidate_data->lname)){!! $candidate_data->lname !!}@endif</h4>
                                        @endif
                                        @if(isset($candidate_detail->salary) && !empty($candidate_detail->salary))
                                            <h5>£{!! $candidate_detail->salary !!}</h5>
                                        @endif
                                        @if(isset($candidate_detail->sector) && !empty($candidate_detail->sector))
                                            <h5>{!! App\Models\JobCategory::categoryName($candidate_detail->sector) !!}</h5 >
                                        @endif
                                        <ul class="talent-pool-top-ul">
                                            <li>
                                                @php
                                                    $location = 'United Kingdom';
                                                    if(isset($candidate_detail->location) && !empty($candidate_detail->location)){
                                                        $location = App\Models\Region::regionName($candidate_detail->location);
                                                    }
                                                @endphp
                                                <img class="flag" src="{{url('assets/frontend')}}/img/gb.svg" alt=""><h5> {!! $location !!}</h5>
                                            </li>
                                        </ul>
                                        <ul class="talent-pool-top-ul">
                                            <li>
                                                @php
                                                    $c_w_email = '';
                                                    if(isset($candidate_data->email) && !empty($candidate_data->email)){
                                                        $c_w_email = $candidate_data->email;
                                                    }
                                                @endphp
                                                <img class="flag" src="{{url('assets/frontend')}}/img/envelope.svg" alt=""><h5> {!! $c_w_email !!}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-solid  separator-danger  mt-3 mb-5 w-80 w-sm-c-100 m-auto"></div>
                        <div class="row justify-content-center p-t-50">
                            <div class="col-md-8 col-sm-8 w-sm-90">
                                <div class="container-detail-box">

                                    <div class="apply-job-header m-b-40">
                                        @if(isset($candidate_detail->sector) && !empty($candidate_detail->sector))
                                            <a href="javascript:void(0)" class="text-dark"><span><i class="fa fa-building"></i> {!! App\Models\JobCategory::categoryName($candidate_detail->sector) !!}</span></a>
                                        @endif
                                            <a href="javascript:void(0)" class="text-dark"><span><i class="fa fa-map-marker-alt"></i>{!! $location !!}</span></a>
                                    </div>

                                    @if(isset($candidate_detail->noticeperiod) && !empty($candidate_detail->noticeperiod))
                                        <div class="apply-job-header m-b-10">
                                            <a href="javascript:void(0)" class="text-dark"><span><strong>Notice period:-</strong>  {!! $candidate_detail->noticeperiod !!}</span></a>
                                        </div>
                                    @endif
                                    @if(isset($candidate_data->phone) && !empty($candidate_data->phone))
                                        <div class="apply-job-header m-b-10">
                                            <a href="javascript:void(0)" class="text-dark"><span><strong>Phone Number:-</strong>  {!! $candidate_data->phone !!}</span></a>
                                        </div>
                                    @endif
                                    @if(isset($candidate_detail->workbasepreference) && !empty($candidate_detail->workbasepreference))
                                        <div class="apply-job-header m-b-20">
                                            <a href="javascript:void(0)" class="text-dark"><span><strong>Work Preference:-</strong>  {!! $candidate_detail->workbasepreference !!}</span></a>
                                        </div>
                                    @endif

                                    @php
                                        $key_skill = null;
                                        if(isset($candidate_detail->key_skills) && !empty($candidate_detail->key_skills)){
                                            $key_skill = explode(",",$candidate_detail->key_skills);
                                        }
                                    @endphp
                                    @if(isset($key_skill) && !empty($key_skill))
                                        <div class="apply-job-detail">
                                            <h5><strong>Skills</strong></h5>
                                            <ul class="skills">
                                                @foreach($key_skill as $Kkey => $k_value)
                                                    <li>{!! App\Models\JobSkill::getSkillName($k_value) !!}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(isset($candidate_detail->description) && !empty($candidate_detail->description))
                                        <div>
                                            <h5><strong>Cover letter</strong></h5>
                                            <div class="apply-job-detail">
                                                {!! $candidate_detail->description !!}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="iframe-block mt-5">
                                        @php
                                            $fileUrl = null;
                                            if(isset($candidate_detail->cv) && !empty($candidate_detail->cv)){
                                                $file = $candidate_detail->cv;
                                                $check_ext = explode('.', $file);
                                                $fileUrl = url('uploads').'/candidate/'.$candidate_detail->user_id.'/'.$file;
                                            }
                                        @endphp
                                        @if(isset($fileUrl) && !empty($fileUrl))
                                            @if($check_ext[1] == 'pdf')
                                                <iframe src="{{$fileUrl}}#view=FitH" frameborder="0" height="400px" width="100%"></iframe>
                                            @else
                                                <div class="detail-block mt-5">
                                                    <ul class="d-flex flex-column mb-0 p-0">
                                                        <li class="d-flex justify-content-start gap-5 align-items-center">
                                                            <p class="title mb-0">Download File</p>
                                                            <p class="mb-0">
                                                                @php
                                                                    $candidate_file_download = $fileUrl;
                                                                @endphp
                                                                <a href="{{$candidate_file_download}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download">
                                                                    <span class="svg-icon svg-icon-md">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                                <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"></rect>
                                                                                <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "></path>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footerScripts')

@stop
