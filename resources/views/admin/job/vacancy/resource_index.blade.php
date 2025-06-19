@extends('admin.layouts.common')

@section('title', 'Vacancy List')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
                            <a href="{{route($route_name.'.vacancyAdd')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>
                                Add Vacancy
                            </a>
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
                                                        <label class="fs-6 fw-semibold mb-2">Select Client</label>
                                                        <div>
                                                            <select class="form-control select2" name="user_select" id="user_select">
                                                                <option selected value="all">All</option>
                                                                @if(!empty($client))
                                                                    @foreach($client as $clientKey => $client_value)
                                                                        <option value="{!! $client_value->id !!}" {!! (isset($_GET['user_select']) && $_GET['user_select'] == $client_value->id) ? 'selected' : ''; !!}>{!! App\Models\User::clientName($client_value->id) !!} - ({!! App\Models\User::clientCompany($client_value->id) !!})</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
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
                                                    <div class="form-group mb-3" >
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
                                                    </div>
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
                    <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                <li class="nav-item mr-3">
                                    <a class="nav-link tab_click_job_vacancy @if($q_managed_by == 1) active @elseif($q_managed_by == 2)  @else active @endif" data-toggle="tab" href="#kt_tab_re_source" data-id="zero-config">
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
                                        <span class="nav-text font-size-lg">Re:Source</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link tab_click_job_vacancy @if($q_managed_by == 2) active @endif" data-toggle="tab" href="#kt_tab_direct" data-id="zero-config-1">
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
                                        <span class="nav-text font-size-lg">Direct</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane px-7 @if($q_managed_by == 1) show active  @elseif($q_managed_by == 2)  @else show active  @endif" id="kt_tab_re_source" role="tabpanel">
                                <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dt-table-hover" id="zero-config" role="grid" aria-describedby="kt_datatable_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sr No.</th>
                                                        @if(Auth::user()->role == 1)
                                                        <th>Main Client</th>
                                                        @endif
                                                        <th>Company Name</th>
                                                        <th>Managed by</th>
                                                        <th>Hiring Manager</th>
                                                        <th>Job title</th>
                                                        <th>Applications</th>
                                                        <th>Status</th>
                                                        <th>Vacancy stage</th>
                                                        <th>Created date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($re_job_vacancy))
                                                    @foreach($re_job_vacancy as $Rkey => $r_value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$Rkey+1!!}">{!!$Rkey+1!!}</td>
                                                        @if(Auth::user()->role == 1)
                                                        <td>@if(isset($r_value['user_select']) && !empty($r_value['user_select'])){!! App\Models\User::getUserName($r_value['user_select']) !!}@endif</td>
                                                        @endif
                                                        <td>
                                                            @if(isset($r_value['sub_company']) && !empty($r_value['sub_company']))
                                                                {!! App\Models\SubCompany::getSubCompanyName($r_value['sub_company']) !!}
                                                            @else
                                                                @if(isset($r_value['user_select']) && !empty($r_value['user_select'])){!! App\Models\User::clientCompany($r_value['user_select']) !!}@endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($r_value['managed_by']) && !empty($r_value['managed_by']))
                                                                @if($r_value['managed_by'] == 1)
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">Re:Source</span>
                                                                @else
                                                                <span class="label label-lg label-light-warning label-inline  lable-custom-w-h">Direct</span>
                                                                @endif
                                                            @endif
                                                            @if(isset($r_value['recruiter_arr']) && !empty($r_value['recruiter_arr']))
                                                                <span class="label label-lg label-light-info label-inline lable-custom-w-h">Recruiter</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($r_value['staff_arr']) && !empty($r_value['staff_arr']))
                                                                @php
                                                                    $staff = '';
                                                                    $event_staff_data = explode(",",$r_value['staff_arr']);
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
                                                                    if(isset($r_value['user_select']) && !empty($r_value['user_select'])){
                                                                        $main_client = App\Models\User::getUserName($r_value['user_select']);
                                                                    }
                                                                @endphp
                                                                <span class="label label-lg label-light-success label-inline lable-custom-w-h">{!! $main_client !!}</span>
                                                                {{-- <p>{!! $main_client !!}</p> --}}
                                                            @endif
                                                        </td>
                                                        <td>@if(isset($r_value['jobtitle']) && !empty($r_value['jobtitle'])){!! $r_value['jobtitle'] !!}@endif</td>
                                                        <td>
                                                            <a href="{{route($route_name.'.jobApplied',['id' => $r_value['id']])}}">
                                                                <span class="label label-lg label-light-info label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">@if(isset($r_value['id']) && !empty($r_value['id'])){!! App\Models\JobApplied::checkAppliedJobCount($r_value['id']) !!}@endif</span>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{-- @if($r_value['jobvacancystatus'] == 3)
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystatus[$r_value['jobvacancystatus']] !!}</span>
                                                            @else --}}
                                                                <select class="form-control job-on-change" data-id="{{$r_value['id']}}" data-value="jobvacancystatus" style="width: 100%;">
                                                                    @if(!empty($jobvacancystatus))
                                                                        @foreach($jobvacancystatus as $jobvacancystatusKey => $jobvacancystatus_value)
                                                                            <option value="{!! $jobvacancystatusKey !!}" @if($jobvacancystatusKey == $r_value['jobvacancystatus'] ) selected="selected" @endif>{!! $jobvacancystatus_value !!}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            {{-- @endif --}}
                                                        </td>
                                                        <td>
                                                            {{-- @if($r_value['jobvacancystatus'] == 3)
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">{!! $jobvacancystage[$r_value['jobvacancystage']] !!}</span>
                                                            @else --}}
                                                                <select class="form-control job-on-change" data-id="{{$r_value['id']}}" data-value="jobvacancystage" style="width: 100%;">
                                                                    @if(!empty($jobvacancystage))
                                                                        @foreach($jobvacancystage as $jobvacancystageKey => $jobvacancystage_value)
                                                                            <option value="{!! $jobvacancystageKey !!}" @if($jobvacancystageKey == $r_value['jobvacancystage'] ) selected="selected" @endif>{!! $jobvacancystage_value !!}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            {{-- @endif --}}
                                                        </td>
                                                        <td>
                                                            @if(isset($r_value['created_at']) && !empty($r_value['created_at']))
                                                                @php
                                                                    $newformat = '---';
                                                                    if(isset($r_value['created_at']) && !empty($r_value['created_at'])){
                                                                        $time = strtotime($r_value['created_at']);

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
                                                                    if(Auth::user()->id == $r_value['user_id']){
                                                                        $check_edit = "1";
                                                                    }
                                                                }else{
                                                                    $check_edit = "1";
                                                                }
                                                            @endphp

                                                            @if(Auth::user()->role != "3")
                                                                <div class="figure">
                                                                    @php
                                                                        $user_id = Auth::user()->id;
                                                                        $template_id = $r_value['id'];
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
                                                                        <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 save_template_this" data-theme="dark" data-html="true" data-toggle="modal" data-target="#save_{{$Rkey}}" title="Template Save">
                                                                            <i class="icon-md fas fa-save"></i>
                                                                        </a>
                                                                        <div class="modal fade" id="save_{{$Rkey}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
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
                                                                                                            <input type="hidden" name="id" value="{!!$r_value['id']!!}" />
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

                                                            <a href="{{route($route_name.'.jobApplied',['id' => $r_value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">
                                                                <i class="icon-md fas fa-eye"></i>
                                                            </a>



                                                            @if($check_edit == "1")
                                                            <a href="{{route($route_name.'.vacancyEdit',['id' => $r_value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Edit">
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

                                                            @if($check_edit == "1")
                                                            <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon delete_this" data-toggle="tooltip" data-theme="dark" data-html="true" title="Delete" data-id="{!!$r_value['id']!!}">
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
                                                                <input type="hidden" name="id" value="{!!$r_value['id']!!}" />
                                                                @csrf
                                                            </form>
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
                            <div class="tab-pane px-7 @if($q_managed_by == 2) show active @endif" id="kt_tab_direct" role="tabpanel">
                                <div id="kt_datatable_wrapper_1" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table dt-table-hover" id="zero-config-1" role="grid" aria-describedby="kt_datatable_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>Sr No.</th>
                                                        @if(Auth::user()->role == 1)
                                                        <th>Main Client</th>
                                                        @endif
                                                        <th>Company Name</th>
                                                        <th>Managed by</th>
                                                        <th>Hiring Manager</th>
                                                        <th>Job title</th>
                                                        <th>Applications</th>
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
                                                        <td>
                                                            @if(isset($value['sub_company']) && !empty($value['sub_company']))
                                                                {!! App\Models\SubCompany::getSubCompanyName($value['sub_company']) !!}
                                                            @else
                                                                @if(isset($value['user_select']) && !empty($value['user_select'])){!! App\Models\User::clientCompany($value['user_select']) !!}@endif
                                                            @endif


                                                        <td>
                                                            @if(isset($value['managed_by']) && !empty($value['managed_by']))
                                                                @if($value['managed_by'] == 1)
                                                                <span class="label label-lg label-light-primary label-inline  lable-custom-w-h">Re:Source</span>
                                                                @else
                                                                <span class="label label-lg label-light-warning label-inline  lable-custom-w-h">Direct</span>
                                                                @endif
                                                            @endif
                                                            @if(isset($value['recruiter_arr']) && !empty($value['recruiter_arr']))
                                                                <span class="label label-lg label-light-info label-inline  lable-custom-w-h">Recruiter</span>
                                                            @endif
                                                        </td>
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
                                                        <td>
                                                            <a href="{{route($route_name.'.jobApplied',['id' => $value['id']])}}">
                                                                <span class="label label-lg label-light-info label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">@if(isset($value['id']) && !empty($value['id'])){!! App\Models\JobApplied::checkAppliedJobCount($value['id']) !!}@endif</span>
                                                            </a>
                                                        </td>
                                                        <td>
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
                                                        </td>
                                                        <td>
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

                                                            <a href="{{route($route_name.'.jobApplied',['id' => $value['id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-toggle="tooltip" data-theme="dark" data-html="true" title="Application">
                                                                <i class="icon-md fas fa-eye"></i>
                                                            </a>



                                                            @if($check_edit == "1")
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

                                                            @if($check_edit == "1")
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
                // "sInfo": "Showing page _PAGE_ of _PAGES_ of _TOTAL_ entries",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [5, 10, 20, 50, 100, 150, 200],
            "pageLength": 10
        });

        var zeroconfig_table_1 = $('#zero-config-1').DataTable({
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

        $('body').on('click', '.tab_click_job_vacancy', function() {
            var id = $(this).attr('data-id');
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
    <script>

        jQuery(document).ready(function() {
            $('body').on('change', '#user_select', function() {
                var id = $(this).val();
                subCompanyGet(id);
            });
        });
        function subCompanyGet(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('rats-5768.subCompanyGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('.tz_sub_company').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {

                        if (data.sub_company !='') {
                            $('#client_sub_company').show();
                            var option = '';
                            var html = '<option value="all" selected>All</option>';
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
                        }

                    } else {
                        $('#client_sub_company').hide();
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                }
            });
        }
    </script>
@stop
