@extends('admin.layouts.common')

@section('title', 'Offer List')

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
                            <h3 class="card-label">Offer List
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    @php
                                        $check_action = true;
                                        if(Auth::user()->role == 3){
                                            $check_data = App\Models\User::clientData(Auth::user()->created_user_id);
                                            if($check_data->offer_status == '0'){
                                                $check_action = true;
                                            }
                                            if ($check_data->offer_status == '1') {
                                                $check_action = false;
                                            }
                                        }
                                    @endphp
                                    <table class="table dt-table-hover" id="zero-config" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Candidate</th>
                                                <th>Vacancy title</th>
                                                <th>hiring manager</th>
                                                <th>Suggested start date</th>
                                                <th>Offered salary</th>
                                                <th>Declined Reason</th>
                                                <th width="100">Status</th>
                                                @if($check_action)
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($offer))
                                                @foreach($offer as $key => $value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                        <td>
                                                            @if(isset($value['candidate_id']) && !empty($value['candidate_id']))
                                                                @if(isset($value['job_reference']) && !empty($value['job_reference']))
                                                                    @php 
                                                                        $tooltip = App\Models\User::getUserName($value['r_c_id']);

                                                                        $clientData = App\Models\User::clientData($value->r_c_id);
                                                                        $companyname = '-';
                                                                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                                                            $companyname = $clientData->company_name;
                                                                        }
                                                                    @endphp
                                                                    {!! App\Models\RecruiterCandidate::recruiterCandidateName($value['candidate_id']) !!} <span class="label label-lg label-light-info label-inline lable-custom-w-h text-capitalize" data-toggle="tooltip" data-theme="dark" data-html="true" title="Recruiter Company Name">{!! $companyname !!}</span>
                                                                @else
                                                                    {!! App\Models\User::getUserName($value['candidate_id']) !!}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($value['vacancy_id']) && !empty($value['vacancy_id']))
                                                                {!! App\Models\JobVacancy::jobName($value['vacancy_id']) !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $hiring_manager = App\Models\JobApplied::hiringManager($value['vacancy_id']);
                                                                $hiring_manager_arr = explode(",",$hiring_manager);
                                                                $count = count($hiring_manager_arr);
                                                                if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                                    $hiring = $hiring_manager_arr[0];
                                                                }else{
                                                                    $hiring = $value->client_id;
                                                                }
                                                            @endphp
                                                            {!! App\Models\User::getUserName($hiring) !!}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $newformat = null;
                                                                if(isset($value['suggested_date']) && !empty($value['suggested_date'])){
                                                                    $time = strtotime($value['suggested_date']);

                                                                    $newformat = date('d-m-Y',$time);
                                                                }
                                                            @endphp
                                                            {!! $newformat !!}
                                                        </td>
                                                        <td>
                                                            @if(isset($value['offered_salary']) && !empty($value['offered_salary']))
                                                                £{!! App\CustomFunction\CustomFunction::number_format($value['offered_salary']) !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($value['declined_reason']) && !empty($value['declined_reason']))
                                                                {!! $declined_reason[$value['declined_reason']] !!}
                                                            @else
                                                            --
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value['offer_status'] == 1)
                                                                <span class="label label-lg label-light-success label-inline lable-custom-w-h">Offer Accepted</span>
                                                            @elseif($value['offer_status'] == 2)
                                                                @php
                                                                    $decliend_tooltip = '';
                                                                    if(isset($value['declined_reason']) && !empty($value['declined_reason'])){
                                                                        $decliend_tooltip = $declined_reason[$value['declined_reason']];
                                                                    }
                                                                @endphp
                                                                <span class="label label-lg label-light-danger label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="{!! $decliend_tooltip !!}">Offer Declined</span>
                                                            @else
                                                                <span class="label label-lg label-light-primary label-inline lable-custom-w-h">In Progress</span>
                                                            @endif
                                                        </td>
                                                        @if($check_action)
                                                        <td nowrap="nowrap">

                                                            {{-- @if((Auth::user()->role == 2) || (Auth::user()->role == 3)) --}}
                                                            <div class="figure">
                                                                @php
                                                                    $getData = $offer_id = $applied_id = $vacancy_id = $client_id = $candidate_id = $job_reference = $r_c_id = $confirmed_start_date = $confirmed_leave_date = $reason_for_leaving = null;
                                                                    if(isset($value['offer_id']) && !empty($value['offer_id'])){
                                                                        $offer_id = $value['offer_id'];
                                                                    }
                                                                    if(isset($value['applied_id']) && !empty($value['applied_id'])){
                                                                        $applied_id = $value['applied_id'];
                                                                    }
                                                                    if(isset($value['vacancy_id']) && !empty($value['vacancy_id'])){
                                                                        $vacancy_id = $value['vacancy_id'];
                                                                    }
                                                                    if(isset($value['client_id']) && !empty($value['client_id'])){
                                                                        $client_id = $value['client_id'];
                                                                    }
                                                                    if(isset($value['candidate_id']) && !empty($value['candidate_id'])){
                                                                        $candidate_id = $value['candidate_id'];
                                                                    }
                                                                    if(isset($value['job_reference']) && !empty($value['job_reference'])){
                                                                        $job_reference = $value['job_reference'];
                                                                    }
                                                                    if(isset($value['r_c_id']) && !empty($value['r_c_id'])){
                                                                        $r_c_id = $value['r_c_id'];
                                                                    }

                                                                    $getData = App\Models\OfferLeavingReason::findData($offer_id,$applied_id,$vacancy_id,$client_id,$candidate_id,$job_reference,$r_c_id);

                                                                    $edit_class = 'btn-light btn-hover-primary';

                                                                    if(isset($getData) && !empty($getData)){
                                                                        $c_s_d = strtotime($getData->confirmed_start_date);
                                                                        $confirmed_start_date = date('d-m-Y',$c_s_d);
                                                                        
                                                                        $c_l_d = strtotime($getData->confirmed_leave_date);
                                                                        $confirmed_leave_date = date('d-m-Y',$c_l_d);
                                                                        
                                                                        $reason_for_leaving = $getData->reason_for_leaving;

                                                                        $edit_class = 'btn-success btn-hover-info';
                                                                    }

                                                                @endphp
                                                                <a href="javascript:;" class="btn btn-sm {!! $edit_class !!} btn-icon mr-2 save_template_this" data-theme="dark" data-html="true" data-toggle="modal" data-target="#edit_offer_newdata_{{$value['offer_id']}}">
                                                                    <span data-toggle="tooltip" data-theme="dark" data-html="true" title="Start date / leave date">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <i class="fas fa-users-cog"></i>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                                <div class="modal fade" id="edit_offer_newdata_{{$value['offer_id']}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header justify-content-end">
                                                                                {{-- <h5 class="modal-title" id="exampleModalLabel">Edit Offer of employment</h5> --}}
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="form" method="POST" action="{{ route('comman.offerConfirmedLeavingReason')}}">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold required mb-2">Confirmed Start Date</label>
                                                                                                <div>
                                                                                                    <input type="text" class="form-control date" name="confirmed_start_date" id="confirmed_start_date_{{$value['id']}}" value="{{$confirmed_start_date}}" placeholder="Select Confirmed Start Date" required readonly/>
                                                                                                    <input type="hidden" name="offer_id" value="{{$offer_id}}" />
                                                                                                    <input type="hidden" name="applied_id" value="{{$applied_id}}" />
                                                                                                    <input type="hidden" name="vacancy_id" value="{{$vacancy_id}}" />
                                                                                                    <input type="hidden" name="client_id" value="{{$client_id}}" />
                                                                                                    <input type="hidden" name="candidate_id" value="{{$candidate_id}}" />
                                                                                                    <input type="hidden" name="job_reference" value="{{$job_reference}}" />
                                                                                                    <input type="hidden" name="r_c_id" value="{{$r_c_id}}" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold required mb-2">Confirmed Leave Date</label>
                                                                                                <div>
                                                                                                    <input type="text" class="form-control date" name="confirmed_leave_date" id="confirmed_leave_date_{{$value['id']}}" value="{{$confirmed_leave_date}}" placeholder="Select Confirmed leave Date" required readonly/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold required mb-2">Reason For Leaving</label>
                                                                                                <div>
                                                                                                    <select class="form-control " name="reason_for_leaving" id="reason_for_leaving_{{$value['id']}}" required>
                                                                                                        <option selected value="" disabled>Please Select</option>
                                                                                                        <option value="1" @if($reason_for_leaving == 1) selected @endif>left for more money</option>
                                                                                                        <option value="2" @if($reason_for_leaving == 2) selected @endif>left for remote working</option>
                                                                                                        <option value="3" @if($reason_for_leaving == 3) selected @endif>left due to management</option>
                                                                                                        <option value="4" @if($reason_for_leaving == 4) selected @endif>left for a job closer to home</option>
                                                                                                        <option value="5" @if($reason_for_leaving == 5) selected @endif>Sacked for underperformance</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="error-message error_message"></div>
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
                                                            </div>
                                                            {{-- @endif --}}

                                                            <div class="figure">
                                                                @php
                                                                    $getData = $offer_id = $applied_id = $vacancy_id = $client_id = $candidate_id = $job_reference = $r_c_id = $confirmed_start_date = $confirmed_leave_date = $reason_for_leaving = null;
                                                                    if(isset($value['offer_id']) && !empty($value['offer_id'])){
                                                                        $offer_id = $value['offer_id'];
                                                                    }
                                                                    if(isset($value['applied_id']) && !empty($value['applied_id'])){
                                                                        $applied_id = $value['applied_id'];
                                                                    }
                                                                    if(isset($value['vacancy_id']) && !empty($value['vacancy_id'])){
                                                                        $vacancy_id = $value['vacancy_id'];
                                                                    }
                                                                    if(isset($value['client_id']) && !empty($value['client_id'])){
                                                                        $client_id = $value['client_id'];
                                                                    }
                                                                    if(isset($value['candidate_id']) && !empty($value['candidate_id'])){
                                                                        $candidate_id = $value['candidate_id'];
                                                                    }
                                                                    if(isset($value['job_reference']) && !empty($value['job_reference'])){
                                                                        $job_reference = $value['job_reference'];
                                                                    }
                                                                    if(isset($value['r_c_id']) && !empty($value['r_c_id'])){
                                                                        $r_c_id = $value['r_c_id'];
                                                                    }

                                                                    $getData = App\Models\OfferAccept::findData($offer_id,$applied_id,$vacancy_id,$client_id,$candidate_id,$job_reference,$r_c_id);

                                                                @endphp
                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" data-toggle="modal" data-target="#edit_offer_res_{{$value['offer_id']}}">
                                                                    <span data-toggle="tooltip" data-theme="dark" data-html="true" title="offer declined reason">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <i class="fas fa-user-edit"></i>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                                <div class="modal fade" id="edit_offer_res_{{$value['offer_id']}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header justify-content-end">
                                                                                {{-- <h5 class="modal-title" id="exampleModalLabel">Edit Offer of employment</h5> --}}
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="form" method="POST" action="{{ route('comman.offerStatusChange')}}">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="fs-6 fw-semibold mb-2">Declined Status</label>
                                                                                                    <div>
                                                                                                        <select class="form-control" name="offer_status" required>
                                                                                                            <option value="" selected="selected" disabled>select status</option>
                                                                                                            <option value="0">In Progress</option>
                                                                                                            <option value="1">Accept</option>
                                                                                                            <option value="2">Decline</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold mb-2">Declined Reason</label>
                                                                                                <div>
                                                                                                    <select class="form-control" name="declined_reason">
                                                                                                        <option value="" selected="selected">select declined reason</option>
                                                                                                        <option value="1" >Salary too low</option>
                                                                                                        <option value="2">Counter-offered by current company</option>
                                                                                                        <option value="3">Lack of flexibility</option>
                                                                                                        <option value="4">A better offer was on the table elsewhere</option>
                                                                                                    </select>
                                                                                                    <input type="hidden" name="offer_id" value="{{$offer_id}}" />
                                                                                                    <input type="hidden" name="applied_id" value="{{$applied_id}}" />
                                                                                                    <input type="hidden" name="vacancy_id" value="{{$vacancy_id}}" />
                                                                                                    <input type="hidden" name="client_id" value="{{$client_id}}" />
                                                                                                    <input type="hidden" name="candidate_id" value="{{$candidate_id}}" />
                                                                                                    <input type="hidden" name="job_reference" value="{{$job_reference}}" />
                                                                                                    <input type="hidden" name="r_c_id" value="{{$r_c_id}}" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="error-message error_message"></div>
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
                                                            </div>

                                                            <div class="figure">
                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 save_template_this" data-theme="dark" data-html="true" data-toggle="modal" data-target="#edit_offer_{{$key}}">
                                                                    <span data-toggle="tooltip" data-theme="dark" data-html="true" title="offer details">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                                <div class="modal fade" id="edit_offer_{{$key}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Offer of employment</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="form" method="POST" action="{{ route('comman.offerEdit')}}" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">

                                                                                                <label class="fs-6 fw-semibold mb-2 w-100 d-block"><b>Company:</b> {!! App\Models\User::clientCompany($value['client_id']) !!}</label>
                                                                                                <label class="fs-6 fw-semibold mb-2 w-100 d-block"><b>Job Title:</b> {!! App\Models\JobVacancy::jobName($value['vacancy_id']) !!}</label>
                                                                                                <label class="fs-6 fw-semibold mb-2  w-100 d-block"><b>Hiring Manager:</b> {!! App\Models\User::getUserName($hiring) !!}</label>
                                                                                                <div>
                                                                                                    <input type="hidden" name="applied_id" value="@if(isset($value['applied_id']) && !empty($value['applied_id'])){!! $value['applied_id'] !!}@endif" />
                                                                                                    <input type="hidden" name="vacancy_id" value="@if(isset($value['vacancy_id']) && !empty($value['vacancy_id'])){!! $value['vacancy_id'] !!}@endif" />
                                                                                                    <input type="hidden" name="client_id" value="@if(isset($value['client_id']) && !empty($value['client_id'])){!! $value['client_id'] !!}@endif" />
                                                                                                    <input type="hidden" name="user_id" value="@if(isset($value['candidate_id']) && !empty($value['candidate_id'])){!! $value['candidate_id'] !!}@endif" />
                                                                                                    <input type="hidden" name="id" value="@if(isset($value['id']) && !empty($value['id'])){!! $value['id'] !!}@endif" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold required mb-2">Offered salary</label>
                                                                                                <div>
                                                                                                    <input type="number" class="form-control" placeholder="Offered salary" name="offer_offered_salary" id="offer_offered_salary_{{$key}}" value="@if(isset($value['offered_salary']) && !empty($value['offered_salary'])){!! $value['offered_salary'] !!}@endif" required />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold mb-2">Suggested start date</label>
                                                                                                <div>
                                                                                                    @php
                                                                                                        $newformat = null;
                                                                                                        if(isset($value['suggested_date']) && !empty($value['suggested_date'])){
                                                                                                            $time = strtotime($value['suggested_date']);

                                                                                                            $newformat = date('d-m-Y',$time);
                                                                                                        }
                                                                                                    @endphp
                                                                                                    <input class="form-control date" type="text" name="offer_suggested_date" id="offer_suggested_date_{{$key}}" placeholder="Suggested start date"  value="{!! $newformat !!}" required readonly/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                            
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold mb-2">Benefits Package</label>
                                                                                                <div>
                                                                                                    <textarea type="text" class="form-control" placeholder="" name="offer_description" id="offer_description_{{$key}}">@if(isset($value['description']) && !empty($value['description'])){!! $value['description'] !!}@endif</textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-12">
                                                                                            <div class="row justify-content-center w-100 m-auto">
                                                                                                <div class="form-group row w-100 m-0">
                                                                                                    <label class="fs-6 fw-semibold mb-2">Official offer letter</label>
                                                                                                    <div class="custom-file">
                                                                                                        <input type="file" class="custom-file-input offer_letter_data" name="offer_letter_file" accept="image/png, image/jpeg,application/pdf" id="offer_letter_file_{{$key}}" data-id="{{$key}}" />
                                                                                                        <label class="custom-file-label" for="offer_letter_file_{{$key}}">Choose file</label>
                                                                                                    </div>
                                                                                                    <div class="w-100" id="error_msg_{{$key}}" style="display: none;">
                                                                                                        <div class="alert alert-danger alert-block">
                                                                                                            <strong>Try to upload file less than 2MB!</strong>
                                                                                                            <button type="button" class="close fl-right b-none" data-id="{{$key}}">×</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="d-flex justify-content-space-between mt-2 w-100">
                                                                                                        <div>
                                                                                                            <small id="sh-text1" class="form-text text-muted">(png,jpg,pdf file allowed Max. Size 2mb)</small>
                                                                                                        </div>
                                                                                                        @if(isset($value['offer_letter']) && !empty($value['offer_letter']))
                                                                                                        <div>
                                                                                                            @php
                                                                                                                $offer_letter_file = url('uploads').'/offer_letter/'.$value['offer_letter'];
                                                                                                            @endphp
                                                                                                            <input type="hidden" name="offer_letter" id="offer_letter" value="@if(isset($value['offer_letter']) && !empty($value['offer_letter'])){{$value['offer_letter']}}@endif" data-id="{{$key}}"/>
                                                                                                            <a href="{{$offer_letter_file}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
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
                                                                                                        </div>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="card-footer pb-0 mt-10 pl-0">
                                                                                        <div class="row">
                                                                                            <div class="col-xs-12 col-sm-6">
                                                                                                <button type="submit" class="btn btn-light-primary font-weight-bold" id="form_submit_{{$key}}">
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
                                                            </div>

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
                                                            <form action="{{ route('comman.offerDelete')}}" method="post" >
                                                                <input type="hidden" name="id" value="{!!$value['id']!!}" />
                                                                @csrf
                                                            </form>
                                                        </td>
                                                        @endif
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
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/parsley.min.js"></script>

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

        $( ".offer_benefit_package" ).each(function(index) {
            $(this).on("click", function(){
                var client_id = $(this).attr('data-c-id');
                var id = $(this).attr('data-id');
                var package_id =$(this).val();
                benefitPackage(package_id,client_id,id);
            });
        });

        function benefitPackage(package_id,client_id,id) {

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.benefitPackageDataGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    package_id: package_id,
                    client_id: client_id,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },success: function (data) {
                    if (data.code == 1) {
                        setTimeout(function () {
                            var message = data.text;
                            $('#offer_description_'+id).val(message);
                            $.LoadingOverlay("hide");
                        }, 2500);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                    show_toastr('error', 'Please try again!','');
                }
            });

        }

    </script>
    <script type="text/javascript">

        $(function () {

            "use strict";

            $('.date').datepicker({
                rtl: KTUtil.isRTL(),
                // autoclose: true,
                // startDate: new Date(),
                todayHighlight: true,
                format: 'dd-mm-yyyy',
            });

            $('body').on('click', '.save_template_this', function() {
                $('.date').datepicker({
                    rtl: KTUtil.isRTL(),
                    // autoclose: true,
                    // startDate: new Date(),
                    todayHighlight: true,
                    format: 'dd-mm-yyyy',
                });
            });
        });
    </script>

    <script>
        $('.offer_letter_data').bind('change', function() {

            var form_id = $(this).attr('data-id');
            if (this.files[0].size > 2097152) {
                $('#form_submit_'+form_id).prop('disabled', true);
                $('#error_msg_'+form_id).show();
            } else {
                $('#form_submit_'+form_id).prop('disabled', false);
                $('#error_msg_'+form_id).hide();
            }
        });

        $('body').on('click', '.close', function() {
            var form_id = $(this).attr('data-id');
            $('#error_msg_'+form_id).hide();
        });
    </script>

