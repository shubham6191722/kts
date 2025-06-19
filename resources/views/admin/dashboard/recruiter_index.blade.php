@extends('admin.layouts.common')

@section('title', 'Dashboard')

@section('headerScripts')
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
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Live jobs</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-direction-column pt-0">
                                <div class="tab-content event-applied-content" id="job_applied_data">
                                    <div class="job_applied_data_content">
                                        @if(isset($job_vacancy) && !empty($job_vacancy) && count($job_vacancy))
                                            @foreach($job_vacancy as $Pkey => $j_v_value)
                                                @php
                                                    $url = $route_name.".recruiterViewVacancy";
                                                    $route = route($url,['id' => $j_v_value->id]);
                                                @endphp
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-2 even">
                                                    <a href="{{$route}}" class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="width-23 text-center">
                                                            @php
                                                                if(isset($j_v_value['user_select']) && !empty($j_v_value['user_select'])){
                                                                    $logo_client = App\Models\User::clientData($j_v_value['user_select']);
                                                                    $logo =  site_header_logo;
                                                                    $logo_class = 'symbol-light-dark';
                                                                    if(file_exists('uploads/client_profile/'.$logo_client->company_logo)){
                                                                        $logo =  url('uploads').'/client_profile/'.$logo_client->company_logo;
                                                                        $logo_class = 'symbol-white';
                                                                    }
                                                                }else{
                                                                    $logo_class = 'symbol-light-dark';
                                                                    $logo = site_header_logo;
                                                                }
                                                            @endphp
                                                            <div class="symbol symbol-100 {{$logo_class}}">
                                                                <span class="symbol-label">
                                                                    <img src="{!! $logo !!}" class="h-50 align-self-center img-fluid p-5px" alt="">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="width-75">
                                                            <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{!!  $j_v_value->jobtitle !!}</span>
                                                            @if(isset($j_v_value->jobtenure) && !empty($j_v_value->jobtenure))
                                                                <div>
                                                                    @php
                                                                        if($j_v_value->jobtenure == 'permanent'){
                                                                            $jobtenure = 'Permanent';
                                                                        }elseif($j_v_value->jobtenure == 'fixed-term-contract'){
                                                                            $jobtenure = 'Fixed term-contract';
                                                                        }elseif($j_v_value->jobtenure == 'temporary'){
                                                                            $jobtenure = 'Temporary';
                                                                        }elseif($j_v_value->jobtenure == 'part-time'){
                                                                            $jobtenure = 'Part time';
                                                                        }
                                                                    @endphp
                                                                    <span class="font-weight-bolder">Employment Type:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! $jobtenure !!}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($j_v_value->rateupper) && !empty($j_v_value->rateupper))
                                                                <div>
                                                                    <span class="font-weight-bolder">Annual salary:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">£{!! App\CustomFunction\CustomFunction::number_format($j_v_value->rateupper) !!}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($j_v_value->locatedregion) && !empty($j_v_value->locatedregion))
                                                                <div>
                                                                    <span class="font-weight-bolder">Region:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!!  App\Models\Region::regionName($j_v_value->locatedregion) !!}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($j_v_value->categoryid) && !empty($j_v_value->categoryid))
                                                                <div>
                                                                    <span class="font-weight-bolder">Job Category:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! App\Models\JobCategory::categoryName($j_v_value->categoryid) !!}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($j_v_value->occupationid) && !empty($j_v_value->occupationid))
                                                                <div>
                                                                    <span class="font-weight-bolder">Job Sub Category:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! App\Models\JobOccupation::occupationName($j_v_value->occupationid) !!}</span>
                                                                </div>
                                                            @endif
                                                            @if(isset($j_v_value->levelid) && !empty($j_v_value->levelid))
                                                                <div>
                                                                    <span class="font-weight-bolder">Job Level:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! App\Models\JobLevel::levelName($j_v_value->levelid) !!}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="pl-0">No Vacancy</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center mt-auto @if($job_vacancy_count > 2) d-block @else d-none @endif">
                                    <button class="btn btn-primary font-weight-bolder" id="load_more_job_applied">Load More</button>
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
                            <div class="card-body d-flex flex-direction-column pt-0">
                                <div class="tab-content event-applied-content" id="job_pending_offers_data">
                                    @if(isset($pending_offer) && !empty($pending_offer) && count($pending_offer))
                                        @foreach($pending_offer as $Pkey => $p_o_value)
                                            @php
                                                $url = $route_name.".offerList";
                                                $route = route($url);
                                            @endphp
                                            <div class="job_pending_offers_data_content">
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-5 @if($loop->iteration % 2 == 0) odd @else even @endif">
                                                    <a href="{!! $route !!}" class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="w-100">
                                                            <div class="d-flex align-items-center mb-6">
                                                                <p class="text-dark font-bold text-center line-height-sm font-size-lg m-0" data-toggle="tooltip" data-theme="dark" data-original-title="Vacancy Title">@if(isset($p_o_value['vacancy_id']) && !empty($p_o_value['vacancy_id'])){!! App\Models\JobVacancy::jobName($p_o_value['vacancy_id']) !!}@endif</p>
                                                            </div>
                                                            <div class="d-flex align-items-center row row-gap-10">
                                                                @php
                                                                    if($p_o_value['job_reference'] == 1){
                                                                        $candidate_tooltip = 'Candidate Name';
                                                                        $candidate_name = App\Models\RecruiterCandidate::recruiterCandidateName($p_o_value['candidate_id']);
                                                                    }else{
                                                                        $candidate_tooltip = 'Candidate';
                                                                        if(isset($p_o_value['candidate_id']) && !empty($p_o_value['candidate_id'])){
                                                                            $candidate_name = App\Models\User::getUserName($p_o_value['candidate_id']);
                                                                        }
                                                                    }
                                                                @endphp

                                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="d-flex align-items-center column-gap-10 w-100">
                                                                        <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                            <i class="font-20 far fa-user text-warning" data-toggle="tooltip" data-theme="dark" data-original-title="{{$candidate_tooltip}}"></i>
                                                                        </div>
                                                                        <div class="d-flex flex-column font-weight-bold">
                                                                            <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $candidate_name !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="d-flex align-items-center column-gap-10 w-100">
                                                                        <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                            <i class="font-20 fas fa-user text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Hiring Manager"></i>
                                                                        </div>
                                                                        <div class="d-flex flex-column font-weight-bold">
                                                                            @php
                                                                                $hiring_manager = App\Models\JobApplied::hiringManager($p_o_value['vacancy_id']);
                                                                                $hiring_manager_arr = explode(",",$hiring_manager);
                                                                                $count = count($hiring_manager_arr);
                                                                                if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                                                    $hiring = $hiring_manager_arr[0];
                                                                                }else{
                                                                                    $hiring = $p_o_value['client_id'];
                                                                                }
                                                                            @endphp
                                                                            <p class="text-dark line-height-sm font-size-lg m-0 ">{!! App\Models\User::getUserName($hiring) !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="d-flex align-items-center column-gap-10 w-100">
                                                                        <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                            <i class="font-20 far fa-calendar-alt text-success" data-toggle="tooltip" data-theme="dark" data-original-title="Suggested start date"></i>
                                                                        </div>
                                                                        <div class="d-flex flex-column font-weight-bold">
                                                                            @php
                                                                                $newformat = null;
                                                                                if(isset($p_o_value['suggested_date']) && !empty($p_o_value['suggested_date'])){
                                                                                    $time = strtotime($p_o_value['suggested_date']);

                                                                                    $newformat = date('d-m-Y',$time);
                                                                                }
                                                                            @endphp
                                                                            <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $newformat !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                    <div class="d-flex align-items-center column-gap-10 w-100">
                                                                        <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                            <i class="font-20 far fa-pound-sign text-primary" data-toggle="tooltip" data-theme="dark" data-original-title="Offered salary"></i>
                                                                        </div>
                                                                        <div class="d-flex flex-column font-weight-bold">
                                                                            <p class="text-dark line-height-sm font-size-lg m-0">@if(isset($p_o_value['offered_salary']) && !empty($p_o_value['offered_salary'])){!! App\CustomFunction\CustomFunction::number_format($p_o_value['offered_salary']) !!}@endif</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="pl-0">No offer</p>
                                    @endif
                                </div>
                                <div class="text-center mt-auto @if($pending_offer_count > 2) d-block @else d-none @endif">
                                    <button class="btn btn-primary font-weight-bolder" id="load_more_pending_offers">Load More</button>
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

                                                                        @if(isset($j_p_e_value['r_c_id']) && !empty($j_p_e_value['r_c_id']))
                                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                                <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                    <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                        <i class="font-20 fas fa-user text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                                    </div>
                                                                                    <div class="d-flex flex-column font-weight-bold">
                                                                                        @php
                                                                                            $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($j_p_e_value['r_c_id']);
                                                                                        @endphp
                                                                                        <p class="text-dark line-height-sm font-size-lg m-0">{!! $user_name !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

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
                                                                                        <i class="font-20 fas fa-users text-info" data-toggle="tooltip" data-theme="dark" title="Staff"></i>
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
                                                                                {{-- <form action="{!! route('recruiter.getEventTimeReject') !!}" method="post">
                                                                                    <input type="hidden" name="id" value="{!!$j_p_e_value['id']!!}" />
                                                                                    <input type="hidden" name="event_status" value="2" />
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm btn-light-danger fw-bold w-md-100 w-100">Reject</button>
                                                                                </form> --}}
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
                                    <span class="card-label font-weight-bolder text-dark">Upcoming Interview for next 7 days</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-direction-column pt-0">

                                <div class="tab-content event-applied-content row" id="job_event_data">
                                    @if(isset($job_event) && !empty($job_event) && count($job_event))
                                        @foreach($job_event as $Ekey => $p_e_value)
                                            @php
                                                $url = $route_name.".eventList";
                                                $route = route($url);

                                                $url1 = $route_name.".getEventTime";
                                                $event_id = $p_e_value['event_slug'];
                                                if(isset($event_id) && !empty($event_id)){
                                                    $route_event = route($url1,$event_id);    
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
                                                                        @if($p_e_value['check_time_slot'] == 1)
                                                                            @if(isset($p_e_value['event_date']) && !empty($p_e_value['event_date']))
                                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                                                    <div class="d-flex align-items-center column-gap-10 w-100">
                                                                                        <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                            <i class="font-20 far fa-calendar-alt text-success" data-toggle="tooltip" data-theme="dark" title="Date"></i>
                                                                                        </div>
                                                                                        <div class="d-flex flex-column font-weight-bold">
                                                                                            <p class="text-dark line-height-sm font-size-lg m-0 ">{!! App\CustomFunction\CustomFunction::get_date_forment($p_e_value['event_date']) !!}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @else
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
                                                                        @endif

                                                                        {{-- @if($p_e_value['check_time_slot'] == 1) --}}
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
                                                                        {{-- @else
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
                                                                        @endif --}}

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
                                                                                    <a href="{{$route}}" class="btn btn-sm btn-light-warning fw-bold mb-3 w-md-100 w-100">View</a>
                                                                                    <button type="button" class="btn btn-sm btn-light-danger fw-bold w-md-100 w-100" data-event-id="{!!$p_e_value['id']!!}" data-event-status="3" data-event-type="cancel" onclick="eventCancel({!!$p_e_value['id']!!},3,'cancel')">Cancel</button>
                                                                                @else
                                                                                    <a href="{{$route_event}}" class="btn btn-sm btn-light-primary fw-bold mb-3 w-md-100 w-100">Re Schedule</a>
                                                                                    <a href="{{$route}}" class="btn btn-sm btn-light-warning fw-bold mb-3 w-md-100 w-100">View</a>
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
    </div>
@stop

@section('footerScripts')
    <script>

        $(document).ready(function(){

            // pending offer data get
            $(".job_pending_offers_data_content").slice(0, 2).show();
            $( "body" ).on( "click", "#load_more_pending_offers", function(e) {
                e.preventDefault();
                $(".job_pending_offers_data_content:hidden").slice(0, 2).slideDown();
                if($(".job_pending_offers_data_content:hidden").length == 0) {
                    $("#load_more_pending_offers").hide();
                }
            });

            // job applications data get
            $(".job_applied_data_content").slice(0, 2).show();
            $( "body" ).on( "click", "#load_more_job_applied", function(e) {
                e.preventDefault();
                $(".job_applied_data_content:hidden").slice(0, 2).slideDown();
                if($(".job_applied_data_content:hidden").length == 0) {
                    $("#load_more_job_applied").hide();
                }
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
                        url: "{!! route('recruiter.getEventTimeReject') !!}",
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

    </script>
@stop
