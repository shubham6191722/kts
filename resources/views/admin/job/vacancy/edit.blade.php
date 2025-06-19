@extends('admin.layouts.common')

@section('title', 'Vacancy Edit')

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
                            <h3 class="card-label">Vacancy Edit</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route($route_name.'.vacancyList')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Vacancy</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route($route_name.'.vacancyUpdate')}}" enctype="multipart/form-data">
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
                                                <input type="hidden" name="id" value="@if(isset($job_vacancy->id) && !empty($job_vacancy->id)){!! $job_vacancy->id !!}@endif"/>
                                                <div class="card-body">
                                                    <div class="row">
                                                        @if(Auth::check())
                                                            @if(Auth::user()->role == 1)
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Client Select</label>
                                                                        <div>
                                                                            <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" readonly value="@if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){!! App\Models\User::getUserName($job_vacancy['user_select']) !!} @endif"/>
                                                                            <input type="hidden" name="user_select" value="@if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){{$job_vacancy->user_select}}@endif">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                @if(Auth::user()->role == 3)
                                                                    <input type="hidden" name="user_select" value="@if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){{$job_vacancy->user_select}}@endif">
                                                                @else
                                                                    <input type="hidden" name="user_select" value="@if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){{$job_vacancy->user_select}}@endif">
                                                                @endif
                                                            @endif
                                                        @endif

                                                        @if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company))
                                                        <div class="col-md-3" id="client_sub_company" @if($sub_company_check  == false) style="display: none;" @endif>
                                                            <div class="form-group">
                                                                <label>Select Sub Company</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" value="@if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){!! App\Models\SubCompany::getSubCompanyName($job_vacancy->sub_company) !!}@endif" readonly/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Provide Pipeline</label>
                                                                <div>
                                                                    <select class="form-control select2" name="jobworkflow_id">
                                                                        @if(!empty($jobWorkFlow))
                                                                            @foreach($jobWorkFlow as $jobWorkFlowKey => $jobWorkFlow_value)
                                                                                <option value="{!! $jobWorkFlow_value->id !!}" @if($job_vacancy->jobworkflow_id == $jobWorkFlow_value->id) selected @endif >{!! $jobWorkFlow_value->workflow_name !!}</option>
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
                                                                        @php
                                                                            $staff_arr = explode(",",$job_vacancy->staff_arr);
                                                                        @endphp
                                                                        <select class="form-control select2 tz_staff" name="staff_select[]" id="staff_select" multiple="multiple">
                                                                            @if(!empty($staff_data))
                                                                                @foreach($staff_data as $SKey => $s_value)
                                                                                    <option value="{!! $s_value->id !!}" @if(in_array($s_value->id, $staff_arr)) selected @endif>{!! $s_value->name !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if(Auth::user()->role == 3)
                                                            @php
                                                                $recruiter_arr = explode(",",$job_vacancy->recruiter_arr);
                                                            @endphp
                                                            @foreach($recruiter_arr as $RKey => $r_value)
                                                            <input type="hidden" name="recruiter_select[{{$RKey}}]" value="{{$r_value}}">
                                                            @endforeach
                                                        @else
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Recruiter Select <small>(you can select multiple option.)</small><div class="lable-tooltip" data-toggle="tooltip" data-theme="dark" data-html="true" title="Select Recruiter"><i class="fas fa-info-circle"></i></div></label>
                                                                    <div>
                                                                        @php
                                                                            $recruiter_arr = explode(",",$job_vacancy->recruiter_arr);
                                                                        @endphp
                                                                        <select class="form-control select2 tz_recruiter" name="recruiter_select[]" id="recruiter_select" multiple="multiple">
                                                                            @if(!empty($recruiter_data))
                                                                                @foreach($recruiter_data as $RKey => $r_value)
                                                                                    <option value="{!! $r_value->id !!}" @if(in_array($r_value->id, $recruiter_arr)) selected @endif>{!! $r_value->name !!}</option>
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
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" readonly value="@if($job_vacancy->managed_by == 2) Direct @elseif($job_vacancy->managed_by == 1) Re:Source @endif"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job title</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobtitle" value="@if(isset($job_vacancy->jobtitle) && !empty($job_vacancy->jobtitle)){!! $job_vacancy->jobtitle !!}@endif" placeholder="Job title" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Specification</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_specification" type="radio" name="media_specification" value="media" checked>
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
                                                                    {{-- <small id="specification_file_select" @if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/@if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif">@if(isset($job_vacancy->specification_file_title) && !empty($job_vacancy->specification_file_title)){!! $job_vacancy->specification_file_title !!}@else @if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif @endif</a></small> --}}
                                                                    <small id="specification_file_select" @if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/@if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif">@if(isset($job_vacancy->specification_file_title) && !empty($job_vacancy->specification_file_title)){!! $job_vacancy->specification_file_title !!}@else @if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif @endif</a></small>
                                                                    <input type="hidden" id="specification_file_value" name="specification_file_value" value="@if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif">
                                                                    <input type="hidden" id="specification_file_title" name="specification_file_title" value="@if(isset($job_vacancy->specification_file_title) && !empty($job_vacancy->specification_file_title)){!! $job_vacancy->specification_file_title !!}@endif">
                                                                    <input type="hidden" id="specification_file_id" name="specification_file_id" value="@if(isset($job_vacancy->specification_file_id) && !empty($job_vacancy->specification_file_id)){!! $job_vacancy->specification_file_id !!}@endif">
                                                                    <input type="hidden" name="job_specification" value="@if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){!! $job_vacancy->job_specification !!}@endif"/>
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
                                                                        <option value="permanent" @if($job_vacancy->jobtenure == 'permanent') selected @endif>Permanent</option>
                                                                        <option value="fixed-term-contract" @if($job_vacancy->jobtenure == 'fixed-term-contract') selected @endif>Fixed term-contract</option>
                                                                        <option value="temporary" @if($job_vacancy->jobtenure == 'temporary') selected @endif>Temporary</option>
                                                                        <option value="part-time" @if($job_vacancy->jobtenure == 'part-time') selected @endif>Part Time</option>
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
                                                                    @php
                                                                        $newformat = null;
                                                                        if(isset($job_vacancy->startdate) && !empty($job_vacancy->startdate)){
                                                                            $time = strtotime($job_vacancy->startdate);

                                                                            $newformat = date('d-m-Y',$time);
                                                                        }
                                                                    @endphp
                                                                    <input type="text" class="form-control date" name="startdate" value="{!! $newformat !!}" placeholder="Select date" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 durationlength jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Duration Length</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="duration" value="@if(isset($job_vacancy->duration) && !empty($job_vacancy->duration)){!! $job_vacancy->duration !!}@endif" placeholder="Duration" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 lengthofcontract jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Length of Contract</label>
                                                                <div>
                                                                    <input type="number" class="form-control  custom-form-control-lg mb-2" name="lengthofcontract" value="@if(isset($job_vacancy->lengthofcontract) && !empty($job_vacancy->lengthofcontract)){!! $job_vacancy->lengthofcontract !!}@endif" placeholder="Length of Contract" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 durationperiod jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Duration Period</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_durationperiod" name="durationperiod">
                                                                        <option value="weeks" @if($job_vacancy->durationperiod == "weeks") selected @endif>Weeks</option>
                                                                        <option value="months" @if($job_vacancy->durationperiod == "months") selected @endif>Months</option>
                                                                        <option value="years" @if($job_vacancy->durationperiod == "years") selected @endif>Years</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 weeklyworkinghours jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Weekly hours</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="weeklyworkinghours" value="@if(isset($job_vacancy->weeklyworkinghours) && !empty($job_vacancy->weeklyworkinghours)){!! $job_vacancy->weeklyworkinghours !!}@endif" placeholder="Weekly hours" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 ratelower jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Hourly rate</label>
                                                                <div>
                                                                    <input type="number" class="form-control  custom-form-control-lg mb-2" name="ratelower" value="@if(isset($job_vacancy->ratelower) && !empty($job_vacancy->ratelower)){!! $job_vacancy->ratelower !!}@endif" placeholder="Hourly rate" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 rateupper jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <label>Annual salary</label>
                                                                <div>
                                                                    <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="rateupper" value="@if(isset($job_vacancy->rateupper) && !empty($job_vacancy->rateupper)){!! $job_vacancy->rateupper !!}@endif" placeholder="Annual salary" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Benefits</label>
                                                                <div>
                                                                    <textarea type="text" id="benefits" class="form-control form-control-lg mb-2" rows="4" name="benefits" placeholder="Benefits">@if(isset($job_vacancy->benefits) && !empty($job_vacancy->benefits)){!! $job_vacancy->benefits !!}@endif</textarea>
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
                                                                    <select class="form-control select2 tz_country" name="locatedcountry">
                                                                        {{-- @if(!empty($country))
                                                                            @foreach($country as $countryKey => $country_value)

                                                                                @if (old('locatedcountry') == $country_value->countrycode)
                                                                                <option value="{!! $country_value->countrycode !!}" selected>{!! $country_value->country !!}</option>
                                                                                @else
                                                                                <option value="{!! $country_value->countrycode !!}" @if($country_value->countrycode == 'GBR') selected @endif>{!! $country_value->country !!}</option>
                                                                                @endif

                                                                            @endforeach
                                                                        @endif --}}
                                                                        <option value="GBR" selected>United Kingdom</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Region</label>
                                                                <div>
                                                                    <select class="form-control select2 tz_region" name="locatedregion" id="kt_select2">
                                                                        @if(!empty($region))
                                                                            @foreach($region as $regionKey => $region_value)
                                                                                <option value="{!! $region_value->region_id !!}" @if($job_vacancy->locatedregion == $region_value->region_id) selected @endif>{!! $region_value->region !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Alt Location to City</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="altlocation" value="@if(isset($job_vacancy->altlocation) && !empty($job_vacancy->altlocation)){!! $job_vacancy->altlocation !!}@endif" placeholder="Alt Location to City" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Postcode</label>
                                                                <div>
                                                                    <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="locatedpostcode" value="@if(isset($job_vacancy->locatedpostcode) && !empty($job_vacancy->locatedpostcode)){!! $job_vacancy->locatedpostcode !!}@endif" placeholder="Postcode" />
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
                                                                    <select class="form-control select2 tz_categoryid" name="categoryid" required>
                                                                        @if(!empty($job_category))
                                                                            @foreach($job_category as $job_categoryKey => $job_category_value)
                                                                                <option value="{!! $job_category_value->category_id !!}" @if($job_vacancy->categoryid == $job_category_value->category_id) selected @endif >{!! $job_category_value->category !!}</option>
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
                                                                    <select class="form-control select2 tz_occupationid" name="occupationid" required>
                                                                        @if(!empty($job_occupation))
                                                                            @foreach($job_occupation as $job_occupationKey => $job_occupation_value)
                                                                                <option value="{!! $job_occupation_value->occupation_id !!}" @if($job_vacancy->occupationid == $job_occupation_value->occupation_id) selected @endif>{!! $job_occupation_value->occupation !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Job Level</label>
                                                                <div>
                                                                    <select class="form-control select2" name="levelid" required>
                                                                        @if(!empty($job_level))
                                                                            @foreach($job_level as $job_levelKey => $job_level_value)
                                                                                <option value="{!! $job_level_value->levels_id !!}" @if($job_vacancy->levelid == $job_level_value->levels_id) selected @endif>{!! $job_level_value->level !!}</option>
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
                                                                    <select class="form-control select2" name="jobcategory1" required>
                                                                        @if(!empty($job_sectors))
                                                                            @foreach($job_sectors as $job_sectorsyKey => $job_sectors_value)
                                                                                <option value="{!! $job_sectors_value->sector_id !!}" @if($job_vacancy->jobcategory1 == $job_sectors_value->sector_id) selected @endif>{!! $job_sectors_value->sector !!}</option>
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
                                                                    <select class="form-control select2 job_skill" name="skillsrequired[]" multiple="multiple">
                                                                        @if(!empty($job_level))
                                                                            @php
                                                                                $skill_data = explode(",",$job_vacancy->skillsrequired);
                                                                            @endphp
                                                                            @foreach($skillList as $SKey => $s_value)
                                                                                <option value="{!! $s_value->id !!}" @if(in_array($s_value->id, $skill_data)) selected @endif>{!! $s_value->skill_name !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Qualifications</label>
                                                                <div>
                                                                    <textarea type="text" class="form-control form-control-lg mb-2" name="qualificationsrequired" placeholder="Qualifications">@if(isset($job_vacancy->qualificationsrequired) && !empty($job_vacancy->qualificationsrequired)){!! $job_vacancy->qualificationsrequired !!}@endif</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Work base preference <small>(you can select multiple option.)</small></label>
                                                                <div>
                                                                    @php
                                                                        $work_base_preference = explode(",",$job_vacancy->work_base_preference);
                                                                    @endphp
                                                                    <select class="form-control select2" name="work_base_preference[]" id="work_base_preference" multiple="multiple">
                                                                        <option value="Office" @if(in_array('Office', $work_base_preference)) selected @endif>Office</option>
                                                                        <option value="Remote" @if(in_array('Remote', $work_base_preference)) selected @endif>Remote</option>
                                                                        <option value="Hybrid" @if(in_array('Hybrid', $work_base_preference)) selected @endif>Hybrid</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Job Advert</label>
                                                                <div>
                                                                    <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="jobdescription" placeholder="Job Advert" required>@if(isset($job_vacancy->jobdescription) && !empty($job_vacancy->jobdescription)){!! $job_vacancy->jobdescription !!}@endif</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Select status</label>
                                                                <div>
                                                                    {{-- @if($job_vacancy->jobvacancystatus == 3)
                                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" value="{!! $jobvacancystatus[$job_vacancy->jobvacancystatus] !!}" readonly/>
                                                                        <input type="hidden" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobvacancystatus" value="{!! $job_vacancy->jobvacancystatus !!}" readonly/>
                                                                    @else --}}
                                                                        <select class="form-control select2" name="jobvacancystatus" required>
                                                                            @if(!empty($jobvacancystatus))
                                                                                @foreach($jobvacancystatus as $jobvacancystatusKey => $jobvacancystatus_value)
                                                                                    <option value="{!! $jobvacancystatusKey !!}" @if($jobvacancystatusKey == $job_vacancy->jobvacancystatus ) selected="selected" @endif>{!! $jobvacancystatus_value !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    {{-- @endif --}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Select vacancy stage</label>
                                                                <div>
                                                                    {{-- @if($job_vacancy->jobvacancystatus == 3)
                                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" value="{!! $jobvacancystage[$job_vacancy->jobvacancystage] !!}" readonly/>
                                                                        <input type="hidden" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobvacancystage" value="{!! $job_vacancy->jobvacancystage !!}" readonly/>
                                                                    @else --}}
                                                                        <select class="form-control select2" name="jobvacancystage" required>
                                                                            @if(!empty($jobvacancystage))
                                                                                @foreach($jobvacancystage as $jobvacancystageKey => $jobvacancystage_value)
                                                                                    <option value="{!! $jobvacancystageKey !!}" @if($jobvacancystageKey == $job_vacancy->jobvacancystage ) selected="selected" @endif>{!! $jobvacancystage_value !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    {{-- @endif --}}
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
                                                                    <textarea type="text" id="infofromthehiringmanager" class="form-control form-control-lg mb-2" rows="4" name="infofromthehiringmanager" placeholder="Info From The Hiring Manager" maxlength="500">@if(isset($job_vacancy->infofromthehiringmanager) && !empty($job_vacancy->infofromthehiringmanager)){!! $job_vacancy->infofromthehiringmanager !!}@endif</textarea>
                                                                    <div id="info">Characters left: 500</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Hiring Manager Image</label>
                                                                <div class="radio-inline">
                                                                    <label class="radio radio-rounded">
                                                                        <input class="job_hiring_manager" type="radio" name="media_hiring_manager" value="media" checked>
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
                                                                    {{-- <small id="hiring_manager_file_select" @if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/@if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif">@if(isset($job_vacancy->hiring_manager_file_title) && !empty($job_vacancy->hiring_manager_file_title)){!! $job_vacancy->hiring_manager_file_title !!} @else @if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif @endif</a></small> --}}
                                                                    <small id="hiring_manager_file_select" @if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/@if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif">@if(isset($job_vacancy->hiring_manager_file_title) && !empty($job_vacancy->hiring_manager_file_title)){!! $job_vacancy->hiring_manager_file_title !!} @else @if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif @endif</a></small>
                                                                    <input type="hidden" id="hiring_manager_file_value" name="hiring_manager_file_value" value="@if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif">
                                                                    <input type="hidden" id="hiring_manager_file_title" name="hiring_manager_file_title" value="@if(isset($job_vacancy->hiring_manager_file_title) && !empty($job_vacancy->hiring_manager_file_title)){!! $job_vacancy->hiring_manager_file_title !!}@endif">
                                                                    <input type="hidden" id="hiring_manager_file_id" name="hiring_manager_file_id" value="@if(isset($job_vacancy->hiring_manager_file_id) && !empty($job_vacancy->hiring_manager_file_id)){!! $job_vacancy->hiring_manager_file_id !!}@endif">
                                                                    <input type="hidden" name="cover_image" value="@if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image)){!! $job_vacancy->cover_image !!}@endif"/>
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
                                                                        <input class="job_benefits" type="radio" name="media_benefits" value="media" @if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)) checked @endif>
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
                                                                    {{-- <small id="benefits_file_select" @if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/@if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif">@if(isset($job_vacancy->benefits_file_title) && !empty($job_vacancy->benefits_file_title)){!! $job_vacancy->benefits_file_title !!} @else @if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif @endif</a></small> --}}
                                                                    <small id="benefits_file_select" @if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)) style="display:block;" @else style="display:none;" @endif>Select File <a target="_blank" href="{{url('uploads')}}/job_vacancy/@if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif">@if(isset($job_vacancy->benefits_file_title) && !empty($job_vacancy->benefits_file_title)){!! $job_vacancy->benefits_file_title !!} @else @if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif @endif</a></small>
                                                                    <input type="hidden" id="benefits_file_value" name="benefits_file_value" value="@if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif">
                                                                    <input type="hidden" id="benefits_file_title" name="benefits_file_title" value="@if(isset($job_vacancy->benefits_file_title) && !empty($job_vacancy->benefits_file_title)){!! $job_vacancy->benefits_file_title !!}@endif">
                                                                    <input type="hidden" id="benefits_file_id" name="benefits_file_id" value="@if(isset($job_vacancy->benefits_file_id) && !empty($job_vacancy->benefits_file_id)){!! $job_vacancy->benefits_file_id !!}@endif">
                                                                    <input type="hidden" name="benefits_image" value="@if(isset($job_vacancy->benefits_image) && !empty($job_vacancy->benefits_image)){!! $job_vacancy->benefits_image !!}@endif"/>
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
                                                                    <input type="hidden" id="old_video_file" name="video" value="@if(isset($job_vacancy->video) && !empty($job_vacancy->video)){!! $job_vacancy->video !!}@endif"/>
                                                                    <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Video</label>
                                                                </div>
                                                                @if(isset($job_vacancy->video) && !empty($job_vacancy->video))
                                                                    @php
                                                                        $video = url('uploads').'/job_vacancy/'.$job_vacancy->video;
                                                                    @endphp
                                                                    <div class="d-flex justify-content-space-between align-items-center" id="tz-video-remove-div">
                                                                        <div>
                                                                            <a data-fancybox data-width="640" data-height="360" href="{!! $video !!}">Video : {!! $job_vacancy->video !!}</a>
                                                                        </div>
                                                                        <div>
                                                                            <a class="tz-remove-video" href="javascript:;">Remove Video</a>
                                                                        </div>
                                                                    </div>
                                                                @endif
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

        jobtenure($('#jobtenure').val());

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
                            $(data.stage_data).each(function(index,item) {
                                    html += '<option value="' +item.occupation_id +'" >' +item.occupation +'</option>';
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

        function countryIdAction(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                        'meta[name="csrf-token"]'
                    ).attr('content')
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
                    $('.tz_region').empty()
                        .select2();
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

        $(function() {

            @if(Session::get('error'))
                $('.tz_categoryid').trigger("change");
                $('.tz_country').trigger("change");
            @endif

        });

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
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
                                message: 'Pipeline is required'
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
            setTimeout(function() {
                KTUtil.btnRelease(formSubmitButton);
            }, 2000);
        });

        $('.select2').on('change', function(){
            var name = $(this).attr('name');
            if((name == "skillsrequired[]") || (name == "keywords[]") || (name == "staff_select[]") || (name == "recruiter_select[]") || (name == "durationperiod") || (name == "work_base_preference[]")){
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

        $("#info").text("Characters left: " + (parseInt($('#infofromthehiringmanager').attr('maxlength')) - parseInt($('#infofromthehiringmanager').val().length)));

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

        $('body').on('click', '.tz-remove-video', function() {
            $('#old_video_file').val('');
            $('#tz-video-remove-div').removeClass("d-flex");
            $('#tz-video-remove-div').addClass("d-none");
        });
    </script>
@stop