@if(Session::get('open_modal') && Session::get('open_modal') == "On")
    <script>
                
        $(function () {
            
                var modal_name = '{{Session::get("modal_name")}}';
                var error_message = '{{Session::get("error_msg")}}';
                var modal_id = '{{Session::get("modal_id")}}';
                
                var confirmed_start_date = '{{Old("confirmed_start_date")}}';
                var confirmed_leave_date = '{{Old("confirmed_leave_date")}}';
                var reason_for_leaving = '{{Old("reason_for_leaving")}}';

                $("#confirmed_start_date_"+modal_id).val(confirmed_start_date);
                $("#confirmed_leave_date_"+modal_id).val(confirmed_leave_date);
                $("#reason_for_leaving_"+modal_id).val(reason_for_leaving).change();

                var html_data = '<div class="alert alert-danger alert-block d-flex justify-content-space-between"><strong>'+error_message+'</strong><button type="button" class="close fl-right border-0 right-10" data-dismiss="alert">×</button></div>';
                $('#'+modal_name+' .error_message').html(html_data);
                var myModal = new bootstrap.Modal(document.getElementById(modal_name));
                myModal.show();
                <?php Session::forget('open_modal'); Session::forget('modal_name'); Session::forget('modal_id'); Session::forget('error_msg'); ?>
        });
    </script>
@endif
@stop
