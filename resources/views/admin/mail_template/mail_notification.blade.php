@extends('admin.layouts.common')

@section('title', 'E-Mail Template')

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

    {{-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-3 custom-card-header">
                        <div class="card-title card-custom-title">
                            <h3 class="card-label">E-Mail Template</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="zero-config" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Title</th>
                                                <th>Subject</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @if(!empty($mail_noti_template))
                                                @foreach($mail_noti_template as $key => $value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                        <td>@if(isset($value->type_text) && !empty($value->type_text)){!! $value->type_text !!}@endif</td>
                                                        <td>@if(isset($value->email_subject) && !empty($value->email_subject)){!! $value->email_subject !!}@endif</td>
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
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="Edit Work Flow" data-toggle="modal" data-target="#statusEdit_{{$key}}">
                                                                <span class="svg-icon svg-icon-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </a>

                                                            <div class="modal fade" id="statusEdit_{{$key}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form" method="POST" action="{{ route('rats-5768.mailNotificationUpdate') }}">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <h4>@if(isset($value->type_text) && !empty($value->type_text)){!! $value->type_text !!}@endif</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Email Subject</label>
                                                                                            <div>
                                                                                                <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email_subject" value="@if(isset($value->email_subject) && !empty($value->email_subject)){!! $value->email_subject !!}@endif" placeholder="Email Subject" required />
                                                                                                <input type="hidden" name="notifications_type" value="@if(isset($value->notifications_type) && !empty($value->notifications_type)){!! $value->notifications_type !!}@endif" required />
                                                                                                <input type="hidden" name="role" value="@if(isset($value->role) && !empty($value->role)){!! $value->role !!}@endif" required />
                                                                                                <input type="hidden" name="id" value="@if(isset($value->id) && !empty($value->id)){!! $value->id !!}@endif" required />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label><label>Email Description</label></label>
                                                                                            <div>
                                                                                                <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="email_description" placeholder="Email Description" required>@if(isset($value->email_description) && !empty($value->email_description)){!! $value->email_description !!}@endif</textarea>
                                                                                            </div>
                                                                                            <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                                                            <div>
                                                                                                <ul class="mail-dynamic-tag">
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{client-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{staff-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{recruiter-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{candidate-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{event-type}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{vacancy-title}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{company-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-company}</code>
                                                                                                    </li>
                                                                                                </ul>
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
    </div> --}}

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid m-b-20">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5 custom-card-header">
                        <div class="card-title card-custom-title">
                            <h3 class="card-label">Job Application E-Mail Template</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="zero-config" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Title</th>
                                                <th>Subject</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @if(!empty($job_application))
                                                @foreach($job_application as $key => $value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$key+1!!}">{!!$key+1!!}</td>
                                                        <td>@if(isset($value->type_text) && !empty($value->type_text)){!! $value->type_text !!}@endif</td>
                                                        <td>@if(isset($value->email_subject) && !empty($value->email_subject)){!! $value->email_subject !!}@endif</td>
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
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="Edit Work Flow" data-toggle="modal" data-target="#statusEdit_{{$key}}">
                                                                <span class="svg-icon svg-icon-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </a>

                                                            <div class="modal fade" id="statusEdit_{{$key}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form" method="POST" action="{{ route('rats-5768.mailNotificationUpdate') }}">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <h4>@if(isset($value->type_text) && !empty($value->type_text)){!! $value->type_text !!}@endif</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Email Subject</label>
                                                                                            <div>
                                                                                                <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email_subject" value="@if(isset($value->email_subject) && !empty($value->email_subject)){!! $value->email_subject !!}@endif" placeholder="Email Subject" required />
                                                                                                <input type="hidden" name="notifications_type" value="@if(isset($value->notifications_type) && !empty($value->notifications_type)){!! $value->notifications_type !!}@endif" required />
                                                                                                <input type="hidden" name="role" value="@if(isset($value->role) && !empty($value->role)){!! $value->role !!}@endif" required />
                                                                                                <input type="hidden" name="id" value="@if(isset($value->id) && !empty($value->id)){!! $value->id !!}@endif" required />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label><label>Email Description</label></label>
                                                                                            <div>
                                                                                                <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="email_description" placeholder="Email Description" required>@if(isset($value->email_description) && !empty($value->email_description)){!! $value->email_description !!}@endif</textarea>
                                                                                            </div>
                                                                                            <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                                                            <div>
                                                                                                <ul class="mail-dynamic-tag">
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{client-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{staff-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{recruiter-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{candidate-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{event-type}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{vacancy-title}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{company-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-company}</code>
                                                                                                    </li>
                                                                                                </ul>
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
        <div class="d-flex flex-column-fluid m-b-20">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5 custom-card-header">
                        <div class="card-title card-custom-title">
                            <h3 class="card-label">Job Interview E-Mail Template</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="zero-config-1" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Title</th>
                                                <th>Subject</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @if(!empty($job_events))
                                                @foreach($job_events as $JEkey => $j_e_value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$JEkey+1!!}">{!!$JEkey+1!!}</td>
                                                        <td>@if(isset($j_e_value->type_text) && !empty($j_e_value->type_text)){!! $j_e_value->type_text !!}@endif</td>
                                                        <td>@if(isset($j_e_value->email_subject) && !empty($j_e_value->email_subject)){!! $j_e_value->email_subject !!}@endif</td>
                                                        <td>
                                                            @php
                                                                $newformat = null;
                                                                if(isset($j_e_value['updated_at']) && !empty($j_e_value['updated_at'])){
                                                                    $time = strtotime($j_e_value['updated_at']);

                                                                    $newformat = date('d-m-Y h:i A',$time);
                                                                }
                                                            @endphp
                                                            {!! $newformat !!}
                                                        </td>
                                                        <td nowrap="nowrap">
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="Edit Work Flow" data-toggle="modal" data-target="#statusEdit_{{$j_e_value->id}}">
                                                                <span class="svg-icon svg-icon-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </a>

                                                            <div class="modal fade" id="statusEdit_{{$j_e_value->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form" method="POST" action="{{ route('rats-5768.mailNotificationUpdate') }}">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <h4>@if(isset($j_e_value->type_text) && !empty($j_e_value->type_text)){!! $j_e_value->type_text !!}@endif</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Email Subject</label>
                                                                                            <div>
                                                                                                <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email_subject" value="@if(isset($j_e_value->email_subject) && !empty($j_e_value->email_subject)){!! $j_e_value->email_subject !!}@endif" placeholder="Email Subject" required />
                                                                                                <input type="hidden" name="notifications_type" value="@if(isset($j_e_value->notifications_type) && !empty($j_e_value->notifications_type)){!! $j_e_value->notifications_type !!}@endif" required />
                                                                                                <input type="hidden" name="role" value="@if(isset($j_e_value->role) && !empty($j_e_value->role)){!! $j_e_value->role !!}@endif" required />
                                                                                                <input type="hidden" name="id" value="@if(isset($j_e_value->id) && !empty($j_e_value->id)){!! $j_e_value->id !!}@endif" required />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label><label>Email Description</label></label>
                                                                                            <div>
                                                                                                <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="email_description" placeholder="Email Description" required>@if(isset($j_e_value->email_description) && !empty($j_e_value->email_description)){!! $j_e_value->email_description !!}@endif</textarea>
                                                                                            </div>
                                                                                            <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                                                            <div>
                                                                                                <ul class="mail-dynamic-tag">
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{client-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{staff-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{recruiter-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{candidate-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{event-type}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{vacancy-title}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{company-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-company}</code>
                                                                                                    </li>
                                                                                                </ul>
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
        <div class="d-flex flex-column-fluid m-b-20">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5 custom-card-header">
                        <div class="card-title card-custom-title">
                            <h3 class="card-label">Job Offers E-Mail Template</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="zero-config-2" role="grid"
                                        aria-describedby="kt_datatable_info" style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr No.</th>
                                                <th>Title</th>
                                                <th>Subject</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @if(!empty($job_offers))
                                                @foreach($job_offers as $JOkey => $j_o_value)
                                                    <tr class="odd">
                                                        <td class="dtr-control" tabindex="{!!$JOkey+1!!}">{!!$JOkey+1!!}</td>
                                                        <td>@if(isset($j_o_value->type_text) && !empty($j_o_value->type_text)){!! $j_o_value->type_text !!}@endif</td>
                                                        <td>@if(isset($j_o_value->email_subject) && !empty($j_o_value->email_subject)){!! $j_o_value->email_subject !!}@endif</td>
                                                        <td>
                                                            @php
                                                                $newformat = null;
                                                                if(isset($j_o_value['updated_at']) && !empty($j_o_value['updated_at'])){
                                                                    $time = strtotime($j_o_value['updated_at']);

                                                                    $newformat = date('d-m-Y h:i A',$time);
                                                                }
                                                            @endphp
                                                            {!! $newformat !!}
                                                        </td>
                                                        <td nowrap="nowrap">
                                                            <a href="javascript:void(0)" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="Edit Work Flow" data-toggle="modal" data-target="#statusEdit_{{$j_o_value->id}}">
                                                                <span class="svg-icon svg-icon-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            </a>

                                                            <div class="modal fade" id="statusEdit_{{$j_o_value->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form" method="POST" action="{{ route('rats-5768.mailNotificationUpdate') }}">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <h4>@if(isset($j_o_value->type_text) && !empty($j_o_value->type_text)){!! $j_o_value->type_text !!}@endif</h4>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Email Subject</label>
                                                                                            <div>
                                                                                                <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email_subject" value="@if(isset($j_o_value->email_subject) && !empty($j_o_value->email_subject)){!! $j_o_value->email_subject !!}@endif" placeholder="Email Subject" required />
                                                                                                <input type="hidden" name="notifications_type" value="@if(isset($j_o_value->notifications_type) && !empty($j_o_value->notifications_type)){!! $j_o_value->notifications_type !!}@endif" required />
                                                                                                <input type="hidden" name="role" value="@if(isset($j_o_value->role) && !empty($j_o_value->role)){!! $j_o_value->role !!}@endif" required />
                                                                                                <input type="hidden" name="id" value="@if(isset($j_o_value->id) && !empty($j_o_value->id)){!! $j_o_value->id !!}@endif" required />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label><label>Email Description</label></label>
                                                                                            <div>
                                                                                                <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="email_description" placeholder="Email Description" required>@if(isset($j_o_value->email_description) && !empty($j_o_value->email_description)){!! $j_o_value->email_description !!}@endif</textarea>
                                                                                            </div>
                                                                                            <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                                                            <div>
                                                                                                <ul class="mail-dynamic-tag">
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{client-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{staff-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{recruiter-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{candidate-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{event-type}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{vacancy-title}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{company-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-name}</code>
                                                                                                    </li>
                                                                                                    <li>
                                                                                                        <code class="text-dark-50 font-size-base">{admin-company}</code>
                                                                                                    </li>
                                                                                                </ul>
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
            "pageLength": 5
        });
        var zeroconfig_table_1 = $('#zero-config-1').DataTable({
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
            "pageLength": 5
        });
        var zeroconfig_table_2 = $('#zero-config-2').DataTable({
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
            "pageLength": 5
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

    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.summernote').summernote({
                    height: 150,
                    disableDragAndDrop:true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
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
                init: function() {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTSelect2.init();
        });
        $('#zero-config').on('draw.dt', function() {
            KTSelect2.init();
        });
        $('#zero-config-1').on('draw.dt', function() {
            KTSelect2.init();
        });
        $('#zero-config-2').on('draw.dt', function() {
            KTSelect2.init();
        });
    </script>

@stop
