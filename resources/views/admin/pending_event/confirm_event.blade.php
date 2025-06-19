@extends('admin.layouts.common')

@section('title', 'Confirm Interviews List')

@section('headerScripts')
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
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
                            <h3 class="card-label">Confirm Interviews List
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table dt-table-hover" id="zero-config" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Interview stage</th>
                                                <th>Candidate Name</th>
                                                <th>Vacancy Name</th>
                                                <th>Interview Date</th>
                                                <th>Interview Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($event) && !empty($event))
                                                @foreach($event as $key => $value)
                                                    <tr>
                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                        <td>@if(isset($value['event_type']) && !empty($value['event_type'])){!! $value['event_type'] !!}@endif</td>
                                                        <td>@if($value['job_reference'] == 1)
                                                                @if(isset($value['r_c_id']) && !empty($value['r_c_id']))
                                                                    {!! App\Models\RecruiterCandidate::recruiterCandidateName($value['r_c_id']) !!}
                                                                @endif
                                                            @else
                                                                @if(isset($value['user_id']) && !empty($value['user_id']))
                                                                    {!! App\Models\User::getUserName($value['user_id']) !!}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>@if(isset($value['vacancy_id']) && !empty($value['vacancy_id'])){!! App\Models\JobVacancy::jobName($value['vacancy_id']) !!}@endif</td>
                                                        <td>@if(isset($value['event_date']) && !empty($value['event_date'])){!! App\CustomFunction\CustomFunction::get_date_forment($value['event_date']) !!}@endif</td>
                                                        <td>
                                                            @if($value['event_status'] == 1)
                                                                <span class="label label-lg label-light-success label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true"  data-original-title="" title="">Confirm</span>
                                                            @endif
                                                            @if($value['check_time_slot'] == 1)
                                                                <span class="label label-lg label-light-warning label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true"  data-original-title="" title="">Normal interview flow</span>
                                                            @else
                                                                <span class="label label-lg label-light-dark label-inline lable-custom-w-h" data-toggle="tooltip" data-theme="dark" data-html="true"  data-original-title="" title="">Outlook interview flow</span>
                                                            @endif
                                                        </td>
                                                        <td  nowrap="nowrap">
                                                            @if($value['event_status'] == 2)

                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 open-tooltip-custom" data-toggle="modal" data-target="#event_reject_{{$value['id']}}">
                                                                    <i class="icon-md fas fa-eye"></i>
                                                                </a>

                                                            @elseif($value['event_status'] == 3)

                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 open-tooltip-custom" data-toggle="modal" data-target="#event_reject_{{$value['id']}}">
                                                                    <i class="icon-md fas fa-eye"></i>
                                                                </a>
                                                                
                                                            @else
                                                            
                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 open-tooltip-custom" data-toggle="modal" data-target="#event_reject_{{$value['id']}}">
                                                                    <i class="icon-md fas fa-eye"></i>
                                                                </a>

                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 event_edit open-tooltip-custom" data-toggle="modal" data-target="#event_edit_{{$value['id']}}">
                                                                    <span class="svg-icon svg-icon-md">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                </a>

                                                                <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" onclick="eventCancel({!!$value['id']!!},3,'cancel')" data-toggle="tooltip" data-theme="dark" data-html="true" title="Cancel Interview">
                                                                    <i class="icon-md fas fa-trash-alt"></i>
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

    @if(isset($event) && !empty($event))
        @foreach($event as $Ukey => $u_value)
            @if($u_value->event_status == 1)
            <div class="modal fade" id="event_edit_{{$u_value->id}}" tabindex="-1" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered mw-650px modal-dialog-scrollable">
                    <div class="modal-content">
                        <form class="form" action="{{route('comman.editEvent')}}" id="kt_modal_add_event_form" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h2 class="fw-bold" data-kt-calendar="title">@if(isset($u_value->event_title) && !empty($u_value->event_title)){!! $u_value->event_title !!}@endif </h2>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary kt_modal_add_event_close" data-id="event_edit_{{$u_value->id}}">
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body py-10 px-lg-17 overflow-x-hidden"  style="max-height: 550px;">
                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview stage</label>
                                        <div>
                                            <select class="form-control event_type" name="event_type" required data-id="{{$Ukey}}">
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
                                            <input type="hidden" name="event_check_time_slot" value="@if(isset($u_value->event_check_time_slot) && !empty($u_value->event_check_time_slot)){!! $u_value->event_check_time_slot!!}@endif" />
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
            @endif
        @endforeach
    @endif

    @if(isset($event) && !empty($event))
        @foreach($event as $Ukey => $r_value)
            <div class="modal fade" id="event_reject_{{$r_value->id}}" tabindex="-1" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-650px">
                    <div class="modal-content">
                        <form class="form" action="#" id="kt_modal_add_event_form" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h2 class="fw-bold" data-kt-calendar="title">@if(isset($r_value->event_title) && !empty($r_value->event_title)){!! $r_value->event_title !!}@endif</h2>
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"  data-dismiss="modal" aria-label="Close">
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-body py-10 px-lg-17 overflow-x-hidden" style="max-height: 550px;">
                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview stage</label>
                                        <div>
                                            <div class="form-control form-control-custom">@if(isset($r_value->event_type) && !empty($r_value->event_type)){!! $r_value->event_type !!}@endif</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Select User 
                                            {{-- <small>(you can select multiple option.)</small> --}}
                                        </label>
                                        <div class="event-view-select-box">
                                            @php
                                                $user_client = App\Models\User::clientDataData($u_value->client_id);
                                                $user_staff = App\Models\User::staffList($u_value->client_id);
                                                $user_clent = App\Models\User::clientListForClient($u_value->client_id);
                                                $staff_data = $user_staff->concat($user_clent)->shuffle();
                                                $staff = $staff_data->concat($user_client)->shuffle();
                                                $event_staff_data = array();
                                                if(isset($r_value->event_staff_select) && !empty($r_value->event_staff_select)){
                                                    $event_staff_data = explode(",",$r_value->event_staff_select);
                                                }
                                            @endphp
                                            <select class="form-control select2" name="event_staff_select[]" multiple="multiple" disabled>
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
                                            <div class="form-control form-control-custom">@if(isset($r_value->interview_type) && !empty($r_value->interview_type)){!! $r_value->interview_type !!}@endif</div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="fv-row mb-9" id="video_interview_{{$Ukey}}"  @if($r_value->interview_type == 'Video interview')style="display:block;"@else style="display:none;"@endif>
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">video link</label>
                                        <div>
                                            <div class="form-control form-control-custom">@if(isset($r_value->video_link) && !empty($r_value->video_link)){!! $r_value->video_link !!}@endif</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="fv-row mb-9" id="face_to_face_interview_{{$Ukey}}" @if($r_value->interview_type == 'Face to face interview')style="display:block;"@else style="display:none;"@endif>
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Interview Address</label>
                                        <div>
                                            <div class="form-control form-control-custom">@if(isset($r_value->address_select) && !empty($r_value->address_select)){!! App\Models\SiteAddress::addressGet($r_value->address_select) !!}@endif</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="fv-row mb-9">
                                    <div class="form-group">
                                        <label class="fs-6 fw-semibold mb-2">Additional Information</label>
                                        <div>
                                            <div class="form-control form-control-custom">@if(isset($r_value->event_description) && !empty($r_value->event_description)){!! $r_value->event_description !!}@endif</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row event-date-time-show">
                                    <label class="fs-6 fw-semibold mb-2">Interview Time</label>
                                    @php
                                        $time_slot = array();
                                        if(isset($r_value->time_slot) && !empty($r_value->time_slot)){
                                            $time_slot = json_decode($r_value->time_slot, true);
                                        }
                                    @endphp
                                    @if($r_value->check_time_slot == 2)
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
                                                                        if($r_value->confirm_date == $TimeKey){
                                                                            $t_val_start_time = $t_val['start_time'].':00';
                                                                            $t_val_end_time = $t_val['end_time'].':00';
                                                                            if(($t_val_start_time == $r_value->event_time) && ($t_val_end_time == $r_value->confirm_time)){
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
                                    @if($r_value->check_time_slot == 1)
                                        <div class="timeline-content">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="mr-2">
                                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                        {{App\CustomFunction\CustomFunction::isFullDate($r_value->event_date)}}
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
                                                            <span>{{ App\CustomFunction\CustomFunction::get_time_forment($r_value->event_time) }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
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

        $('body').on('click', '.event_edit', function(e) {
            KTCkeditor.init();
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
                        url: "{!! route('comman.getEventTimeReject') !!}",
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

                $(".event_time").timepicker();

                $('.date').datepicker({
                    rtl: KTUtil.isRTL(),
                    autoclose: true,
                    startDate: new Date(),
                    daysOfWeekDisabled: [0, 6],
                    todayHighlight: true,
                    format: 'dd-mm-yyyy',
                });

                $('.select2').select2({
                    placeholder: "Please Select"
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
            $(".event_time").timepicker();
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