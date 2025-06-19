@extends('admin.layouts.common')

@section('title', 'Report List')

@section('headerScripts')
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
@stop

@section('content')
    @php
        $route_name = App\CustomFunction\CustomFunction::role_name();
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Report</h5>
                </div>
                <div class="d-flex align-items-center flex-wrap mr-2">
                    @if(Auth::check())
                        @if(Auth::user()->role == 1)
                            <select class="form-control" name="user_select" id="user_select">
                                @if(!empty($clientList))
                                    @foreach($clientList as $TKey => $c_value)
                                        <option value="{!! $c_value->id !!}" @if($TKey == 0) selected="selected" @endif>@if(isset($c_value->name) && !empty($c_value->name)){!! $c_value->name !!}@endif @if(isset($c_value->company_name) && !empty($c_value->company_name)) ({!! $c_value->company_name !!}) @endif</option>
                                    @endforeach
                                @endif
                            </select>
                        @else
                            @if(Auth::user()->role == 2)
                                @php
                                    if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                                        $id = Auth::user()->created_user_id;
                                    }else{
                                        $id = Auth::user()->id;
                                    }
                                @endphp
                                <input type="hidden" id="user_select" value="{!! $id !!}">
                                <input type="hidden" id="client_id" value="">
                            @else
                                <input type="hidden" id="user_select" value="{!! Auth::user()->id !!}">
                                <input type="hidden" id="client_id" value="@if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){!! Auth::user()->created_user_id !!}@endif">
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom gutter-b card-stretch pt-8 pb-8">
                        <div class="container">
                            <div class="row justify-content-center m-576-gap-5">
                                <div class="col-xl-5 col-lg-7 col-md-10 col-sm-12 col-12">
                                    <div class="d-flex gap-5">
                                        <div class='input-group' id='kt_report_1'>
                                            <input type='text' class="form-control" readonly  placeholder="Select date range" id="report_to_date" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-5">
                                            <button type="submit" id="report_submit" class="btn btn-primary full-width">Search</button>
                                            <button type="reset" id="report_reset" class="btn btn-primary full-width">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card card-custom  card-stretch  gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Job Advertisement Source Chart</h3>
                            </div>
                        </div>
                        <div class="card-body min-height-350">
                            <div id="job_advertisement_source" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card card-custom  card-stretch  gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Work Base Preference</h3>
                            </div>
                        </div>
                        <div class="card-body min-height-350">
                            <div id="work_base_preference" class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-custom  card-stretch  gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Time to Hire</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <select class="form-control" name="job_vacancy" id="job_vacancy">
                                        <option value="all" selected="selected">All Jobs</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <select class="form-control" name="job_category" id="job_category">
                                        <option value="all" selected="selected">All Category</option>
                                        @if(!empty($job_category))
                                            @foreach($job_category as $job_categoryKey => $job_category_value)
                                                <option value="{!! $job_category_value->category_id !!}">{!!$job_category_value->category !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="d-flex gap-5">
                                        <div class='input-group' id='kt_report_2'>
                                            <input type='text' class="form-control" readonly  placeholder="Select date range" id="report_to_date_2" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-5">
                                            <button type="submit" id="report_submit_2" class="btn btn-primary full-width">Search</button>
                                            <button type="reset" id="report_reset_2" class="btn btn-primary full-width">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer m-t-30">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid m-b-15">
        <div class="container">
            <div  class="row justify-content-end">
                <div class="col-md-3">
                    <input type="hidden" id="print_url" value="{{route($route_name.'.reportPrintAction')}}">
                    <a id="print_2" href="" target="_blank" class="btn btn-primary full-width float-right d-none" >Print</a>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="print_url" value="{{route($route_name.'.reportPrintAction')}}">

    <div class="d-flex flex-column-fluid" id="divToPrint">
        <div class="container h-100">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="row">

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_live_vacancies" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-wave-square icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="live_vacancies">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Live vacancies</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_live_interviews" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-user-tie icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="live_interviews">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Live interviews</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_offers_pending" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-pound-sign icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="offers_pending">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Offers pending</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_jobs_filled" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-fill-drip icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_filled">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs filled</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_candidates_waiting" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-user-clock icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="candidates_waiting">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Candidates due to start</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_jobs_on_hold" href="#" target="_blank">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="far fa-clipboard icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_on_hold">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs on hold</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_jobs_cancelled" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-ban icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="jobs_cancelled">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Jobs cancelled</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-0">
                                <a id="a_candidates_left" href="#">
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <span class="symbol symbol-50 symbol-light-primary mr-2">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-xl svg-icon-primary">
                                                    <i class="fas fa-users-slash icon-lg text-primary"></i>
                                                </span>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column text-right">
                                            <span class="text-dark-75 font-weight-bolder font-size-h3" id="candidates_left">0</span>
                                            <span class="text-muted font-weight-bold mt-2">Candidates exited within 1st 8 weeks</span>
                                        </div>
                                    </div>
                                </a>
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
    <script type="text/javascript">
        $(function () {

            "use strict";

            // predefined ranges
            var start = moment().subtract(29, 'days');
            var end = moment();

            $('#kt_report_1').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',

                startDate: start,
                endDate: end,
                opens: "center",
                drops: "auto",
                alwaysShowCalendars: true,
                autoUpdateInput: false,
                linkedCalendars: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, kt_report_1);

            function kt_report_1(start, end) {
                $('#kt_report_1 .form-control').val( start.format('DD-MM-YYYY') + ' To ' + end.format('DD-MM-YYYY'));
            }

            $('#kt_report_2').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',

                startDate: start,
                endDate: end,
                opens: "center",
                drops: "auto",
                alwaysShowCalendars: true,
                autoUpdateInput: false,
                linkedCalendars: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, kt_report_2);

            function kt_report_2(start, end) {
                $('#kt_report_2 .form-control').val( start.format('DD-MM-YYYY') + ' To ' + end.format('DD-MM-YYYY'));
            }

            var KTCalendarBasic = function () {

                return {
                    //main function to initiate the module
                    init: function () {
                        jobAdvertisementSource();
                        workBasePreference();
                    }
                };
            }();

            $('body').on('click', '#report_submit', function() {
                var u_id = $("#user_select").val();
                var c_id = null;
                var todate = $('#report_to_date').val();
                // var fromdate = $('#report_from_date').val();
                reportSelectAction(u_id,c_id,todate);
            });

            $('body').on('click', '#report_reset', function() {
                $('#report_to_date').val(null);
                var todate = null;
                if({{Auth::user()->role}} == 1){
                    var u_id = $("#user_select option:selected").val();
                    var c_id = null;
                }else{
                    var u_id = $("#user_select").val();
                    var c_id = $("#client_id").val();
                }
                reportSelectAction(u_id,c_id,todate);
                // location.reload();
            });

        });

        function jobAdvertisementSource(advertisement_option_name,advertisement_option_count,advertisement_option_color){

            $('#job_advertisement_source').html('');

            const apexChart = "#job_advertisement_source";

            var options = {
                series: advertisement_option_count,
                chart: {
                    height: 'auto',
                    type: 'donut',
                    width: '100%',
                },
                colors: advertisement_option_color,
                labels: advertisement_option_name
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }

        function workBasePreference(work_base_preference){

            $('#work_base_preference').html('');

            const apexChart = "#work_base_preference";

            var options = {
                series: work_base_preference,
                chart: {
                    height: 'auto',
                    type: 'pie',
                    width: '100%',
                },
                labels: ['Office', 'Remote', 'Hybrid'],
                colors: ['#33b2df', '#546E7A', '#d4526e']
            };

            var chart = new ApexCharts(document.querySelector(apexChart), options);
            chart.render();
        }

        $('#user_select').on('change', function(){
            var u_id = $(this).val();
            var c_id = null;
            var todate = $('#report_to_date').val();
            var client_id = $(this).val();
            var j_id = $("#job_vacancy option:selected").val();
            var j_c_id = $("#job_category option:selected").val();
            // var fromdate = $('#report_from_date').val();

            var print_btn = $('#print_url').val();

            var a_live_vacancies = print_btn+'/'+u_id+'?action=live_vacancies';
            $("#a_live_vacancies").attr("href", a_live_vacancies);

            var a_live_interviews = print_btn+'/'+u_id+'?action=live_interviews';
            $("#a_live_interviews").attr("href", a_live_interviews);

            var a_offers_pending = print_btn+'/'+u_id+'?action=offers_pending';
            $("#a_offers_pending").attr("href", a_offers_pending);

            var a_jobs_filled = print_btn+'/'+u_id+'?action=jobs_filled';
            $("#a_jobs_filled").attr("href", a_jobs_filled);

            var a_candidates_waiting = print_btn+'/'+u_id+'?action=candidates_waiting';
            $("#a_candidates_waiting").attr("href", a_candidates_waiting);

            var a_jobs_on_hold = print_btn+'/'+u_id+'?action=jobs_on_hold';
            $("#a_jobs_on_hold").attr("href", a_jobs_on_hold);

            var a_jobs_cancelled = print_btn+'/'+u_id+'?action=jobs_cancelled';
            $("#a_jobs_cancelled").attr("href", a_jobs_cancelled);

            var a_candidates_left = print_btn+'/'+u_id+'?action=candidates_left';
            $("#a_candidates_left").attr("href", a_candidates_left);

            var full_url = print_btn+'/'+u_id;

            $("#print_2").attr("href", full_url);

            reportSelectAction(u_id,c_id,todate);
            timeToHire(client_id);
            reportTimeToHireAction(u_id,todate,j_id,j_c_id);


        });

        if({{Auth::user()->role}} == 1){
            var u_id = $("#user_select option:selected").val();
            var c_id = null;
            var client_id = $("#user_select option:selected").val();
            var todate = $('#report_to_date').val();
            // var fromdate = $('#report_from_date').val();

            var print_btn = $('#print_url').val();

            var a_live_vacancies = print_btn+'/'+u_id+'?action=live_vacancies';
            $("#a_live_vacancies").attr("href", a_live_vacancies);

            var a_live_interviews = print_btn+'/'+u_id+'?action=live_interviews';
            $("#a_live_interviews").attr("href", a_live_interviews);

            var a_offers_pending = print_btn+'/'+u_id+'?action=offers_pending';
            $("#a_offers_pending").attr("href", a_offers_pending);

            var a_jobs_filled = print_btn+'/'+u_id+'?action=jobs_filled';
            $("#a_jobs_filled").attr("href", a_jobs_filled);

            var a_candidates_waiting = print_btn+'/'+u_id+'?action=candidates_waiting';
            $("#a_candidates_waiting").attr("href", a_candidates_waiting);

            var a_jobs_on_hold = print_btn+'/'+u_id+'?action=jobs_on_hold';
            $("#a_jobs_on_hold").attr("href", a_jobs_on_hold);

            var a_jobs_cancelled = print_btn+'/'+u_id+'?action=jobs_cancelled';
            $("#a_jobs_cancelled").attr("href", a_jobs_cancelled);

            var a_candidates_left = print_btn+'/'+u_id+'?action=candidates_left';
            $("#a_candidates_left").attr("href", a_candidates_left);

            var full_url = print_btn+'/'+u_id;

            $("#print_2").attr("href", full_url);

        }else{
            var u_id = $("#user_select").val();
            var c_id = $("#client_id").val();
            var todate = $('#report_to_date').val();
            var client_id = $("#user_select").val();
            // var fromdate = $('#report_from_date').val();

            var print_btn = $('#print_url').val();

            var a_live_vacancies = print_btn+'/'+u_id+'?action=live_vacancies';
            $("#a_live_vacancies").attr("href", a_live_vacancies);

            var a_live_interviews = print_btn+'/'+u_id+'?action=live_interviews';
            $("#a_live_interviews").attr("href", a_live_interviews);

            var a_offers_pending = print_btn+'/'+u_id+'?action=offers_pending';
            $("#a_offers_pending").attr("href", a_offers_pending);

            var a_jobs_filled = print_btn+'/'+u_id+'?action=jobs_filled';
            $("#a_jobs_filled").attr("href", a_jobs_filled);

            var a_candidates_waiting = print_btn+'/'+u_id+'?action=candidates_waiting';
            $("#a_candidates_waiting").attr("href", a_candidates_waiting);

            var a_jobs_on_hold = print_btn+'/'+u_id+'?action=jobs_on_hold';
            $("#a_jobs_on_hold").attr("href", a_jobs_on_hold);

            var a_jobs_cancelled = print_btn+'/'+u_id+'?action=jobs_cancelled';
            $("#a_jobs_cancelled").attr("href", a_jobs_cancelled);

            var a_candidates_left = print_btn+'/'+u_id+'?action=candidates_left';
            $("#a_candidates_left").attr("href", a_candidates_left);

            var full_url = print_btn+'/'+u_id;

            $("#print_2").attr("href", full_url);
        }

        reportSelectAction(u_id,c_id,todate);
        timeToHire(client_id);

        function reportSelectAction(u_id,c_id,todate) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.reportDataGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    u_id: u_id,
                    c_id: c_id,
                    todate: todate,
                    // fromdate: fromdate,
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                    $('#live_vacancies').html(0);
                    $('#jobs_filled').html(0);
                    $('#jobs_on_hold').html(0);
                    $('#offers_pending').html(0);
                    $('#live_interviews').html(0);
                    $('#candidates_waiting').html(0);
                    $('#candidates_left').html(0);
                },
                success: function(data) {

                    if (data.code == 1) {
                        setTimeout(function () {
                            workBasePreference(data.work_base_preference);
                            jobAdvertisementSource(data.advertisement_option_name,data.advertisement_option_count,data.advertisement_option_color);

                            $('#live_vacancies').html(data.live_vacancies);
                            $('#jobs_filled').html(data.jobs_filled);
                            $('#jobs_on_hold').html(data.jobs_on_hold);
                            $('#offers_pending').html(data.offers_pending);
                            $('#live_interviews').html(data.live_interviews);
                            $('#candidates_waiting').html(data.candidates_waiting);
                            $('#candidates_left').html(data.candidates_left);

                        }, 1000);

                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                        }, 1500);

                    } else {
                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                            $('#template_select').val('');
                        }, 1000);
                    }

                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                        $('#template_select').val('');
                    }, 1000);
                }
            });
        }

        function timeToHire(client_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.timeToHire')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    client_id: client_id,
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                    $('#job_vacancy').html('');
                },
                success: function(data) {

                    if (data.code == 1) {

                        var html = '<option label="All Jobs" value="all" selected>All Jobs</option>';
                        $(data.job_vacancy).each(function(index,item) {
                            html += '<option value="' + item.id +'" >' +item.jobtitle +'</option>';
                        });
                        $('#job_vacancy').append(html)

                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                        }, 1500);

                    } else {
                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                        }, 1000);
                    }

                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                    }, 1000);
                }
            });
        }

        $(function () {

            "use strict";

            $('body').on('click', '#report_submit_2', function() {
                var u_id = $("#user_select").val();
                var todate = $('#report_to_date_2').val();
                var j_id = $("#job_vacancy option:selected").val();
                var j_c_id = $("#job_category option:selected").val();
                reportTimeToHireAction(u_id,todate,j_id,j_c_id);
            });

            $('body').on('click', '#report_reset_2', function() {
                if({{Auth::user()->role}} == 1){
                    setTimeout(function () {
                        $('#report_to_date_2').val(null);
                        $('#job_vacancy').prop('selectedIndex',0);
                        $('#job_category').prop('selectedIndex',0);

                        var u_id = $("#user_select option:selected").val();
                        var todate = $('#report_to_date_2').val();
                        var j_id = 'all';
                        var j_c_id = 'all';
                        reportTimeToHireAction(u_id,todate,j_id,j_c_id);
                    }, 1000);

                }else{
                    setTimeout(function () {
                        var u_id = $("#user_select").val();
                        var todate = $('#report_to_date_2').val();
                        var j_id = $("#job_vacancy option:selected").val();
                        var j_c_id = $("#job_category option:selected").val();
                        reportTimeToHireAction(u_id,todate,j_id,j_c_id);
                    }, 1000);
                }
                // $('#report_to_date_2').val(null);
                // $('#job_vacancy').prop('selectedIndex',0);
                // $('#job_category').prop('selectedIndex',0);

                // var u_id = $("#user_select option:selected").val();
                // var todate = $('#report_to_date_2').val();
                // var j_id = 'all';
                // var j_c_id = 'all';
                // reportTimeToHireAction(u_id,todate,j_id,j_c_id);
            });
        });

        function reportTimeToHireAction(u_id,todate,j_id,j_c_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route($route_name.'.reportTimeToHireAction')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    u_id: u_id,
                    todate: todate,
                    j_id: j_id,
                    j_c_id: j_c_id,
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                    $('#kt_datatable_wrapper').html('');
                },
                success: function(data) {

                    if (data.code == 1) {
                        setTimeout(function () {
                            if(data.data){
                                $('#kt_datatable_wrapper').html(data.data);
                            }else{
                                $('#kt_datatable_wrapper').html('<div class="time_to_hire_no_data">No Data Found.</div>');
                            }
                        }, 1000);

                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                            zeroconfig_table();
                            tooltipHover();
                        }, 1500);

                    } else {
                        setTimeout(function () {
                            $.LoadingOverlay("hide");
                            $('#kt_datatable_wrapper').html('<div class="time_to_hire_no_data">No Data Found.</div>');
                        }, 1000);
                    }

                },
                error: function(jqXhr, textStatus,errorThrown) {
                    setTimeout(function () {
                        $.LoadingOverlay("hide");
                        $('#kt_datatable_wrapper').html('<div class="time_to_hire_no_data">No Data Found.</div>');
                    }, 1000);
                }
            });
        }

        if({{Auth::user()->role}} == 1){
            setTimeout(function () {
                var u_id = $("#user_select option:selected").val();
                var todate = $('#report_to_date_2').val();
                var j_id = $("#job_vacancy option:selected").val();
                var j_c_id = $("#job_category option:selected").val();
                reportTimeToHireAction(u_id,todate,j_id,j_c_id);
            }, 1000);

        }else{
            setTimeout(function () {
                var u_id = $("#user_select").val();
                var todate = $('#report_to_date_2').val();
                var j_id = $("#job_vacancy option:selected").val();
                var j_c_id = $("#job_category option:selected").val();
                reportTimeToHireAction(u_id,todate,j_id,j_c_id);
            }, 1000);
        }

    </script>

    <script>
        function zeroconfig_table() {
            $('#zero-config').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    // "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [5, 10, 20, 50, 100, 150, 200],
                "pageLength": 10,
                "searching": false,
                "lengthChange": false,
                "info": false,
                "paging": false,
            });
        }

        function tooltipHover() {
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
        }
    </script>

    <script>
        // function PrintDiv() {
            // var head_custom = '<head>';
            // // head_custom += '<meta charset="utf-8">';
            // // head_custom += '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            // // head_custom += '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
            // head_custom += '<title>Report</title>';
            // head_custom += '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/style.bundle.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/themes/layout/header/base/dark.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/themes/layout/header/menu/dark.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '<link href="{{url('assets/backend')}}/css/custom.css" rel="stylesheet" type="text/css"/>';
            // head_custom += '</head>';
            // var divToPrint = document.getElementById('divToPrint');
            // var popupWin = window.open('', '_blank', '');
            // popupWin.document.open();
            // popupWin.document.write('<html>'+head_custom+'<body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            // popupWin.document.close();
        // }
    </script>
@stop
