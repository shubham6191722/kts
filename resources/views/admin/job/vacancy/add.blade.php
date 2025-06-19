@extends('admin.layouts.common')

@section('title', 'Vacancy Add')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
            $route_name = App\CustomFunction\CustomFunction::role_name();        
        @endphp
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Vacancy Add</h3>
                        </div>
                        <div class="card-toolbar">
                            <div class="mr-3">
                                <select class="form-control" name="template_select" id="template_select">
                                    <option value="" selected="selected" disabled="">Please Select Template</option>
                                        @if(!empty($templateData))
                                            @foreach($templateData as $TKey => $t_value)
                                                <option value="{!! $t_value->id !!}">{!! $t_value->template_name !!}</option>
                                            @endforeach
                                        @endif
                                </select>
                            </div>
                            <a href="{{route($route_name.'.vacancyList')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Vacancy
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route($route_name.'.vacancyCreate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="card card-custom" id="kt_card_1" style="width: 100%;">
                                                <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Basic details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Basic details">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        @if(Auth::check())
                                                            @if(Auth::user()->role == 1)
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Client Select<div class="lable-tooltip" data-toggle="tooltip" data-theme="dark" data-html="true" title="And here's some amazing <span class='label label-inline font-weight-bold label-light-primary'>HTML</span> content. It's very <code>engaging</code>. Right?"><i class="fas fa-info-circle"></i></div></label>
                                                                        <div>
                                                                            <select class="form-control select2 tz_user" name="user_select" id="user_select">
                                                                                <option selected value=""></option>
                                                                                    @if(!empty($client_data))
                                                                                        @foreach($client_data as $client_dataKey => $client_data_value)
                                                                                            <option value="{!! $client_data_value->id !!}">{!! $client_data_value->name !!}</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                @if(Auth::user()->role == 3)
                                                                    <input type="hidden" name="user_select" value="{{Auth::user()->created_user_id}}" id="user_select">
                                                                @else
                                                                    @php
                                                                        $u_id = Auth::user()->id;
                                                                        if(Auth::user()->role == 2){
                                                                            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                                                                $u_id = Auth::user()->created_user_id;
                                                                            }else{
                                                                                $u_id = Auth::user()->id;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <input type="hidden" name="user_select" value="{{$u_id}}" id="user_select">
                                                                @endif
                                                            @endif
                                                        @endif

                                                        <div class="col-md-3" id="client_sub_company" @if($sub_company_check  == false) style="display: none;" @endif>
                                                            <div class="form-group">
                                                                <label>Select Sub Company</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_sub_company" name="sub_company" id="sub_company">
                                                                        <option selected value=""></option>
                                                                        <option value="0">None</option>
                                                                        @if(!empty($sub_company))
                                                                            @foreach($sub_company as $s_CKey => $sub_data_value)
                                                                                <option value="{!! $sub_data_value->id !!}">{!! $sub_data_value->company_name !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Provide Pipeline</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_pipeline" name="jobworkflow_id" id="jobworkflow_id" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($jobWorkFlow))
                                                                            @foreach($jobWorkFlow as $JWFKey => $jwf_data_value)
                                                                                <option value="{!! $jwf_data_value->id !!}">{!! $jwf_data_value->workflow_name !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if(Auth::user()->role == 3)
                                                            <input type="hidden" name="staff_select[]" value="{{Auth::user()->id}}" id="staff_select">
                                                        @else
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Hiring Managers Select <small>(you can select multiple option.)</small><div class="lable-tooltip" data-toggle="tooltip" data-theme="dark" data-html="true" title="Select Hiring Managers "><i class="fas fa-info-circle"></i></div></label>
                                                                    <div>
                                                                        <select class="form-control select2 tz_staff" name="staff_select[]" id="staff_select" multiple="multiple">
                                                                            @if(!empty($staff_data))
                                                                                @foreach($staff_data as $SKey => $s_value)
                                                                                    <option value="{!! $s_value->id !!}">{!! $s_value->name !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if(Auth::user()->role == 3)
                                                            {{-- <input type="hidden" name="recruiter_select[]" value="{{Auth::user()->id}}" id="recruiter_select"> --}}
                                                        @else
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Recruiter Select <small>(you can select multiple option.)</small><div class="lable-tooltip" data-toggle="tooltip" data-theme="dark" data-html="true" title="Select Recruiter"><i class="fas fa-info-circle"></i></div></label>
                                                                    <div>
                                                                        <select class="form-control select2 tz_recruiter" name="recruiter_select[]" id="recruiter_select" multiple="multiple">
                                                                            @if(!empty($recruiter_data))
                                                                                @foreach($recruiter_data as $RKey => $r_value)
                                                                                    <option value="{!! $r_value->id !!}">{!! $r_value->name !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Credit managed by</label>
                                                                <div>
                                                                    <select class="form-control select2" name="managed_by" id="managed_by">
                                                                        <option selected value=""></option>
                                                                        <option value="1">Re:Source</option>
                                                                        <option value="2">Direct</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job title</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobtitle" value="{!! old('jobtitle') !!}" placeholder="Job title" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Specification</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_specification" type="radio" name="media_specification" value="media">
                                                                        <span></span>
                                                                        Media File
                                                                    </label>
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_specification" type="radio" name="media_specification" value="select">
                                                                        <span></span>
                                                                        Upload File
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <small id="specification_file_select"></small>
                                                                    <input type="hidden" id="specification_file_value" name="specification_file_value">
                                                                    <input type="hidden" id="specification_file_title" name="specification_file_title">
                                                                    <input type="hidden" id="specification_file_id" name="specification_file_id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3" id="specification_file_check">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="job_specification_file" value="" id="jobSpecification" accept="application/pdf" />
                                                                    <label class="custom-file-label" for="jobSpecification" style="overflow: hidden;">Select File</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-custom" id="kt_card_2" style="width: 100%;">
                                                <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Remuneration</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Remuneration">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Employment type</label>
                                                                <div>
                                                                    <select class="form-control select2" name="jobtenure" id="jobtenure">
                                                                        <option selected value=""></option>
                                                                        <option value="permanent">Permanent</option>
                                                                        <option value="fixed-term-contract">Fixed term contract</option>
                                                                        <option value="temporary">Temporary</option>
                                                                        <option value="part-time">Part Time</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 startdate jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Start Date</label>
                                                                <div class="input-group date">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-calendar-check-o"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" class="form-control date" name="startdate" value="{!! old('startdate') !!}" placeholder="Select date" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 durationlength jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Duration Length</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="duration" value="{!! old('duration') !!}" placeholder="Duration" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 lengthofcontract jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Length of Contract</label>
                                                                <div>
                                                                    <input type="number" class="form-control  custom-form-control-lg mb-2" name="lengthofcontract" value="{!! old('lengthofcontract') !!}" placeholder="Length of Contract" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 durationperiod jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Duration Period</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_durationperiod" name="durationperiod" id="durationperiod">
                                                                        <option selected value=""></option>
                                                                        <option value="weeks">Weeks</option>
                                                                        <option value="months">Months</option>
                                                                        <option value="years">Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 weeklyworkinghours jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Weekly hours</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="weeklyworkinghours" value="{!! old('weeklyworkinghours') !!}" placeholder="Weekly hours" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 ratelower jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Hourly rate</label>
                                                                <div>
                                                                    <input type="number" class="form-control  custom-form-control-lg mb-2" name="ratelower" value="{!! old('ratelower') !!}" placeholder="Hourly rate" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 rateupper jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Annual salary</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="rateupper" value="{!! old('rateupper') !!}" placeholder="Annual salary" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Benefits</label>
                                                                <div>
                                                                    <textarea type="text" id="benefits" class="form-control form-control-lg mb-2" rows="4" name="benefits" placeholder="Benefits">{!! old('benefits') !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-custom" id="kt_card_3" style="width: 100%;">
                                                <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Location & requirements</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Location & requirements">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_country" name="locatedcountry" id="locatedcountry">
                                                                        {{-- @if(!empty($country))
                                                                            @foreach($country as $countryKey => $country_value)

                                                                                @if (old('locatedcountry') == $country_value->countrycode)
                                                                                <option value="{!! $country_value->countrycode !!}" selected>{!! $country_value->country !!}</option>
                                                                                @else
                                                                                <option value="{!! $country_value->countrycode !!}" @if($country_value->countrycode == 'GBR') selected @endif>{!! $country_value->country !!}</option>
                                                                                @endif

                                                                            @endforeach
                                                                        @endif --}}
                                                                        <option selected value=""></option>
                                                                        <option value="GBR">United Kingdom</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Region</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_region" name="locatedregion" id="locatedregion">
                                                                        <option selected value=""></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Alt Location to City</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="altlocation" value="{!! old('altlocation') !!}" placeholder="Alt Location to City" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Postcode</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="locatedpostcode" value="{!! old('locatedpostcode') !!}" placeholder="Postcode" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-custom" id="kt_card_4" style="width: 100%;">
                                                <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Job details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Job details">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Category</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_categoryid" name="categoryid" id="categoryid" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($job_category))
                                                                            @foreach($job_category as $job_categoryKey => $job_category_value)
                                                                                <option value="{!! $job_category_value->category_id !!}">{!!$job_category_value->category !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Sub Category</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_occupationid" name="occupationid" id="occupationid" required>
                                                                        <option selected value=""></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Level</label>
                                                                <div>
                                                                    <select class="form-control select2" name="levelid" id="levelid" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($job_level))
                                                                            @foreach($job_level as $job_levelKey => $job_level_value)
                                                                                <option value="{!! $job_level_value->levels_id !!}">{!! $job_level_value->level !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Please choose business sector</label>
                                                                <div>
                                                                    <select class="form-control select2" name="jobcategory1" id="jobcategory1" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($job_sectors))
                                                                            @foreach($job_sectors as $job_sectorsyKey => $job_sectors_value)
                                                                                <option value="{!! $job_sectors_value->sector_id !!}">{!! $job_sectors_value->sector !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Skills <small>(you can select multiple option.)</small></label>
                                                                <div>
                                                                <select class="form-control select2 job_skill" name="skillsrequired[]" id="skillsrequired" multiple="multiple">
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Qualifications</label>
                                                                <div>
                                                                    <textarea type="text" class="form-control form-control-lg mb-2" name="qualificationsrequired" placeholder="Qualifications">{!! old('qualificationsrequired') !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Work base preference <small>(you can select multiple option.)</small></label>
                                                                <div>
                                                                    <select class="form-control select2" name="work_base_preference[]" id="work_base_preference" multiple="multiple">
                                                                        <option value="Office">Office</option>
                                                                        <option value="Remote">Remote</option>
                                                                        <option value="Hybrid">Hybrid</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Job Advert</label>
                                                                <div>
                                                                    <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="jobdescription" placeholder="Job Advert" required>{!! old('jobdescription') !!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Select status</label>
                                                                <div>
                                                                    <select class="form-control select2" name="jobvacancystatus" id="jobvacancystatus" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($jobvacancystatus))
                                                                            @foreach($jobvacancystatus as $jobvacancystatusKey => $jobvacancystatus_value)
                                                                                <option value="{!! $jobvacancystatusKey!!}">{!! $jobvacancystatus_value !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Select vacancy stage</label>
                                                                <div>
                                                                    <select class="form-control select2" name="jobvacancystage" id="jobvacancystage" required>
                                                                        <option selected value=""></option>
                                                                        @if(!empty($jobvacancystage))
                                                                            @foreach($jobvacancystage as $jobvacancystageKey => $jobvacancystage_value)
                                                                                <option value="{!! $jobvacancystageKey!!}">{!! $jobvacancystage_value !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-custom" id="kt_card_5" style="width: 100%;">
                                                <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Additional details</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Additional details">
                                                            <i class="ki ki-arrow-down icon-nm"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Info From The Hiring Manager</label>
                                                                <div>
                                                                    <textarea type="text" id="infofromthehiringmanager" class="form-control form-control-lg mb-2" rows="4" name="infofromthehiringmanager" placeholder="Info From The Hiring Manager" maxlength="500">{!! old('infofromthehiringmanager') !!}</textarea>
                                                                    <div id="info">Characters left: 500</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Hiring Manager Image</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_hiring_manager" type="radio" name="media_hiring_manager" value="media">
                                                                        <span></span>
                                                                        Media File
                                                                    </label>
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_hiring_manager" type="radio" name="media_hiring_manager" value="select">
                                                                        <span></span>
                                                                        Upload File
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <small id="hiring_manager_file_select"></small>
                                                                    <input type="hidden" id="hiring_manager_file_value" name="hiring_manager_file_value">
                                                                    <input type="hidden" id="hiring_manager_file_title" name="hiring_manager_file_title">
                                                                    <input type="hidden" id="hiring_manager_file_id" name="hiring_manager_file_id">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3" id="hiring_manager_file_check">
                                                            <div class="form-group">
                                                                <label>Hiring Manager Image<span class="">*</span></label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="cover_image_file" value="" id="customFile" accept=".jpg, .jpeg, .png" required />
                                                                    <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Image</label>
                                                                </div>
                                                                <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 2mb)</small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Benefits Image</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_benefits" type="radio" name="media_benefits" value="media">
                                                                        <span></span>
                                                                        Media File
                                                                    </label>
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_benefits" type="radio" name="media_benefits" value="select">
                                                                        <span></span>
                                                                        Upload File
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <small id="benefits_file_select"></small>
                                                                    <input type="hidden" id="benefits_file_value" name="benefits_file_value">
                                                                    <input type="hidden" id="benefits_file_title" name="benefits_file_title">
                                                                    <input type="hidden" id="benefits_file_id" name="benefits_file_id">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3" id="benefits_file_check">
                                                            <div class="form-group">
                                                                <label>Benefits Image</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="benefits_image_file" value="" id="customFile" accept=".jpg, .jpeg, .png" required />
                                                                    <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Image</label>
                                                                </div>
                                                                <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 2mb)</small>
                                                            </div>
                                                        </div>

                                                        @if(Auth::user()->role == 1)
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Video</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="video_file" value="" id="video_file" accept="video/mp4,video/x-m4v,video/*" onchange="Filevalidation()"/>
                                                                    <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Video</label>
                                                                </div>
                                                                <div class="fv-plugins-message-container">
                                                                    <div data-field="video_file" data-validator="notEmpty" class="fv-help-block" id="size_error" style="display: none;">File too Big, please select a file less than 100mb</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold" id="kt_form_submit_button">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait... 
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaSpecification" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($media_pdf))
                                @foreach($media_pdf as $SKey => $s_value)
                                    <div class="col-2">
                                        <div class="d-flex flex-column align-items-center modal-box-bodar">
                                            @if($s_value['file_type'] == "pdf")
                                                <div class="select_file_specification text-center" data-id="{!! $s_value['id'] !!}" data-name="{!! $s_value['file_name'] !!}" data-title="@if(isset($s_value['file_title']) && !empty($s_value['file_title'])){!! $s_value['file_title'] !!} @else{!! $s_value['file_name'] !!}@endif">
                                                    @if(isset($s_value['file_title']) && !empty($s_value['file_title']))<span class="media-file-title">{!! $s_value['file_title'] !!}</span>@endif
                                                    <img alt="" class="max-h-55px" src="{!!url('assets/backend')!!}/media/svg/files/pdf.svg">
                                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($s_value['file_name']) && !empty($s_value['file_name'])){!! $s_value['file_name'] !!}@endif</a>
                                                </div>
                                            @else
                                                <div class="select_file_specification text-center" data-id="{!! $s_value['id'] !!}" data-name="{!! $s_value['file_name'] !!}" data-title="@if(isset($s_value['file_title']) && !empty($s_value['file_title'])){!! $s_value['file_title'] !!} @else{!! $s_value['file_name'] !!}@endif">
                                                    @if(isset($s_value['file_title']) && !empty($s_value['file_title']))<span class="media-file-title">{!! $s_value['file_title'] !!}</span>@endif
                                                    <img alt="" class="max-h-55px" src="{!!url('assets/backend')!!}/media/svg/files/doc.svg">
                                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($s_value['file_name']) && !empty($s_value['file_name'])){!! $s_value['file_name'] !!}@endif</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaCoverImage" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($media_image))
                                @foreach($media_image as $MKey => $m_value)
                                    <div class="col-2">
                                        <div class="d-flex flex-column align-items-center modal-box-bodar">
                                            <div class="select_file_hiring_manager text-center" data-id="{!! $m_value['id'] !!}" data-name="{!! $m_value['file_name'] !!}" data-title="@if(isset($m_value['file_title']) && !empty($m_value['file_title'])){!! $m_value['file_title'] !!} @else{!! $m_value['file_name'] !!}@endif">
                                                @if(isset($m_value['file_title']) && !empty($m_value['file_title']))<span class="media-file-title">{!! $m_value['file_title'] !!}</span>@endif
                                                @php
                                                    // $image_path = url('uploads').'/job_vacancy/'.Auth::user()->id.'/';
                                                    $image_path = url('uploads').'/job_vacancy/';
                                                @endphp
                                                <img alt="" class="max-h-55px max-w-100" src="{!! $image_path !!}{!! $m_value['file_name'] !!}">
                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($m_value['file_name']) && !empty($m_value['file_name'])){!! $m_value['file_name'] !!}@endif</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaBenefitsImage" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($media_image))
                                @foreach($media_image as $MKey => $m_value)
                                    <div class="col-2">
                                        <div class="d-flex flex-column align-items-center modal-box-bodar">
                                            <div class="select_file_benefits text-center" data-id="{!! $m_value['id'] !!}" data-name="{!! $m_value['file_name'] !!}" data-title="@if(isset($m_value['file_title']) && !empty($m_value['file_title'])){!! $m_value['file_title'] !!} @else{!! $m_value['file_name'] !!}@endif">
                                                @if(isset($m_value['file_title']) && !empty($m_value['file_title']))<span class="media-file-title">{!! $m_value['file_title'] !!}</span>@endif
                                                @php
                                                    // $image_path = url('uploads').'/job_vacancy/'.Auth::user()->id.'/';
                                                    $image_path = url('uploads').'/job_vacancy/';
                                                @endphp
                                                <img alt="" class="max-h-55px max-w-100" src="{!! $image_path !!}{!! $m_value['file_name'] !!}">
                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($m_value['file_name']) && !empty($m_value['file_name'])){!! $m_value['file_name'] !!}@endif</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});

                $('.date').datepicker({
                    rtl: KTUtil.isRTL(),
                    // autoclose: true,
                    // startDate: new Date(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    format: 'dd-mm-yyyy',
                });
                $('.summernote').summernote({
                    height: 150,
                    disableDragAndDrop:true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                    ],
                    callbacks: {
                        onPaste: function (e) {
                            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                            e.preventDefault();
                            document.execCommand('insertText', false, bufferText);
                        }
                    }
                });
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
        $('body').on('change', '#jobtenure', function() {
            var jobtenure_val = $(this).val();
            jobtenure(jobtenure_val);
        });

        function jobtenure(val) {
            var jobtenure_val = val;
            if(jobtenure_val === 'permanent'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide'); 
            }else if(jobtenure_val === 'fixed-term-contract'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide');
                $('.lengthofcontract').removeClass('jobtenure-hide');
            }else if(jobtenure_val === 'temporary'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.ratelower').removeClass('jobtenure-hide');
                $('.lengthofcontract').removeClass('jobtenure-hide');
            }else if(jobtenure_val === 'part-time'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.ratelower').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide');
            }else{
                $('.jobtenure-add').addClass('jobtenure-hide');
            }
        }


        $('body').on('change', '.tz_country', function() {
            var id = $(this).val();
            countryIdAction(id);
        });

        function countryIdAction(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.regionGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('.tz_region').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {
                        if (data.stage_data != '') {
                            var option = '';
                            var html = '<option label="Label" value="" selected disabled>Please Select</option>';
                            $(data.stage_data).each(function(index, item) {
                                html += '<option value="' + item.region_id + '" >' + item.region +'</option>';
                            });
                            $('.tz_region').append(html).trigger('change');

                            $('.tz_region').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            var html = '';
                            html += '<option label="Label"></option>';
                            $('.tz_region').append(html).trigger('change');
                            $('.select2').select2({placeholder: "Please Select"});
                            $('.tz_region').trigger({
                                type: 'select2:select'
                            });
                        }

                    } else {
                        show_toastr('error', data.msg, '');
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                }
            });
        }

        $('body').on('change', '.tz_categoryid', function() {
            var id = $(this).val();
            categoryIdAction(id);
        });

        function categoryIdAction(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.categoryidGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('.tz_occupationid').empty().select2();
                    $('.job_skill').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {
                        if (data.stage_data !='') {
                            var option = '';
                            var html = '<option label="Label" value="" selected disabled>Please Select</option>';
                            $(data.stage_data)
                                .each(function(index,item) { 
                                    html += '<option value="' + item.occupation_id +'" >' +item.occupation +'</option>';
                                });

                            var html1 = '';
                            $(data.skillList).each(function(index,item) { 
                                html1 += '<option value="' + item.id +'" >' +item.skill_name +'</option>';
                            });

                            $('.tz_occupationid') .append(html).trigger('change');
                            $('.job_skill').append(html1).trigger('change');

                            $('.tz_occupationid').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                            $('.job_skill').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            html += '<option>Please Select</option>';
                            $('.tz_occupationid').append(html).trigger('change');

                            html1 += '';
                            $('.job_skill').append(html1).trigger('change');

                            $('.tz_occupationid').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                            $('.job_skill').trigger({
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

        $('body').on('change', '.tz_user', function() {
            var id = $(this).val();
            piplineAction(id);
        });

        function piplineAction(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.pipelineGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('.tz_pipeline').empty().select2();
                    $('.tz_staff').empty().select2();
                    $('.tz_recruiter').empty().select2();
                    $('.tz_sub_company').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {
                        if (data.stage_data !='') {
                            var option = '';
                            var html = '<option label="Label" value="" selected disabled>Please Select</option>';
                            $(data.stage_data)
                                .each(function(index,item) { 
                                    html += '<option value="' + item.id +'" >' +item.workflow_name +'</option>';
                                });
                            $('.tz_pipeline') .append(html).trigger('change');
                            

                            $('.tz_pipeline').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            html = '<option>Please Select</option>';
                            $('.tz_pipeline').append(html).trigger('change');

                            $('.tz_pipeline').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        }

                        if (data.staff_list !='') {
                            var option = '';
                            var html = '';
                            $(data.staff_list)
                                .each(function(index,item) { 
                                    html += '<option value="' + item.id +'" >' +item.name +'</option>';
                                });
                            $('.tz_staff') .append(html).trigger('change');
                            

                            $('.tz_staff').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            html = '';
                            $('.tz_staff').append(html).trigger('change');

                            $('.tz_staff').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        }

                        if (data.recruiter_list !='') {
                            var option = '';
                            var html = '';
                            $(data.recruiter_list)
                                .each(function(index,item) { 
                                    html += '<option value="' + item.id +'" >' +item.name +'</option>';
                                });
                            $('.tz_recruiter') .append(html).trigger('change');
                            

                            $('.tz_recruiter').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            html = '';
                            $('.tz_recruiter').append(html).trigger('change');

                            $('.tz_recruiter').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        }
                        
                        if (data.sub_company !='') {
                            $('#client_sub_company').show();
                            var option = '';
                            var html = '<option label="Label" value="" selected disabled>Please Select</option>';
                            $(data.sub_company)
                                .each(function(index,item) { 
                                    html += '<option value="' + item.id +'" >' +item.company_name +'</option>';
                                });
                            $('.tz_sub_company') .append(html).trigger('change');
                            

                            $('.tz_sub_company').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {
                            $('#client_sub_company').hide();
                            html = '<option>Please Select</option>';
                            $('.tz_sub_company').append(html).trigger('change');

                            $('.tz_sub_company').trigger({
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

        $(function() {

            @if(Session::get('error'))
                $('#user_select').val({{old('user_select')}}).trigger("change");
                $('#managed_by').val({{old('managed_by')}}).trigger("change");
                $('#jobtenure').val('{{old('jobtenure')}}').trigger("change");
                $('#durationperiod').val('{{old('durationperiod')}}').trigger("change");
                $('#locatedcountry').val('{{old('locatedcountry')}}').trigger("change");
                $('#categoryid').val({{old('categoryid')}}).trigger("change");
                $('#levelid').val({{old('levelid')}}).trigger("change");
                $('#jobcategory1').val({{old('jobcategory1')}}).trigger("change");
                $('#jobvacancystatus').val({{old('jobvacancystatus')}}).trigger("change");
                $('#jobvacancystage').val({{old('jobvacancystage')}}).trigger("change");
                $('#infofromthehiringmanager').keyup();

                setTimeout(function () {
                    $('#jobworkflow_id').val({{old('jobworkflow_id')}}).trigger('change');
                    $('#locatedregion').val({{old('locatedregion')}}).trigger('change');
                    $('#occupationid').val({{old('occupationid')}}).trigger('change');
                }, 1000);
            @endif
            if ('{!!$errors->any()!!}') {
                $('#user_select').val({{old('user_select')}}).trigger("change");
                $('#managed_by').val({{old('managed_by')}}).trigger("change");
                $('#jobtenure').val('{{old('jobtenure')}}').trigger("change");
                $('#durationperiod').val('{{old('durationperiod')}}').trigger("change");
                $('#locatedcountry').val('{{old('locatedcountry')}}').trigger("change");
                $('#categoryid').val({{old('categoryid')}}).trigger("change");
                $('#levelid').val({{old('levelid')}}).trigger("change");
                $('#jobcategory1').val({{old('jobcategory1')}}).trigger("change");
                $('#jobvacancystatus').val({{old('jobvacancystatus')}}).trigger("change");
                $('#jobvacancystage').val({{old('jobvacancystage')}}).trigger("change");
                $('#infofromthehiringmanager').keyup();

                setTimeout(function () {
                    $('#jobworkflow_id').val({{old('jobworkflow_id')}}).trigger('change');
                    $('#locatedregion').val({{old('locatedregion')}}).trigger('change');
                    $('#occupationid').val({{old('occupationid')}}).trigger('change');
                }, 1000);
            }
            

        });

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
                    @if(Auth::user()->role == 1)
                        user_select: {
                            validators: {
                                notEmpty: {
                                    message: 'Client is required'
                                }
                            }
                        },
                    @endif
                    managed_by: {
                        validators: {
                            notEmpty: {
                                message: 'Managed by is required'
                            }
                        }
                    },
                    jobtitle: {
                        validators: {
                            notEmpty: {
                                message: 'Job title is required'
                            }
                        }
                    },
                    jobtenure: {
                        validators: {
                            notEmpty: {
                                message: 'Employment type is required'
                            }
                        }
                    },
                    locatedcountry: {
                        validators: {
                            notEmpty: {
                                message: 'Country is required'
                            }
                        }
                    },
                    locatedregion: {
                        validators: {
                            notEmpty: {
                                message: 'Region is required'
                            }
                        }
                    },
                    categoryid: {
                        validators: {
                            notEmpty: {
                                message: 'Job Category is required'
                            }
                        }
                    },
                    occupationid: {
                        validators: {
                            notEmpty: {
                                message: 'Job Sub Category is required'
                            }
                        }
                    },
                    levelid: {
                        validators: {
                            notEmpty: {
                                message: 'Job Level is required'
                            }
                        }
                    },
                    jobdescription: {
                        validators: {
                            notEmpty: {
                                message: 'Job Advert is required'
                            }
                        }
                    },
                    jobcategory1: {
                        validators: {
                            notEmpty: {
                                message: 'Please choose business sector is required'
                            }
                        }
                    },
                    jobvacancystatus: {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    jobvacancystage: {
                        validators: {
                            notEmpty: {
                                message: 'Vacancy stage is required'
                            }
                        }
                    },
                    jobworkflow_id: {
                        validators: {
                            notEmpty: {
                                message: 'Provide Pipeline is required'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ).on('core.form.valid', function() {
            // Show loading state on button
            KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

            // Simulate Ajax request
            // setTimeout(function() {
            //     KTUtil.btnRelease(formSubmitButton);
            // }, 2000);
        });    

        $('.select2').on('change', function(){
            var name = $(this).attr('name');
            if((name == "skillsrequired[]") || (name == "keywords[]") || (name == "staff_select[]") || (name == "recruiter_select[]") || (name == "durationperiod") || (name == "work_base_preference[]") || (name == "sub_company")){
            }else{
                validator.revalidateField(name);
            }
        });

        var card = new KTCard('kt_card_1');
        var card2 = new KTCard('kt_card_2');
        var card3 = new KTCard('kt_card_3');
        var card4 = new KTCard('kt_card_4');
        var card5 = new KTCard('kt_card_5');

        setTimeout(function () {
            KTApp.unblock(card.getSelf());
            KTApp.unblock(card2.getSelf());
            KTApp.unblock(card3.getSelf());
            KTApp.unblock(card4.getSelf());
            KTApp.unblock(card5.getSelf());
        }, 2000);

        $('#jobSpecification').on( 'change', function() {
            var myfile = $( this ).val();
            var ext = myfile.split('.').pop();
            if(ext=="pdf" || ext=="docx" || ext=="doc"){
                
            } else{
                $( this ).val('');
                alert("Please Select PDF File!");
            }
        });

        $("#infofromthehiringmanager").keyup(function()
        {
            var maxlen = $(this).attr('maxlength');
            var length = $(this).val().length;
            
            if(length > (maxlen-1) ){
                $('#info').text('max length '+maxlen+' characters only!')
            }else{
                $("#info").text("Characters left: " + (parseInt(maxlen) - parseInt(length)));
            }
        });

        $('#template_select').on('change', function(){
            var t_val = $(this).val();
            TemplateAction(t_val);
        });

        function TemplateAction(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.templateGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                    $("#hiring_manager_file_select").text('').fadeIn();
                    $("#specification_file_select").text('').fadeIn();
                },
                success: function(data) {
                    
                    if (data.code == 1) {
                        if (data.template_data != '') {
                            $('input[name="jobtitle"]').val(data.template_data.jobtitle);
                            $('input[name="weeklyworkinghours"]').val(data.template_data.weeklyworkinghours);
                            $('input[name="rateupper"]').val(data.template_data.rateupper);
                            $('input[name="ratelower"]').val(data.template_data.ratelower);
                            var startdate = moment(data.template_data.startdate).format('DD-MM-YYYY');
                            $('input[name="startdate"]').val(startdate);
                            $('input[name="altlocation"]').val(data.template_data.altlocation);
                            $('input[name="locatedpostcode"]').val(data.template_data.locatedpostcode);
                            $('textarea[name="qualificationsrequired"]').val(data.template_data.qualificationsrequired);
                            $('textarea[name="infofromthehiringmanager"]').val(data.template_data.infofromthehiringmanager);
                            $('textarea[name="infofromthehiringmanager"]').val(data.template_data.infofromthehiringmanager);
                            $('textarea[name="lengthofcontract"]').val(data.template_data.lengthofcontract);
                            $('#infofromthehiringmanager').keyup();

                            let htmlContent = data.template_data.jobdescription ;
                            $('textarea[name="jobdescription"]').summernote('code',htmlContent);

                            @if(Auth::user()->role == 1)
                                $('#user_select').val(data.template_data.user_select).trigger('change');
                            @endif
                            $('#managed_by').val(data.template_data.managed_by).trigger('change');
                            $('#jobtenure').val(data.template_data.jobtenure).trigger('change');
                            $('#durationperiod').val(data.template_data.durationperiod).trigger('change');
                            $('#locatedcountry').val(data.template_data.locatedcountry).trigger('change');
                            $('#locatedregion').val(data.template_data.locatedregion).trigger('change');
                            $('#categoryid').val(data.template_data.categoryid).trigger('change');
                            $('#levelid').val(data.template_data.levelid).trigger('change');
                            $('#jobcategory1').val(data.template_data.jobcategory1).trigger('change');
                            $('#jobvacancystatus').val(data.template_data.jobvacancystatus).trigger('change');
                            $('#jobvacancystage').val(data.template_data.jobvacancystage).trigger('change');
                            $('#jobvacancystage').val(data.template_data.jobvacancystage).trigger('change');

                            $('input[name="media_specification"][value="media"]').prop("checked",true);
                            // var text_add_specification = 'Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+data.template_data.job_specification+'">'+data.template_data.specification_file_title+'</a>';
                            if(data.template_data.specification_file_title){
                                var specification_file_title = data.template_data.specification_file_title;
                            }else{
                                var specification_file_title = data.template_data.job_specification;
                            }
                            var text_add_specification = 'Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/'+data.template_data.job_specification+'">'+specification_file_title+'</a>';
                            $("#specification_file_select").append(text_add_specification).fadeIn();
                            $("#specification_file_value").val(data.template_data.job_specification);
                            $("#specification_file_title").val(data.template_data.specification_file_title);
                            $("#specification_file_id").val(data.template_data.specification_file_id);

                            $('input[name="media_hiring_manager"][value="media"]').prop("checked",true);
                            // var text_add_hiring_manager_1 = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+data.template_data.cover_image+'">'+data.template_data.hiring_manager_file_title+'</a>';
                            if(data.template_data.hiring_manager_file_title){
                                var hiring_manager_file_title = data.template_data.hiring_manager_file_title;
                            }else{
                                var hiring_manager_file_title = data.template_data.cover_image;
                            }
                            var text_add_hiring_manager_1 = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/'+data.template_data.cover_image+'">'+hiring_manager_file_title+'</a>';
                            $("#hiring_manager_file_select").append(text_add_hiring_manager_1).fadeIn();
                            $("#hiring_manager_file_value").val(data.template_data.cover_image);
                            $("#hiring_manager_file_title").val(data.template_data.hiring_manager_file_title);
                            $("#hiring_manager_file_id").val(data.template_data.hiring_manager_file_id);

                            $('input[name="media_benefits"][value="media"]').prop("checked",true);
                            // var text_add_benefits_1 = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+data.template_data.benefits_image+'">'+data.template_data.benefits_file_title+'</a>';
                            if(data.template_data.benefits_file_title){
                                var benefits_file_title = data.template_data.benefits_file_title;
                            }else{
                                var benefits_file_title = data.template_data.benefits_image;
                            }
                            var text_add_benefits_1 = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/'+data.template_data.benefits_image+'">'+benefits_file_title+'</a>';
                            $("#benefits_file_select").append(text_add_benefits_1).fadeIn();
                            $("#benefits_file_value").val(data.template_data.benefits_image);
                            $("#benefits_file_title").val(data.template_data.benefits_file_title);
                            $("#benefits_file_id").val(data.template_data.benefits_file_id);

                            setTimeout(function () {
                                $('#jobworkflow_id').val(data.template_data.jobworkflow_id).trigger('change');
                                $('#locatedregion').val(data.template_data.locatedregion).trigger('change');
                                $('#occupationid').val(data.template_data.occupationid).trigger('change');

                                $('#sub_company').val(data.template_data.sub_company).trigger('change');

                                const skillsrequired = data.template_data.skillsrequired;
                                if(skillsrequired){
                                    if (skillsrequired.indexOf(',') > -1) { 
                                        var skillsrequired_data = skillsrequired.split(',') 
                                    }else{
                                        var skillsrequired_data = data.template_data.skillsrequired;
                                    }
                                    $('#skillsrequired').val(skillsrequired_data).trigger('change');
                                }
                                
                                const staff_select = data.template_data.staff_arr;
                                if(staff_select){
                                    if (staff_select.indexOf(',') > -1) { 
                                        var staff_select_data = staff_arr.split(',') 
                                    }else{
                                        var staff_select_data = data.template_data.staff_arr;
                                    }
                                    $('#staff_select').val(staff_select_data).trigger('change');
                                }
                                
                                const recruiter_select = data.template_data.recruiter_arr;
                                if(recruiter_select){
                                    if (recruiter_select.indexOf(',') > -1) { 
                                        var recruiter_select_data = recruiter_arr.split(',') 
                                    }else{
                                        var recruiter_select_data = data.template_data.recruiter_arr;
                                    }
                                    $('#recruiter_select').val(recruiter_select_data).trigger('change');
                                }
                                
                            }, 1000);

                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                $('#template_select').val('');
                            }, 1000);

                        } else {
                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                $('#template_select').val('');
                            }, 1000);
                        }

                    } else {
                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                            $('#template_select').val('');
                        }, 1000);
                    }
                
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                        $('#template_select').val('');
                    }, 1000);
                }
            });
        }

    </script>

    <script>
        $(".job_specification").click(function(){
            var radioValue = $("input[name='media_specification']:checked").val();
            if(radioValue === 'media'){
                $('#specification_file_check').hide();
                $('#mediaSpecification').modal('show');
            }
            if(radioValue === 'select'){
                $('#specification_file_check').show();
                $("#specification_file_select").text('').fadeOut();
                $("#specification_file_value").val('');
                $("#specification_file_title").val('');
                $("#specification_file_id").val('');
            }
        });

        $(".select_file_specification").click(function(){
            var file_id = $(this).attr('data-id');
            var file_name = $(this).attr('data-name');
            var file_title = $(this).attr('data-title');
            $("#specification_file_select").text('').fadeOut();
            setTimeout(function () {
                // var text_add_specification = 'Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+file_name+'">'+file_title+'</a>';
                var text_add_specification = 'Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/'+file_name+'">'+file_title+'</a>';
                $("#specification_file_select").append(text_add_specification).fadeIn();
                $("#specification_file_value").val(file_name);
                $("#specification_file_title").val(file_title);
                $("#specification_file_id").val(file_id);
                $('#mediaSpecification').modal('hide');
            }, 500);

        });

        $(".job_hiring_manager").click(function(){
            var radioValue = $("input[name='media_hiring_manager']:checked").val();
            if(radioValue === 'media'){
                $('#hiring_manager_file_check').hide();
                $('#mediaCoverImage').modal('show');
            }
            if(radioValue === 'select'){
                $('#hiring_manager_file_check').show();
                $("#hiring_manager_file_select").text('').fadeOut();
                $("#hiring_manager_file_value").val('');
                $("#hiring_manager_file_title").val('');
                $("#hiring_manager_file_id").val('');
            }
        });

        $(".select_file_hiring_manager").click(function(){
            var file_id = $(this).attr('data-id');
            var file_name = $(this).attr('data-name');
            var file_title = $(this).attr('data-title');
            $("#hiring_manager_file_select").text('').fadeOut();
            setTimeout(function () {
                // var text_add_hiring_manager = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+file_name+'">'+file_title+'</a>';
                var text_add_hiring_manager = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/'+file_name+'">'+file_title+'</a>';
                $("#hiring_manager_file_select").append(text_add_hiring_manager).fadeIn();
                $("#hiring_manager_file_value").val(file_name);
                $("#hiring_manager_file_title").val(file_title);
                $("#hiring_manager_file_id").val(file_id);
                $('#mediaCoverImage').modal('hide');
            }, 500);

        });

        $(".job_benefits").click(function(){
            var radioValue = $("input[name='media_benefits']:checked").val();
            if(radioValue === 'media'){
                $('#benefits_file_check').hide();
                $('#mediaBenefitsImage').modal('show');
            }
            if(radioValue === 'select'){
                $('#benefits_file_check').show();
                $("#benefits_file_select").text('').fadeOut();
                $("#benefits_file_value").val('');
                $("#benefits_file_title").val('');
                $("#benefits_file_id").val('');
            }
        });

        $(".select_file_benefits").click(function(){
            var file_id = $(this).attr('data-id');
            var file_name = $(this).attr('data-name');
            var file_title = $(this).attr('data-title');
            $("#benefits_file_select").text('').fadeOut();
            setTimeout(function () {
                // var text_add_benefits = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+file_name+'">'+file_title+'</a>';
                var text_add_benefits = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/'+file_name+'">'+file_title+'</a>';
                $("#benefits_file_select").append(text_add_benefits).fadeIn();
                $("#benefits_file_value").val(file_name);
                $("#benefits_file_title").val(file_title);
                $("#benefits_file_id").val(file_id);
                $('#mediaBenefitsImage').modal('hide');
            }, 500);

        });

        function Filevalidation() {
            const fi = document.getElementById('video_file');
            // Check if any file is selected.
            if (fi.files.length > 0) {
                for (const i = 0; i <= fi.files.length - 1; i++) {
          
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file.
                    if (file >= 102400) {
                        $('#size_error').show();
                        $('#kt_form_submit_button').prop('disabled', true);
                    }else{
                        $('#size_error').hide();
                        $('#kt_form_submit_button').prop('disabled', false);
                    }
                }
            }
        }
    </script>
@stop