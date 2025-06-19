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

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <ul class="nav gap-column gap-row mb-10 mt-10">
                        <li class="nav-item">
                            <a class="btn btn-outline-primary nav-link appliction-tab-btn candidate-offer active" data-toggle="tab" id="tab_offer_data_panding" href="#offer_data_panding">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span class="nav-text font-size-lg">Offers Pending <span class="label label-lg label-light-primary label-inline">{!! $offer_data_panding_count !!}</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-success nav-link appliction-tab-btn candidate-offer" data-toggle="tab" id="tab_offer_data_accepted" href="#offer_data_accepted">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span class="nav-text font-size-lg">Offers Accepted <span class="label label-lg label-light-primary label-inline">{!! $offer_data_accepted_count !!}</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger nav-link appliction-tab-btn candidate-offer" data-toggle="tab" id="tab_offer_data_declined" href="#offer_data_declined">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>
                                <span class="nav-text font-size-lg">Offers Declined <span class="label label-lg label-light-primary label-inline">{!! $offer_data_declined_count !!}</span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="tab-content mt-5 w-100" id="myActivityDetail">
                        <div class="active tab-pane px-7" id="offer_data_panding" role="tabpanel">
                            <div class="row">
                                @if(isset($offer_data_panding) && !empty($offer_data_panding))
                                    @foreach($offer_data_panding as $Pkey => $p_value)
                                        @php
                                            $vacancy_data = App\Models\JobVacancy::jobGet($p_value->vacancy_id);
                                            // $client_data = App\Models\User::clientData($p_value->client_id);
                                            if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                                                $client_data = App\Models\SubCompany::getSubCompanyData($vacancy_data->sub_company);
                                            }else{
                                                $client_data = App\Models\User::clientData($p_value->client_id);    
                                            }

                                            if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                                $logo =  url('uploads').'/client_profile/'.$client_data->company_logo;
                                            }else{
                                                $logo = site_header_logo;
                                            }
                                            $hiring_manager = App\Models\JobApplied::hiringManager($p_value->vacancy_id);
                                            $hiring_manager_arr = explode(",",$hiring_manager);
                                            $count = count($hiring_manager_arr);
                                            if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                $hiring = $hiring_manager_arr[0];
                                            }else{
                                                $hiring = $p_value->client_id;
                                            }
                                        @endphp
                                    @if(isset($vacancy_data) && !empty($vacancy_data))
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="card card-custom card-stretch gutter-b">
                                                <div class="card-body pt-4 d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-5">
                                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                            <div class="symbol h-50 align-self-center img-fluid p-5px bg-light">
                                                                <img alt="Pic" src="{{$logo}}" class="object-fit-contain">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <p class="text-dark font-weight-bold font-size-h4 mb-0">{{$vacancy_data->jobtitle}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Candidate Name:</span>
                                                            <p class="text-muted mb-0">@if(isset($p_value->candidate_id) && !empty($p_value->candidate_id)){!! App\Models\RecruiterCandidate::recruiterCandidateName($p_value->candidate_id) !!}@endif</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center my-1">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Company:</span>
                                                            <p class="text-muted mb-0">@if(isset($client_data->company_name) && !empty($client_data->company_name)){{$client_data->company_name}}@endif</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center my-1">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Hiring Manager:</span>
                                                            <p class="text-muted mb-0">{!! App\Models\User::getUserName($hiring) !!}</p>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center my-1">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Offered Salary:</span>
                                                            <p class="text-muted mb-0">£@if(isset($p_value->offered_salary) && !empty($p_value->offered_salary)){{$p_value->offered_salary}}@endif</p>
                                                        </div>
                                                        @if(isset($p_value->offer_letter) && !empty($p_value->offer_letter))
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Offer Letter:</span>
                                                                <p class="text-muted mb-0">
                                                                    @php
                                                                        $offer_letter_file = url('uploads').'/offer_letter/'.$p_value->offer_letter;
                                                                    @endphp
                                                                    <a href="{{$offer_letter_file}}" class="btn btn-sm btn-light btn-hover-primary btn-icon m-auto" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
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
                                                            </div>
                                                        @endif
                                                        <div class="d-flex justify-content-between align-items-center my-1">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Benefits package details:</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center my-1">
                                                            <div class="text-muted description-main-div description-height-{{$Pkey}}">
                                                                <div class="description-read" data-id="{{$Pkey}}">
                                                                    @php
                                                                        $address = '';
                                                                        if(isset($p_value->description) && !empty($p_value->description)){
                                                                            $str     = $p_value->description;
                                                                            $order   = array("\r\n", "\n", "\r");
                                                                            $replace = '<br/>';
                                                                            $newstr = str_replace($order, $replace, $str);
                                                                        }
                                                                    @endphp
                                                                    @if(isset($newstr) && !empty($newstr)){!!$newstr!!}@endif
                                                                </div>
                                                                <a href="javascript:void(0)" class="read-more">Read more</a>
                                                                <a href="javascript:void(0)" class="read-less">Read less</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="separator separator-solid @if($p_value->offer_status == 1) separator-success @elseif($p_value->offer_status == 2) separator-danger @else separator-warning @endif mt-3 mb-5"></div>

                                                    <div class="mb-0">
                                                        @if($p_value->offer_status != 0)
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Offer</span>
                                                                <p class="text-muted m-0">
                                                                    @if($p_value->offer_status == 1)
                                                                    <span class="label label-lg label-light-success label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Accept Offer">Accept</span>
                                                                    @elseif($p_value->offer_status == 2)
                                                                    <span class="label label-lg label-light-danger label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Decline Offer">Decline</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if($p_value->offer_status == 0)
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Would you like to accept this job offer?</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <button class="btn btn-light-success font-weight-bolder font-size-sm mt-2 offer-accept-btn" data-offer-id="{{$p_value->id}}" data-user-id="{{$p_value->candidate_id}}" data-r-c-id="{{$p_value->r_c_id}}" data-value="1">Accept</button>
                                                                <button class="btn btn-light-danger font-weight-bolder font-size-sm mt-2  offer-declin-btn" data-theme="dark" data-html="true" data-toggle="modal" data-target="#offer_declin">Decline</button>
                                                                <div class="modal fade" id="offer_declin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="form" method="POST" action="{{ route('recruiter.offerDeclin')}}">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label class="fs-6 fw-semibold mb-2">Declined Reason</label>
                                                                                                <div>
                                                                                                    <select class="form-control" name="declined_reason" id="declined_reason" required>
                                                                                                        <option value="1" selected="selected">Salary too low</option>
                                                                                                        <option value="2">Counter-offered by current company</option>
                                                                                                        <option value="3">Lack of flexibility</option>
                                                                                                        <option value="4">A better offer was on the table elsewhere</option>
                                                                                                    </select>
                                                                                                    {{-- <textarea type="text" class="form-control" placeholder="" name="declined_reason" id="declined_reason" required></textarea> --}}
                                                                                                    <input type="hidden" name="offer_id" value="{{$p_value->id}}" />
                                                                                                    <input type="hidden" name="user_id" value="{!! $p_value->candidate_id !!}" />
                                                                                                    <input type="hidden" name="r_c_id" value="{!! $p_value->r_c_id !!}" />
                                                                                                    <input type="hidden" name="value" value="2" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-footer pb-0 mt-10 pl-0">
                                                                                        <div class="row">
                                                                                            <div class="col-xs-12 col-sm-12">
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
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane px-7" id="offer_data_accepted" role="tabpanel">
                            <div class="row">
                                @if(isset($offer_data_accepted) && !empty($offer_data_accepted))
                                    @foreach($offer_data_accepted as $Akey => $a_value)
                                        @php
                                            $vacancy_data = App\Models\JobVacancy::jobGet($a_value->vacancy_id);
                                            // $client_data = App\Models\User::clientData($a_value->client_id);
                                            if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                                                $client_data = App\Models\SubCompany::getSubCompanyData($vacancy_data->sub_company);
                                            }else{
                                                $client_data = App\Models\User::clientData($a_value->client_id);    
                                            }

                                            if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                                $logo =  url('uploads').'/client_profile/'.$client_data->company_logo;
                                            }else{
                                                $logo = site_header_logo;
                                            }
                                            $hiring_manager = App\Models\JobApplied::hiringManager($a_value->vacancy_id);
                                            $hiring_manager_arr = explode(",",$hiring_manager);
                                            $count = count($hiring_manager_arr);
                                            if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                $hiring = $hiring_manager_arr[0];
                                            }else{
                                                $hiring = $a_value->client_id;
                                            }
                                        @endphp
                                        @if(isset($vacancy_data) && !empty($vacancy_data))
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="card card-custom card-stretch gutter-b">
                                                    <div class="card-body pt-4 d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-5">
                                                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                                <div class="symbol h-50 align-self-center img-fluid p-5px bg-light">
                                                                    <img alt="Pic" src="{{$logo}}" class="object-fit-contain">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <p class="text-dark font-weight-bold font-size-h4 mb-0">{{$vacancy_data->jobtitle}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Candidate Name:</span>
                                                                <p class="text-muted mb-0">@if(isset($a_value->candidate_id) && !empty($a_value->candidate_id)){!! App\Models\RecruiterCandidate::recruiterCandidateName($a_value->candidate_id) !!}@endif</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Company:</span>
                                                                <p class="text-muted mb-0">@if(isset($client_data->company_name) && !empty($client_data->company_name)){{$client_data->company_name}}@endif</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Hiring Manager:</span>
                                                                <p class="text-muted mb-0">{!! App\Models\User::getUserName($hiring) !!}</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Offered Salary:</span>
                                                                <p class="text-muted mb-0">£@if(isset($a_value->offered_salary) && !empty($a_value->offered_salary)){{$a_value->offered_salary}}@endif</p>
                                                            </div>
                                                            @if(isset($a_value->offer_letter) && !empty($a_value->offer_letter))
                                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Offer Letter:</span>
                                                                    <p class="text-muted mb-0">
                                                                        @php
                                                                            $offer_letter_file = url('uploads').'/offer_letter/'.$a_value->offer_letter;
                                                                        @endphp
                                                                        <a href="{{$offer_letter_file}}" class="btn btn-sm btn-light btn-hover-primary btn-icon m-auto" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
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
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Benefits package details:</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <div class="text-muted description-main-div description-height-{{$Akey}}">
                                                                    <div class="description-read" data-id="{{$Akey}}">
                                                                        @php
                                                                            $address = '';
                                                                            if(isset($a_value->description) && !empty($a_value->description)){
                                                                                $str     = $a_value->description;
                                                                                $order   = array("\r\n", "\n", "\r");
                                                                                $replace = '<br/>';
                                                                                $newstr = str_replace($order, $replace, $str);
                                                                            }
                                                                        @endphp
                                                                        @if(isset($newstr) && !empty($newstr)){!!$newstr!!}@endif
                                                                    </div>
                                                                    <a href="javascript:void(0)" class="read-more">Read more</a>
                                                                    <a href="javascript:void(0)" class="read-less">Read less</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="separator separator-solid @if($a_value->offer_status == 1) separator-success @elseif($a_value->offer_status == 2) separator-danger @else separator-warning @endif mt-3 mb-5"></div>

                                                        <div class="mb-0">
                                                            @if($a_value->offer_status != 0)
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Offer</span>
                                                                    <p class="text-muted m-0">
                                                                        @if($a_value->offer_status == 1)
                                                                            <span class="label label-lg label-light-success label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Accept Offer">Accept</span>
                                                                        @elseif($a_value->offer_status == 2)
                                                                            <span class="label label-lg label-light-danger label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Decline Offer">Decline</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            @if($a_value->offer_status == 0)
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Would you like to accept this job offer?</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                                    <button class="btn btn-light-success font-weight-bolder font-size-sm mt-2 offer-accept-btn" data-offer-id="{{$a_value->id}}" data-user-id="{{$a_value->candidate_id}}" data-r-c-id="{{$a_value->r_c_id}}" data-value="1">Accept</button>
                                                                    <button class="btn btn-light-danger font-weight-bolder font-size-sm mt-2  offer-declin-btn" data-theme="dark" data-html="true" data-toggle="modal" data-target="#offer_declin">Decline</button>
                                                                    <div class="modal fade" id="offer_declin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form class="form" method="POST" action="{{ route('recruiter.offerDeclin')}}">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="fs-6 fw-semibold mb-2">Declined Reason</label>
                                                                                                    <div>
                                                                                                        <textarea type="text" class="form-control" placeholder="" name="declined_reason" id="declined_reason" required></textarea>
                                                                                                        <input type="hidden" name="offer_id" value="{{$a_value->id}}" />
                                                                                                        <input type="hidden" name="user_id" value="{!! $a_value->candidate_id !!}" />
                                                                                                        <input type="hidden" name="r_c_id" value="{!! $a_value->r_c_id !!}" />
                                                                                                        <input type="hidden" name="value" value="2" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="card-footer pb-0 mt-10 pl-0">
                                                                                            <div class="row">
                                                                                                <div class="col-xs-12 col-sm-12">
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
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane px-7" id="offer_data_declined" role="tabpanel">
                            <div class="row">
                                @if(isset($offer_data_declined) && !empty($offer_data_declined))
                                    @foreach($offer_data_declined as $Okey => $d_value)
                                        @php
                                            $vacancy_data = App\Models\JobVacancy::jobGet($d_value->vacancy_id);
                                            // $client_data = App\Models\User::clientData($d_value->client_id);
                                            if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                                                $client_data = App\Models\SubCompany::getSubCompanyData($vacancy_data->sub_company);
                                            }else{
                                                $client_data = App\Models\User::clientData($d_value->client_id);    
                                            }

                                            if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                                $logo =  url('uploads').'/client_profile/'.$client_data->company_logo;
                                            }else{
                                                $logo = site_header_logo;
                                            }
                                            $hiring_manager = App\Models\JobApplied::hiringManager($d_value->vacancy_id);
                                            $hiring_manager_arr = explode(",",$hiring_manager);
                                            $count = count($hiring_manager_arr);
                                            if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                                $hiring = $hiring_manager_arr[0];
                                            }else{
                                                $hiring = $d_value->client_id;
                                            }
                                        @endphp
                                        @if(isset($vacancy_data) && !empty($vacancy_data))
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="card card-custom card-stretch gutter-b">
                                                    <div class="card-body pt-4 d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-5">
                                                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                                <div class="symbol h-50 align-self-center img-fluid p-5px bg-light">
                                                                    <img alt="Pic" src="{{$logo}}" class="object-fit-contain">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <p class="text-dark font-weight-bold font-size-h4 mb-0">{{$vacancy_data->jobtitle}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Candidate Name:</span>
                                                                <p class="text-muted mb-0">@if(isset($d_value->candidate_id) && !empty($d_value->candidate_id)){!! App\Models\RecruiterCandidate::recruiterCandidateName($d_value->candidate_id) !!}@endif</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Company:</span>
                                                                <p class="text-muted mb-0">@if(isset($client_data->company_name) && !empty($client_data->company_name)){{$client_data->company_name}}@endif</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Hiring Manager:</span>
                                                                <p class="text-muted mb-0">{!! App\Models\User::getUserName($hiring) !!}</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Offered Salary:</span>
                                                                <p class="text-muted mb-0">£@if(isset($d_value->offered_salary) && !empty($d_value->offered_salary)){{$d_value->offered_salary}}@endif</p>
                                                            </div>
                                                            @if(isset($d_value->offer_letter) && !empty($d_value->offer_letter))
                                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Offer Letter:</span>
                                                                    <p class="text-muted mb-0">
                                                                        @php
                                                                            $offer_letter_file = url('uploads').'/offer_letter/'.$d_value->offer_letter;
                                                                        @endphp
                                                                        <a href="{{$offer_letter_file}}" class="btn btn-sm btn-light btn-hover-primary btn-icon m-auto" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
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
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <span class="text-dark-75 font-weight-bolder mr-2">Benefits package details:</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                                <div class="text-muted description-main-div description-height-{{$Okey}}">
                                                                    <div class="description-read" data-id="{{$Okey}}">
                                                                        @php
                                                                            $address = '';
                                                                            if(isset($d_value->description) && !empty($d_value->description)){
                                                                                $str     = $d_value->description;
                                                                                $order   = array("\r\n", "\n", "\r");
                                                                                $replace = '<br/>';
                                                                                $newstr = str_replace($order, $replace, $str);
                                                                            }
                                                                        @endphp
                                                                        @if(isset($newstr) && !empty($newstr)){!!$newstr!!}@endif
                                                                    </div>
                                                                    <a href="javascript:void(0)" class="read-more">Read more</a>
                                                                    <a href="javascript:void(0)" class="read-less">Read less</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="separator separator-solid @if($d_value->offer_status == 1) separator-success @elseif($d_value->offer_status == 2) separator-danger @else separator-warning @endif mt-3 mb-5"></div>

                                                        <div class="mb-0">
                                                            @if($d_value->offer_status != 0)
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Offer</span>
                                                                    <p class="text-muted m-0">
                                                                        @if($d_value->offer_status == 1)
                                                                            <span class="label label-lg label-light-success label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Accept Offer">Accept</span>
                                                                        @elseif($d_value->offer_status == 2)
                                                                            <span class="label label-lg label-light-danger label-inline" data-toggle="tooltip" data-theme="dark" data-html="true" data-title="Decline Offer">Decline</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            @endif
                                                            @if($d_value->offer_status == 0)
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span class="text-dark-75 font-weight-bolder mr-2">Would you like to accept this job offer?</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between align-items-center my-1">
                                                                    <button class="btn btn-light-success font-weight-bolder font-size-sm mt-2 offer-accept-btn" data-offer-id="{{$d_value->id}}" data-user-id="{{$d_value->candidate_id}}" data-r-c-id="{{$d_value->r_c_id}}" data-value="1">Accept</button>
                                                                    <button class="btn btn-light-danger font-weight-bolder font-size-sm mt-2  offer-declin-btn" data-theme="dark" data-html="true" data-toggle="modal" data-target="#offer_declin">Decline</button>
                                                                    <div class="modal fade" id="offer_declin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <i aria-hidden="true" class="ki ki-close"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form class="form" method="POST" action="{{ route('recruiter.offerDeclin')}}">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label class="fs-6 fw-semibold mb-2">Declined Reason</label>
                                                                                                    <div>
                                                                                                        <textarea type="text" class="form-control" placeholder="" name="declined_reason" id="declined_reason" required></textarea>
                                                                                                        <input type="hidden" name="offer_id" value="{{$d_value->id}}" />
                                                                                                        <input type="hidden" name="user_id" value="{!! $d_value->candidate_id !!}" />
                                                                                                        <input type="hidden" name="r_c_id" value="{!! $d_value->r_c_id !!}" />
                                                                                                        <input type="hidden" name="value" value="2" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row" id="candidate_application_data"></div>                                                                    
                                                                                        <div class="col-xs-12 col-sm-12">
                                                                                            <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                                                                <span class="indicator-label">Submit</span>
                                                                                                <span class="indicator-progress">Please wait... 
                                                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
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

    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="{!!url('assets/backend')!!}/js/scrollspyNav.js"></script>

    <script type="text/javascript">
        $(function () {
            
            "use strict";

            var token = $("meta[name='csrf-token']").attr("content");

            $('body').on('click', '.offer-accept-btn', function() {
                var value = $(this).attr('data-value');
                var offer_id = $(this).attr('data-offer-id');
                var user_id = $(this).attr('data-user-id');
                var r_c_id = $(this).attr('data-r-c-id');

                var this_button = $(this);
                Swal.fire({
                    title: "Are you sure to accept this offer?",
                    text: "",
                    icon: "warning",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "No",
                    confirmButtonText: "Yes"
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: "{{route('recruiter.offerAccept')}}",
                            type: 'POST',
                            data: {
                                "value": value,
                                "_token": token,
                                "offer_id": offer_id,
                                "user_id": user_id,
                                "r_c_id": r_c_id,
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show");
                            },success: function (data){

                                if (data.code == 1) {
                                    show_toastr('success',data.msg);
                                } else {
                                    show_toastr('error', 'Please try again!','');
                                }
                                setTimeout(function () {
                                    $.LoadingOverlay("hide");
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                }, 200);
                            },
                            error: function (jqXhr, textStatus, errorThrown) {
                                $.LoadingOverlay("hide");
                                show_toastr('error', 'Please try again!','');
                            }
                        });
                    }
                });
            });

            $( ".description-read" ).each(function( index ) {
                var height_count = $( this ).height();
                var data_id = $(this).attr('data-id');
                descriptionRead(height_count,data_id);
            });

            $('body').on('click', '#tab_offer_data_accepted', function() {
                $.LoadingOverlay("show");
                var tab_offer_data_accepted = $( "#offer_data_accepted" ).find( ".description-read" );
                if(tab_offer_data_accepted.length){
                    setTimeout(function () {

                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }else{
                    setTimeout(function () {
                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }

            });

            $('body').on('click', '#tab_offer_data_declined', function() {
                $.LoadingOverlay("show");
                var tab_offer_data_declined = $( "#offer_data_declined" ).find( ".description-read" );
                if(tab_offer_data_declined.length){
                    setTimeout(function () {
                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }else{
                    setTimeout(function () {
                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }
            });

            $('body').on('click', '#tab_offer_data_panding', function() {
                $.LoadingOverlay("show");
                var tab_offer_data_panding = $( "#offer_data_panding" ).find( ".description-read" );
                if(tab_offer_data_panding.length){
                    setTimeout(function () {
                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }else{
                    setTimeout(function () {
                        $( ".description-read" ).each(function( index ) {
                            var height_count = $( this ).height();
                            var data_id = $( this ).attr('data-id');
                            descriptionRead(height_count,data_id);
                            $.LoadingOverlay("hide");
                        });
                        $.LoadingOverlay("hide");
                    }, 1500);
                }
            });

        });

        function descriptionRead(height_count,data_id) {
            if(height_count >= 100){
                $('.description-height-'+data_id+' .description-read').css("height", "100px");
                $('.description-height-'+data_id+' .read-more').css("display", "block");
            }else{
                $('.description-height-'+data_id+' .read-more').css("display", "none");
                $('.description-height-'+data_id+' .read-less').css("display", "none");
            }

        }
        
    </script>

@stop
