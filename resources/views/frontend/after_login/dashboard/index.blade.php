@extends('admin.layouts.common')

@section('title', 'Dashboard')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    @php
        $route_name = App\CustomFunction\CustomFunction::role_name();
    @endphp

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row justify-content-space-between">
                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Recent Applications</span>
                                </h3>
                            </div>
                            <div class="card-body  pt-0">
                                <div class="tab-content" id="myTabTables11">
                                    <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                                        <div class="candidate-table">
                                            @if(isset($job_applied) && !empty($job_applied) && count($job_applied))
                                                @if(!empty($job_applied))
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach($job_applied as $key => $value)
                                                        @php
                                                            $count++;
                                                        @endphp
                                                        <div class="row align-items-center justify-content-left m-b-10 @if($loop->iteration % 2 == 0) appl-even @else appl-odd @endif">
                                                            <div class="col-md-2 col-4 line-height-1 mobile-order-1">
                                                                <div class="symbol symbol-white w-100 symbol-w-100">
                                                                    <span class="symbol-label">
                                                                        @php
                                                                            if(isset($value->company_logo) && !empty($value->company_logo)){
                                                                                $logo =  url('uploads').'/client_profile/'.$value->company_logo;
                                                                            }else{
                                                                                $logo = site_header_logo;
                                                                            }
                                                                            $company_name = $value->company_name;
                                                                            if(isset($value->sub_company) && !empty($value->sub_company)){
                                                                                $client_detail = App\Models\SubCompany::getSubCompanyData($value->sub_company);
                                                                                $company_name = $client_detail->company_name;
                                                                                $logo =  url('uploads').'/client_profile/'.$client_detail->company_logo;
                                                                            }
                                                                        @endphp
                                                                        <img src="{{$logo}}" class="align-self-center img-fluid p-5px symbol-img-display" alt="">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7 col-12 p-0 mobile-order-3">
                                                                <a href="{{route('getJobDetail',['id' => $value->slug])}}" target="_blank" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif</a>
                                                                {{-- <div>
                                                                    <span class="font-weight-bolder">Email:</span>
                                                                    <a class="text-muted font-weight-bold text-hover-primary" href="mailto:@if(isset($value->email) && !empty($value->email)){!! $value->email !!}@endif">@if(isset($value->email) && !empty($value->email)){!! $value->email !!}@endif</a>
                                                                </div> --}}
                                                                <div>
                                                                    <span class="font-weight-bolder">Company Name:</span>
                                                                    <a class="text-dark-75 font-weight-normal text-hover-primary" href="javascript:void(0)">{!! $company_name !!}</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-8 mobile-order-2">
                                                                @php
                                                                    $job_stage = $value->job_stage;
                                                                    $job_workflow_id = $value->job_workflow_id;
                                                                    $satge_name = App\Models\JobWorkFlowStage::candidateStageGet($job_stage,$job_workflow_id);
                                                                @endphp
                                                                @if($value->job_status)
                                                                    <span class="label label-lg label-light-success label-inline cursor-pointer float-right" data-toggle="tooltip" data-theme="dark" data-html="true" title="Successful">@if(isset($satge_name->stage_name) && !empty($satge_name->stage_name)){!! $satge_name->stage_name !!}@endif</span>
                                                                @else
                                                                    <span class="label label-lg label-light-danger label-inline cursor-pointer float-right" data-toggle="tooltip" data-theme="dark" data-html="true" title="Unsuccessful">@if(isset($satge_name->stage_name) && !empty($satge_name->stage_name)){!! $satge_name->stage_name !!}@endif</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @else
                                                <p class="pl-0">No application</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Offers</span>
                                </h3>
                            </div>
                            <div class="card-body  pt-0">
                                <div class="tab-content" id="myTabTables11">
                                    <div class="tab-pane fade active show" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                                        <div class="candidate-table">
                                            @if(isset($offer_data) && !empty($offer_data) && count($offer_data))
                                                @if(!empty($offer_data))
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach($offer_data as $key => $o_value)
                                                        @php
                                                            $count++;
                                                            $vacancy_data = App\Models\JobVacancy::jobGet($o_value->vacancy_id);
                                                            $client_data = App\Models\User::clientData($o_value->client_id);
                                                            if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                                                $logo =  url('uploads').'/client_profile/'.$client_data->company_logo;
                                                            }else{
                                                                $logo = site_header_logo;
                                                            }
                                                            $hiring_manager = App\Models\JobApplied::hiringManager($o_value->vacancy_id);
                                                            $hiring_manager_arr = explode(",",$hiring_manager);
                                                            $count = count($hiring_manager_arr);
                                                            if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                                $hiring = $hiring_manager_arr[0];
                                                            }else{
                                                                $hiring = $o_value->client_id;
                                                            }
                                                        @endphp

                                                        <div class="row align-items-center justify-content-left m-b-10 @if($loop->iteration % 2 == 0) appl-even @else appl-odd @endif">
                                                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4 line-height-1 mobile-order-1">
                                                                <div class="symbol symbol-white w-100 symbol-w-100">
                                                                    <span class="symbol-label">
                                                                        @php
                                                                            if(isset($value->company_logo) && !empty($value->company_logo)){
                                                                                $logo =  url('uploads').'/client_profile/'.$value->company_logo;
                                                                            }else{
                                                                                $logo = site_header_logo;
                                                                            }
                                                                        @endphp
                                                                        <img src="{{$logo}}" class="align-self-center img-fluid p-5px symbol-img-display" alt="">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-10 col-lg-9 col-md-8 col-sm-8 col-8 p-0 mobile-order-3">
                                                                <a href="{{route('candidate.offerGet')}}" target="_blank" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">@if(isset($o_value->vacancy_id) && !empty($o_value->vacancy_id)){!! App\Models\JobVacancy::jobName($o_value->vacancy_id) !!}@endif</a>
                                                                <div class="d-flex gap-10">
                                                                    <span class="font-weight-bolder">Company:</span>
                                                                    <p class="text-muted font-weight-bold text-hover-primary m-0">@if(isset($client_data->company_name) && !empty($client_data->company_name)){{$client_data->company_name}}@endif</p>
                                                                </div>
                                                                <div class="d-flex gap-10">
                                                                    <span class="font-weight-bolder">Hiring Manager:</span>
                                                                    <p class="text-muted font-weight-bold text-hover-primary m-0">{!! App\Models\User::getUserName($hiring) !!}</p>
                                                                </div>
                                                                <div class="d-flex gap-10">
                                                                    <span class="font-weight-bolder">Offered Salary:</span>
                                                                    <p class="text-muted font-weight-bold text-hover-primary m-0">£@if(isset($o_value->offered_salary) && !empty($o_value->offered_salary)){{$o_value->offered_salary}}@endif</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @else
                                                <p class="pl-0">No offer</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Pending request for interview</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-direction-column pt-0">

                                <div class="tab-content event-applied-content row" id="job_pending_event_data">
                                    @if(isset($job_pending_event) && !empty($job_pending_event) && count($job_pending_event))
                                        @foreach($job_pending_event as $Ekey => $j_p_e_value)
                                            @php
                                                $url = $route_name.".getEventTime";
                                                $event_id = $j_p_e_value['event_slug'];
                                                if(isset($event_id) && !empty($event_id)){
                                                    $route_event = route($url,$event_id);    
                                                }else{
                                                    $route_event = "javascript:;";
                                                }
                                            @endphp
                                            <div class="job_event_data_pending_content col-md-12 col-sm-12">
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-5 even">
                                                    <div class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="w-100">
                                                            <div class="d-flex align-items-center mb-6">
                                                                    @php
                                                                        $vacancy = App\Models\JobVacancy::jobName($j_p_e_value['vacancy_id']);
                                                                    @endphp
                                                                    <p class="text-dark font-bold text-center line-height-sm font-size-lg m-0">{!! $vacancy !!}</p>
                                                            </div>
                                        
                                                            <div class="d-flex align-items-center row row-gap-10">
                                                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                                                    <div class="d-flex align-items-center row row-gap-10">
                                                                        @if(isset($j_p_e_value['event_type']) && !empty($j_p_e_value['event_type']))
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        @if($j_p_e_value['event_type'] == 'Phone screen')
                                                                                            <i class="font-20 fas fa-phone-volume text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                                        @else
                                                                                            <i class="icon-xl socicon-googlegroups text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! $j_p_e_value['event_type'] !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        @if(isset($j_p_e_value['event_staff_select']) && !empty($j_p_e_value['event_staff_select']))
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 fas fa-user text-info" data-toggle="tooltip" data-theme="dark" title="Staff"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        @php
                                                                                            $staff = '';
                                                                                            $event_staff_data = explode(",",$j_p_e_value['event_staff_select']);
                                                                                        @endphp
                                                                                        <p class="text-dark line-height-sm font-size-lg mb-1 text-capitalize">
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
                                                                            </div>
                                                                        @endif

                                                                        @if(isset($j_p_e_value['client_id']) && !empty($j_p_e_value['client_id']))
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                @php
                                                                                    $clientData = App\Models\User::clientData($j_p_e_value['client_id']);
                                                                                    $companyname = '-';
                                                                                    if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                                                        $companyname = $clientData->company_name;
                                                                                    }
                                                                                @endphp
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 fas fa-building text-info" data-toggle="tooltip" data-theme="dark" title="Company Name"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! $companyname !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                                                    <div class="d-flex align-items-center row row-gap-10">
                                                                        <div class="col-12">
                                                                            <div class="text-center">
                                                                                <a href="{{$route_event}}" class="btn btn-sm btn-light-primary fw-bold mb-3 w-md-100 w-100">Schedule</a>
                                                                                <button type="button" class="btn btn-sm btn-light-danger fw-bold w-md-100 w-100" data-event-id="{!!$j_p_e_value['id']!!}" data-event-status="2" data-event-type="" onclick="eventCancel({!!$j_p_e_value['id']!!},2,null)">Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                        
                                                            </div>
                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="pl-4">No pending request for interview</p>
                                    @endif
                                </div>
                                <div class="text-center mt-auto @if($job_pending_event_count > 2) d-block @else d-none @endif">
                                    <button class="btn btn-primary font-weight-bolder" id="load_more_pending_event">Load More</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Upcoming Interview for next 14 days</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-direction-column pt-0">

                                <div class="tab-content event-applied-content row" id="job_event_data">
                                    @if(isset($job_event) && !empty($job_event) && count($job_event))
                                        @foreach($job_event as $Ekey => $p_e_value)
                                            @php
                                                $url = $route_name.".getEventTime";
                                                $event_id = $p_e_value['event_slug'];
                                                if(isset($event_id) && !empty($event_id)){
                                                    $route_event = route($url,$event_id);    
                                                }else{
                                                    $route_event = "javascript:;";
                                                }
                                            @endphp
                                            <div class="job_event_data_content col-md-12 col-sm-12">
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-5 even">
                                                    <div class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="w-100">
                                                            <div class="d-flex align-items-center mb-6">
                                                                    @php
                                                                        $vacancy = App\Models\JobVacancy::jobName($p_e_value['vacancy_id']);
                                                                    @endphp
                                                                    <p class="text-dark font-bold text-center line-height-sm font-size-lg m-0">{!! $vacancy !!}</p>
                                                            </div>
                                        
                                                            <div class="d-flex align-items-center row row-gap-10">

                                                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                                                    <div class="d-flex align-items-center row row-gap-10">
                                                                        @if(isset($p_e_value['confirm_date']) && !empty($p_e_value['confirm_date']))
                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 far fa-calendar-alt text-success" data-toggle="tooltip" data-theme="dark" title="Date"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0 ">{!! App\CustomFunction\CustomFunction::get_date_forment($p_e_value['confirm_date']) !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($p_e_value['event_time']) && !empty($p_e_value['event_time']))
                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 far fa-clock text-primary" data-toggle="tooltip" data-theme="dark" title="Time"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! App\CustomFunction\CustomFunction::get_time_forment($p_e_value['event_time']) !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($p_e_value['event_type']) && !empty($p_e_value['event_type']))
                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        @if($p_e_value['event_type'] == 'Phone screen')
                                                                                            <i class="font-20 fas fa-phone-volume text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                                        @else
                                                                                            <i class="icon-xl socicon-googlegroups text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! $p_e_value['event_type'] !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($p_e_value['client_id']) && !empty($p_e_value['client_id']))
                                                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                @php
                                                                                    $clientData = App\Models\User::clientData($p_e_value['client_id']);
                                                                                    $companyname = '-';
                                                                                    if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                                                        $companyname = $clientData->company_name;
                                                                                    }
                                                                                @endphp
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 fas fa-building text-info" data-toggle="tooltip" data-theme="dark" title="Company Name"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! $companyname !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if(isset($p_e_value['event_staff_select']) && !empty($p_e_value['event_staff_select']))
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 fas fa-user text-info" data-toggle="tooltip" data-theme="dark" title="Staff"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        @php
                                                                                            $staff = '';
                                                                                            $event_staff_data = explode(",",$p_e_value['event_staff_select']);
                                                                                        @endphp
                                                                                        <p class="text-dark line-height-sm font-size-lg mb-1 text-capitalize">
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
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                                                    <div class="d-flex align-items-center row row-gap-10">
                                                                        <div class="col-12">
                                                                            <div class="text-center">
                                                                                @if($p_e_value['check_time_slot'] == 1)
                                                                                <button type="button" class="btn btn-sm btn-light-danger fw-bold w-md-100 w-100" data-event-id="{!!$p_e_value['id']!!}" data-event-status="3" data-event-type="cancel" onclick="eventCancel({!!$p_e_value['id']!!},3,'cancel')">Cancel</button>
                                                                                @else
                                                                                <a href="{{$route_event}}" class="btn btn-sm btn-light-primary fw-bold mb-3 w-md-100 w-100">Re Schedule</a>
                                                                                <button type="button" class="btn btn-sm btn-light-danger fw-bold w-md-100 w-100" data-event-id="{!!$p_e_value['id']!!}" data-event-status="3" data-event-type="cancel" onclick="eventCancel({!!$p_e_value['id']!!},3,'cancel')">Cancel</button>
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
                                        @endforeach
                                    @else
                                        <p class="pl-4">No upcoming interview</p>
                                    @endif
                                </div>
                                <div class="text-center mt-auto @if($job_event_count > 2) d-block @else d-none @endif">
                                    <button class="btn btn-primary font-weight-bolder" id="load_more_event">Load More</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body">
                                <div id="calendar_event_data" style="display: none;visibility: hidden">{{ $event_data }}</div>
                                <div id="kt_calendar"></div>
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
                        <div class="modal-header border-0 justify-content-end pb-0">
                            <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-dismiss="modal" aria-label="Close" data-kt-initialized="1">
                                <span class="svg-icon svg-icon-1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="modal-body pb-10 px-lg-17 pt-0">
                            @if(isset($e_value->vacancy_id) && !empty($e_value->vacancy_id))
                                <div class="d-flex align-items-center mb-6">
                                    <div class="d-flex flex-column font-weight-bold">
                                        @php
                                            $vacancy = App\Models\JobVacancy::jobName($e_value->vacancy_id);
                                        @endphp
                                        <h3 class="text-dark line-height-sm m-0 ">{!! $vacancy !!}</h3>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex align-items-center mb-6">
                                @if(isset($e_value->user_id) && !empty($e_value->user_id))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
                                        <div class="d-flex flex-column font-weight-bold w-20px">
                                            <i class="icon-xl far fa-user text-warning" data-toggle="tooltip" data-theme="dark" data-original-title="User"></i>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            @php
                                                $user = App\Models\User::getUserName($e_value->user_id);
                                            @endphp
                                            <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $user !!}</p>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($e_value->event_staff_select) && !empty($e_value->event_staff_select))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                            <div class="d-flex align-items-center mb-6">
                                @if(isset($e_value->event_date) && !empty($e_value->event_date))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                                @if(isset($e_value->event_time) && !empty($e_value->event_time))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                            <div class="d-flex align-items-center mb-6">
                                @if(isset($e_value->event_type) && !empty($e_value->event_type))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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

                            <div class="d-flex align-items-center mb-6">
                                @if(isset($e_value->interview_type) && !empty($e_value->interview_type))
                                    <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                                        <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                                            <div class="d-flex align-items-center justify-content-start column-gap-10 w-50">
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
                                <div class="d-flex flex-column font-weight-bold">
                                    <i class="icon-xl flaticon-file-2 text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Description"></i>
                                </div>
                                <div class="d-flex flex-column font-weight-bold m-l-10 w-100">
                                    <div class="text-dark line-height-md font-size-lg word-break m-0">{!! $e_value->event_description !!}</div>
                                </div>
                            </div>
                            @endif
                        </div>
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
                    }
                };
            }();

            jQuery(document).ready(function () {
                KTCalendarBasic.init();
            });

            // events data get
            $(".job_event_data_content").slice(0, 2).show();
            $( "body" ).on( "click", "#load_more_event", function(e) {
                e.preventDefault();
                $(".job_event_data_content:hidden").slice(0, 2).slideDown();
                if($(".job_event_data_content:hidden").length == 0) {
                    $("#load_more_event").hide();
                }
            });
            
            $(".job_event_data_pending_content").slice(0, 2).show();
            $( "body" ).on( "click", "#load_more_pending_event", function(e) {
                e.preventDefault();
                $(".job_event_data_pending_content:hidden").slice(0, 2).slideDown();
                if($(".job_event_data_pending_content:hidden").length == 0) {
                    $("#load_more_pending_event").hide();
                }
            });

        });

        function eventCancel(event_id,event_status,event_type) {
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{!! route('candidate.getEventTimeReject') !!}",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id: event_id,
                            event_status: event_status,
                            event_type: event_type,
                        },
                        beforeSend: function() {
                            $.LoadingOverlay("show");
                        },
                        success: function(data) {
                            if (data.code == 1) {
                                show_toastr('success',data.msg, '');
                            } else {
                                show_toastr('error',data.msg, '');
                            }
                            $.LoadingOverlay("hide");
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function(jqXhr, textStatus,errorThrown) {
                            $.LoadingOverlay("hide");
                            show_toastr(textStatus,'Please try again','');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                    });
                }
            });
        }

        function calendar(){
            var events_data = [];

            var events = $('#calendar_event_data').text();
            var json_obj = jQuery.parseJSON(events);

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

                plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    right: 'dayGridMonth,timeGridWeek'
                },

                height: 900,
                contentHeight: 880,
                aspectRatio: 3, 

                nowIndicator: true,
                now: TODAY,

                views: {
                    dayGridMonth: {buttonText: 'month'},
                    timeGridWeek: {buttonText: 'week'},
                    timeGridDay: {buttonText: 'day'},
                    month: {
                        eventLimit: 2
                    }
                },

                defaultView: 'timeGridWeek',
                defaultDate: TODAY,

                editable: false,
                eventLimit: true,
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
@stop 
