@extends('admin.layouts.common')

@section('title', 'Candidate Edit')

@section('headerScripts')
    <link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
    <link rel="stylesheet" type="text/css" href="{!!url('assets/backend')!!}/plugins/table/datatable/datatables.css" />
    <link href="{!!url('assets/backend')!!}/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="{!!url('assets/backend')!!}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/frontend')}}/css/intlTelInput.css" rel="stylesheet">
@stop

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">

                <div class="card card-custom">
                    <div class="card-header justify-content-end flex-wrap py-5">
                        <div class="card-toolbar">
                            <a href="{{route('rats-5768.candidateList')}}"
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
                                </span>List Candidate</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route('rats-5768.candidateUpdate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg  mb-2" name="name" value="@if(isset($candidateList->name) && !empty($candidateList->name)){!! $candidateList->name !!}@endif" placeholder="First Name" />
                                                        <input type="hidden" name="id" value="@if(isset($candidateList->main_id) && !empty($candidateList->main_id)){!! $candidateList->main_id !!}@endif" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg  mb-2" name="lname" value="@if(isset($candidateList->lname) && !empty($candidateList->lname)){!! $candidateList->lname !!}@endif" placeholder="Last Name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div>
                                                        <input type="email" class="form-control form-control-lg  mb-2" name="email" value="@if(isset($candidateList->email) && !empty($candidateList->email)){!! $candidateList->email !!}@endif" placeholder="Email" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <div>
                                                        <input type="tel" class="form-control form-control-lg  mb-2" name="phone" value="@if(isset($candidateList->phone) && !empty($candidateList->phone)){!! $candidateList->phone !!}@endif" placeholder="Phone Number" id="c_number"/>
                                                        <input type="hidden" id="c_code" name="c_code" value="@if(isset($candidateList->c_code) && !empty($candidateList->c_code)){!! $candidateList->c_code !!}@endif">
                                                        <input type="hidden" id="country_code" name="country_code" value="@if(isset($candidateList->country_code) && !empty($candidateList->country_code)){!! $candidateList->country_code !!}@endif">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <div>
                                                        @php
                                                            $location = null;
                                                            if(isset($candidateList->location) && !empty($candidateList->location)){
                                                                $location = $candidateList->location;    
                                                            }
                                                        @endphp
                                                        <select class="form-control select2" name="location">
                                                            <option value="" selected="selected" disabled="">Select location</option>
                                                                @if(!empty($r_region))
                                                                    @foreach($r_region as $RKey => $r_value)
                                                                        <option value="{!! $r_value->region_id !!}" @if($r_value->region_id == $location) selected @endif>{!! $r_value->region !!}</option>
                                                                    @endforeach
                                                                @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Town</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg  mb-2" name="town" value="@if(isset($candidateList->town) && !empty($candidateList->town)){!! $candidateList->town !!}@endif" placeholder="Town"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Salary</label>
                                                    <div>
                                                        <input type="number" class="form-control form-control-lg  mb-2" name="salary" value="@if(isset($candidateList->salary) && !empty($candidateList->salary)){!! $candidateList->salary !!}@endif" placeholder="Salary"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Notice Period</label>
                                                    <div>
                                                        @php
                                                            $noticeperiod = null;
                                                            if(isset($candidateList->noticeperiod) && !empty($candidateList->noticeperiod)){
                                                                $noticeperiod = $candidateList->noticeperiod;    
                                                            }
                                                        @endphp
                                                        <select class="form-control select2" name="noticeperiod">
                                                            <option value="Available Now"  @if('Available Now' == $noticeperiod) selected @endif>Available Now</option>
                                                            <option value="1 Weeks Notice" @if('1 Weeks Notice' == $noticeperiod) selected @endif>1 Weeks Notice</option>
                                                            <option value="2 Weeks Notice" @if('2 Weeks Notice' == $noticeperiod) selected @endif>2 Weeks Notice</option>
                                                            <option value="1 Months Notice" @if('1 Months Notice' == $noticeperiod) selected @endif>1 Months Notice</option>
                                                            <option value="2 Months Notice" @if('2 Months Notice' == $noticeperiod) selected @endif>2 Months Notice</option>
                                                            <option value="3 Months Notice" @if('3 Months Notice' == $noticeperiod) selected @endif>3 Months Notice</option>
                                                            <option value="6 months Notice" @if('6 months Notice' == $noticeperiod) selected @endif>6 months Notice</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Work preference <span>(you can select multiple option.)</span></label>
                                                    <div>
                                                        @php
                                                            $workbasepreference[0] = 0;
                                                            if(isset($candidateList->workbasepreference) && !empty($candidateList->workbasepreference)){
                                                                $workbasepreference = explode(",",$candidateList->workbasepreference);    
                                                            }
                                                        @endphp
                                                        <select class="form-control select2" name="workbasepreference[]" multiple="multiple">
                                                            <option value="Office" @if(in_array('Office', $workbasepreference)) selected @endif>Office</option>
                                                            <option value="Remote" @if(in_array('Remote', $workbasepreference)) selected @endif>Remote</option>
                                                            <option value="Hybrid" @if(in_array('Hybrid', $workbasepreference)) selected @endif>Hybrid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Job Specialism</label>
                                                    <div>
                                                        @php
                                                            $sector_id = null;
                                                            if(isset($candidateList->sector) && !empty($candidateList->sector)){
                                                                $sector_id = $candidateList->sector;
                                                            }
                                                        @endphp
                                                        <select class="form-control select2 tz_categoryid" name="sector">
                                                            <option selected value=""></option>
                                                            @if(!empty($job_category))
                                                                @foreach($job_category as $JCKey => $jc_value)
                                                                    <option value="{!! $jc_value->category_id !!}" @if($jc_value->category_id == $sector_id) selected @endif>{!! $jc_value->category !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Skills <span>(you can select multiple option.)</span></label>
                                                    <div>
                                                        @php
                                                            $key_skills[0] = 0;
                                                            if(isset($candidateList->key_skills) && !empty($candidateList->key_skills)){
                                                                $key_skills = explode(",",$candidateList->key_skills);    
                                                            }
                                                        @endphp
                                                        <select class="form-control select2 job_skill" name="skillsrequired[]" id="skillsrequired" multiple="multiple">
                                                            @if(!empty($job_skill))
                                                                @foreach($job_skill as $SKey => $job_skill_value)
                                                                    <option value="{!! $job_skill_value->id !!}" @if(in_array($job_skill_value->id, $key_skills)) selected @endif>{!! $job_skill_value->skill_name !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
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
                                                    <a href="{{route('rats-5768.candidateList')}}" class="btn btn-clean font-weight-bold">Cancel</a>
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

    <script type="text/javascript" src="{{url('assets/frontend')}}/js/intlTelInput.min.js"></script>

    <script src="{{url('assets/frontend')}}/js/jquery.lazy.min.js"></script>
    <script src="{{url('assets/frontend')}}/js/jquery.lazy.plugins.min.js"></script>

    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});

                $('.date').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    // autoclose: true,
                    // startDate: new Date(),
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

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Name is required'
                            }
                        }
                    },
                    company: {
                        validators: {
                            notEmpty: {
                                message: 'Company is required'
                            }
                        }
                    },
                    jobtitle: {
                        validators: {
                            notEmpty: {
                                message: 'Job title is required'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            }
                        }
                    },
                    credits: {
                        validators: {
                            notEmpty: {
                                message: 'Credits is required'
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

    <script>
        let input = document.querySelector("#c_number");

        var code_data = '{{$candidateList->c_code}}';
        var initial_country = '{{$candidateList->country_code}}';

        let iti = intlTelInput(input, {
            initialCountry: initial_country,
            separateDialCode: true,
            nationalMode: false,
            // onlyCountries: ["gb", "in"]
        });

        $(window).on("load", function() {
            intlTelInputGlobals.loadUtils("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.1/js/utils.js");
            // let countryData = window.intlTelInputGlobals.getCountryData();
        });

        input.addEventListener("countrychange", function() {
            var code = iti.getSelectedCountryData().dialCode;
            var c_code = iti.getSelectedCountryData().iso2;
            $('#c_code').val(code);
            $('#country_code').val(c_code);
        });

    </script>

@stop
