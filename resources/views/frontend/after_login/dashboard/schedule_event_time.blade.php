@extends('admin.layouts.common')

@php
  $job_full_name = 'Interview Schedule';
@endphp

@section('title', $job_full_name)

@section('headerScripts')
@stop

@section('content')
    @php
        $route_name = App\CustomFunction\CustomFunction::role_name();
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">

                <div class="card card-custom border-radius-none box-shadow-none ">
                    <div class="card-header card-header-tabs-line nav-tabs-line-3x border-none d-block m-height-100 position-relative">
                        <div class="card-toolbar d-block applictio-name mb-5 mt-5">
                            <div class="d-lg-flex d-md-flex d-sm-block justify-content-space-between">
                                <div>
                                    @php
                                        $vacancy = App\Models\JobVacancy::jobName($event_data->vacancy_id);
                                    @endphp
                                    <span>
                                        {!! $vacancy !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom border-radius-none box-shadow-none ">
                    <div class="card-body">
                        <div class="tab-content event-applied-content row" id="job_event_data">
                            <div class="job_event_data_content col-md-12 col-sm-12 d-block">
                                <div class="d-flex justify-content-space-between align-items-center mb-5 p-5 even">
                                    <div class="d-flex justify-content-space-between align-items-center w-100">
                                        <div class="w-100">
                                            <div class="d-flex align-items-center row row-gap-10">
                                                @if(isset($event_data->event_type) && !empty($event_data->event_type))
                                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                @if($event_data->event_type == 'Phone screen')
                                                                    <i class="font-20 fas fa-phone-volume text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                @else
                                                                    <i class="icon-xl socicon-googlegroups text-info" data-toggle="tooltip" data-theme="dark" title="Type"></i>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex flex-column font-weight-bold">
                                                                <p class="text-dark line-height-sm font-size-lg m-0">{!! $event_data->event_type !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($event_data->event_staff_select) && !empty($event_data->event_staff_select))
                                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                <i class="font-20 fas fa-user text-info" data-toggle="tooltip" data-theme="dark" title="Staff"></i>
                                                            </div>
                                                            <div class="d-flex flex-column font-weight-bold">
                                                                @php
                                                                    $staff = '';
                                                                    $event_staff_data = explode(",",$event_data->event_staff_select);
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

                                                @if(isset($event_data->client_id) && !empty($event_data->client_id))
                                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                        @php
                                                            $clientData = App\Models\User::clientData($event_data->client_id);
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
                                                
                                                @if(isset($event_data->interview_type) && !empty($event_data->interview_type))
                                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                @if($event_data->interview_type == 'Face to face interview')
                                                                    <i class="icon-xl fas fa-people-arrows text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Face to face interview"></i>
                                                                @else
                                                                    <i class="icon-xl fas fa-video text-info" data-toggle="tooltip" data-theme="dark" data-original-title="Video interview"></i>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex flex-column font-weight-bold">
                                                                <p class="text-dark line-height-sm font-size-lg m-0">{!! $event_data->interview_type !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($event_data->interview_type == 'Face to face interview')
                                                    @if(isset($event_data->address_select) && !empty($event_data->address_select))
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="d-flex align-items-center column-gap-10 w-100">
                                                                <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                    <i class="font-20 fas fa-address-book text-info" data-toggle="tooltip" data-theme="dark" title="Site Address"></i>
                                                                </div>
                                                                <div class="d-flex flex-column font-weight-bold">
                                                                    <p class="text-dark line-height-sm font-size-lg m-0">{!! App\Models\SiteAddress::addressGet($event_data->address_select) !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if(isset($event_data->video_link) && !empty($event_data->video_link))
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="d-flex align-items-center column-gap-10 w-100">
                                                                <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                    <i class="font-20 fas fa-link text-info" data-toggle="tooltip" data-theme="dark" title="Video Link"></i>
                                                                </div>
                                                                <div class="d-flex flex-column font-weight-bold">
                                                                    <p class="text-dark line-height-sm font-size-lg m-0">{!! $event_data->video_link !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if(isset($event_data->event_description) && !empty($event_data->event_description))
                                                    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="d-flex align-items-center column-gap-10 w-100">
                                                            <div class="d-flex flex-column font-weight-bold width-20 height-20">
                                                                <i class="font-20 flaticon-file-2 text-info" data-toggle="tooltip" data-theme="dark" title="Description"></i>
                                                            </div>
                                                            <div class="d-flex flex-column font-weight-bold">
                                                                <div class="text-dark line-height-sm font-size-lg m-0">{!! $event_data->event_description !!}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                        
                                            </div>
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom border-none border-radius-none box-shadow-none">
                    <div class="card-body pt-0">

                        <div class="tab-pane" id="booking_date_time" role="1">
                            <div class="row">
                                <div class="col-md-8 col-sm-12 mt-5 h-100">
                                    <div id="demo_booking_multiple" class="h-100"> </div>
                                    <div class="time-available-unavailable d-flex justify-content-center align-items-center gap-10">
                                        <div class="tz-time-available d-flex pt-5 align-items-center gap-5">
                                            <span class="tz-time-round available-round">

                                            </span>
                                            <span class="time-available-unavailable-text">Available</span>
                                        </div>
                                        <div class="tz-time-unavailable d-flex pt-5 align-items-center gap-5">
                                            <span class="tz-time-round unavailable-round"></span>
                                            <span class="time-available-unavailable-text">Unavailable</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 mt-5 h-100">
                                    <div id="timePicker">
                                        <div class="maintimePicker">
                                            <ul class="widgets-time-slots" id="widgets_time_slots"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        @php
                            $url_save = $route_name.".saveScheduleEventTime";
                            $route_save = route($url_save);
                        @endphp
                            <form class="form d-none" id="kt_form_2" method="POST" action="{{ $route_save }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{!! $event_data->id !!}" />
                                <input type="hidden" name="event_status" value="1" />
                                <input type="hidden" name="event_date" id="event_date" value="@if(isset($current_date) && !empty($current_date)){!! $current_date !!}@endif"/>
                                <input type="hidden" name="event_time" id="event_time" value=""/>
                                <input type="hidden" name="event_end_time" id="event_end_time" value=""/>
                                <input type="hidden" name="schedule_type" id="schedule_type" value="@if(isset($schedule_type) && !empty($schedule_type)){!! $schedule_type !!}@endif"/>
                                <button type="submit" class="btn btn-light-primary font-weight-bold mr-2" id="schedule_subimt">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait... 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </form>
                            <button type="button" class="btn btn-light-primary font-weight-bold mr-2" id="schedule_subimt_click">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        @php
                            $url = $route_name.".dashboard";
                            $route = route($url);
                        @endphp
                        <a href="{!! $route !!}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="date_value_disabled" style="display: none;visibility: hidden">{!! $date_disabled_value !!}</div>
    <div id="time_value_available" style="display: none;visibility: hidden">{!! $time_value !!}</div>
    <input id="current_date" type="hidden" value="@if(isset($current_date) && !empty($current_date)){!! $current_date !!}@endif">
    <input id="end_date" type="hidden" value="@if(isset($end_date) && !empty($end_date)){!! $end_date !!}@endif">

@stop

@section('footerScripts')
<script>
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var active_date = $('#current_date').val();
    check_date(active_date);

    var KTSelect2 = function() {

        var date_value_disabled = $('#date_value_disabled').text();
        var current_date = $('#current_date').val();
        var end_date = $('#end_date').val();
        var json_obj = jQuery.parseJSON(date_value_disabled);

        var demos = function() {
            $('#demo_booking_multiple').datepicker({
                rtl: KTUtil.isRTL(),
                autoclose: true,
                startDate: new Date(current_date),
                daysOfWeekDisabled: [0, 6],
                datesDisabled: json_obj,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
                endDate:new Date(end_date),
            }).on('changeDate', function(e) {  
                var select_data = e.format();
                $('#event_date').val(select_data);
                check_date(select_data);
            });
        }

        return {
            init: function() {
                demos();
            }
        };
    }();

    $(function () {
        KTSelect2.init();

        $('body').on('click', '.widgets-time-slot', function() {
            $('.widgets-time-slot').removeClass('active');
            var event_start_time = $(this).attr('data-start');
            var end_time = $(this).attr('data-end');
            $('#event_time').val(event_start_time);
            $('#event_end_time').val(end_time);
            $(this).addClass('active');
        });

        $('body').on('click', '#schedule_subimt_click', function() {
            var event_date = $('#event_date').val();
            var event_time = $('#event_time').val();

            var error_check = 'no null';
            
            if(event_date == ''){
                show_toastr("error", 'Date is required!', "");
                error_check = 'null';
            }

            if(event_time == ''){
                show_toastr("error", 'Time is required!', "");
                error_check = 'null';
            }
            if((error_check != 'null') ){
                $("#schedule_subimt").click();
                $('#schedule_subimt_click').attr("data-kt-indicator","on");
                $('#schedule_subimt_click').prop('disabled', true);
            }else{
                $('#schedule_subimt_click').removeAttr("data-kt-indicator");
                $('#schedule_subimt_click').prop('disabled', false);
            }
        });
        
    });

    window.onload = function(){
        var dates = $('#current_date').val();
        setTimeout(function () {
            var find_class = $('#demo_booking_multiple').find('.datepicker-inline').find('[data-date="'+toTimestamp(dates)+'"]').addClass('active');
        }, 1000);
    };

    function check_date(select_data) {
        var time_value_available = $('#time_value_available').text();
        var time_json_obj = jQuery.parseJSON(time_value_available);

        var time_get = time_json_obj[select_data];

        html = '';

        if($.isEmptyObject(time_get)) {
            html += '<div class="form-check mb-0 d-flex align-items-center p-0 gap-2 justify-content-center h-100">';
            html += '<div> No time slots available';
            html += '</div>';
            html += '</div>';
        }else {
            $.each(time_get, function (k,v) {
                var star_time = formatAMPM(v.start_time);
                var end_time = formatAMPM(v.end_time);
                var time_get_v = star_time +' To '+end_time;
                html += '<li class="widgets-time-slot" data-start="'+v.start_time+'" data-end="'+v.end_time+'"><span>'+time_get_v+'</span></li>';
            });
        }

        var objTo = document.getElementById('widgets_time_slots')
        objTo.innerHTML = html;
        $('#event_time').val('');
        $('#event_end_time').val('');
    }

    function formatAMPM(time) {
        var timeArr = time.split(':');
        var hours = timeArr[0];
        var minutes = timeArr[1];
        var ampm = hours >= 12 ? 'PM' : 'AM';

        var endhours = hours;
        var iNum = parseInt(endhours);
        endhours = iNum + 1;
        var endampm = endhours >= 12 ? 'PM' : 'AM';
        endhours = endhours % 12;
        
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? ''+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;

        endhours = endhours ? endhours : 12;
        var endTime = endhours + ':' + minutes + ' ' + endampm;

        // var string =  strTime + ' To ' + endTime;
        var string =  strTime;
        return string;
    }

    function toTimestamp(strDate){
        var datum = Date.parse(strDate);
        return datum;
    }
</script>

@stop
