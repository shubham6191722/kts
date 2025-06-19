@extends('admin.layouts.common')

@section('title', 'Applications')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
<link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
<link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <input type="hidden" id="user_id" value="{!! Auth::user()->id !!}">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Applications</h5>
                </div>
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <a href="{{route('candidate.archiveData')}}" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000"/>
                                    <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                        Past Applications
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row" id="candidate_application_data">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sticky modal-sticky-bottom-right" id="kt_chat_modal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-custom">
                    <div class="card-header align-items-center px-4 py-3">
                        <div class="text-start flex-grow-1">
                            <div class="text-dark-75 font-weight-bold font-size-h5" id="chat_user_name">Matt Pears</div>
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

@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/promise-polyfill.js"></script>
    <script src="{!!url('assets/backend')!!}/js/scrollspyNav.js"></script>

    <script>
        $(function () {
            
            "use strict";

            $('body').on('click', '.archive-btn-click', function() {
                var data_id = $(this).attr('data-id');
                archiveCandidate(data_id);
            });

            var user_id = $('#user_id').val();
            applicationData(user_id);

        });

        function applicationData(user_id) {

            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('candidate.applicationData')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: user_id,
                    _token: csrf_token,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },
                success: function (data) {
                    if (data.code == 1) {
                        if(data.page){
                            $('#candidate_application_data').html(data.page);
                        }else{
                            $('#candidate_application_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');
                        }
                        
                    } else {

                        $('#candidate_application_data').html('<h4 class="text-center" style="width: 100%;">No Data found</h4>');

                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 200);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    show_toastr('error', 'Please try again!','');
                }
            });

        }
        function archiveCandidate(data_id) {
            
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: "{{route('candidate.archiveCandidate')}}",
                type: 'POST',
                data: {
                    "id": data_id,
                    "_token": token,
                },
                beforeSend: function () {
                    $.LoadingOverlay("show");
                },success: function (data){

                    if (data.code == 1) {
                        show_toastr('success',data.msg);
                        var user_id = $('#user_id').val();
                        applicationData(user_id);
                    } else {
                        show_toastr('error', 'Please try again!','');
                        var user_id = $('#user_id').val();
                        applicationData(user_id);
                    }
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 200);
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

            function sendChat(chat_message,chat_job_id,chat_client_id,chat_candidate_id,chat_applied_id,chat_created_id,chat_r_c_id,chat_message_id) {

                var csrf_token = $('meta[name="csrf-token"]').attr('content');

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
                        _token: csrf_token,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            $('#chat_message_id').val(data.message_id);
                            $("#user_message_data").append(data.message);
                            $("#chat_message").val('');
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        // show_toastr('error', 'Please try again!','');
                    }
                });

            }
        });
    </script>

@stop 
