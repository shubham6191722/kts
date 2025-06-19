@extends('admin.layouts.common')

@section('title', 'Candidate Add')

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
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Add Candidate</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route('recruiter.recruiterCandidateList')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Candidate
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{route('recruiter.recruiterCandidateCreate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Job Title</label>
                                                    <div>
                                                        <select class="form-control select2" name="job_id" id="job_id" required>
                                                            <option value="" selected disabled>Please Select</option>
                                                            @if(!empty($job_vacancy))
                                                                @foreach($job_vacancy as $key => $value)
                                                                    <option value="@if(isset($value->id) && !empty($value->id)){!! $value->id !!}@endif">@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="fname" value="{!! old('fname') !!}" placeholder="First Name" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="lname" value="{!! old('lname') !!}" placeholder="Last Name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>CV</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="cv_file" value="" id="cv_file" accept="application/pdf,application/msword" required  />
                                                        <label class="custom-file-label" for="cv_file" style="overflow: hidden;">Select Image</label>
                                                    </div>
                                                    <small id="hiring_manager_file_select" class="text-danger">Max File Size 3MB</small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Notice Period</label>
                                                    <div>
                                                        <select class="form-control select2" name="notice_period" id="notice_period" required>
                                                            <option value="" selected disabled>Please Select</option>
                                                            <option value="Available Now">Available Now</option>
                                                            <option value="1 Weeks Notice">1 Weeks Notice</option>
                                                            <option value="2 Weeks Notice">2 Weeks Notice</option>
                                                            <option value="1 Months Notice">1 Months Notice</option>
                                                            <option value="2 Months Notice">2 Months Notice</option>
                                                            <option value="3 Months Notice">3 Months Notice</option>
                                                            <option value="6 months Notice">6 months Notice</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Salary Expectations</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text mb-2">
                                                                <i class="fas fa-pound-sign"></i>
                                                            </span>
                                                        </div>
                                                        <input type="number" class="form-control form-control-lg custom-form-control-lg mb-2" name="salary_expectations" value="{!! old('salary_expectations') !!}" placeholder="Salary Expectations" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Work Base Preferences</label>
                                                    <div>
                                                        <select class="form-control select2" name="work_base_preferences" id="work_base_preferences" required>
                                                            <option value="" selected disabled>Please Select</option>
                                                            <option value="Office">Office</option>
                                                            <option value="Remote">Remote</option>
                                                            <option value="Hybrid">Hybrid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="recruiter_id" value="{{Auth::user()->id}}" id="recruiter_id">

                                        </div>

                                        <div class="card-footer pb-0 mt-10 pl-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
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
@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script src="{{url('assets/backend')}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.js"></script>
    <script src="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script>

        @if(Session::get('error'))
            $('#job_id').val({{old('job_id')}}).trigger("change");
            $('#notice_period').val("{{old('notice_period')}}").trigger("change");
            $('#work_base_preferences').val("{{old('work_base_preferences')}}").trigger("change");
        @endif
        if ('{!!$errors->any()!!}') {
            $('#job_id').val({{old('job_id')}}).trigger("change");
            $('#notice_period').val("{{old('notice_period')}}").trigger("change");
            $('#work_base_preferences').val("{{old('work_base_preferences')}}").trigger("change");   
        }

        var KTSelect2 = function() {
            var demos = function() {
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

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
                    job_id: {
                        validators: {
                            notEmpty: {
                                message: 'Job Title is required'
                            }
                        }
                    },
                    fname: {
                        validators: {
                            notEmpty: {
                                message: 'First Name is required'
                            }
                        }
                    },
                    lname: {
                        validators: {
                            notEmpty: {
                                message: 'Last Name is required'
                            }
                        }
                    },
                    cv_file: {
                        validators: {
                            notEmpty: {
                                message: 'CV File is required'
                            }
                        }
                    },
                    notice_period: {
                        validators: {
                            notEmpty: {
                                message: 'Notice Period is required'
                            }
                        }
                    },
                    salary_expectations: {
                        validators: {
                            notEmpty: {
                                message: 'Salary Expectations is required'
                            }
                        }
                    },
                    work_base_preferences: {
                        validators: {
                            notEmpty: {
                                message: 'Work Base Preferences is required'
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
            // Show loading state on button
            KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

            // Simulate Ajax request
            setTimeout(function() {
                KTUtil.btnRelease(formSubmitButton);
            }, 2000);
        });

        $('.select2').on('change', function(){
            var name = $(this).attr('name');
            validator.revalidateField(name);
        });

        $('#town').on('change', function(){
            var value_data = $(this).val();
            if(value_data=== "other"){
                $('#tname').css('display','block');
            }else{
                $('#tname').css('display','none');
            }
        });
    </script>
@stop
