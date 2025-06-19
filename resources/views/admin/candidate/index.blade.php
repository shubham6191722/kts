@extends('admin.layouts.common')

@section('title', 'Candidate List')

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
                            <h3 class="card-label">Candidate List
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Town</th>
                                                <th>Status</th>
                                                <th>Talent pool status</th>
                                                <th>Status Profile</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($candidateList))
                                            @foreach($candidateList as $key => $value)
                                            <tr class="odd">
                                                <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                <td>@if(isset($value['name']) && !empty($value['name'])){!! App\Models\User::getUserName($value['main_id']) !!}@endif</td>
                                                <td>@if(isset($value['email']) && !empty($value['email'])){!! $value['email'] !!}@endif</td>
                                                <td>@if(isset($value['phone']) && !empty($value['phone'])){!! $value['phone'] !!}@endif</td>
                                                <td>@if(isset($value['town']) && !empty($value['town'])){!! $value['town'] !!}@endif</td>
                                                <td>
                                                    <div class="star-status-main">
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label data-toggle="tooltip" data-theme="dark"  @if($value['status'] == 1) title="Active" @else title="De-Active" @endif>
                                                                <input type="checkbox" class="click-stars-slider" data-id="{{$value['main_id']}}" data-name="status" @if($value['status'] == 1)checked="checked"@endif/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="star-status-main">
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label data-toggle="tooltip" data-theme="dark"  @if($value['talent_pool_status'] == 1) title="Active" @else title="De-Active" @endif>
                                                                <input type="checkbox" class="click-stars-slider" data-id="{{$value['main_id']}}" data-name="talent_pool_status" @if($value['talent_pool_status'] == 1)checked="checked"@endif/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if(isset($value['deleted_at']) && !empty($value['deleted_at']))
                                                        <span class="label label-lg label-light-info label-inline">ReActive</span>
                                                    @else
                                                        <span class="label label-lg label-light-success label-inline">Active</span>
                                                    @endif
                                                </td>
                                                <td nowrap="nowrap">
                                                    @php
                                                        $client_slug = '#';
                                                        if(isset($value['client_slug']) && !empty($value['client_slug'])){
                                                            $client_slug = $value['client_slug'];
                                                        }
                                                    @endphp

                                                    <a href="{{route($route_name.'.telantPootDetail',['id' => $client_slug])}}" target="_blank" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 client-copy-link" data-link="{{route($route_name.'.telantPootDetail',['id' => $client_slug])}}" data-toggle="tooltip" data-theme="dark" data-html="true" title="Link"> 
                                                        <span class="svg-icon svg-icon-md"> 
                                                            <i class="fas fa-link"></i>
                                                        </span> 
                                                    </a>

                                                    <a href="{{route($route_name.'.candidateEdit',['id' => $value['main_id']])}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 KTSelect2_load" data-theme="dark" data-html="true" title="Edit" data-id="@if(isset($value['main_id']) && !empty($value['main_id'])){!! $value['main_id'] !!}@endif"> 
                                                        <span class="svg-icon svg-icon-md"> 
                                                            <i class="fas fa-user-edit"></i>
                                                        </span> 
                                                    </a>

                                                    {{-- <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon delete_this" data-toggle="tooltip" data-theme="dark" data-html="true" title="Delete"> 
                                                        <span class="svg-icon svg-icon-md"> 
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                                </g>
                                                            </svg> 
                                                        </span> 
                                                    </a>
                                                    <form action="{{ route('rats-5768.candidateDelete')}}" method="post" >
                                                        <input type="hidden" name="id" value="{!!$value['main_id']!!}" />
                                                        @csrf
                                                    </form> --}}
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

        $('body').on('click', '.delete_this', function() {
            var id = $(this).attr('data-id');
            var this_button = $(this);
            Swal.fire({
                title: "Are you sure to delete this?",
                text: "",
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    this_button.next().submit();
                }
            });
        });
        $('body').on('click', '.click-stars-slider', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(
                        'meta[name="csrf-token"]'
                    ).attr('content')
                }
            });
            if(name === 'status'){
                $.ajax({
                    url: "{{route('rats-5768.statusUpdate')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                        name : name,
                    },
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            show_toastr('success',data.msg);
                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                location.reload();
                            }, 1000);
                            
                        } else {
                            show_toastr('error',data.msg);

                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(jqXhr, textStatus, errorThrown) {
                        show_toastr('error', 'Please try again','');
                    }
                });
            }
            if(name === 'talent_pool_status'){
                $.ajax({
                    url: "{{route('rats-5768.candidateStatusUpdate')}}",
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                        name : name,
                    },
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    },
                    success: function(data) {
                        if (data.code == 1) {
                            show_toastr('success',data.msg);
                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                location.reload();
                            }, 1000);
                            
                        } else {
                            show_toastr('error',data.msg);

                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(jqXhr, textStatus, errorThrown) {
                        show_toastr('error', 'Please try again','');
                    }
                });
            }
            
        });
    </script>

@stop
