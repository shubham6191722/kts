<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">

            </div>
        </div>
        <div class="topbar">
            @if(Auth::check())
                {{-- @if(Auth::user()->role != 1) --}}
                    @php
                        $route_name = App\CustomFunction\CustomFunction::role_name();
                        $url = $route_name.".indexList";
                        $route = route($url);
                        $message_count = null;
                        if(Auth::user()->role == 2){
                            $message_count = App\Models\MessageCount::getClientAllCountDisplay(Auth::user()->id);
                        }elseif(Auth::user()->role == 3){
                            $user_created_user = Auth::user()->created_user_id;
                            $user_id = Auth::user()->id;
                            $chat_data = App\Models\MessageCount::getStaffAllCountDisplay($user_created_user);
                            $staff_chat_data = App\Models\MessageCount::getStaffCountDisplay($user_created_user,$user_id);
                            $message_count = $staff_chat_data + $chat_data;
                        }elseif(Auth::user()->role == 4){
                            $message_count = App\Models\MessageCount::getRecruiterCountDisplay(Auth::user()->id);
                        }elseif(Auth::user()->role == 5){
                            $message_count = App\Models\MessageCount::getCandidateCountDisplay(Auth::user()->id);
                        }
                    @endphp
                    <div class="topbar-item">
                        <a href="{!! $route !!}">
                            <div id="count_message_main" class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 position-relative @if(isset($notification_count) && !empty($notification_count)) pulse pulse-primary @endif">
                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                    <i class="flaticon-chat text-info icon-lg"></i>
                                </span>
                                <span class="pulse-ring"></span>
                                <div class="notification-count" id="count_message_main_dispaly" style="display: none;">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <span class="d-flex justify-content-center align-items-center" id="count_message_dispaly">{{$message_count}}</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                {{-- @endif --}}
            @endif
            @if(Auth::check())
                {{-- @if(Auth::user()->role != 4) --}}
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
                    <div class="topbar-item" id="kt_quick_panel_toggle">
                        <div id="count_notification_main" class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 position-relative @if(isset($notification_count) && !empty($notification_count)) pulse pulse-primary @endif">
                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                <i class="flaticon-bell text-success icon-lg"></i>
                            </span>
                            <span class="pulse-ring"></span>
                            @if(isset($notification_count) && !empty($notification_count))
                                <div class="notification-count" id="count_notification_main_dispaly">
                                    <span class="d-flex justify-content-center align-items-center">
                                        <span class="d-flex justify-content-center align-items-center" id="count_notification_dispaly">{{$notification_count}}</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                {{-- @endif --}}
            @endif
            @if(Auth::check())
                @if(Auth::user()->role == 2)
                    @php
                        $u_id = Auth::user()->id;
                        if(Auth::user()->role == 2){
                            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                $u_id = Auth::user()->created_user_id;
                            }else{
                                $u_id = Auth::user()->id;
                            }
                        }
                        $user_data = App\Models\User::find($u_id);
                        $company_credits = $user_data->company_credits;
                        $client_slug = $user_data->client_slug;
                    @endphp
                    <div class="topbar-item">
                        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                            <span class="symbol custom-symbol symbol-light-warning">
                                <span class="symbol-label font-size-h5 font-weight-bold">Credit left: {!! $company_credits !!}
                                    <span class="pulse-ring"></span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon btn-light-warning btn-hover-primary mr-1 client-copy-link" data-link="{{route('home.getClientJobDetail',['id' => $client_slug])}}">
                            <span class="svg-icon svg-icon-xl svg-icon-primary">
                                <i class="fas fa-link"></i>
                            </span>
                        </div>
                    </div>
                @endif
            @endif
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{!!ucfirst(Auth::user()->name)!!}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">{!!strtoupper(substr(Auth::user()->email,0,1))!!}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>