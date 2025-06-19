@extends('admin.layouts.common')

@section('title', 'Membership Detail Edit')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
<link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
<link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">

                <div class="card card-custom">
                    <div class="card-header align-items-center flex-wrap py-5">
                        <h3 class="card-label">Membership Detail Edit</h3>
                        <div class="card-toolbar">
                            <a href="{{route('rats-5768.clientList')}}"
                                class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Client
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route('rats-5768.membershipUpdate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Subscription Model</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="sub_model" value="@if(isset($user_data->sub_model) && !empty($user_data->sub_model)){!! $user_data->sub_model !!}@endif" placeholder="Subscription Model" required />
                                                        <input type="hidden" name="id" value="@if(isset($user_data->id) && !empty($user_data->id)){!! $user_data->id !!}@endif"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Subscription Created</label>
                                                    <div>
                                                        @php

                                                            $sub_created = null;
                        
                                                            if(isset($user_data->sub_created) && !empty($user_data->sub_created)){
                                                                $sub_created_time = strtotime($user_data->sub_created);
                                                                $sub_created = date('d-m-Y',$sub_created_time);
                                                            }

                                                        @endphp
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2 date" name="sub_created" value="@if(isset($sub_created) && !empty($sub_created)){!! $sub_created !!}@endif" placeholder="Subscription Created" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Subscription Expires</label>
                                                    <div>
                                                        @php

                                                            $sub_expires = null;
                        
                                                            if(isset($user_data->sub_expires) && !empty($user_data->sub_expires)){
                                                                $sub_expires_time = strtotime($user_data->sub_expires);
                                                                $sub_expires = date('d-m-Y',$sub_expires_time);
                                                            }

                                                        @endphp
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2 date" name="sub_expires" value="@if(isset($sub_expires) && !empty($sub_expires)){!! $sub_expires !!}@endif" placeholder="Subscription Expires" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Subscription Cost</label>
                                                    <div>
                                                        <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="sub_cost" value="@if(isset($user_data->sub_cost) && !empty($user_data->sub_cost)){!! $user_data->sub_cost !!}@endif" placeholder="Subscription Cost" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Payment Terms</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="sub_payment_terms" value="@if(isset($user_data->sub_payment_terms) && !empty($user_data->sub_payment_terms)){!! $user_data->sub_payment_terms !!}@endif" placeholder="Payment Terms" autocomplete="off"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Credits</label>
                                                    <div>
                                                        <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="credits" value="@if(isset($user_data->company_credits) && !empty($user_data->company_credits)){!! $user_data->company_credits !!}@endif" placeholder="Credits" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Credits Expire</label>
                                                    <div>
                                                        @php

                                                            $credits_expire = null;
                        
                                                            if(isset($user_data->credits_expire) && !empty($user_data->credits_expire)){
                                                                $credits_expire_time = strtotime($user_data->credits_expire);
                                                                $credits_expire = date('d-m-Y',$credits_expire_time);
                                                            }

                                                        @endphp
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2 date" name="credits_expire" value="@if(isset($credits_expire) && !empty($credits_expire)){!! $credits_expire !!}@endif" placeholder="Credits Expire" required />
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
                                                    <a href="{{route('rats-5768.clientList')}}" class="btn btn-clean font-weight-bold">Cancel</a>
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
@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});

                $('.date').datepicker({
                    rtl: KTUtil.isRTL(),
                    // autoclose: true,
                    // startDate: new Date(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    format: 'dd-mm-yyyy',
                });
                $('.summernote').summernote({
                    height: 150,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
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

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
                    sub_model: {
                        validators: {
                            notEmpty: {
                                message: 'Subscription Model is required'
                            }
                        }
                    },
                    sub_created: {
                        validators: {
                            notEmpty: {
                                message: 'Subscription Created is required'
                            }
                        }
                    },
                    sub_expires: {
                        validators: {
                            notEmpty: {
                                message: 'Subscription Expires is required'
                            }
                        }
                    },
                    sub_cost: {
                        validators: {
                            notEmpty: {
                                message: 'Subscription Cost is required'
                            }
                        }
                    },
                    sub_payment_terms: {
                        validators: {
                            notEmpty: {
                                message: 'Payment Terms is required'
                            }
                        }
                    },
                    credits: {
                        validators: {
                            notEmpty: {
                                message: 'Credits is required'
                            }
                        }
                    },
                    credits_expire: {
                        validators: {
                            notEmpty: {
                                message: 'Credits Expire is required'
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
