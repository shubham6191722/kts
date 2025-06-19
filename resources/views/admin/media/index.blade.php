@extends('admin.layouts.common')

@section('title', 'Media List')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
<link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
<link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/custom/uppy/uppy.bundle.css" rel="stylesheet" type="text/css" />
@stop
@php
    $route_name = App\CustomFunction\CustomFunction::role_name();
@endphp

@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Media List</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="javascript:void(0)" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#mediaAdd">
                                <span class="svg-icon svg-icon-md">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"></path>
                                        <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.20001C9.70001 3 10.2 3.20001 10.4 3.60001ZM16 11.6L12.7 8.29999C12.3 7.89999 11.7 7.89999 11.3 8.29999L8 11.6H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H16Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M11 11.6V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V11.6H11Z" fill="currentColor"></path>
                                    </svg>
                                </span>Upload Files
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="zero-config" role="grid" aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @if(!empty($media_data))
                                                @foreach($media_data as $key => $value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                        <td>@if(isset($value->file_title) && !empty($value->file_title)){!! $value->file_title !!} @endif</td>
                                                        <td>
                                                            @if($value['file_type'] == "jpg" || $value['file_type'] == "png" || $value['file_type'] == "jpeg" || $value['file_type'] == "gif")
                                                                <div class="d-flex align-items-center">
                                                                    <img alt="" class="max-h-25px" src="{!!url('assets/backend')!!}/media/svg/files/jpg.svg">
                                                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($value['file_name']) && !empty($value['file_name'])){!! $value['file_name'] !!}@endif</a>
                                                                </div>
                                                            @elseif($value['file_type'] == "pdf")
                                                                <img alt="" class="max-h-25px" src="{!!url('assets/backend')!!}/media/svg/files/pdf.svg">
                                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($value['file_name']) && !empty($value['file_name'])){!! $value['file_name'] !!}@endif</a>
                                                            @else
                                                                <img alt="" class="max-h-25px" src="{!!url('assets/backend')!!}/media/svg/files/doc.svg">
                                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($value['file_name']) && !empty($value['file_name'])){!! $value['file_name'] !!}@endif</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $newformat = null;
                                                                if(isset($value['updated_at']) && !empty($value['updated_at'])){
                                                                    $time = strtotime($value['updated_at']);

                                                                    $newformat = date('d-m-Y h:i A',$time);
                                                                }
                                                            @endphp
                                                            {!! $newformat !!}
                                                        </td>
                                                        <td nowrap="nowrap">
                                                            @php
                                                                $file_download = url('uploads').'/job_vacancy/'.$value['file_name'];
                                                            @endphp
                                                            <a href="{{$file_download}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" target="_blank" data-theme="dark" data-html="true" title="Download" data-toggle="tooltip" data-target="#skillEdit_{{$key}}">
                                                                <span class="svg-icon svg-icon-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
                                                                            <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </a>

                                                            <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon" data-toggle="modal" data-target="#mediaEdit_{{$key}}">
                                                                <span data-toggle="tooltip" data-theme="dark" data-html="true" title="Edit">
                                                                    <span class="svg-icon svg-icon-md">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                            </a>

                                                            <div class="modal fade" id="mediaEdit_{{$key}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Upload files</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form" method="POST" action="{{route($route_name.'.mediaUpdate')}}" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Title</label>
                                                                                            <div>
                                                                                                <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="file_title" value="@if(isset($value['file_title']) && !empty($value['file_title'])){!! $value['file_title'] !!}@endif" placeholder="Title" required />
                                                                                                <input type="hidden" name="id" value="@if(isset($value['id']) && !empty($value['id'])){!! $value['id'] !!}@endif"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <a href="{{$file_download}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" target="_blank" data-theme="dark" data-html="true" title="Download" data-toggle="tooltip" data-target="#skillEdit_{{$key}}">
                                                                                                <span class="svg-icon svg-icon-md">
                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                                                            <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
                                                                                                            <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                                                                                                        </g>
                                                                                                    </svg>
                                                                                                </span>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-footer pb-0 mt-10 pl-0">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-12 col-sm-12">
                                                                                            <button type="submit" class="btn btn-light-primary font-weight-bold">
                                                                                                <span class="indicator-label">Submit</span>
                                                                                                <span class="indicator-progress">Please wait...
                                                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" class="btn btn-sm btn-light btn-hover-primary btn-icon delete_this" data-toggle="tooltip" data-theme="dark" data-html="true" title="Delete" data-id="{!!$value['id']!!}">
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
                                                            <form action="{{ route($route_name.'.mediaDelete')}}" method="post" >
                                                                <input type="hidden" name="id" value="{!!$value['id']!!}" />
                                                                @csrf
                                                            </form>
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

    <div class="modal fade" id="mediaAdd" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" method="POST" action="{{route($route_name.'.mediaSave')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <div>
                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="file_title" value="{!! old('file_title') !!}" placeholder="Title" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" value="" id="customFile" required />
                                        <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select File</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pb-0 mt-10 pl-0">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-light-primary font-weight-bold">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <script src="{!!url('assets/backend')!!}/plugins/custom/uppy/uppy.bundle.js"></script>

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

    </script>
@stop
