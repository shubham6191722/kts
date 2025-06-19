@extends('admin.layouts.common')

@section('title', 'Vacancy List')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
<link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
<link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
@php
    $route_name = App\CustomFunction\CustomFunction::role_name();
@endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Vacancy List
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            
                            @if(Auth::check())
                                @if((Auth::user()->role != 4) && (Auth::user()->role != 3))
                                    <a href="{{route($route_name.'.vacancyAdd')}}" class="btn btn-primary font-weight-bolder">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                        </span>Add Vacancy
                                    </a>
                                @endif
                            @endif

                            <div class="dropdown">
                                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                    <div class="btn btn-primary font-weight-bolder ml-2">
                                        <span class="svg-icon svg-icon-md">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        Filter
                                    </div>
                                </div>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                    <div class="py-5 px-4">
                                        <div class="text-dark font-weight-bolder icon-ms">Filter Options</div>
                                    </div>
                                    <div class="separator border-gray-200 pb-5"></div>
                                    <form method="GET" action="{{route($route_name.'.vacancyList')}}" enctype="multipart/form-data">
                                        <div class="tab-content">
                                            <div class="tab-pane active show px-4">
                                                <div>
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Job title</label>
                                                        <div>
                                                            <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobtitle" value="@if(isset($_GET['jobtitle']) && !empty($_GET['jobtitle'])){!! $_GET['jobtitle'] !!}@endif" placeholder="Job title" />
                                                        </div>
                                                    </div>
                                                    @if((Auth::user()->role != 4) && (Auth::user()->role != 3))
                                                    <div class="form-group mb-3" id="client_sub_company" style="@if($check_sub_company == 1) display:block; @else display:none; @endif">
                                                        <label class="fs-6 fw-semibold mb-2">Select Sub Company</label>
                                                        <div>
                                                            <select class="form-control select2 tz_sub_company" name="sub_company" id="sub_company">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($sub_company_data))
                                                                    @foreach($sub_company_data as $SCKey => $sub_company_value)
                                                                        <option value="{!! $sub_company_value->id !!}" {!! (isset($_GET['sub_company']) && $_GET['sub_company'] == $sub_company_value->id) ? 'selected' : ''; !!}> {!! App\Models\SubCompany::getSubCompanyName($sub_company_value->id) !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if((Auth::user()->role != 4))
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Managed by</label>
                                                        <div>
                                                            <select class="form-control select2" name="managed_by">
                                                                <option selected value="all">All</option>
                                                                <option value="1" {!! (isset($_GET['managed_by']) && $_GET['managed_by'] == 1) ? 'selected' : ''; !!}>Re:Source</option>
                                                                <option value="2" {!! (isset($_GET['managed_by']) && $_GET['managed_by'] == 2) ? 'selected' : ''; !!}>Direct</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Job Status</label>
                                                        <div>
                                                            <select class="form-control select2" name="jobvacancystatus">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($jobvacancystatus))
                                                                    @foreach($jobvacancystatus as $jobvacancystatusKey => $jobvacancystatus_value)
                                                                        <option value="{!! $jobvacancystatusKey !!}" {!! (isset($_GET['jobvacancystatus']) && $_GET['jobvacancystatus'] == $jobvacancystatusKey) ? 'selected' : ''; !!}>{!! $jobvacancystatus_value !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Vacancy stage</label>
                                                        <div>
                                                            <select class="form-control select2" name="jobvacancystage">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($jobvacancystage))
                                                                    @foreach($jobvacancystage as $jobvacancystageKey => $jobvacancystage_value)
                                                                        <option value="{!! $jobvacancystageKey !!}" {!! (isset($_GET['jobvacancystage']) && $_GET['jobvacancystage'] == $jobvacancystageKey) ? 'selected' : ''; !!}>{!! $jobvacancystage_value !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if((Auth::user()->role != 4))
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Hiring manager</label>
                                                        <div>
                                                            <select class="form-control select2" name="hiringmanager">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($get_hiring_manager))
                                                                    @foreach($get_hiring_manager as $HKey => $h_m_value)
                                                                        <option value="{!! $h_m_value->id !!}" {!! (isset($_GET['hiringmanager']) && $_GET['hiringmanager'] == $h_m_value->id) ? 'selected' : ''; !!}>{!! App\Models\User::clientName($h_m_value->id) !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    {{-- <div class="form-group mb-3" >
                                                        <label class="fs-6 fw-semibold mb-2">Employment type</label>
                                                        <div>
                                                            <select class="form-control select2" name="jobtenure">
                                                                <option selected value="all">All</option>
                                                                <option value="permanent" {!! (isset($_GET['jobtenure']) && $_GET['jobtenure'] == 'permanent') ? 'selected' : ''; !!}>Permanent</option>
                                                                <option value="fixed-term-contract" {!! (isset($_GET['jobtenure']) && $_GET['jobtenure'] == 'fixed-term-contract') ? 'selected' : ''; !!}>Fixed term contract</option>
                                                                <option value="temporary" {!! (isset($_GET['jobtenure']) && $_GET['jobtenure'] == 'temporary') ? 'selected' : ''; !!}>Temporary</option>
                                                                <option value="part-time" {!! (isset($_GET['jobtenure']) && $_GET['jobtenure'] == 'part-time') ? 'selected' : ''; !!}>Part Time</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Region</label>
                                                        <div>
                                                            <select class="form-control select2" name="locatedregion">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($region))
                                                                    @foreach($region as $regionKey => $region_value)
                                                                        <option value="{!! $region_value->region_id !!}" {!! (isset($_GET['locatedregion']) && $_GET['locatedregion'] == $region_value->region_id) ? 'selected' : ''; !!}>{!! $region_value->region !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Job Category</label>
                                                        <div>
                                                            <select class="form-control select2" name="categoryid">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($job_category))
                                                                    @foreach($job_category as $job_categoryKey => $job_category_value)
                                                                        <option value="{!! $job_category_value->category_id !!}" {!! (isset($_GET['categoryid']) && $_GET['categoryid'] == $job_category_value->category_id) ? 'selected' : ''; !!}>{!!$job_category_value->category !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="fs-6 fw-semibold mb-2">Business sector</label>
                                                        <div>
                                                            <select class="form-control select2" name="jobcategory1">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($job_sectors))
                                                                    @foreach($job_sectors as $job_sectorsyKey => $job_sectors_value)
                                                                        <option value="{!! $job_sectors_value->sector_id !!}" {!! (isset($_GET['jobcategory1']) && $_GET['jobcategory1'] == $job_sectors_value->sector_id) ? 'selected' : ''; !!}>{!! $job_sectors_value->sector !!}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group mb-3 text-center">
                                                        <a href="{{route($route_name.'.vacancyList')}}" class="btn btn-light me-3 kt_modal_add_event_cancel">Reset</a>
                                                        <button type="submit" class="btn btn-primary">
                                                            <span class="indicator-label">Submit</span>
                                                            <span class="indicator-progress">Please wait... 
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table dt-table-hover" id="zero-config" role="grid" aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                @if(Auth::user()->role == 1)
                                                    <th>Client Name</th>
                                                @endif
                                                @if(Auth::user()->role != 4)
                                                    <th>Managed by</th>
                                                @endif
                                                <th>Hiring Manager</th>
                                                <th>Job title</th>
                                                @if(Auth::user()->role == 4)
                                                    <th>Company name</th>
                                                @endif
                                                @if(Auth::user()->role != 4)
                                                    <th>Applications</th>
                                                @endif
                                                <th>Status</th>
                                                <th>Vacancy stage</th>
                                                <th>Created date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($job_vacancy))
                                                @foreach($job_vacancy as $key => $value)
                                                    <tr class="odd">

                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>

                                                        @if(Auth::user()->role == 1)
                                                            <td>@if(isset($value['user_select']) && !empty($value['user_select'])){!! App\Models\User::getUserName($value['user_select']) !!}@endif</td>
                                                        @endif

                                                        @if(Auth::user()->role != 4)
                                                            <td>
                                                                @if(isset($value['managed_by']) && !empty($value['managed_by']))
                                                                    @if($value['managed_by'] == 1)
                                                                    <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">Re:Source</span>
                                                                    @else
                                                                    <span class="label label-lg label-light-warning label-inline  lable-custom-w-h">Direct</span>
                                                                    @endif
                                                                @endif
                                                                @if(isset($value['recruiter_arr']) && !empty($value['recruiter_arr']))
                                                                <span class="label label-lg label-light-info label-inline lable-custom-w-h">Recruiter</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if(isset($value['staff_arr']) && !empty($value['staff_arr']))
                                                                @php
                                                                    $staff = '';
                                                                    $event_staff_data = explode(",",$value['staff_arr']);
                                                                @endphp
                                                                <p>
                                                                @foreach($event_staff_data as $sKey => $svalue)
                                                                    @php
                                                                        $staff = App\Models\User::getUserName($svalue);
                                                                    @endphp
                                                                    @if( count( $event_staff_data ) != $sKey + 1 )
                                                                        {{ $staff }},
                                                                    @else
                                                                        {{ $staff }}
                                                                    @endif
                                                                @endforeach
                                                                </p>
                                                            @else
                                                                @php
                                                                    $main_client = '';
                                                                    if(isset($value['user_select']) && !empty($value['user_select'])){
                                                                        $main_client = App\Models\User::getUserName($value['user_select']);
                                                                    }
                                                                @endphp
                                                                <span class="label label-lg label-light-success label-inline lable-custom-w-h">{!! $main_client !!}</span>
                                                                {{-- <p>{!! $main_client !!}</p> --}}
                                                            @endif
                                                        </td>

                                                        <td>@if(isset($value['jobtitle']) && !empty($value['jobtitle'])){!! $value['jobtitle'] !!}@endif</td>
                                                        
                                                        @if(Auth::user()->role == 4)
                                                            <td>@if(isset($value['user_select']) && !empty($value['user_select'])){!! App\Models\User::clientCompany($value['user_select']) !!}@endif</td>
                                                        @endif

                                                        @if(Auth::user()->role != 4)
                                                            <td>
                                                                <a href="{{route($route_name.'.jobApplied',['id' => $value['id']])}}">
                                                                    <span class="label label-lg label-light-info label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">@if(isset($value['id']) && !empty($value['id'])){!! App\Models\JobApplied::checkAppliedJobCount($value['id']) !!}@endif</span>
                                                                </a>
                                                            </td>
                                                        @endif

                                                        <td>
                                                            @if(Auth::user()->role != 4)
                                                                {{-- @if($value['jobvacancystatus'] == 3)
                                                                    <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystatus[$value['jobvacancystatus']] !!}</span>
                                                                @else --}}
                                                                    <select class="form-control job-on-change" data-id="{{$value['id']}}" data-value="jobvacancystatus" style="width: 100%;">
                                                                            @if(!empty($jobvacancystatus))
                                                                                @foreach($jobvacancystatus as $jobvacancystatusKey => $jobvacancystatus_value)
                                                                                    <option value="{!! $jobvacancystatusKey !!}" @if($jobvacancystatusKey == $value['jobvacancystatus'] ) selected="selected" @endif>{!! $jobvacancystatus_value !!}</option>
                                                                                @endforeach
                                                                            @endif
                                                                    </select>
                                                                {{-- @endif --}}
                                                            @else
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystatus[$value['jobvacancystatus']] !!}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(Auth::user()->role != 4)
                                                                {{-- @if($value['jobvacancystatus'] == 3)
                                                                    <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystage[$value['jobvacancystage']] !!}</span>
                                                                @else --}}
                                                                    <select class="form-control job-on-change" data-id="{{$value['id']}}" data-value="jobvacancystage" style="width: 100%;">
                                                                        @if(!empty($jobvacancystage))
                                                                            @foreach($jobvacancystage as $jobvacancystageKey => $jobvacancystage_value)
                                                                                <option value="{!! $jobvacancystageKey !!}" @if($jobvacancystageKey == $value['jobvacancystage'] ) selected="selected" @endif>{!! $jobvacancystage_value !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                {{-- @endif --}}
                                                            @else
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystage[$value['jobvacancystage']] !!}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($value['created_at']) && !empty($value['created_at']))
                                                                @php
                                                                    $newformat = '---';
                                                                    if(isset($value['created_at']) && !empty($value['created_at'])){
                                                                        $time = strtotime($value['created_at']);

                                                                        $newformat = date('d-m-Y',$time);
                                                                    }
                                                                @endphp
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $newformat !!}</span>
                                                            @endif
                                                        </td>

                                                        <td nowrap="nowrap">

                                                            @php
                                                                $check_edit = "0";
                                                                if(Auth::user()->role == 3){
                                                                    if(Auth::user()->id == $value['user_id']){
                                                                        $check_edit = "1";
                                                                    }
                                                                }else{
                                                                    $check_edit = "1";
                                                                }
                                                            @endphp

                                                            @if(Auth::user()->role != "3")
                                                                @if(Auth::user()->role != 4)
                                                                    <div class="figure">
                                                                        @php
                                                                            $user_id = Auth::user()->id;
                                                                            $template_id = $value['id'];
                                                                            $check_template = App\Models\Template::checkTempalte($user_id,$template_id);
                                                                            $check_save = 0;
                                                                            if(isset($check_template) && !empty($check_template)){
                                                                                $check_save = 1;
                                                                            }
                                                                        @endphp
                                                                        
                                                                        @if(isset($check_save) && !empty($check_save))
                                                                            <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 already_save_template_this" data-toggle="tooltip" data-theme="dark" data-html="true" title="Tempalte already Save">
                                                                                <i class="icon-md fas fa-save"></i>
                                                                            </a>
                                                                        @else
                                                                            <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 save_template_this" data-theme="dark" data-html="true" data-toggle="modal" data-target="#save_{{$key}}" title="Template Save">
                                                                                <i class="icon-md fas fa-save"></i>
                                                                            </a>
                                                                            <div class="modal fade" id="save_{{$key}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLabel">Save Template</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <form class="form" method="POST" action="{{ route($route_name.'.saveVacancyTemplate')}}">
                                                                                                @csrf
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <div class="form-group">
                                                                                                            <label>Template Name</label>
                                                                                                            <div>
                                                                                                                <input type="text" class="form-control form-control-lg  mb-2" name="template_name" value="" placeholder="Template Name" required />
                                                                                                                <input type="hidden" name="id" value="{!!$value['id']!!}" />
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
                                                                                                                {{-- <input type="hidden" name="user_id" value="{!!$u_id!!}" /> --}}
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
                                                                                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endif

                                                            @if(Auth::user()->role != 4)
                                                                <a href="{{route($route_name.'.jobApplied',['id' => $value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">
                                                                    <i class="icon-md fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                            

                                                            @if($check_edit == "1")
                                                                @if(Auth::user()->role != 4)
                                                                    <a href="{{route($route_name.'.vacancyEdit',['id' => $value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Edit">
                                                                        <span class="svg-icon svg-icon-md"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                @endif
                                                            @endif

                                                            @if($check_edit == "1")
                                                                @if(Auth::user()->role != 4)
                                                                    <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon delete_this" data-toggle="tooltip" data-theme="dark" data-html="true" title="Delete" data-id="{!!$value['id']!!}">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                    <form action="{{ route($route_name.'.vacancyDelete')}}" method="post" >
                                                                        <input type="hidden" name="id" value="{!!$value['id']!!}" />
                                                                        @csrf
                                                                    </form>
                                                                @endif
                                                            @endif

                                                            @if(Auth::user()->role == 4)
                                                                <a href="{{route('recruiter.recruiterViewVacancy',['id' => $value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="View">
                                                                    <i class="icon-md fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
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
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/promise-polyfill.js"></script>

    <script src="{!!url('assets/backend')!!}/js/scrollspyNav.js"></script>
    <script>
        var zeroconfig_table = $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                // "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50, 100, 150, 200],
            "pageLength": 10
        });

        $('body').on('click', '.delete_this', function() {
            var id = $(this).attr('data-id');
            var this_button = $(this);
            Swal.fire({
                title: "Are you sure to delete this?",
                text: "",
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    this_button.next().submit();
                }
            });
        });


        $('body').on('click', '.already_save_template_this', function() {
            var id = $(this).attr('data-id');
            var this_button = $(this);
            Swal.fire({
                title: "template already save.",
                text: "",
                icon: "success",
                type: 'success',
                showCancelButton: true,
            }).then(function(result) {
            });
        });    
    </script>

    <script>
        var KTCkeditor = function() {
            
            var demos = function() {
                $('.select2').select2({
                    placeholder: "Please Select"
                });
            }
            return {
                init: function() {
                    demos();
                }
            };
        }();
        
        jQuery(document).ready(function() {
            KTCkeditor.init();
        });
    </script>

    @if(Auth::check())
        @if(Auth::user()->role != 4)
            <script>
                $('body').on('change', '.job-on-change', function() {
                    var id = $(this).attr('data-id');
                    var change_value = $(this).attr('data-value');
                    var value = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $(
                                'meta[name="csrf-token"]'
                            ).attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route($route_name.'.vacancyUpdateStatus')}}",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id: id,
                            change_value : change_value,
                            value : value,
                        },
                        success: function(data) {
                            if (data.code == 1) {
                                show_toastr('success',data.msg);
                            } else {
                                show_toastr('error',data.msg);
                            }
                        },
                        error: function(jqXhr, textStatus, errorThrown) {
                            show_toastr('error', 'Please try again','');
                        }
                    });
                });
            </script>
        @endif
    @endif

@stop
