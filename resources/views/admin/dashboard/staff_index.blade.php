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
                                    <span class="card-label font-weight-bolder text-dark">Job Applications</span>
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-direction-column pt-0">
                                <div class="tab-content event-applied-content" id="job_applied_data">
                                    @if(isset($job_applied) && !empty($job_applied) && count($job_applied))
                                        @foreach($job_applied as $Akey => $p_value)
                                            @php
                                                $url = $route_name.".jobApplied";
                                                $route = route($url,["id" => $p_value['job_id']]);
                                            @endphp
                                            <div class="job_applied_data_content">
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-2 @if($loop->iteration % 2 == 0) odd @else even @endif">
                                                    <a href="{!! $route !!}" class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="width-10 text-center">
                                                            @php
                                                                if(isset($p_value['user_id']) && !empty($p_value['user_id'])){
                                                                    $logo_client = App\Models\User::clientData($p_value['client_id']);
                                                                    $logo_class = 'symbol-light-dark';
                                                                    $logo =  site_header_logo;
                                                                    if(file_exists('uploads/client_profile/'.$logo_client->company_logo)){
                                                                        $logo =  url('uploads').'/client_profile/'.$logo_client->company_logo;
                                                                        $logo_class = 'symbol-white';
                                                                    }

                                                                }else{
                                                                    $logo = site_header_logo;
                                                                    $logo_class = 'symbol-light-dark';
                                                                }
                                                            @endphp
                                                            <div class="symbol symbol-50 {{$logo_class}}">
                                                                <span class="symbol-label">
                                                                    <img src="{!! $logo !!}" class="h-50 align-self-center img-fluid p-5px" alt="">
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="width-75">
                                                            <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">@if(isset($p_value['job_id']) && !empty($p_value['job_id'])){!! App\Models\JobVacancy::jobName($p_value['job_id']) !!}@endif</span>

                                                            @if($p_value['job_reference'] == 1)

                                                                @php
                                                                    $userName = App\Models\RecruiterCandidate::recruiterCandidateName($p_value['user_id']);

                                                                    $getId = App\Models\RecruiterCandidate::getId($p_value['user_id']);

                                                                    $clientData = App\Models\User::clientData($getId);

                                                                    $companyname = '-';
                                                                    if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                                        $companyname = $clientData->company_name;
                                                                    }

                                                                    if(isset($clientData->name) && !empty($clientData->name)){
                                                                        $name = $clientData->name;
                                                                    }
                                                                    if(isset($clientData->lname) && !empty($clientData->lname)){
                                                                        $lname = $clientData->lname;
                                                                    }
                                                                    if(isset($name) && !empty($name)){
                                                                        $recruitere_name = $name;
                                                                    }
                                                                    if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                                                                        $recruitere_name = $name.' '.$lname;
                                                                    }

                                                                    $town = $recruitere_name;
                                                                    $email = $clientData->email;

                                                                @endphp
                                                                <div>
                                                                    <span class="font-weight-bolder">Name:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! $userName !!}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Recruiter Company Name:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! $companyname !!}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Recruiter Name:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! $town !!}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Recruiter Email:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">{!! $email !!}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Salary:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">@if(isset($p_value['salary_expectations']) && !empty($p_value['salary_expectations']))£{!! App\CustomFunction\CustomFunction::number_format($p_value['salary_expectations']) !!}@endif</span>
                                                                </div>

                                                            @else

                                                                <div>
                                                                    <span class="font-weight-bolder">Name:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">@if(isset($p_value['user_id']) && !empty($p_value['user_id'])){!! App\Models\User::getUserName($p_value['user_id']) !!}@endif</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Location:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">@if(isset($p_value['user_id']) && !empty($p_value['user_id'])){!! App\Models\User::getTown($p_value['user_id']) !!}@endif</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Email:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">@if(isset($p_value['user_id']) && !empty($p_value['user_id'])){!! App\Models\User::getEmail($p_value['user_id']) !!}@endif</span>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bolder">Salary:</span>
                                                                    <span class="text-muted font-weight-bold text-hover-primary">@if(isset($p_value['salary_expectations']) && !empty($p_value['salary_expectations'])){!! App\CustomFunction\CustomFunction::number_format($p_value['salary_expectations']) !!}@endif</span>
                                                                </div>

                                                            @endif

                                                        </div>
                                                        <div class="width-10">
                                                            <span class="label label-lg label-light-success label-inline cursor-pointer" data-toggle="tooltip" data-theme="dark" data-html="true" title="" data-original-title="Successful">New</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="pl-0">No application</p>
                                    @endif
                                </div>
                                <div class="text-center mt-auto @if($job_applied_count > 2) d-block @else d-none @endif">
                                    <button class="btn btn-primary font-weight-bolder" id="load_more_job_applied">Load More</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">Pending Offers</span>
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
                                                                        $candidate_tooltip = 'Recruiter Candidate';
                                                                        $candidate_name = App\Models\RecruiterCandidate::recruiterCandidateName($p_o_value['candidate_id']);
                                                                        $recruiter_tag = '<span class="label label-lg label-light-info label-inline">R</span>';
                                                                    }else{
                                                                        $recruiter_tag = '';
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

                                                                @if($p_o_value['job_reference'] == 1)
                                                                    @php
                                                                        $clientData = App\Models\User::clientData($p_o_value['r_c_id']);
                                                                        $companyname = '-';
                                                                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                                            $companyname = $clientData->company_name;
                                                                        }
                                                                    @endphp
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                <i class="font-20 far fa-building text-primary" data-toggle="tooltip" data-theme="dark" data-original-title="Company Name"></i>
                                                                            </div>
                                                                            <div class="d-flex flex-column font-weight-bold">
                                                                                <p class="text-dark line-height-sm font-size-lg m-0">{!! $companyname !!}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

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

                    <div class="col-md-12">
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
                                                $url = $route_name.".eventList";
                                                $route = route($url);
                                            @endphp
                                            <div class="job_event_data_content col-md-6 col-sm-12">
                                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-5 even">
                                                    <a href="{!! $route !!}" class="d-flex justify-content-space-between align-items-center w-100">
                                                        <div class="w-100">
                                                            <div class="d-flex align-items-center mb-6">
                                                                    @php
                                                                        $vacancy = App\Models\JobVacancy::jobName($p_e_value['vacancy_id']);
                                                                    @endphp
                                                                    <p class="text-dark font-bold text-center line-height-sm font-size-lg m-0">{!! $vacancy !!}</p>
                                                            </div>

                                                            <div class="d-flex align-items-center row row-gap-10">
                                                                @if(isset($p_e_value['user_id']) && !empty($p_e_value['user_id']))
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                                            @php
                                                                                    if($p_e_value['job_reference'] == 1){
                                                                                        $candidate_tooltip = 'Recruiter Candidate';
                                                                                        $candidate_name = App\Models\RecruiterCandidate::recruiterCandidateName($p_e_value['r_c_id']);
                                                                                        $recruiter_tag = '<span class="label label-lg label-light-info label-inline">R</span>';
                                                                                    }else{
                                                                                        $recruiter_tag = '';
                                                                                        $candidate_tooltip = 'Candidate';
                                                                                        if(isset($p_e_value['user_id']) && !empty($p_e_value['user_id'])){
                                                                                            $candidate_name = App\Models\User::getUserName($p_e_value['user_id']);
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                                <i class="font-20 far fa-user text-warning" data-toggle="tooltip" data-theme="dark" title="{{$candidate_tooltip}}"></i>
                                                                            </div>
                                                                            <div class="d-flex flex-column font-weight-bold">
                                                                                <p class="text-dark line-height-sm font-size-lg m-0 ">{!! $candidate_name !!} {!! $recruiter_tag !!}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                @if(isset($p_e_value['event_staff_select']) && !empty($p_e_value['event_staff_select']))
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
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

                                                                @if(isset($p_e_value['event_date']) && !empty($p_e_value['event_date']))
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
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

                                                                @if(isset($p_e_value['event_time']) && !empty($p_e_value['event_time']))
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
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
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
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

                                                                @if(isset($p_e_value['job_reference']) && !empty($p_e_value['job_reference']))
                                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                                        @php
                                                                            $clientData = App\Models\User::clientData($p_e_value['user_id']);
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
                                                    </a>
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

            // events data get
            // new_job_activity_data();

        });

        function new_job_activity_data() {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('staff.dashboard.clientActivity')}}",
                dataType: 'json',
                type: 'post',
                beforeSend: function () {
                    $.LoadingOverlay("show");
                }, success: function (data) {

                    if (data.code == 1) {
                        if(data.page){
                            $('#job_activity_data').append(data.page);
                            setTimeout(function () {
                                KTCalendarBasic.init();
                            }, 200);
                        }
                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {

                }
            });
        }

        var KTCalendarBasic = function() {

            var settings = {};

            var initTooltip = function(el) {
                var theme = el.data('theme') ? 'tooltip-' + el.data('theme') : '';
                var width = el.data('width') == 'auto' ? 'tooltop-auto-width' : '';
                var trigger = el.data('trigger') ? el.data('trigger') : 'hover';

                $(el).tooltip({
                    trigger: trigger,
                    template: '<div class="tooltip ' + theme + ' ' + width + '" role="tooltip">\
                        <div class="arrow"></div>\
                        <div class="tooltip-inner"></div>\
                    </div>'
                });
            }

            var initTooltips = function() {
                // init bootstrap tooltips
                $('[data-toggle="tooltip"]').each(function() {
                    initTooltip($(this));
                });
            }

            var initPopover = function(el) {
                var skin = el.data('skin') ? 'popover-' + el.data('skin') : '';
                var triggerValue = el.data('trigger') ? el.data('trigger') : 'hover';

                el.popover({
                    trigger: triggerValue,
                    template: '\
                    <div class="popover ' + skin + '" role="tooltip">\
                        <div class="arrow"></div>\
                        <h3 class="popover-header"></h3>\
                        <div class="popover-body"></div>\
                    </div>'
                });
            }

            var initPopovers = function() {
                // init bootstrap popover
                $('[data-toggle="popover"]').each(function() {
                    initPopover($(this));
                });
            }

            var initFileInput = function() {
                // init bootstrap popover
                $('.custom-file-input').on('change', function() {
                    var fileName = $(this).val();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                });
            }

            var initScroll = function() {
                $('[data-scroll="true"]').each(function() {
                    var el = $(this);

                    KTUtil.scrollInit(this, {
                        mobileNativeScroll: true,
                        handleWindowResize: true,
                        rememberPosition: (el.data('remember-position') == 'true' ? true : false),
                        height: function() {
                            if (KTUtil.isBreakpointDown('lg') && el.data('mobile-height')) {
                                return el.data('mobile-height');
                            } else {
                                return el.data('height');
                            }
                        }
                    });
                });
            }

            var initAlerts = function() {
                // init bootstrap popover
                $('body').on('click', '[data-close=alert]', function() {
                    $(this).closest('.alert').hide();
                });
            }

            var initCard = function(el, options) {
                // init card tools
                var el = $(el);
                var card = new KTCard(el[0], options);
            }

            var initCards = function() {
                // init card tools
                $('[data-card="true"]').each(function() {
                    var el = $(this);
                    var options = {};

                    if (el.data('data-card-initialized') !== true) {
                        initCard(el, options);
                        el.data('data-card-initialized', true);
                    }
                });
            }

            var initStickyCard = function() {
                if (typeof Sticky === 'undefined') {
                    return;
                }

                var sticky = new Sticky('[data-sticky="true"]');
            }

            var initAbsoluteDropdown = function(context) {
                var dropdownMenu;

                if (!context) {
                    return;
                }

                $('body').on('show.bs.dropdown', context, function(e) {
                    dropdownMenu = $(e.target).find('.dropdown-menu');
                    $('body').append(dropdownMenu.detach());
                    dropdownMenu.css('display', 'block');
                    dropdownMenu.position({
                        'my': 'right top',
                        'at': 'right bottom',
                        'of': $(e.relatedTarget),
                    });
                }).on('hide.bs.dropdown', context, function(e) {
                    $(e.target).append(dropdownMenu.detach());
                    dropdownMenu.hide();
                });
            }

            var initAbsoluteDropdowns = function() {
                $('body').on('show.bs.dropdown', function(e) {
                    // e.target is always parent (contains toggler and menu)
                    var $toggler = $(e.target).find("[data-attach='body']");
                    if ($toggler.length === 0) {
                        return;
                    }
                    var $dropdownMenu = $(e.target).find('.dropdown-menu');
                    // save detached menu
                    var $detachedDropdownMenu = $dropdownMenu.detach();
                    // save reference to detached menu inside data of toggler
                    $toggler.data('dropdown-menu', $detachedDropdownMenu);

                    $('body').append($detachedDropdownMenu);
                    $detachedDropdownMenu.css('display', 'block');
                    $detachedDropdownMenu.position({
                        my: 'right top',
                        at: 'right bottom',
                        of: $(e.relatedTarget),
                    });
                });

                $('body').on('hide.bs.dropdown', function(e) {
                    var $toggler = $(e.target).find("[data-attach='body']");
                    if ($toggler.length === 0) {
                        return;
                    }
                    // access to reference of detached menu from data of toggler
                    var $detachedDropdownMenu = $toggler.data('dropdown-menu');
                    // re-append detached menu inside parent
                    $(e.target).append($detachedDropdownMenu.detach());
                    // hide dropdown
                    $detachedDropdownMenu.hide();
                });
            };

            return {
                init: function(settingsArray) {
                    if (settingsArray) {
                        settings = settingsArray;
                    }

                    KTApp.initComponents();
                },

                initComponents: function() {
                    initScroll();
                    initTooltips();
                    initPopovers();
                    initAlerts();
                    initFileInput();
                    initCards();
                    initStickyCard();
                    initAbsoluteDropdowns();
                },

                initTooltips: function() {
                    initTooltips();
                },

                initTooltip: function(el) {
                    initTooltip(el);
                },

                initPopovers: function() {
                    initPopovers();
                },

                initPopover: function(el) {
                    initPopover(el);
                },

                initCard: function(el, options) {
                    initCard(el, options);
                },

                initCards: function() {
                    initCards();
                },

                initSticky: function() {
                    initSticky();
                },

                initAbsoluteDropdown: function(context) {
                    initAbsoluteDropdown(context);
                },

                block: function(target, options) {
                    var el = $(target);

                    options = $.extend(true, {
                        opacity: 0.05,
                        overlayColor: '#000000',
                        type: '',
                        size: '',
                        state: 'primary',
                        centerX: true,
                        centerY: true,
                        message: '',
                        shadow: true,
                        width: 'auto'
                    }, options);

                    var html;
                    var version = options.type ? 'spinner-' + options.type : '';
                    var state = options.state ? 'spinner-' + options.state : '';
                    var size = options.size ? 'spinner-' + options.size : '';
                    var spinner = '<span class="spinner ' + version + ' ' + state + ' ' + size + '"></span';

                    if (options.message && options.message.length > 0) {
                        var classes = 'blockui ' + (options.shadow === false ? 'blockui' : '');

                        html = '<div class="' + classes + '"><span>' + options.message + '</span>' + spinner + '</div>';

                        var el = document.createElement('div');

                        $('body').prepend(el);
                        KTUtil.addClass(el, classes);
                        el.innerHTML = html;
                        options.width = KTUtil.actualWidth(el) + 10;
                        KTUtil.remove(el);

                        if (target == 'body') {
                            html = '<div class="' + classes + '" style="margin-left:-' + (options.width / 2) + 'px;"><span>' + options.message + '</span><span>' + spinner + '</span></div>';
                        }
                    } else {
                        html = spinner;
                    }

                    var params = {
                        message: html,
                        centerY: options.centerY,
                        centerX: options.centerX,
                        css: {
                            top: '30%',
                            left: '50%',
                            border: '0',
                            padding: '0',
                            backgroundColor: 'none',
                            width: options.width
                        },
                        overlayCSS: {
                            backgroundColor: options.overlayColor,
                            opacity: options.opacity,
                            cursor: 'wait',
                            zIndex: (target == 'body' ? 1100 : 10)
                        },
                        onUnblock: function() {
                            if (el && el[0]) {
                                KTUtil.css(el[0], 'position', '');
                                KTUtil.css(el[0], 'zoom', '');
                            }
                        }
                    };

                    if (target == 'body') {
                        params.css.top = '50%';
                        $.blockUI(params);
                    } else {
                        var el = $(target);
                        el.block(params);
                    }
                },

                unblock: function(target) {
                    if (target && target != 'body') {
                        $(target).unblock();
                    } else {
                        $.unblockUI();
                    }
                },

                blockPage: function(options) {
                    return KTApp.block('body', options);
                },

                unblockPage: function() {
                    return KTApp.unblock('body');
                },

                getSettings: function() {
                    return settings;
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarBasic.init();
        });

    </script>
@stop
