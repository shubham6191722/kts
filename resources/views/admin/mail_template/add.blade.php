@extends('admin.layouts.common')

@section('title', 'Add Mail Template')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
            $route_name = App\CustomFunction\CustomFunction::role_name();        
        @endphp
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="card card-custom">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Add Mail Template</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route($route_name.'.emailTemplateList')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Mail Template
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route($route_name.'.emailTemplateCreate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="client_id" value="{{$id}}" id="client_id">  

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Template Title</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="template_title" value="{!! old('template_title') !!}" placeholder="Template Title" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Email Subject</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email_subject" value="{!! old('email_subject') !!}" placeholder="Email Subject" required />
                                                    </div>
                                                    <small class="text-dark-50 font-size-base">Note: Use the <code class="text-dark-50 font-size-base">{candidate-name}</code> keywords for a dynamic subject.</small>
                                                </div>
                                            </div>
                                            @if(isset($sub_company) && !empty($sub_company))
                                                @if(Auth::user()->role == 1)

                                                @else
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Select Sub Company</label>
                                                            <div>
                                                                <select class="form-control select2" name="sub_company" id="sub_company">
                                                                    <option selected value=""></option>
                                                                        @foreach($sub_company as $s_CKey => $sub_data_value)
                                                                            <option value="{!! $sub_data_value->id !!}">{!! $sub_data_value->company_name !!}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Email Description</label>
                                                    <div>
                                                        <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="email_description" placeholder="Email Description" required>{!! old('email_description') !!}</textarea>
                                                    </div>
                                                    <small class="text-dark-50 font-size-base">Note: Use following variable for dynamic value</small>
                                                    <div>
                                                        <ul class="mail-dynamic-tag">
                                                            <li>
                                                                <code class="text-dark-50 font-size-base">{candidate-name}</code>
                                                            </li>
                                                            <li>
                                                                <code class="text-dark-50 font-size-base">{vacancy-title}</code>
                                                            </li>
                                                            <li>
                                                                <code class="text-dark-50 font-size-base">{company-name}</code>
                                                            </li>
                                                            <li>
                                                                <code class="text-dark-50 font-size-base">{user-name}</code>
                                                            </li>
                                                            <li>
                                                                <code class="text-dark-50 font-size-base">{user-job-title}</code>
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
                                                    <button type="submit" class="btn btn-light-primary font-weight-bold" id="kt_form_submit_button">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="mediaCoverImage" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($media_image))
                                @foreach($media_image as $MKey => $m_value)
                                    <div class="col-2">
                                        <div class="d-flex flex-column align-items-center modal-box-bodar">
                                            <div class="select_file_hiring_manager text-center" data-id="{!! $m_value['id'] !!}" data-name="{!! $m_value['file_name'] !!}">
                                                @php
                                                    // $image_path = url('uploads').'/job_vacancy/'.Auth::user()->id.'/';
                                                    $image_path = url('uploads').'/job_vacancy/';
                                                @endphp
                                                <img alt="" class="max-h-55px" src="{!! $image_path !!}{!! $m_value['file_name'] !!}">
                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary">@if(isset($m_value['file_name']) && !empty($m_value['file_name'])){!! $m_value['file_name'] !!}@endif</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@stop

@section('footerScripts')

    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
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

        // $(function() {
        //     $(".job_hiring_manager").click(function(){
        //         var radioValue = $("input[name='logo_manager']:checked").val();
        //         if(radioValue === 'media'){
        //             $('#hiring_manager_file_check').hide();
        //             $('#mediaCoverImage').modal('show');
        //         }
        //         if(radioValue === 'select'){
        //             $('#hiring_manager_file_check').show();
        //             $("#logo_file_file_select").text('').fadeOut();
        //             $("#logo_filefile_value").val('');
        //         }
        //     });

        //     $(".select_file_hiring_manager").click(function(){
        //         var file_id = $(this).attr('data-id');
        //         var file_name = $(this).attr('data-name');
        //         $("#logo_file_file_select").text('').fadeOut();
        //         setTimeout(function () {
        //             // var text_add_hiring_manager = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/{{Auth::user()->id}}/'+file_name+'">'+file_name+'</a>';
        //             var text_add_hiring_manager = 'Select File <a data-fancybox href="{{url('uploads')}}/job_vacancy/'+file_name+'">'+file_name+'</a>';
        //             $("#logo_file_file_select").append(text_add_hiring_manager).fadeIn();
        //             $("#logo_filefile_value").val(file_name);
        //             $('#mediaCoverImage').modal('hide');
        //         }, 500);

        //     });
        // });

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
                    template_title: {
                        validators: {
                            notEmpty: {
                                message: 'Template Title is required'
                            }
                        }
                    },
                    email_subject: {
                        validators: {
                            notEmpty: {
                                message: 'Email Subject is required'
                            }
                        }
                    },
                    email_description: {
                        validators: {
                            notEmpty: {
                                message: 'Email Description is required'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ).on('core.form.valid', function() {
            KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

            setTimeout(function() {
                KTUtil.btnRelease(formSubmitButton);
            }, 2000);
        });    

    </script>

@stop