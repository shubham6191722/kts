@extends('admin.layouts.common')

@php
  $job_full_name = 'Applications for '.$job_name;
@endphp

@section('title', $job_full_name)

@section('headerScripts')
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
@stop

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <input id="jobid" type="hidden" value="{!!$id!!}">
                    <input id="user_id" type="hidden" value="{!!$user_id!!}">

                <div class="card card-custom border-radius-none box-shadow-none ">
                    <div class="card-header card-header-tabs-line nav-tabs-line-3x border-none d-block m-height-100 position-relative">
                        <div class="card-toolbar d-block applictio-name mb-5 mt-5">
                            <div class="d-lg-flex d-md-flex d-sm-block justify-content-space-between">
                                <div>
                                    <span>
                                        Applications for <span class="text-muted">{{$job_name}}</span>
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        Company <span class="text-muted">{!! $sub_company !!}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- @if(isset($sub_company) && !empty($sub_company))
                        <div class="applictio-name text-success sub-company-name">
                            {!! $sub_company !!}
                        </div>
                        @endif --}}
                    </div>
                </div>

                <div class="card card-custom border-none border-radius-none box-shadow-none">
                    <div class="tab-block card-header mb-5">
                        <ul class="custom-box nav nav-tabs border-0 p-5">

                        @if(!empty($job_workflow_stage))
                            @foreach($job_workflow_stage as $key => $value)
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link border-none nav-hover-job @if($key == 0) active @endif main-status-change" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="{{$value->order}}" data-id="{{$id}}" @if($key == 0) data-new="1" @else data-new="0" @endif>
                                    {!! $value->stage_name !!} <span class="label label-lg label-light-primary label-inline"><span class="stage-count" id="stage_{{$value->order}}">{!! App\Models\JobApplied::jobCount($value->order,$id) !!}</span></span>
                                </a>
                            </li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                    <div class="card-body pt-0">

                        <div class="tab-pane" id="maintab_1" role="1">
                            <div class="row mt-3">
                                <div class="col-lg-12 col-xxl-4">
                                    <div class="card card-custom card-stretch gutter-b custom-box">
                                        <div class="card-body p-6">
                                            <div class="top-bar">
                                                <div class="top-bar-caption d-flex flex-column">
                                                    <div class="btn-bar">
                                                        <ul class="nav nav-tabs border-0 appliction-grid-btn custom-grid-3">
                                                            <li class="nav-item appliction-status-new-btn">
                                                                <a href="javascript:void(0)" id="new" class="nav-link border-none nav-hover-job status-change active" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="1" data-id="{{$id}}" data-new="1">
                                                                    New <span class="label label-lg label-light-primary label-inline"><span class="stage-count" id="new_1"></span></span>
                                                                </a>
                                                            </li>

                                                            <li class="nav-item">
                                                                <a href="javascript:void(0)" id="qualified" class="nav-link border-none nav-hover-job status-change" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="1" data-id="{{$id}}" data-new="0">
                                                                    Successful <span class="label label-lg label-light-primary label-inline"><span class="stage-count" id="qualified_1"></span></span>
                                                                </a>
                                                            </li>

                                                            <li class="nav-item">
                                                                <a href="javascript:void(0)" id="unsuccessful" class="nav-link border-none nav-hover-job status-change" data-flowid="{{$jobworkflow_id}}" data-status="0" data-stage="1" data-id="{{$id}}" data-new="0">
                                                                    Unsuccessful <span class="label label-lg label-light-primary label-inline"><span class="stage-count" id="unsuccessful_1"></span></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="tab_1" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <select class="form-control change_data_attr change_stage mt-3" title="Choose one of the following..." tabindex="null" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="1" data-id="{{$id}}" data-new="0">
                                                                    <option value="" selected="selected" disabled>Move to stage</option>
                                                                    @foreach($job_workflow_stage as $Skey => $s_value)
                                                                        <option value="{!! $s_value->order !!}">{!! $s_value->stage_name !!}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select class="form-control change_data_attr change_status mt-3" title="Choose one of the following..." tabindex="null" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="1" data-id="{{$id}}" data-new="0">
                                                                    <option value="" selected="selected" disabled>Make a decision on candidate</option>
                                                                    <option value="1">Successful</option>
                                                                    <option value="0">Unsuccessful</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="input-icon my-3">
                                                            <input type="text" class="form-control" id="search" placeholder="Search by name" data-flowid="{{$jobworkflow_id}}" data-status="1" data-stage="1" data-new="1" data-id="{{$id}}">
                                                            <span><i class="flaticon2-search-1 icon-md"></i></span>
                                                        </div>
                                                        <div class="check-item">
                                                            <div class="select-all-check bg-light-primary p-4">
                                                                <div class="d-flex justify-content-space-between align-items-center">
                                                                    <div class="">
                                                                        <label class="checkbox checkbox-success position-relative w-fit-content">
                                                                            <input type="checkbox" id="checkAll">
                                                                            <span></span>
                                                                            Select All
                                                                        </label>
                                                                    </div>
                                                                    <div class="" id="unsuccessful_mail" style="display: none;">
                                                                        <span data-toggle="modal" data-target="#kt_modal_unsuccessful_mail">
                                                                            <a href="javascript:void(0);" data-toggle="tooltip" data-theme="dark" data-html="true" title="" data-original-title="Unsuccessful Mail">
                                                                                <i class="fas fa-envelope"></i>
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="chekbox-item d-flex flex-column mt-3" id="application_side_bar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-8 order-2 order-xxl-1">
                                    <div id="appiction_data" class="">
                                        <div id="appiction"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_mail_preview" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold" data-kt-calendar="title">Mail Preview</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17" style="background-color: #ffffff;">
                        <div class="mail-preview" id="mail_preview_data"></div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" data-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sticky modal-sticky-bottom-right" id="kt_chat_modal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-kt-scrolltop="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-custom">
                    <div class="card-header align-items-center px-4 py-3">
                        <div class="text-start flex-grow-1">
                            <div class="text-dark-75 font-weight-bold font-size-h5" id="chat_user_name">Matt Pears</div>
                            {{-- <div>
                                <span class="label label-dot label-success"></span>
                                <span class="font-weight-bold text-muted font-size-sm">Active</span>
                            </div> --}}
                        </div>
                        <div class="text-right flex-grow-1">
                            <button type="button" class="btn btn-light btn-hover-primary btn-sm btn-icon btn-icon-md" data-dismiss="modal">
                                <i class="ki ki-close icon-1x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body message-box-body" id="user_message_main">
                        <div class="user-chat d-flexs align-items-center">
                            
                            <div class="user-chat-des d-flex flex-column">
                                <span class="user-chat-timing"></span>
                                <div class="mb-0 user-chat-summary" id="user_message_data">
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer align-items-center">
                        <textarea class="form-control border-0 p-0" rows="2" placeholder="Type a message" id="chat_message"></textarea>
                        <input type="hidden" id="chat_job_id" value="">
                        <input type="hidden" id="chat_client_id" value="">
                        <input type="hidden" id="chat_candidate_id" value="">
                        <input type="hidden" id="chat_applied_id" value="">
                        <input type="hidden" id="chat_created_id" value="">
                        <input type="hidden" id="chat_r_c_id" value="">
                        <input type="hidden" id="chat_message_id" value="">
                        <div class="d-flex align-items-center justify-content-end mt-5">
                            <button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6" id="chat_submit">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_unsuccessful_mail" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold" data-kt-calendar="title">Mail</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="fv-row">
                            <div class="form-group m-0">
                                <label class="fs-6 fw-semibold required mb-2">Mail Template</label>
                                <div>
                                    <div>
                                        <select class="form-control interview_type" name="unsuccessful_mail_template" id="unsuccessful_mail_template" required data-id="{{$job_id}}" data-client-id="{{$user_id}}" data-created-id="{{Auth::user()->id}}">
                                            <option value="" selected="selected" disabled="">Please Select</option>
                                            @if(!empty($mail_template_client))
                                                @foreach($mail_template_client as $MKey => $m_c_value)
                                                    <option value="{!! $m_c_value->id !!}">{!! $m_c_value->template_title !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" data-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="unsuccessful_mail_submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_note" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Note</h5>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body" style="max-height: 550px;">
                    <div class="form" method="POST">
                        <div class="modal-body-sub">
                            <div class="fv-row">
                                <div class="form-group mb-0">
                                    <label class="fs-6 fw-semibold mb-2">Note</label>
                                    <div class="note-section-data">
                                        <textarea type="text" class="form-control summernote" rows="2" placeholder="Type a message" id="user_note" name="user_note"></textarea>
                                        <input type="hidden" id="user_note_id" name="user_note_id">
                                        <input type="hidden" id="created_user_id" name="created_user_id" value="{{Auth::user()->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer pl-0 pr-0 flex-left">
                            <button type="reset" data-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="note_mail_submit">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                    <div class="">
                        <div class="timeline timeline-3">
                            <div class="timeline-items" id="apllication_note_timeline_items">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/js/pages/crud/forms/widgets/bootstrap-timepicker.js"></script>
    <script>
        $(document).ready(function () {
            
            var jobid = $('#jobid').val();
            var jobstatus = 1;
            var jobstage = 1;
            var jobnew = 1;
            load_status_job_data_user(jobid,jobstatus,jobstage,jobnew);

            $(".status-change").click(function() {
                $('.status-change').removeClass('active');
                $(this).addClass('active');
                jobid = $(this).attr('data-id');
                jobstatus = $(this).attr('data-status');
                jobstage = $(this).attr('data-stage');
                jobnew = $(this).attr('data-new');
                $('.change_data_attr').attr("data-status",jobstatus);
                $('#search').attr("data-status",jobstatus);
                $('#search').attr("data-new",jobnew);
                $('#checkAll').prop('checked', false);
                $('#search').val('');

                if(jobstatus == 0){
                    $('#unsuccessful_mail').show();
                }else{
                    $('#unsuccessful_mail').hide();
                }

                load_status_job_data_user(jobid,jobstatus,jobstage,jobnew);
            });
            
            $(".main-status-change").click(function() {

                $('.main-status-change').removeClass('active');
                $(this).addClass('active');

                jobid = $(this).attr('data-id');
                jobstatus = $(this).attr('data-status');
                jobstage = $(this).attr('data-stage');
                jobnew = $(this).attr('data-new');

                $('.change_data_attr').attr("data-stage",jobstage);
                $('.change_data_attr').attr("data-status",'1');

                $('#search').attr("data-stage",jobstage);
                $('#search').attr("data-status",'1');
                $('#search').attr("data-new",jobnew);
                $('#checkAll').prop('checked', false);
                $('#search').val('');
                $('.change_stage').val('');
                $('.change_status').val('');

                if(jobstage != '1'){
                    $('#qualified').attr("data-stage",jobstage);
                    $('#unsuccessful').attr("data-stage",jobstage);
                    $('.appliction-status-new-btn').hide();
                    $('#unsuccessful').removeClass('active');
                    $('#qualified').addClass('active');
                    $('.appliction-grid-btn').removeClass('custom-grid-3');
                }else{
                    $('#qualified').attr("data-stage",jobstage);
                    $('#unsuccessful').attr("data-stage",jobstage);
                    $('.appliction-status-new-btn').show();
                    $('#unsuccessful').removeClass('active');
                    $('#qualified').removeClass('active');
                    $('#new').addClass('active');
                    $('.appliction-grid-btn').addClass('custom-grid-3');
                }
                load_status_job_data_user(jobid,jobstatus,jobstage,jobnew);

            });

            $('.change_stage').on('change', function (e) {
                var changevalue = this.value;
                var job = 'job_stage';
                var id = [];

                var data_status = $(this).attr('data-status');
                var data_stage = $(this).attr('data-stage');
                var data_id = $(this).attr('data-id');
                var data_flowid = $(this).attr('data-flowid');
                var data_new = $(this).attr('data-new');

                $('input[name="chnage_status_stage"]:checked').each(function() {
                    var value = $(this).val();
                    id.push(value);
                });

                if (id.length === 0) {
                    show_toastr('error', 'Please select a candidate!','');
                    $('.change_data_attr').prop('selectedIndex',0);
                    $('#checkAll').prop('checked', false);
                }else{
                    jobStageStatusChange(changevalue,id,job,data_status,data_stage,data_id,data_flowid,data_new);
                }

            });

            $('.change_status').on('change', function (e) {
                var changevalue = this.value;
                var job = 'job_status';
                var id = [];

                var data_status = $(this).attr('data-status');
                var data_stage = $(this).attr('data-stage');
                var data_id = $(this).attr('data-id');
                var data_flowid = $(this).attr('data-flowid');
                var data_new = $(this).attr('data-new');

                $('input[name="chnage_status_stage"]:checked').each(function() {
                    var value = $(this).val();
                    id.push(value);
                });

                if(changevalue){
                    if (id.length === 0) {
                        show_toastr('error', 'Please select a candidate!','');
                        $('.change_data_attr').prop('selectedIndex',0);
                        $('#checkAll').prop('checked', false);
                    }else{
                        jobStageStatusChange(changevalue,id,job,data_status,data_stage,data_id,data_flowid,data_new);
                    }
                }

            });

            $("#checkAll").click(function(){
                $('input[name="chnage_status_stage"]:checkbox').not(this).prop('checked', this.checked);
            });

            $('body').on('click', '.checkbox_cursor_pointer', function() {
                
                var appliedid = $(this).attr('data-id');
                $('.chekbox-item-caption').removeClass('active-application');
                $(this).parent().parent().addClass('active-application');
                load_job_data_user(appliedid);
            });

            $('body').on('change', '.applided_change_stage', function() {
                var changevalue = this.value;
                var job = 'job_status';
                var id = [];

                var data_status = $(this).attr('data-status');
                var data_stage = $(this).attr('data-stage');
                var data_id = $(this).attr('data-id');
                var data_flowid = $(this).attr('data-flowid');
                var data_new = $(this).attr('data-new');
                id.push($(this).attr('data-value'));

                if(changevalue){
                    if (id.length === 0) {
                        show_toastr('error', 'Please select a candidate!','');
                        $('.change_data_attr').prop('selectedIndex',0);
                        $('#checkAll').prop('checked', false);
                    }else{
                        jobStageStatusChange(changevalue,id,job,data_status,data_stage,data_id,data_flowid,data_new);
                    }
                }

            });

            $('body').on('click', '#offer_submit', function() {

                var applied_id = $('#offer_applied_id').val();
                var vacancy_id = $('#offer_vacancy_id').val();
                var client_id = $('#offer_client_id').val();
                var user_id = $('#offer_user_id').val();
                var offered_salary = $('#offer_offered_salary').val();
                var suggested_date = $('#offer_suggested_date').val();
                var description = $('#offer_description').val();
                var offer_id = $('#offer_id').val();

                var job_reference = $('#offer_job_reference').val();
                var offer_r_c_id = $('#offer_r_c_id').val();

                var offer_submit = 'offer_submit';
                var modal_name = 'kt_modal_offer';

                if(offered_salary == ''){
                    show_toastr("error", 'Offered salary ', "");
                }
                if(suggested_date == ''){
                    show_toastr("error", 'Suggested start date', "");
                }
                if(description == ''){
                    show_toastr("error", 'description', "");
                }


                if( (suggested_date != '') && (offered_salary != '') && (description != '')){
                    // offerSubmit(applied_id,vacancy_id,client_id,user_id,offered_salary,suggested_date,description,offer_submit,modal_name,offer_id,job_reference,offer_r_c_id);
                    offerSubmit(offer_submit,modal_name);
                }

            });

            $('body').on('click', '.onclick_thumbs_status', function() {
                
                var data_id = $(this).attr('data-id');
                var data_value = $(this).attr('data-value');
                var data_class = $(this).attr('data-class');
                var data_remove_class = $(this).attr('data-remove-class');
                thumbs_status_change(data_id,data_value,data_class,data_remove_class);
            });

            $('body').on('change', '#offer_letter_file', function() {
                var form_id = $(this).attr('data-id');

                if (this.files[0].size > 2097152) {
                    $('#offer_submit').prop('disabled', true);
                    $('#error_msg_'+form_id).show();
                } else {
                    $('#offer_submit').prop('disabled', false);
                    $('#error_msg_'+form_id).hide();
                }
            });

            $('body').on('click', '.close', function() {
                var form_id = $(this).attr('data-id');
                $('#error_msg_'+form_id).hide();
            });

        });

        function offerSubmit(offer_submit,modal_name) {

            var formData = new FormData();

            var applied_id = $('#offer_applied_id').val();
            var vacancy_id = $('#offer_vacancy_id').val();
            var client_id = $('#offer_client_id').val();
            var user_id = $('#offer_user_id').val();
            var offered_salary = $('#offer_offered_salary').val();
            var suggested_date = $('#offer_suggested_date').val();
            var description = $('#offer_description').val();
            var offer_id = $('#offer_id').val();

            var job_reference = $('#offer_job_reference').val();
            var offer_r_c_id = $('#offer_r_c_id').val();

            var offer_submit = 'offer_submit';
            var modal_name = 'kt_modal_offer';

            let _token = $('#kt_modal_offer input[name="_token"]').val();
            var photo = $('#offer_letter_file').prop('files')[0];

            formData.append('applied_id', applied_id);
            formData.append('vacancy_id', vacancy_id);
            formData.append('client_id', client_id);
            formData.append('user_id', user_id);
            formData.append('offered_salary', offered_salary);
            formData.append('suggested_date', suggested_date);
            formData.append('description', description);
            formData.append('offer_id', offer_id);
            
            formData.append('job_reference', job_reference);
            formData.append('offer_r_c_id', offer_r_c_id);
            
            formData.append('offer_submit', offer_submit);
            formData.append('modal_name', modal_name);
            formData.append('_token', _token);

            formData.append('offer_letter_file', photo);
            if($('#offer_letter').length){
                var offer_letter = $('#offer_letter').val();
                formData.append('offer_letter', offer_letter);
            }

            $('#'+offer_submit).attr("data-kt-indicator","on");
            $('#'+offer_submit).prop('disabled', true);

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.offerCreate')}}",
                type: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    // $.LoadingOverlay("show");
                },success: function (data) {
                    if (data.code == 1) {
                        $('#'+data.modal_name).modal('hide');
                        show_toastr("success", data.msg, "");
                        setTimeout(function () {
                            // $.LoadingOverlay("hide");
                            var appliedid = $('#application_side_bar .active-application .checkbox_cursor_pointer').attr('data-id');
                            load_job_data_user(appliedid);
                        }, 1000);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $('#'+offer_submit).removeAttr("data-kt-indicator");
                    $('#'+offer_submit).prop('disabled', false);
                    show_toastr('error', 'Please try again!','');
                    $.LoadingOverlay("hide");
                }
            });

        }

        function load_job_data_user(appliedid) {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#appiction').hide();
            $.ajax({
                url: "{{route('comman.jobDataGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    appliedid: appliedid,
                },
                beforeSend: function () {
                    $('#appiction_data').addClass('loader');
                    $('#appiction').hide();
                }, success: function (data) {

                    if (data.code == 1) {
                        if(data.page){
                            $('#appiction').html(data.page);
                        }else{
                            $('#appiction').html('<p class="text-center">No Details found</p>');
                        }
                        
                    } else {

                        $('#appiction').html('<p class="text-center">No Details found</p>');

                    }
                    
                    setTimeout(function () {
                        $('#appiction_data').removeClass('loader');
                        $('#appiction').fadeIn(1000);
                        $('#ev_event_staff_select.select2').select2({
                            placeholder: "Please Select",
                            allowClear: true
                        });
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $('#appiction_data').removeClass('loader');
                    $('#appiction').html('<p class="text-center">No Details found</p>');
                    $('#appiction').fadeIn(1000);
                }
            });
        }

        function jobStageStatusChange(changevalue,id,job,data_status,data_stage,data_id,data_flowid,data_new) {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.chageStateSattus')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    changevalue: changevalue,
                    job: job,
                    id: id,
                    data_status: data_status,
                    data_stage: data_stage,
                    data_id: data_id,
                    data_flowid: data_flowid,
                    data_new: data_new,
                },
                beforeSend: function () {
                    $('#application_side_bar').addClass('loader');
                    $.LoadingOverlay("show");
                }, success: function (data) {

                    if (data.code == 1) {
                        show_toastr('success',data.msg);
                        $('.change_data_attr').prop('selectedIndex',0);
                        $('#checkAll').prop('checked', false);
                        var data_new = $('.status-change.active').attr('data-new');
                    
                        load_status_job_data_user(data.data_id,data.data_status,data.data_stage,data_new);
                        
                        setTimeout(function () {
                            jobCount(data.data_flowid);
                        }, 200);

                    } else {
                        show_toastr('error', 'Please try again!','');
                        $('#application_side_bar').html('<p class="text-center">No Details found</p>');
                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                        $('#application_side_bar').removeClass('loader');
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                    show_toastr('error', 'Please try again!','');
                    $('#application_side_bar').removeClass('loader');
                    $('#application_side_bar').html('<p class="text-center">No Details found</p>');
                }
            });
        }

        function jobCount(data_id) {
            var jobid = $('#jobid').val();
            var user_id = $('#user_id').val();
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.chageCount')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    data_id: data_id,
                    jobid: jobid,
                    user_id: user_id,
                },
                success: function (data) {
                    if (data.code == 1) {
                        var substr = data.jobCount_arr;
                        $.each(substr , function(index, val) { 
                            $('#stage_'+index).html(val);
                        });
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                }
            });
        }

        function load_status_job_data_user(jobid,jobstatus,jobstage,jobnew) {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.jobApplied')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    jobid: jobid,
                    jobstatus: jobstatus,
                    jobstage: jobstage,
                    jobnew: jobnew,
                },
                beforeSend: function () {
                    $('#application_side_bar').addClass('loader');
                    $.LoadingOverlay("show");
                }, success: function (data) {

                    $('#appiction').html('');

                    if (data.code == 1) {
                        if(data.page){
                            $('#application_side_bar').html(data.page);
                            setTimeout(function () {
                                var appliedid = $('#application_side_bar .checkbox_cursor_pointer').attr('data-id');
                                load_job_data_user(appliedid);
                            }, 1000);

                        }else{
                            $('#application_side_bar').html('<p class="text-center">No Details found</p>');
                        }
                        
                    } else {

                        $('#application_side_bar').html('<p class="text-center">No Details found</p>');

                    }
                    setTimeout(function () {
                        $('#qualified_1').html(data.qualified);
                        $('#unsuccessful_1').html(data.unsuccessful);
                        $('#new_1').html(data.new);
                        $.LoadingOverlay("hide");
                        $('#application_side_bar').removeClass('loader');
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $('#application_side_bar').removeClass('loader');
                    $('#application_side_bar').html('<p class="text-center">No Details found</p>');
                }
            });
        }

        function thumbs_status_change(data_id,data_value,data_class,data_remove_class) {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.thumbsStatusChange')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    data_id: data_id,
                    data_value: data_value,
                    data_class: data_class,
                    data_remove_class: data_remove_class,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                }, success: function (data) {

                    if (data.code == 1) {
                        $('.'+data.remove_class).removeClass('active');
                        $('.'+data.class).addClass('active');
                        show_toastr('success',data.msg);
                    } else {
                        show_toastr('error', 'Please try again!','');
                    }
                    
                    $.LoadingOverlay("hide");
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                    $.LoadingOverlay("hide");
                }
            });
        }
        
    </script>
    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function() {

                var token = $("meta[name='csrf-token']").attr("content");

                var search_value = $(this).val();

                var data_status = $(this).attr('data-status');
                var data_stage = $(this).attr('data-stage');
                var data_id = $(this).attr('data-id');
                var data_flowid = $(this).attr('data-flowid');
                var data_new = $(this).attr('data-new');

                $.ajax({
                    url: "{{route('comman.jobNameSearch')}}",
                    type: 'POST',
                    data: {
                        "search_value": search_value,
                        "_token": token,
                        "data_status": data_status,
                        "data_stage": data_stage,
                        "data_id": data_id,
                        "data_flowid": data_flowid,
                        "jobnew": data_new,
                    },
                    beforeSend: function () {
                        $('#application_side_bar').addClass('loader');
                    },success: function (data){

                        $('#appiction').html('');
                        
                        if (data.code == 1) {
                            if(data.page){
                                $('#application_side_bar').html(data.page);
                            }else{
                                $('#application_side_bar').html('<p class="text-center">No Details found</p>');
                            }
                            
                        } else {

                            $('#application_side_bar').html('<p class="text-center">No Details found</p>');

                        }
                        setTimeout(function () {
                            $('#application_side_bar').removeClass('loader');
                        }, 200);
                        
                    }
                });
            });

            $('body').on('click', '#mail_submit', function() {

                var applied_id = $('#mail_applied_id').val();
                var vacancy_id = $('#mail_vacancy_id').val();
                var client_id = $('#mail_client_id').val();
                var user_id = $('#mail_user_id').val();
                var mail_template = $('#mail_template').val();
                var job_reference = $('#mail_job_reference').val();
                var created_id = $('#mail_created_id').val();
                var offer_submit = 'mail_submit';
                var modal_name = 'kt_modal_mail';

                if((mail_template == '') || (mail_template == null)){
                    show_toastr("error", 'Please Select Mail template ', "");
                }

                if( (mail_template != '') && (mail_template != null)){
                    mailSend(applied_id,vacancy_id,client_id,user_id,mail_template,offer_submit,modal_name,job_reference,created_id);
                }

            });

            $('body').on('change', '#mail_template', function() {
                var applied_id = $(this).attr('data-a-id');
                var vacancy_id = $(this).attr('data-v-id');
                var client_id = $(this).attr('data-c-id');
                var user_id = $(this).attr('data-u-id');
                var created_id = $(this).attr('data-created-id');
                var job_reference = $(this).attr('data-j-r-id');
                var mail_template =$(this).val();
                $('#btn_kt_modal_mail_preview').css("display", "block");
                mailPriview(applied_id,vacancy_id,client_id,user_id,mail_template,job_reference,created_id);
            });
        });
        function mailPriview(applied_id,vacancy_id,client_id,user_id,mail_template,job_reference,created_id) {

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.candidateMailPreview')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    applied_id: applied_id,
                    vacancy_id: vacancy_id,
                    client_id: client_id,
                    user_id: user_id,
                    mail_template: mail_template,
                    job_reference: job_reference,
                    created_id: created_id,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },success: function (data) {
                    if (data.code == 1) {
                        setTimeout(function () {
                            $('#mail_preview_data').html(data.msg);
                            // $('#kt_modal_mail_preview').modal('show');
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

        function mailSend(applied_id,vacancy_id,client_id,user_id,mail_template,offer_submit,modal_name,job_reference,created_id) {

            $('#'+offer_submit).attr("data-kt-indicator","on");
            $('#'+offer_submit).prop('disabled', true);

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.candidateMailSend')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    applied_id: applied_id,
                    vacancy_id: vacancy_id,
                    client_id: client_id,
                    user_id: user_id,
                    mail_template: mail_template,
                    job_reference: job_reference,
                    created_id: created_id,
                },
                success: function (data) {
                    if (data.code == 1) {
                        setTimeout(function () {
                            $('#'+modal_name).modal('hide');
                            $('#mail_template').val('');
                            $('#'+offer_submit).removeAttr("data-kt-indicator");
                            $('#'+offer_submit).prop('disabled', false);
                            show_toastr("success", data.msg, "");
                        }, 1000);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $('#'+modal_name).modal('hide');
                    $('#mail_template').val('');
                    $('#'+offer_submit).removeAttr("data-kt-indicator");
                    $('#'+offer_submit).prop('disabled', false);
                    show_toastr('error', 'Please try again!','');
                }
            });

        }
    </script>
    <script>
        $(document).ready(function () {

            $('body').on('click', '#kt_modal_add_event_submit', function() {

                var event_check_time_slot = $('#ev_check_time_slot').val();

                var event_time_slot = null;

                if(event_check_time_slot == 2){
                    const event_time_slot_data = new Array();
                    $('input.time_slot_input:checked').each(function(i){
                        var value = $(this).val();
                        var v_date = $(this).attr('data-date');
                        var v_start_time = $(this).attr('data-start-time');
                        var v_end_time = $(this).attr('data-end-time');

                        event_time_slot_data.push({
                            v_date: v_date, 
                            v_start_time: v_start_time, 
                            v_end_time: v_end_time, 
                            value: value, 
                        });
                    });

                    // var event_time_slot = $('input.time_slot_input:checked').serializeArray();

                    const myJSON = JSON.stringify(event_time_slot_data);
                    event_time_slot = myJSON;
                    
                    // $('input.date_slot_input:checked').each(function(i){
                    // });
                }

                var event_type = $('#ev_event_type option:selected').val();
                var event_staff_select = $('#ev_event_staff_select').val();
                var interview_type = $('#ev_interview_type option:selected').val();
                var video_link = $('#ev_video_link').val();
                var address_select = $('#ev_address_select option:selected').val();
                var event_description = $('#ev_event_description').val();
                if(event_check_time_slot == 2){
                    var myDate=new Date();
                    myDate.setDate(myDate.getDate()+1);
                    // format a date
                    var dt = myDate.getDate() + '-' + ("0" + (myDate.getMonth() + 1)).slice(-2) + '-' + myDate.getFullYear();
                    var event_date = dt;
                }else{
                    var event_date = $('#ev_event_date').val();    
                }
                var event_time = $('#ev_event_time').val();
                
                var applied_id = $('#ev_applied_id').val();
                var vacancy_id = $('#ev_vacancy_id').val();
                var client_id = $('#ev_client_id').val();
                var user_id = $('#ev_user_id').val();
                var job_reference = $('#ev_job_reference').val();
                var ev_r_c_id = $('#ev_r_c_id').val();
            
                var offer_submit = 'kt_modal_add_event_submit';
                var modal_name = 'kt_modal_add_event';

                var error_check = 'no null';

                if(event_type === 'Please Select'){
                    show_toastr("error", 'Interview stage is required!', "");
                    error_check = 'null';
                }
                
                if(interview_type === 'Please Select'){
                    show_toastr("error", 'Interview type is required!', "");
                    error_check = 'null';
                }

                if(interview_type == 'Face to face interview'){
                    if(address_select == ''){
                        show_toastr("error", 'Interview Address is required!', "");
                        error_check = 'null';
                    }
                }
                
                if(event_staff_select == ''){
                    show_toastr("error", 'Interview Staff is required!', "");
                    error_check = 'null';
                }

                if(interview_type == 'Video interview'){
                    if(video_link == ''){
                        show_toastr("error", 'Video link is required!', "");
                        error_check = 'null';
                    }
                }

                if(event_description == ''){
                    show_toastr("error", 'Additional Information is required!', "");
                    error_check = 'null';
                }

                if(event_date == ''){
                    show_toastr("error", 'Interview Date is required!', "");
                    error_check = 'null';
                }

                if((error_check != 'null') ){
                    eventSubmit(event_type,event_staff_select,interview_type,video_link,address_select,event_description,event_date,applied_id,vacancy_id,client_id,user_id,job_reference,offer_submit,modal_name,ev_r_c_id,event_time,event_check_time_slot,event_time_slot);
                }

            });
        });

        function eventSubmit(event_type,event_staff_select,interview_type,video_link,address_select,event_description,event_date,applied_id,vacancy_id,client_id,user_id,job_reference,offer_submit,modal_name,ev_r_c_id,event_time,event_check_time_slot,event_time_slot) {

            $('#'+offer_submit).attr("data-kt-indicator","on");
            $('#'+offer_submit).prop('disabled', true);

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.addEvent')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    event_type: event_type,
                    event_staff_select: event_staff_select,
                    interview_type: interview_type,
                    video_link: video_link,
                    address_select: address_select,
                    event_description: event_description,
                    event_date: event_date,
                    event_time: event_time,
                    applied_id: applied_id,
                    vacancy_id: vacancy_id,
                    client_id: client_id,
                    user_id: user_id,
                    job_reference: job_reference,
                    r_c_id: ev_r_c_id,
                    event_check_time_slot: event_check_time_slot,
                    event_time_slot: event_time_slot
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    if (data.code == 1) {
                        setTimeout(function () {
                            $('#'+offer_submit).removeAttr("data-kt-indicator");
                            $('#'+modal_name).modal('hide');
                            $('#'+offer_submit).prop('disabled', false);
                            show_toastr("success", data.msg, "");

                            $('#ev_event_type').prop('selectedIndex',0);
                            $('#ev_event_staff_select').prop('selectedIndex',0);
                            $('#ev_interview_type').prop('selectedIndex',0);
                            $('#ev_video_link').val('');
                            $('#ev_address_select').val('');
                            $('#ev_event_description').val('');
                            $('#ev_event_date').val('');
                            $('#ev_address_select').prop('selectedIndex',0);;
                            $('#video_interview').css('display','none');
                            $('#face_to_face_interview').css('display','none');

                            var date_html = '';
                            var objTo = document.getElementById('ev_event_date_schedule')
                            objTo.innerHTML = date_html;

                            var time_html = '';
                            var objTo_2 = document.getElementById('ev_event_time_schedule')
                            objTo_2.innerHTML = time_html;

                            $('#ev_event_staff_select').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });

                            $.LoadingOverlay("hide");

                        }, 1000);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                    $.LoadingOverlay("hide");
                }
            });

        }
    </script>
    <script>
        $(document).ready(function () {

            $('body').on('change', '#offer_benefit_package', function() {
                var client_id = $(this).attr('data-c-id');
                var package_id =$(this).val();
                benefitPackage(package_id,client_id);
            });
        });
        function benefitPackage(package_id,client_id) {

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
                            $('#offer_description').val(message);
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

    <script>
        $(document).ready(function () {

            $('body').on('click', '#chat_submit', function() {
                var chat_message = $('#chat_message').val();
                var chat_job_id = $('#chat_job_id').val();
                var chat_client_id = $('#chat_client_id').val();
                var chat_candidate_id = $('#chat_candidate_id').val();
                var chat_applied_id = $('#chat_applied_id').val();
                var chat_created_id = $('#chat_created_id').val();
                var chat_r_c_id = $('#chat_r_c_id').val();
                var chat_message_id = $('#chat_message_id').val();
                sendChat(chat_message,chat_job_id,chat_client_id,chat_candidate_id,chat_applied_id,chat_created_id,chat_r_c_id,chat_message_id);
            });
        });
        function sendChat(chat_message,chat_job_id,chat_client_id,chat_candidate_id,chat_applied_id,chat_created_id,chat_r_c_id,chat_message_id) {

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('comman.sendChat')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    job_id: chat_job_id,
                    client_id: chat_client_id,
                    candidate_id: chat_candidate_id,
                    applied_id: chat_applied_id,
                    created_id: chat_created_id,
                    r_c_id: chat_r_c_id,
                    message_id: chat_message_id,
                    message: chat_message,
                },
                success: function (data) {
                    if (data.code == 1) {
                        $('#chat_message_id').val(data.message_id);
                        $("#user_message_data").append(data.message);
                        $("#chat_message").val('');
                        setTimeout(function () {
                            var div_height = $('#user_message_data').height() + 100;
                            $('#user_message_main').animate({
                                scrollTop: div_height
                            }, 100);
                        }, 500);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    // show_toastr('error', 'Please try again!','');
                }
            });

        }
    </script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $("#unsuccessful_mail_submit").click(function(){
                
                var id = [];

                var unsuccessful_mail_template = $('#unsuccessful_mail_template').val();
                var job_id = $('#unsuccessful_mail_template').attr('data-id');
                var client_id = $('#unsuccessful_mail_template').attr('data-client-id');
                var created_id = $('#unsuccessful_mail_template').attr('data-created-id');
                
                $('input[name="chnage_status_stage"]:checked').each(function() {
                    var value = $(this).val();
                    id.push(value);
                });

                if (id.length === 0) {
                    show_toastr('error', 'Please select a candidate!','');
                    $('.change_data_attr').prop('selectedIndex',0);
                    $('#checkAll').prop('checked', false);
                }else{
                    unsuccessfulMailSend(unsuccessful_mail_template,id,job_id,client_id,created_id);
                }
            });
        });
        function unsuccessfulMailSend(unsuccessful_mail_template,id,job_id,client_id,created_id) {
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.unsuccessfulMailSend')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    unsuccessful_mail_template: unsuccessful_mail_template,
                    id: id,
                    job_id: job_id,
                    client_id: client_id,
                    created_id: created_id,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                }, success: function (data) {

                    if (data.code == 1) {
                        show_toastr('success',data.msg);
                        $('.change_data_attr').prop('selectedIndex',0);
                        $('#unsuccessful_mail_template').prop('selectedIndex',0);
                        $('#checkAll').prop('checked', false);

                        var jobid = $('.status-change.active').attr('data-id');
                        var jobstatus = $('.status-change.active').attr('data-status');
                        var jobstage = $('.status-change.active').attr('data-stage');
                        var jobnew = $('.status-change.active').attr('data-new');

                        load_status_job_data_user(jobid,jobstatus,jobstage,jobnew);

                    } else {
                        show_toastr('error', 'Please try again!','');
                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 200);

                    $('#kt_modal_unsuccessful_mail').modal('hide');
                    // var myModal = new bootstrap.Modal(document.getElementById('kt_modal_unsuccessful_mail'));
                    // myModal.hide();
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                    show_toastr('error', 'Please try again!','');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '.open-modal-note', function() {
                var user_note_id = $(this).attr('data-id');
                $('#user_note_id').val(user_note_id);
                var modal_name = 'kt_modal_note';
                noteGet(user_note_id,modal_name)
                // $('#kt_modal_note').modal('show');
            });

            $('body').on('click', '#note_mail_submit', function() {

                var user_note = $('#user_note').val();
                var user_note_id = $('#user_note_id').val();
                var created_user_id = $('#created_user_id').val();

                var note_submit = 'note_mail_submit';
                var modal_name = 'kt_modal_note';

                var error_check = 'no null';

                if(user_note === ''){
                    show_toastr("error", 'Note is required!', "");
                    error_check = 'null';
                }
                if(user_note_id === ''){
                    show_toastr("error", 'Please reload. Please try again!', "");
                    error_check = 'null';
                }
                if((error_check != 'null') ){
                    noteSubmit(user_note,user_note_id,created_user_id,note_submit,modal_name);
                }

            });

        });

        function noteGet(user_note_id,modal_name) {
            
            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.noteGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    user_note_id: user_note_id,
                    modal_name: modal_name,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                    $('#user_note').val('');
                    $('#apllication_note_timeline_items').html('');
                    $(".note-section-data .summernote").summernote("code", '');
                }, 
                success: function (data) {
                    if (data.code == 1) {
                        $('#apllication_note_timeline_items').html(data.note);
                        setTimeout(function () {
                            $('#'+modal_name).modal('show');
                            // KTCkeditor.init();
                        }, 1000);
                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 1000);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                    $.LoadingOverlay("hide");
                }
            });
        }

        function noteSubmit(user_note,user_note_id,created_user_id,note_submit,modal_name) {
            
            $('#'+note_submit).attr("data-kt-indicator","on");
            $('#'+note_submit).prop('disabled', true);

            $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('comman.noteSubmit')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    user_note: user_note,
                    user_note_id: user_note_id,
                    created_user_id: created_user_id,
                    note_submit: note_submit,
                    modal_name: modal_name,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                }, 
                success: function (data) {
                    if (data.code == 1) {
                        setTimeout(function () {
                            $('#'+modal_name).modal('hide');
                            $('#user_note').val('');
                            $('#user_note_id').val('');
                            $('#'+note_submit).removeAttr("data-kt-indicator");
                            $('#'+note_submit).prop('disabled', false);
                            show_toastr("success", data.msg, "");
                        }, 1000);
                    }
                    $.LoadingOverlay("hide");
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    $('#'+modal_name).modal('hide');
                    $('#user_note').val('');
                    $('#user_note_id').val('');
                    $('#'+note_submit).removeAttr("data-kt-indicator");
                    $('#'+note_submit).prop('disabled', false);
                    show_toastr('error', 'Please try again!','');
                    $.LoadingOverlay("hide");
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
        $(function() {
            
            $('body').on('change', '.staff_select_event', function() {
                var id = $(this).val();
                var check_time_slot = $('#ev_check_time_slot').val();
                if(check_time_slot == 2){
                    var myDate=new Date();
                    myDate.setDate(myDate.getDate()+1);
                    // format a date
                    var dt = myDate.getDate() + '-' + ("0" + (myDate.getMonth() + 1)).slice(-2) + '-' + myDate.getFullYear();
                    var date = dt;
                }
                var time_distance = $('#ev_time_distance').val();
                outLookDateTime(id,date,time_distance);
            });

            $('body').on('change', '#ev_time_distance', function() {
                var id = $('#ev_event_staff_select').val();
                var check_time_slot = $('#ev_check_time_slot').val();
                if(check_time_slot == 2){
                    var myDate=new Date();
                    myDate.setDate(myDate.getDate()+1);
                    // format a date
                    var dt = myDate.getDate() + '-' + ("0" + (myDate.getMonth() + 1)).slice(-2) + '-' + myDate.getFullYear();
                    var date = dt;
                }
                var time_distance = $(this).val();
                outLookDateTime(id,date,time_distance);
            });

            $('body').on('click', '.time_slot_input', function() {
                var numberOfChecked = $('input.time_slot_input:checkbox:checked').length;
                if(numberOfChecked > 0){
                    $('#ev_event_time_label_3').show();
                }else{
                    $('#ev_event_time_label_3').hide();
                }
                if($(this).prop('checked')) {
                    var getid = $(this).attr('id');
                    var getdate = $(this).attr('data-date');
                    var getday = $(this).attr('data-day');
                    var getdidate = $(this).attr('data-di-date');
                    var getstarttime = $(this).attr('data-start-time');
                    var getendtime = $(this).attr('data-end-time');
                    var removeid = 'remove_'+$(this).attr('id');
                    addDateTimeDisplay(getid,getdate,getday,getdidate,getstarttime,getendtime,removeid);
                } else {
                    var removeid = 'remove_'+$(this).attr('id');
                    removeDateTimeDisplay(removeid);
                }
            });

            $('body').on('click', '.remove_time_slot_input', function() {

                var numberOfChecked = $('input.time_slot_input:checkbox:checked').length;
                if(numberOfChecked > 1){
                    $('#ev_event_time_label_3').show();
                }else{
                    $('#ev_event_time_label_3').hide();
                }

                var getid = $(this).attr('data-id');
                var removeid = $(this).attr('data-remove-id');
                removeCheckedDateTimeDisplay(getid,removeid);
            });
        });

        function outLookDateTime(id,date,time_distance) {
            if(id != ''){
                $.ajaxSetup({headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('comman.outLookDateTime')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                        date: date,
                        time_distance: time_distance,
                    },
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    }, 
                    success: function (data) {

                        if (data.code == 1) {

                            var event_data = data.event_data;
                            
                            var date_html = '';
                            var time_html = '';
                        
                            $.each(event_data, function (k,v) {

                                var index = k;
                                
                                index = stringReplace(index);

                                const days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
                                // const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
                                // const monthNames = ["Ja", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                const monthNames = ["01", "02", "03", "04", "05", "06","07", "08", "09", "10", "11", "12"];

                                const d = new Date(k);
                                var get_month = d.getMonth()+1;
                                var day = d.getDate();

                                day = ((''+day).length<2 ? '0' : '') + day;
                                
                                date_html += '<li class="nav-item p-0 ms-0 m-0">';
                                date_html += '<a class="nav-link btn d-flex flex-column flex-center min-w-45px py-3 px-3 c-border-add active-bg-color" data-toggle="tab" href="#kt_timeline_widget_'+index+'">';
                                // date_html += '<span class="font-size-13">'+k+'</span>';
                                date_html += '<span class="font-size-13">'+days[d.getDay()]+'</span>';
                                date_html += '<span class="font-size-13">'+monthNames[d.getMonth()] +'-'+day+'</span>';
                                // date_html += '<span class="font-size-13">'+k+'</span>';
                                date_html += '</a>';
                                date_html += '</li>';

                                time_html += '<div class="tab-pane fade add-bg-for-time-slot" id="kt_timeline_widget_'+index+'">';
                                time_html += '<div class="d-flex align-items-left flex-column">';
                                time_html += '<div class="checkbox-wapper d-flex justify-content-between gap-md-2 gap-5">';
                                    if(v.length == 0){
                                        time_html += '<div class="form-check mb-0 d-flex align-items-center p-0 gap-2">';
                                        time_html += '<div> No time slots available';
                                        time_html += '</div>';
                                        time_html += '</div>';
                                    }else{
                                        $.each(v, function (j,vi) {
                                            time_html += '<div class="form-check mb-0 d-flex align-items-center p-0 gap-2">';
                                            time_html += '<input class="select-item_checkbox m-0 time_slot_input" name="time_slot_input['+k+'][]" data-date="'+k+'" data-start-time="'+vi.start_time+'" data-end-time="'+vi.end_time+'" type="checkbox" value="'+vi.full_time+'" id="timeline_'+j+'_'+index+'" data-day="'+days[d.getDay()]+'" data-di-date="'+monthNames[d.getMonth()] +'-'+day+'">';
                                            time_html += '<label class="selector-item_label" for="timeline_'+j+'_'+index+'">'+vi.full_time+'</label>';
                                            time_html += '</div>';
                                        });
                                    }
                                    

                                time_html += '</div>';
                                time_html += '</div>';
                                time_html += '</div>';
                            });
                        
                            var objTo = document.getElementById('ev_event_date_schedule')
                            objTo.innerHTML = date_html;
                            var objTo_2 = document.getElementById('ev_event_time_schedule')
                            objTo_2.innerHTML = time_html;

                            var time_lable = '<label class="fs-6 fw-semibold mb-2">Choose a selection of dates and times to suggest to the candidate, and the candidate will select the option that suits them</label>';
                            var objTo_3 = document.getElementById('ev_event_time_label')
                            objTo_3.innerHTML = time_lable;

                            var time_lable_2 = '<label class="fs-6 fw-semibold mb-2">You can select multiple time slot</label>';
                            var objTo_4 = document.getElementById('ev_event_time_label_2')
                            objTo_4.innerHTML = time_lable_2;
                            
                            var time_lable_3 = '<label class="fs-6 fw-semibold mb-2">Following selected times suggest to candidate</label>';
                            var objTo_5 = document.getElementById('ev_event_time_label_3')
                            objTo_5.innerHTML = time_lable_3;
                            
                            var time_lable_4 = '';
                            var objTo_6 = document.getElementById('ev_event_time_schedule_new_input')
                            objTo_6.innerHTML = time_lable_4;


                        }else{
                            show_toastr('error', 'Please try again!','');
                            
                            var date_html = '';
                            var time_html = '';
                            var time_lable = '';
                            var time_lable_2 = '';
                            var time_lable_3 = '';

                            var objTo = document.getElementById('ev_event_date_schedule')
                            objTo.innerHTML = date_html;
                            var objTo_2 = document.getElementById('ev_event_time_schedule')
                            objTo_2.innerHTML = time_html;
                            var objTo_3 = document.getElementById('ev_event_time_label')
                            objTo_3.innerHTML = time_lable;
                            var objTo_4 = document.getElementById('ev_event_time_label_2')
                            objTo_4.innerHTML = time_lable_2;
                            var objTo_5 = document.getElementById('ev_event_time_label_3')
                            objTo_5.innerHTML = time_lable_3;
                        }
                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                        }, 1000);
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        show_toastr('error', 'Please try again!','');
                        $.LoadingOverlay("hide");
                        var date_html = '';
                        var time_html = '';

                        var objTo = document.getElementById('ev_event_date_schedule')
                        objTo.innerHTML = date_html;
                        var objTo_2 = document.getElementById('ev_event_time_schedule')
                        objTo_2.innerHTML = time_html;
                    }
                });
            }
            
        }

        function stringReplace(index) {
            // Just remove commas and periods - regex can do any chars
            index = index.replace(/([-])+/g, '_');
            return index;
        }
        
        function addDateTimeDisplay(getid,getdate,getday,getdidate,getstarttime,getendtime,removeid) {
            var html = '';
            html += '<div class="remove_time_slot_input_main" id="'+removeid+'">';
            html += '<div class="form-check mb-0 d-flex align-items-center p-0 gap-2">';
            html += '<label class="selector-item_label line-height-1 m-0">'+getday+' '+getdidate+' '+getstarttime+' To '+getendtime+'</label>';
            html += '<button class="remove_time_slot_input line-height-1" type="button" data-date="'+getdate+'" data-start-time="'+getstarttime+'" data-end-time="'+getendtime+'" type="checkbox" data-id="'+getid+'" data-remove-id="'+removeid+'"><i class="fas fa-trash p-0 m-0"></i></button>';
            html += '</div>';
            html += '</div>';
            $('#ev_event_time_schedule_new_input').append(html);
        }
        
        function removeDateTimeDisplay(removeid) {
            $('#'+removeid).remove();
        }

        function removeCheckedDateTimeDisplay(getid,removeid) {
            $('#'+removeid).remove();
            $("#"+getid).prop("checked", false);
        }

    </script>
@stop
