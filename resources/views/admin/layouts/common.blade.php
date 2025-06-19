<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title') | {!!site_title!!}</title>

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <link rel="shortcut icon" href="{!!site_favicon!!}"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <link href="{{url('assets/backend')}}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/header/base/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('assets/backend')}}/css/custom.css" rel="stylesheet" type="text/css"/>



        @yield('headerScripts')
    </head>
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
            <a href="{{route('home.index')}}">
                <img alt="{{site_title}}" src="{{site_header_logo}}" class="img-fluid custom-logo-img" />
            </a>
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path
                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                            fill="#000000" fill-rule="nonzero"/>
                        </g>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">

                @include('admin.layouts.sidebar')

                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    @include('admin.layouts.header')

                    @yield('content')
                    @include('admin.layouts.footer')

                </div>
            </div>
        </div>
        @include('admin.layouts.user_panel')


        <div id="kt_scrolltop" class="scrolltop"><i class="flaticon2-arrow-up"></i></div>

        <script>
            var KTAppSettings = {
                "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400},
                "colors": {
                    "theme": {
                        "base": {"white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32"},
                        "light": {"white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0"},
                        "inverse": {"white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff"}
                    }, "gray": {"gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32"}
                },
                "font-family": "Poppins"
            };
        </script>
        <script src="{{url('assets/backend')}}/plugins/global/plugins.bundle.js" ></script>
        <script src="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.js" defer="defer"></script>
        <script src="{{url('assets/backend')}}/js/scripts.bundle.js"></script>
        <script src="{{url('assets/backend')}}/plugins/custom/fullcalendar/fullcalendar.bundle.js" defer="defer"></script>
        <script src="{{url('assets/backend')}}/js/pages/widgets.js" defer="defer"></script>
        <script src="{!!url('assets/backend')!!}/js/loadingoverlay.min.js"></script>
        <script src="{!!url('assets/backend')!!}/js/loadingoverlay_progress.min.js"></script>
        <script src="{{url('assets/backend')}}/js/pages/features/miscellaneous/toastr.js" defer="defer"></script>
        <script src="{{url('assets/backend')}}/js/custom.js"></script>


        <script type="text/javascript">

            $(function () {
                $.LoadingOverlaySetup({
                    background      : "rgba(0, 0, 0, 0.5)",
                    image           : "{!!url('assets/backend')!!}/img/index.svg",
                    imageAnimation  : "1.5s fadeTo",
                });
            });

            function isNumber(evt, allow_float = 0) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && ((allow_float) ? (charCode < 46 || charCode > 57) : (charCode < 47 || charCode > 57))) {
                    return false;
                }
                return true;
            }
            $('body').on('submit', 'form.form', function() {
                $(this).find('.btn[type="submit"]').attr("data-kt-indicator","on");
            });

            $( ".client-copy-link" ).on( "click", function() {
                var temp = $("<input>");
                $("body").append(temp);
                temp.val($(this).attr('data-link')).select();
                document.execCommand("copy");
                temp.remove();
            });
            // $(function () {
            //     headerButtonClick($(window).width());
            //     $( window ).resize(function() {
            //         headerButtonClick($(window).width());
            //     });
            // });

            $(window).on('load', headerButtonClick($(window).width()));

            function headerButtonClick(window_width) {
                if(window_width <= '991'){
                    // setTimeout(function() {
                        // $('#kt_body').find('#kt_header_mobile_topbar_toggle').trigger("click");
                        var element = document.getElementById("kt_header_mobile_topbar_toggle");
                        element.classList.toggle("active");
                        var element1 = document.getElementById("kt_body");
                        element1.classList.toggle("topbar-mobile-on");
                        $("#kt_wrapper").css({"padding-top": "105px"});
                    // }, 1000);
                }
            }


        </script>

        <div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
			<div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
				<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_notifications">Notifications</a>
					</li>
				</ul>
				<div class="offcanvas-close mt-n1 pr-5">
					<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
						<i class="ki ki-close icon-xs text-muted"></i>
					</a>
				</div>
			</div>
			<div class="offcanvas-content px-10">
				<div class="tab-content">
					<div class="tab-pane fade show pt-2 pr-5 mr-n5 active" id="kt_quick_panel_notifications" role="tabpanel">
                        <div class="mb-3 text-right">
                            @php
                                $u_id = Auth::user()->id;
                                if(Auth::user()->role == 2){
                                    if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                        $u_id = Auth::user()->created_user_id;
                                    }else{
                                        $u_id = Auth::user()->id;
                                    }
                                }
                                $notification_count = App\Models\Notifications::getNotificationCount($u_id);
                            @endphp
                            <div class="font-weight-bolder font-size-sm cursor-pointer d-inline-block mark-all-read-status" data-id="{!! $u_id !!}">
                                Mark all as read
                            </div>
                        </div>
						<div class="navi navi-icon-circle navi-spacer-x-0" id="notification_read_data">
						</div>
					</div>
				</div>
			</div>
		</div>

        <script>
            $(function () {
                $('body').on('click', '.click-chage-status', function() {
                    var id = $(this).attr('data-id');
                    var action = $(this).attr('data-action');
                    var value = $(this).attr('data-value');
                    var url = $(this).attr('data-url');
                    changeNotoficationStatus(id,action,value,url);
                });

                $('body').on('click', '.mark-all-read-status', function() {
                    var id = $(this).attr('data-id');
                    markAllReadStatus(id);
                });

                $('body').on('click', '.click-notification-url', function() {
                    var url = $(this).attr('data-url');
                    setTimeout(function () {
                        window.location.replace(url);
                    }, 1000);
                });

                var timer;
                function startTimer() {
                    timer = setInterval(function() {
                        notificationDisplay();
                        messageCountDisplay();
                    }, 60000);
                }
                function notificationDisplay() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('comman.viewNotification')}}",
                        dataType: 'json',
                        type: 'post',
                        success: function (data) {
                            if (data.code == 1) {
                                $('#count_notification_dispaly').html(data.count);
                                $('body #kt_quick_panel #notification_read_data').html(data.notification);
                            }
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            // show_toastr('error', 'Please try again!','');
                        }
                    });
                }
                function messageCountDisplay() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('comman.viewMessage')}}",
                        dataType: 'json',
                        type: 'post',
                        success: function (data) {
                            if (data.code == 1) {
                                if(data.count > 0){
                                    $('#count_message_main').addClass('pulse pulse-primary');
                                    $('#count_message_dispaly').html(data.count);
                                    $('#count_message_main_dispaly').fadeIn();
                                }else{
                                    $('#count_message_main').removeClass('pulse pulse-primary');
                                    $('#count_message_main_dispaly').fadeOut();
                                }
                            }
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            // show_toastr('error', 'Please try again!','');
                        }
                    });
                }
                startTimer();
                notificationDisplay();
                messageCountDisplay();
            });

            function changeNotoficationStatus(id,action,value,url) {

                $.ajaxSetup({headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('comman.changeNotoficationStatus')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                        action: action,
                        value: value,
                        url: url,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            setTimeout(function () {
                                window.location.replace(url);
                            }, 1000);
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        show_toastr('error', 'Please try again!','');
                    }
                });

            }

            function markAllReadStatus(id) {

                $.ajaxSetup({headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('comman.markAllReadStatus')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        if (data.code == 1) {
                            setTimeout(function () {
                                $('#notification_read_data .notifi-custom').removeClass('click-chage-status');
                                $('#count_notification_dispaly').html(data.msg);
                                if(data.msg === 0){
                                    $('#count_notification_main_dispaly').css('display','none');
                                    $('#count_notification_main').removeClass('pulse pulse-primary');
                                }
                            }, 1000);
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        show_toastr('error', 'Please try again!','');
                    }
                });
            }
        </script>

        <script>
            $(function () {
                $('body').on('click', '.kt_chat_modal_open', function() {
                    var job_id = $(this).attr('data-job-id');
                    var client_id = $(this).attr('data-client-id');
                    var candidate_id = $(this).attr('data-candidate-id');
                    var applied_id = $(this).attr('data-applied-id');
                    var created_id = $(this).attr('data-created-id');
                    var r_c_id = $(this).attr('data-r-c-id');
                    var message_id = $(this).attr('data-message-id');
                    chatModal(job_id,client_id,candidate_id,applied_id,created_id,r_c_id,message_id);
                });
            });

            function chatModal(job_id,client_id,candidate_id,applied_id,created_id,r_c_id,message_id) {

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

                            setTimeout(function () {
                                var myModal = new bootstrap.Modal(document.getElementById("kt_chat_modal"));
                                myModal.show();
                                setTimeout(function () {
                                    var div_height = $('#user_message_data').height() + 100;
                                    $('#user_message_main').animate({
                                        scrollTop: div_height
                                    }, 100);
                                }, 1000);
                            }, 1000);

                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        // show_toastr('error', 'Please try again!','');
                    }
                });

            }
        </script>

        <script type="text/javascript">

            $(function () {

                @if(Session::get('info'))
                    show_toastr("info", "{{ Session::get('info') }}", "");
                    @php Session::forget('info'); @endphp
                @endif

                @if(Session::get('warning'))
                    show_toastr("warning", "{{ Session::get('warning') }}", "");
                    @php Session::forget('warning'); @endphp
                @endif

                @if(Session::get('success'))
                    show_toastr("success", "{{ Session::get('success') }}", "");
                    @php Session::forget('success'); @endphp
                @endif

                @if(Session::get('error'))
                    show_toastr("error", "{{ Session::get('error') }}", "");
                    @php Session::forget('error'); @endphp
                @endif

                @if($errors->any())
                    show_toastr("error", "{{$errors-> first()}}", "");
                @endif
            });

        </script>

        @yield('footerScripts')

        {{-- @if(Auth::check())
            <script>
                $(function () {
                    var timer_check;
                    var user_id = '{{Auth::user()->id}}';
                    function startTimerCheck() {
                        timer_check = setInterval(function() {
                            checkLogin(user_id);
                        }, 100000);
                    }
                    startTimerCheck();
                });
            </script>
        @endif

        <script>
            function checkLogin(id) {
                $.ajaxSetup({headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('comman.checkLoginStatus')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                    }
                });
            }
        </script> --}}

    </body>
</html>
