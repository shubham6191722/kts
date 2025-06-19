@extends('admin.layouts.common')

@section('title', 'Interview')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid @if($outlook_calender_check) @else pt-0 @endif" id="kt_content">
        @if($outlook_calender_check)
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <div class="d-flex align-items-center flex-wrap mr-2">
                        <ul class="nav gap-column gap-row mb-10 mt-10">
                            <li class="nav-item">
                                <a class="btn btn-outline-success nav-link appliction-tab-btn candidate-offer active" data-toggle="tab" id="tab_outlook_calender" href="#outlook_calender">
                                    <span class="nav-text font-size-lg">Outlook Calendar</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="btn btn-outline-primary nav-link appliction-tab-btn candidate-offer" data-toggle="tab" id="tab_system_calendar" href="#system_calendar">
                                    <span class="nav-text font-size-lg">System Calendar</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="tab-content m-0 w-100" id="myActivityDetail">
                        <div class="@if($outlook_calender_check) @else active @endif tab-pane px-7" id="system_calendar" role="tabpanel">
                            <div class="container-fluid p-0">
                                <div class="card card-custom">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">@if($outlook_calender_check) System Calendar @else Event @endif</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="kt_datatable_wrapper_system" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="calendar_event_data" style="display: none;visibility: hidden">{!! $event_data !!}</div>
                                                    <div id="kt_calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane px-7 @if($outlook_calender_check) active @endif" id="outlook_calender" role="tabpanel">
                            <div class="container-fluid p-0">
                                <div class="card card-custom">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">Outlook Calendar</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="kt_datatable_wrapper_outlook" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="outlook_calendar_event_data" style="display: none;visibility: hidden">{!! $outlook_event_data !!}</div>
                                                    <div id="kt_outlook_calendar"></div>
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
        </div>
    </div>

    @if(isset($event) && !empty($event))
        @foreach($event as $Ekey => $e_value)
            <div class="modal fade" id="event_{{$e_value->id}}" tabindex="-1" role="dialog" aria-labelledby="calendar_modelLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">
                        <div class="modal-header border-0 justify-content-end">
                            @if(Auth::check())
                                @if(Auth::user()->role != 4)
                                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-primary me-2 open-tooltip-custom" data-dismiss="modal" data-toggle="modal" data-target="#event_edit_{{$e_value->id}}" aria-label="Close" data-kt-initialized="1">
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-danger me-2" onclick="deleteButton(event_{{$e_value->id}},{{$e_value->id}})">
                                        <span class="svg-icon svg-icon-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </div>
                                @endif
                            @endif
                            <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-dismiss="modal" aria-label="Close" data-kt-initialized="1">
                                <span class="svg-icon svg-icon-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body py-10 px-lg-17">
                            @if(isset($e_value->vacancy_id) && !empty($e_value->vacancy_id))
                            <div class="d-flex align-items-center justify-content-start mb-6">
                                <div class="d-flex flex-column font-weight-bold">
                                    @php
                                        $vacancy = App\Models\JobVacancy::jobName($e_value->vacancy_id);
                                    @endphp
                                    <h3 class="text-dark line-height-sm m-0 ">{!! $vacancy !!}</h3>
                                </div>
                            </div>
                            @endif
                            @if(Auth::user()->role != 4)
                                @if($e_value->job_reference == 1)
                                    <div class="d-flex align-items-center justify-content-start mb-6">
                                        <div class="d-flex align-items-center  justify-content-start column-gap-10 w-100">
                                            @php
                                                $clientData = App\Models\User::clientData($e_value->user_id);
                                                $companyname = '-';
                                                if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                    $companyname = $clientData->company_name;
                                                }
                                            @endphp
                                            <div class="d-flex flex-column font-weight-bold">
                                                <i class="icon-xl far fa-building text-warning" data-toggle="tooltip" data-theme="dark" data-original-title="Recruiter Company Name"></i>
                                            </div>
                                            <div class="d-flex flex-column font-weight-bold">
                                                <p class="text-dark line-height-sm font-size-lg m-0 ">
                                                    {!! $companyname !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="d-flex align-items-center justify-content-start mb-6">
                                @if(isset($e_value->user_id) && !empty($e_value->user_id))
                                    <div class="d-flex align-items-center  justify-content-start column-gap-10 w-50">
                                        @php
                                            if($e_value->job_reference == 1){
                                                $user = App\Models\RecruiterCandidate::recruiterCandidateName($e_value->r_c_id);
                                                $user_tooltip = 'Recruiter User';
                                            }else{
                                                $user = App\Models\User::getUserName($e_value->user_id);
                                                $user_tooltip = 'User';
                                            }
                                        @endphp
                                        <div class="d-flex flex-column font-weight-bold">
                                            <i class="icon-xl far fa-user text-warning" data-toggle="tooltip" data-theme="dark" data-original-title="{{$user_tooltip}}"></i>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            <p class="text-dark line-height-sm font-size-lg m-0 ">
                                                {!! $user !!}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($e_value->event_staff_select) && !empty($e_value->event_staff_select))
                                    <div class="d-flex align-items-center  justify-content-start column-gap-10 w-50">
                                        <div class="d-flex flex-column font-weight-bold w-20px">
                                            <i class="icon-xl fas fa-user-edit text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Staff"></i>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            @php
                                                $staff = '';
                                                $event_staff_data = explode(",",$e_value->event_staff_select);
                                            @endphp
                                            <p class="text-dark line-height-sm font-size-lg mb-2 text-capitalize">
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
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-start mb-6">
                                @if($e_value->check_time_slot == 1)
                                    @if(isset($e_value->event_date) && !empty($e_value->event_date))
                                        <div class="d-flex align-items-center column-gap-10 w-50">
                                            <div class="d-flex flex-column font-weight-bold w-20px">
                                                <i class="icon-xl far fa-calendar-alt text-success" data-toggle="tooltip" data-theme="dark" data-original-title="Date"></i>
                                            </div>
                                            <div class="d-flex flex-column font-weight-bold">
                                                @php
                                                    $date = App\CustomFunction\CustomFunction::get_date_forment($e_value->event_date);
                                                @endphp
                                                <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $date !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if(isset($e_value->confirm_date) && !empty($e_value->confirm_date))
                                        <div class="d-flex align-items-center column-gap-10 w-50">
                                            <div class="d-flex flex-column font-weight-bold w-20px">
                                                <i class="icon-xl far fa-calendar-alt text-success" data-toggle="tooltip" data-theme="dark" data-original-title="Date"></i>
                                            </div>
                                            <div class="d-flex flex-column font-weight-bold">
                                                @php
                                                    $date = App\CustomFunction\CustomFunction::get_date_forment($e_value->confirm_date);
                                                @endphp
                                                <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $date !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if(isset($e_value->event_time) && !empty($e_value->event_time))
                                    <div class="d-flex align-items-center column-gap-10 w-50">
                                        <div class="d-flex flex-column font-weight-bold w-20px">
                                            <i class="icon-xl far fa-clock text-primary" data-toggle="tooltip" data-theme="dark" data-original-title="Time"></i>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            {{-- @php
                                                $time = App\CustomFunction\CustomFunction::get_time_forment($e_value->event_time);
                                            @endphp --}}
                                            @php
                                                $time = App\CustomFunction\CustomFunction::get_time_forment($e_value->event_time);
                                                if($e_value->check_time_slot == 2){
                                                    $get_time_1 = App\CustomFunction\CustomFunction::get_time_forment($e_value->event_time);
                                                    $get_time_2 = App\CustomFunction\CustomFunction::get_time_forment($e_value->confirm_time);
                                                    $time = $get_time_1.' To '.$get_time_2;
                                                }
                                            @endphp
                                            <p class="text-dark line-height-sm font-size-lg m-0">{!! $time !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-start mb-6">
                                @if(isset($e_value->event_type) && !empty($e_value->event_type))
                                    <div class="d-flex align-items-center column-gap-10 w-50">
                                        <div class="d-flex flex-column font-weight-bold w-20px">
                                            @if($e_value->event_type == 'Phone screen')
                                            <i class="icon-xl fas fa-phone-volume text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Type"></i>
                                            @else
                                            <i class="icon-xl socicon-googlegroups text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Type"></i>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            <p class="text-dark line-height-sm font-size-lg m-0">{!! $e_value->event_type !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex align-items-center justify-content-start mb-6">
                                @if(isset($e_value->interview_type) && !empty($e_value->interview_type))
                                    <div class="d-flex align-items-center column-gap-10 w-50">
                                        <div class="d-flex flex-column font-weight-bold w-20px">
                                            @if($e_value->interview_type == 'Face to face interview')
                                            <i class="icon-xl fas fa-people-arrows text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Face to face interview"></i>
                                            @else
                                            <i class="icon-xl fas fa-video text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Video interview"></i>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            <p class="text-dark line-height-sm font-size-lg m-0">{!! $e_value->interview_type !!}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($e_value->interview_type == 'Face to face interview')
                                    @if(isset($e_value->address_select) && !empty($e_value->address_select))
                                        <div class="d-flex align-items-center column-gap-10 w-50">
                                            <div class="d-flex flex-column font-weight-bold w-20px">
                                                <i class="icon-xl far fa-address-book text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Site Address"></i>
                                            </div>
                                            <div class="d-flex flex-column font-weight-bold">
                                                <p class="text-dark line-height-md font-size-lg m-0">{!! App\Models\SiteAddress::addressGet($e_value->address_select) !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if($e_value->interview_type == 'Video interview')
                                        @if(isset($e_value->video_link) && !empty($e_value->video_link))
                                            <div class="d-flex align-items-center column-gap-10 w-50">
                                                <div class="d-flex flex-column font-weight-bold w-20px">
                                                    <i class="icon-xl fas fa-link text-danger" data-toggle="tooltip" data-theme="dark" data-original-title="Video Link"></i>
                                                </div>
                                                <div class="d-flex flex-column font-weight-bold">
                                                    <div class="text-dark line-height-md font-size-lg m-0 word-break-break-word">{!! $e_value->video_link !!}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>

                            @if(isset($e_value->event_description) && !empty($e_value->event_description))
                            <div class="d-flex align-items-center mb-3 w-100">
                                <div class="d-flex flex-column font-weight-bold w-20px">
                                    <i class="icon-xl flaticon-file-2 text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Description"></i>
                                </div>
                                <div class="d-flex flex-column font-weight-bold w-100">
                                    <div class="text-dark line-height-md font-size-lg word-break mb-0 m-l-10">{!! $e_value->event_description !!}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if(isset($event) && !empty($event))
        @foreach($event as $Ukey => $u_value)
            <div class="modal event_edit_modal fade" id="event_edit_{{$u_value->id}}" tabindex="-1" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-650px">
                    <div class="modal-content">
                        <form class="form" action="{{route('comman.editEvent')}}" id="kt_modal_add_event_form" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h2 class="fw-bold" data-kt-calendar="title">Edit Interview</h2>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary kt_modal_add_event_close" data-id="event_edit_{{$u_value->id}}">
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body py-10 px-lg-17">
                                @php
                                    $applictionUserName = null;
                                    if($u_value->job_reference == "1"){
                                        $applictionUserName = App\Models\RecruiterCandidate::recruiterCandidateName($u_value->r_c_id);

                                        $getId = App\Models\RecruiterCandidate::getId($u_value->r_c_id);

                                        $clientData = App\Models\User::clientData($getId);

                                        $company_name_new = null;
                                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                            $company_name_new = $clientData->company_name;
                                        }
                                    }else{
                                        $clientData = App\Models\User::clientData($u_value->user_id);
                                        if(isset($clientData->name) && !empty($clientData->name)){
                                            $name = $clientData->name;
                                        }
                                        if(isset($clientData->lname) && !empty($clientData->lname)){
                                            $lname = $clientData->lname;
                                        }
                                        if(isset($name) && !empty($name)){
                                            $applictionUserName = $name;
                                        }
                                        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                                            $applictionUserName = $name.' '.$lname;
                                        }
                                    }
                                @endphp
                                <div class="fv-row mb-9">
                                    @if($u_value->job_reference == "1")
                                        <h3 class="fw-bold" data-kt-calendar="title" style="display: flex;align-items: center;gap: 10px;">Candidate Name <span class="text-muted d-flex justify-content-center align-items-center gap-10">{!! $applictionUserName !!}<span class="label label-lg label-light-dark label-inline">{!! $company_name_new !!}</span></span></h3>
                                    @else
                                        <h3 class="fw-bold" data-kt-calendar="title" style="display: flex;align-items: center;gap: 10px;">Candidate Name <span class="text-muted d-flex justify-content-center align-items-center gap-10">{!! $applictionUserName !!}</span></h3>
                                    @endif
                                </div>

                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview stage</label>
                                        <div>
                                            <select class="form-control event_type" name="event_type" required  data-id="{{$Ukey}}">
                                                <option value="Phone screen" @if($u_value->event_type == 'Phone screen') selected @endif>Phone screen</option>
                                                <option value="1st interview" @if($u_value->event_type == '1st interview') selected @endif>1st interview</option>
                                                <option value="2nd interview" @if($u_value->event_type == '2nd interview') selected @endif>2nd interview</option>
                                                <option value="3rd interview" @if($u_value->event_type == '3rd interview') selected @endif>3rd interview</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Select User <small>(you can select multiple Users.)</small></label>
                                        <div>
                                            <input type="hidden" name="applied_id" value="@if(isset($u_value->applied_id) && !empty($u_value->applied_id)){!! $u_value->applied_id !!}@endif" />
                                            <input type="hidden" name="id" value="@if(isset($u_value->id) && !empty($u_value->id)){!! $u_value->id !!}@endif" />
                                            <input type="hidden" name="user_id" value="@if(isset($u_value->user_id) && !empty($u_value->user_id)){!! $u_value->user_id !!}@endif" />
                                            <input type="hidden" name="r_c_id"  value="@if(isset($u_value->r_c_id) && !empty($u_value->r_c_id)){!! $u_value->r_c_id !!}@endif" />
                                            <input type="hidden" name="job_reference" value="@if(isset($u_value->job_reference) && !empty($u_value->job_reference)){!! $u_value->job_reference!!}@endif" />
                                            @php
                                                $user_client = App\Models\User::clientDataData($u_value->client_id);
                                                $user_staff = App\Models\User::staffList($u_value->client_id);
                                                $user_clent = App\Models\User::clientListForClient($u_value->client_id);
                                                $staff_data = $user_staff->concat($user_clent)->shuffle();
                                                $staff = $staff_data->concat($user_client)->shuffle();
                                                $event_staff_data = array();
                                                if(isset($u_value->event_staff_select) && !empty($u_value->event_staff_select)){
                                                    $event_staff_data = explode(",",$u_value->event_staff_select);
                                                }
                                            @endphp
                                            <select class="form-control select2" name="event_staff_select[]" multiple="multiple" required disabled>
                                                @if(!empty($staff))
                                                    @foreach($staff as $SKey => $s_value)
                                                        <option value="{!! $s_value->id !!}" @if(in_array($s_value->id, $event_staff_data)) selected @endif>{!! App\Models\User::getUserName($s_value->id) !!} @if($s_value->role == 2)( Main Client )@endif</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview type</label>
                                        <div>
                                            <select class="form-control interview_type" name="interview_type" id="interview_type_{{$Ukey}}" data-id="{{$Ukey}}">
                                                @if($u_value->event_type == 'Phone screen')
                                                    <option value="Telephone call" @if($u_value->interview_type == 'Telephone call') selected @endif>Telephone call</option>
                                                @else
                                                    <option value="Face to face interview" @if($u_value->interview_type == 'Face to face interview') selected @endif>Face to face interview</option>
                                                @endif
                                                <option value="Video interview" @if($u_value->interview_type == 'Video interview') selected @endif>Video interview</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row mb-9" id="video_interview_{{$Ukey}}"  @if($u_value->interview_type == 'Video interview')style="display:block;"@endif @if($u_value->interview_type != 'Video interview') style="display:none;"@endif @if($u_value->interview_type == 'Telephone call')style="display:none;"@endif>
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">video link</label>
                                        <div>
                                            <textarea type="text" class="form-control summernote" placeholder="" name="video_link">@if(isset($u_value->video_link) && !empty($u_value->video_link)) {!! $u_value->video_link !!} @endif</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row mb-9" id="face_to_face_interview_{{$Ukey}}" @if($u_value->interview_type == 'Face to face interview')style="display:block;"@endif @if($u_value->interview_type != 'Face to face interview') style="display:none;"@endif @if($u_value->interview_type == 'Telephone call')style="display:none;"@endif>
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview Address</label>
                                        <div>
                                            @php
                                            $site_address_data = App\Models\SiteAddress::clientAddressGet($u_value->client_id);
                                            @endphp
                                            <select class="form-control address_select" name="address_select" id="address_select">
                                                <option value="" selected="selected" disabled="">Please Select</option>
                                                @if(!empty($staff))
                                                    @foreach($site_address_data as $site_address_data => $s_a_value)
                                                        <option value="{!! $s_a_value->id !!}" @if($u_value->address_select == $s_a_value->id) selected @endif>{!! $s_a_value->site_title !!}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Additional Information</label>
                                        <div>
                                            <textarea type="text" class="form-control" placeholder="" name="event_description">@if(isset($u_value->event_description) && !empty($u_value->event_description)){!! $u_value->event_description !!}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                @if($u_value->check_time_slot == 1)
                                <div class="row row-cols-lg-2 g-10">
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <div class="form-group">
                                                <label class="fs-6 fw-semibold mb-2">Interview Date</label>
                                                <div>
                                                    @php
                                                        if($u_value->check_time_slot == 1){
                                                            $date = App\CustomFunction\CustomFunction::get_date_forment($u_value->event_date);
                                                        }else{
                                                            $date = App\CustomFunction\CustomFunction::get_date_forment($u_value->confirm_date);
                                                        }
                                                    @endphp
                                                    <input class="form-control date" type="text" name="event_date" placeholder="Pick a date" id="event_date" value="{!! $date !!}" required readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="fv-row mb-9">
                                            <div class="form-group">
                                                <label class="fs-6 fw-semibold mb-2">Interview Time</label>
                                                <div>
                                                    @php
                                                        $time = App\CustomFunction\CustomFunction::get_time_forment($u_value->event_time);
                                                        // if($u_value->check_time_slot == 2){
                                                        //     $get_time_1 = App\CustomFunction\CustomFunction::get_time_forment($u_value->event_time);
                                                        //     $get_time_2 = App\CustomFunction\CustomFunction::get_time_forment($u_value->confirm_time);
                                                        //     $time = $get_time_1.' To '.$get_time_2;
                                                        // }
                                                    @endphp
                                                    <input class="form-control event_time" name="event_time" type="text" placeholder="Pick a time"  value="{!! $time !!}" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="fv-row event-date-time-show">
                                    <label class="fs-6 fw-semibold mb-2">Interview Time</label>

                                    @php
                                        $time_slot = array();
                                        if(isset($u_value->time_slot) && !empty($u_value->time_slot)){
                                            $time_slot = json_decode($u_value->time_slot, true);
                                        }
                                    @endphp
                                    @if($u_value->check_time_slot == 2)
                                        @if(isset($time_slot) && !empty($time_slot) && count($time_slot))
                                            @foreach($time_slot as $TimeKey => $time_val)
                                                <div class="timeline-content">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="mr-2">
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                {{-- {{$TimeKey}} --}}
                                                                {{App\CustomFunction\CustomFunction::isFullDate($TimeKey)}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <ul class="widgets-event-div">
                                                            @if(isset($time_val) && !empty($time_val) && count($time_val))
                                                                @foreach($time_val as $TKey => $t_val)
                                                                    @php
                                                                        $add_class = '';
                                                                        $candidates_confirm_time_slot = '';
                                                                        $candidates_confirm_time_slot_class = '';
                                                                        if($u_value->confirm_date == $TimeKey){
                                                                            $t_val_start_time = $t_val['start_time'].':00';
                                                                            $t_val_end_time = $t_val['end_time'].':00';
                                                                            if(($t_val_start_time == $u_value->event_time) && ($t_val_end_time == $u_value->confirm_time)){
                                                                                $add_class = 'active';
                                                                                $candidates_confirm_time_slot = 'Time confirmed by candidate ';
                                                                                $candidates_confirm_time_slot_class = 'candidates-confirm-time-slot';
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <li class="widgets-time-slot {{$add_class}} {{$candidates_confirm_time_slot_class}}">
                                                                        <div data-theme="dark" data-html="true" title="{{$candidates_confirm_time_slot}}">
                                                                        <span>{{App\CustomFunction\CustomFunction::get_time_forment($t_val['start_time'])}} To {{App\CustomFunction\CustomFunction::get_time_forment($t_val['end_time'])}}</span>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                    @php
                                        $candidates_confirm_time_slot = '';
                                    @endphp
                                    @if($u_value->check_time_slot == 1)
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="mr-2">
                                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                        {{-- {{ App\CustomFunction\CustomFunction::get_date_forment($u_value->event_date) }} --}}
                                                        {{App\CustomFunction\CustomFunction::isFullDate($u_value->event_date)}}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="">
                                                <ul class="widgets-event-div">
                                                    @php
                                                        $candidates_confirm_time_slot = 'Time confirmed by candidate ';
                                                    @endphp
                                                    <li class="widgets-time-slot active">
                                                        <div theme="dark" data-html="true" title="{{$candidates_confirm_time_slot}}">
                                                            <span>{{ App\CustomFunction\CustomFunction::get_time_forment($u_value->event_time) }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="modal-footer flex-center">
                                    <button type="reset" data-id="event_edit_{{$u_value->id}}" class="btn btn-light me-3 kt_modal_add_event_cancel">Cancel</button>
                                    <button type="submit" class="btn btn-primary kt_modal_add_event_submit">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>

                            </div>
                            {{-- <div class="modal-footer flex-center">
                                <button type="reset" data-id="event_edit_{{$u_value->id}}" class="btn btn-light me-3 kt_modal_add_event_cancel">Cancel</button>
                                <button type="submit" class="btn btn-primary kt_modal_add_event_submit">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="{!!url('assets/backend')!!}/js/scrollspyNav.js"></script>

    <script type="text/javascript">

        $(function () {

            "use strict";

            var KTCalendarBasic = function () {

                return {
                    init: function () {
                        calendar();
                        outlookCalendar();
                    }
                };
            }();

            $('.select2').select2({placeholder: "Please Select"});

            $('.date').datepicker({
                rtl: KTUtil.isRTL(),
                // autoclose: true,
                startDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                todayHighlight: true,
                format: 'dd-mm-yyyy',
            });

            var dt = new Date();
            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

            function formatAMPM(date) {
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            }
            var time = formatAMPM(dt);
            $(".event_time").timepicker();

            jQuery(document).ready(function () {
                KTCalendarBasic.init();
            });

            $('body').on('click', '.kt_modal_add_event_close', function(e) {
                e.preventDefault();
                var modal_name = $(this).attr('data-id');
                closeButton(modal_name);
            });

            $('body').on('click', '.kt_modal_add_event_cancel', function(e) {
                e.preventDefault();
                var modal_name = $(this).attr('data-id');
                closeButton(modal_name);
            });

            $('body').on('change', '.interview_type', function() {
                var value_interview = $(this).val();
                var field_id = $(this).attr('data-id');

                if(value_interview === "Video interview"){
                    $('#video_interview_'+field_id).show();
                    $('#face_to_face_interview_'+field_id).hide();
                }
                if(value_interview === "Telephone call"){
                    $('#video_interview_'+field_id).hide();
                    $('#face_to_face_interview_'+field_id).hide();
                }
                if(value_interview === "Face to face interview"){
                    $('#video_interview_'+field_id).hide();
                    $('#face_to_face_interview_'+field_id).show();
                }
            });

            $('body').on('change', '.event_type', function() {
                var value_interview = $(this).val();
                var field_id = $(this).attr('data-id');

                if(value_interview === "Phone screen"){
                    $('#interview_type_'+field_id).empty();
                    $('#video_interview_'+field_id).hide();
                    $('#face_to_face_interview_'+field_id).hide();

                    var option = '<option disabled selected>Please Select</option>';
                    option += '<option value="Telephone call">Telephone call</option>';
                    option += '<option value="Video interview">Video interview</option>';
                    $('#interview_type_'+field_id).append(option).trigger('change');

                }else{
                    $('#interview_type_'+field_id).empty();
                    $('#video_interview_'+field_id).hide();
                    $('#face_to_face_interview_'+field_id).hide();

                    var option = '<option disabled selected>Please Select</option>';
                    option += '<option value="Face to face interview">Face to face interview</option>';
                    option += '<option value="Video interview">Video interview</option>';
                    $('#interview_type_'+field_id).append(option).trigger('change');
                }
            });

            $('body').on('click', '#tab_system_calendar', function(e) {
                e.preventDefault();
                $('#kt_calendar').html('');
                setTimeout(function () {
                    calendar();
                }, 500);
            });

            $('body').on('click', '#tab_outlook_calender', function(e) {
                e.preventDefault();
                $('#kt_outlook_calendar').html('');
                setTimeout(function () {
                    outlookCalendar();
                }, 500);
            });

        });

        function closeButton(modal_name) {
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    setTimeout(function () {
                        $('#'+modal_name).modal('hide');
                    }, 500);
                }
            });
        }

        function deleteButton(modal_name,id) {
            Swal.fire({
                text: "Are you sure you would like to delete?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('comman.deleteEvent')}}",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id: id,
                        },
                        beforeSend: function() {
                            $.LoadingOverlay("show");
                            $('.modal').modal('hide');
                            $('.modal-backdrop').remove();
                        },
                        success: function(data) {
                            if (data.code == 1) {
                                $('#calendar_event_data').text('');
                                $('#calendar_event_data').text(data.event_data);
                                calendar();
                                setTimeout(function () {
                                    $.LoadingOverlay("hide");
                                    show_toastr('success','Interview successfully delete.', '');
                                }, 1000);
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);

                            } else {
                                show_toastr('error','Please try again', '');
                            }
                        },
                        error: function(jqXhr, textStatus,errorThrown) {
                            show_toastr('error','Please try again','');
                        }
                    });
                }
            });
        }

        function calendar(){

            $('#kt_calendar').html('');

            var events_data = [];

            var events = $('#calendar_event_data').text();
            var json_obj = jQuery.parseJSON(events);

            var user_id = '{{Auth::user()->role}}';
            var defaultView = 'timeGridWeek';
            // if(user_id == 4){
            //     var defaultView = 'dayGridMonth';
            // }else{
            //     var defaultView = 'timeGridWeek';
            // }

            var exists = jQuery.isEmptyObject(json_obj);
            if (exists == false) {
                for (var i in json_obj)
                {
                    var obj_events_ar = {};

                    if(json_obj[i].check_time_slot == 1){
                        obj_events_ar['date'] = json_obj[i].event_date+' '+json_obj[i].event_time;
                    }else{
                        obj_events_ar['date'] = json_obj[i].confirm_date+' '+json_obj[i].event_time;
                    }
                    // obj_events_ar['date'] = json_obj[i].confirm_date+' '+json_obj[i].event_time;
                    obj_events_ar['title'] = json_obj[i].event_title;
                    obj_events_ar['id'] = json_obj[i].id;
                    obj_events_ar['description'] = json_obj[i].event_title;
                    if(json_obj[i].event_type == "Phone screen" ){
                        obj_events_ar['className'] = 'fc-event-solid-warning';
                    }else if(json_obj[i].event_type == "1st interview" ){
                        obj_events_ar['className'] = 'fc-event-solid-success';
                    }else if(json_obj[i].event_type == "2nd interview" ){
                        obj_events_ar['className'] = 'fc-event-solid-primary';
                    }else if(json_obj[i].event_type == "3rd interview" ){
                        obj_events_ar['className'] = 'fc-event-solid-info';
                    }


                    events_data.push(obj_events_ar);
                }
            }

            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('kt_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                // themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    left: 'title,prev,next,today',
                    // center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    right: 'timeGridWeek'
                },

                height: 900,
                contentHeight: 880,
                aspectRatio: 3,
                nowIndicator: true,
                now: TODAY, // just for demo

                views: {
                    dayGridMonth: {buttonText: 'month'},
                    timeGridWeek: {buttonText: 'week'},
                    timeGridDay: {buttonText: 'day'},
                    month: {
                        eventLimit: 3
                    }
                },

                defaultView: defaultView,
                defaultDate: TODAY,

                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                droppable: false,
                disableDragging: false,
                events: events_data,

                eventRender: function (info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                },

                eventClick:  function(event, jsEvent, view) {
                    var modal_name = "#event_"+event.event._def.publicId;
                    $(modal_name).modal('show');
                },
            });

            calendar.render();
        }

        function outlookCalendar(){

            $('#kt_outlook_calendar').html('');

            var events_data = [];

            var events = $('#outlook_calendar_event_data').text();
            var json_obj = jQuery.parseJSON(events);

            var exists = jQuery.isEmptyObject(json_obj);
            if (exists == false) {
                for (var i in json_obj)
                {
                    var obj_events_ar = {};

                    obj_events_ar['start'] = json_obj[i].startdate;
                    obj_events_ar['end'] = json_obj[i].enddate;
                    obj_events_ar['title'] = json_obj[i].title;
                    obj_events_ar['description'] = json_obj[i].title;
                    obj_events_ar['className'] = 'fc-event-solid-info';

                    events_data.push(obj_events_ar);
                }
            }

            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('kt_outlook_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list'],
                // themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    left: 'title,prev,next,today',
                    // center: 'title',
                    right: 'timeGridWeek' /*dayGridMonth,timeGridWeek,timeGridDay*/
                },

                height: 900,
                contentHeight: 880,
                aspectRatio: 3,
                nowIndicator: true,
                now: TODAY, // just for demo

                views: {
                    dayGridMonth: {buttonText: 'month'},
                    timeGridWeek: {buttonText: 'week'},
                    timeGridDay: {buttonText: 'day'},
                    month: {
                        eventLimit: 3
                    }
                },

                defaultView: 'timeGridWeek',
                defaultDate: TODAY,

                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                droppable: false,
                disableDragging: false,
                events: events_data,

                eventRender: function (info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                },

                eventClick:  function(event, jsEvent, view) {
                    var modal_name = "#event_"+event.event._def.publicId;
                    $(modal_name).modal('show');
                },
            });

            calendar.render();
        }
    </script>
    <script>
        var KTCkeditor = function() {
            // Private functions
            var demos = function() {
                $('.summernote').summernote({
                    height: 100,
                    disableDragAndDrop:true,
                    dialogsInBody: true,
                    toolbar: [
                        // ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['insert', ['link']],
                        // ['para', ['ul', 'ol', 'paragraph']],
                        // ['table', ['table']],
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
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor.init();
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            $('body').on('click', '.open-tooltip-custom', function() {
                var modal_name = $(this).attr('data-target');
                var pic_wrapper = $(modal_name);

                pic_wrapper.on('mouseenter', '.widgets-time-slot.active div', function(e) {
                    $(this).attr('title');
                    $(this).attr('theme');
                    $(this).tooltip({
                        boundary: 'window',
                        template:'<div class="tooltip tooltip-dark fade bs-tooltip-top" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    });
                    $(this).tooltip('show');
                });

            });
        });
    </script>
@stop
