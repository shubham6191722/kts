@extends('admin.layouts.common')

@section('title', 'Message')

@section('headerScripts')

@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid main-div_content pt-4" id="kt_content">

        @if(Auth::user()->role == 2 || Auth::user()->role == 1)
            <div class="subheader py-2 py-lg-4 subheader-solid shadow-none bg-none" id="kt_subheader" style="z-index: 0;">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex justify-content-end align-items-center gap-10">
                                    @if(Auth::user()->role == 1)
                                        <label class="m-0 ">Select Client</label>
                                    @else
                                        <label class="m-0 ">Select Staff</label>
                                    @endif
                                    <div class="w-60">
                                        @php
                                            // if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                            //     $id = Auth::user()->created_user_id;
                                            // }else{
                                            //     $id = Auth::user()->id;
                                            // }
                                            $id = Auth::user()->id;
                                        @endphp
                                        <select class="form-control" id="staff_chat" data-client-id="{!! $id !!}" data-created-id="{!! Auth::user()->id !!}">
                                            <option value="" selected>Please Select</option>
                                            @if(isset($staffData) && !empty($staffData) && count($staffData))
                                                @foreach($staffData as $SKey => $staff_value)
                                                    {{-- @php
                                                        $message_id = $staff_value->message_id;
                                                        if(isset($message_id) && !empty($message_id)){
                                                            if(Auth::user()->id == $staff_value->message_client_id){
                                                                $message_id = $staff_value->message_id;
                                                            }else{
                                                                $message_id = '';
                                                            }
                                                        }
                                                    @endphp --}}
                                                    @php
                                                        $check_client_to_staff_message = App\Models\MessageCount::checkClientToStaffMessage($staff_value->id,Auth::user()->id);
                                                        $message_id = '';
                                                        if(isset($check_client_to_staff_message) && !empty($check_client_to_staff_message)){
                                                            $message_id = $check_client_to_staff_message->id;
                                                        }
                                                    @endphp
                                                    <option value="{!! $staff_value->id !!}" data-message-id="{{$message_id}}">{!! $staff_value->name !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex flex-column-fluid h-100">
            <div class="container h-100">
                <div class="h-100 row">
                    <div class="col-md-4" id="kt_chat_aside">
                        <div class="card card-custom h-100">
                            <div class="card-body message-box-body">
                                <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="svg-icon svg-icon-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control py-4 h-auto" placeholder="Search..." id="search" data-user_id="{{ Auth::user()->id }}" data-user_role="{{ Auth::user()->role }}">
                                </div>
                                <div class="mt-7 scroll scroll-pull w-100" id="user_side_message_data">
                                    @include('admin.chat.chat_side_bar')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 m-m-t-10" id="kt_chat_content">
                        <div class="card card-custom h-100">
                            <div class="card-header align-items-center px-4 py-3">
                                <div class="text-center flex-grow-1 w-100">
                                    <div class="text-dark-75 font-weight-bold font-size-h5" id="chat_user_name"></div>
                                </div>
                            </div>
                            <div class="card-body message-box-body" id="user_message_main">
                                <div class="scroll scroll-pull">
                                    <div class="messages" id="user_message_data">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer align-items-center">
                                <div class="chat_message_form" style="display: none;">
                                    <textarea class="form-control border-0 p-0" rows="2" placeholder="Type a message" id="chat_message"></textarea>
                                    <input type="hidden" id="chat_job_id" value="">
                                    <input type="hidden" id="chat_client_id" value="">
                                    <input type="hidden" id="chat_candidate_id" value="">
                                    <input type="hidden" id="chat_applied_id" value="">
                                    <input type="hidden" id="chat_created_id" value="">
                                    <input type="hidden" id="chat_r_c_id" value="">
                                    <input type="hidden" id="chat_message_id" value="">
                                    <input type="hidden" id="chat_staff_id" value="">
                                    <div class="d-flex align-items-center justify-content-end mt-5">
                                        <button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6" id="chat_submit">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="user_role" value="{{ Auth::user()->role }}">
@stop

@section('footerScripts')
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});
            }

            return {
                init: function() {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTSelect2.init();
        });
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
                var chat_staff_id = $('#chat_staff_id').val();
                sendChat(chat_message,chat_job_id,chat_client_id,chat_candidate_id,chat_applied_id,chat_created_id,chat_r_c_id,chat_message_id,chat_staff_id);
            });

            function sendChat(chat_message,chat_job_id,chat_client_id,chat_candidate_id,chat_applied_id,chat_created_id,chat_r_c_id,chat_message_id,chat_staff_id) {

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
                        staff_id: chat_staff_id,
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

            $(function () {
                $('body').on('click', '.chat_message_on_click', function() {
                    var job_id = $(this).attr('data-job-id');
                    var client_id = $(this).attr('data-client-id');
                    var candidate_id = $(this).attr('data-candidate-id');
                    var applied_id = $(this).attr('data-applied-id');
                    var created_id = $(this).attr('data-created-id');
                    var r_c_id = $(this).attr('data-r-c-id');
                    var message_id = $(this).attr('data-message-id');
                    $('.chat_message_form').fadeOut();
                    $('.chat_message_on_click').removeClass('active');
                    $(this).addClass('active');
                    CommanChatModal(job_id,client_id,candidate_id,applied_id,created_id,r_c_id,message_id);
                    $(this).find('.message-count').fadeOut();
                });

                $('body').on('change', '#staff_chat', function() {
                    var job_id = null;
                    var client_id = $(this).attr('data-client-id');
                    var candidate_id = $(this).val();
                    var applied_id = null;
                    var created_id = $(this).attr('data-created-id');
                    var r_c_id = null;
                    var message_id = $(this).find(':selected').attr('data-message-id');
                    var staff_id = $(this).val();

                    $('.chat_message_on_click').removeClass('active');
                    $('.message_id_'+message_id).addClass('active');
                    $('.chat_message_form').fadeOut();
                    $('#user_message_data').html('');
                    $('#chat_user_name').html('');
                    if(candidate_id != ''){
                        CommanChatModal(job_id,client_id,candidate_id,applied_id,created_id,r_c_id,message_id,staff_id);
                    }
                });
            });

            function CommanChatModal(job_id,client_id,candidate_id,applied_id,created_id,r_c_id,message_id,staff_id) {

                $.ajaxSetup({headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('comman.chatModal')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        job_id: job_id,
                        client_id: client_id,
                        candidate_id: candidate_id,
                        applied_id: applied_id,
                        created_id: created_id,
                        r_c_id: r_c_id,
                        message_id: message_id,
                        staff_id: staff_id,
                    },
                    success: function (data) {
                        $('#user_message_data').html();
                        if (data.code == 1) {
                            $('#user_message_data').html(data.page);
                            $('#chat_user_name').html(data.chatusername);
                            $('#chat_job_id').val(job_id);
                            $('#chat_client_id').val(client_id);
                            $('#chat_candidate_id').val(candidate_id);
                            $('#chat_applied_id').val(applied_id);
                            $('#chat_created_id').val(created_id);
                            $('#chat_r_c_id').val(r_c_id);
                            $('#chat_message_id').val(message_id);
                            $('#chat_staff_id').val(staff_id);
                            $('.chat_message_form').fadeIn();
                            setTimeout(function () {
                                var div_height = $('#user_message_data').height() + 100;
                                $('#user_message_main').animate({
                                    scrollTop: div_height
                                }, 100);
                                $('.offcanvas-mobile-overlay').trigger('click');
                            }, 500);
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        // show_toastr('error', 'Please try again!','');
                    }
                });

            }

            var user_id = $('#user_id').val();
            var user_role = $('#user_role').val();

            $('#search').on('keyup', function() {

                var token = $("meta[name='csrf-token']").attr("content");

                var search_value = $(this).val();

                var user_id = $(this).attr('data-user_id');
                var user_role = $(this).attr('data-user_role');

                liveSearch();
            });

            let cards = document.querySelectorAll('.chat_message_on_click');

            function liveSearch() {
                let search_query = document.getElementById("search").value;
                //Use innerText if all contents are visible
                //Use textContent for including hidden elements
                for (var i = 0; i < cards.length; i++) {
                    if(cards[i].textContent.toLowerCase()
                            .includes(search_query.toLowerCase())) {
                        cards[i].classList.remove("d-none");
                    } else {
                        cards[i].classList.add("d-none");
                    }
                }
            }
        });
    </script>
    <script>
        $(function () {
            var timer_chat;
            function startTimerChat() {
                timer_chat = setInterval(function() {
                    chatCountDisplay();
                }, 60000);
            }
            function chatCountDisplay() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var token = $("meta[name='csrf-token']").attr("content");

                var user_id = '';
                var user_role = '';
                var user_created_user = '';

                if({{Auth::user()->role}} == 1){
                    user_id = '{{Auth::user()->id}}';
                    user_role = '{{Auth::user()->role}}';
                }else if({{Auth::user()->role}} == 2){
                    user_id = '{{Auth::user()->id}}';
                    user_role = '{{Auth::user()->role}}';
                }else if({{Auth::user()->role}} == 3){
                    user_id = '{{Auth::user()->id}}';
                    user_role = '{{Auth::user()->role}}';
                    user_created_user = '{{Auth::user()->created_user_id}}';
                }else if({{Auth::user()->role}} == 4){
                    user_id = '{{Auth::user()->id}}';
                    user_role = '{{Auth::user()->role}}';
                }else if({{Auth::user()->role}} == 5){
                    user_id = '{{Auth::user()->id}}';
                    user_role = '{{Auth::user()->role}}';
                }

                $.ajax({
                    url: "{{route('comman.viewChatCount')}}",
                    type: 'post',
                    data: {
                        "user_id": user_id,
                        "user_role": user_role,
                        "user_created_user": user_created_user,
                        "_token": token,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            $.each(data.datacount, function( index, value ) {
                                var html_data = '';
                                var staff_id = value.staff_id;
                                if(user_role == '2'){
                                    var html_data = '';
                                    if(value.count != ''){
                                        html_data = '<div class="message-count"><span class="d-flex justify-content-center align-items-center"><span class="d-flex justify-content-center align-items-center dis-message-count">'+value.count+'</span></span></div>';
                                    }
                                    $('#chat_message_count_'+value.id).html(html_data);
                                }
                                if(user_role == '3'){
                                    var html_data = '';
                                    if(staff_id != null){
                                        if(value.u_count != '0'){
                                            html_data = '<div class="message-count"><span class="d-flex justify-content-center align-items-center"><span class="d-flex justify-content-center align-items-center dis-message-count">'+value.u_count+'</span></span></div>';
                                        }
                                    }else{
                                        if(value.count != '0'){
                                            html_data = '<div class="message-count"><span class="d-flex justify-content-center align-items-center"><span class="d-flex justify-content-center align-items-center dis-message-count">'+value.count+'</span></span></div>';
                                        }
                                    }
                                    $('#chat_message_count_'+value.id).html(html_data);
                                }
                                if(user_role == '4'){
                                    var html_data = '';
                                    if(value.u_count != '0'){
                                        html_data = '<div class="message-count"><span class="d-flex justify-content-center align-items-center"><span class="d-flex justify-content-center align-items-center dis-message-count">'+value.u_count+'</span></span></div>';
                                    }
                                    $('#chat_message_count_'+value.id).html(html_data);
                                }
                                if(user_role == '5'){
                                    var html_data = '';
                                    if(value.u_count != '0'){
                                        html_data = '<div class="message-count"><span class="d-flex justify-content-center align-items-center"><span class="d-flex justify-content-center align-items-center dis-message-count">'+value.u_count+'</span></span></div>';
                                    }
                                    $('#chat_message_count_'+value.id).html(html_data);
                                }
                            });
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        // show_toastr('error', 'Please try again!','');
                    }
                });
            }
            startTimerChat();
            chatCountDisplay();
        });
    </script>
@stop
