@extends('admin.layouts.common')

@section('title', 'Jobs on hold')

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
                            <h3 class="card-label">Jobs on hold</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route($route_name.'.reportPrintActionPrint',['id' => $user_id.'?action=jobs_on_hold'])}}" target="_blank" class="btn btn-primary font-weight-bolder mr-3">
                                Print
                            </a>
                            
                            <a href="{{route($route_name.'.reportList')}}" class="btn btn-primary font-weight-bolder">
                                Back
                            </a>
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
                                                <th>Job Title</th>
                                                <th>Job Category</th>
                                                <th>Managed by</th>
                                                <th>Vacancy Status</th>
                                                <th>Vacancy Stage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($jobs_on_hold) && !empty($jobs_on_hold) && count($jobs_on_hold))
                                                @foreach($jobs_on_hold as $key => $value)
                                                    @php
                                                        $key = $key + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{!! $key !!}</td>
                                                        <td>{!! $value['jobtitle'] !!}</td>
                                                        <td>{!! App\Models\JobCategory::categoryName($value['categoryid']) !!}</td>
                                                        <td>@if($value['managed_by'] == 2) Direct @else Re:Source @endif</td>
                                                        <td>{!! $jobvacancystatus[$value['jobvacancystatus']] !!}</td>
                                                        <td>{!! $jobvacancystage[$value['jobvacancystage']] !!}</td>
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
    </script>
@stop
