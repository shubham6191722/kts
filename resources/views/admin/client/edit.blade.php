@extends('admin.layouts.common')

@section('title', 'Client Edit')

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
                    <div class="card-header justify-content-end flex-wrap py-5">
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
                                </span>List Client</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route('rats-5768.clientUpdate')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="name" value="@if(isset($user_data->name) && !empty($user_data->name)){!! $user_data->name !!}@endif" placeholder="Name" required />
                                                        <input type="hidden" name="id" value="@if(isset($user_data->id) && !empty($user_data->id)){!! $user_data->id !!}@endif"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Registered company name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="company" value="@if(isset($user_data->company_name) && !empty($user_data->company_name)){!! $user_data->company_name !!}@endif" placeholder="Company" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Job Title</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="jobtitle" value="@if(isset($user_data->job_title) && !empty($user_data->job_title)){!! $user_data->job_title !!}@endif" placeholder="Job Title" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Work Email Address</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="email" value="@if(isset($user_data->email) && !empty($user_data->email)){!! $user_data->email !!}@endif" placeholder="Work Email Address" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <div>
                                                        <input type="password" class="form-control form-control-lg custom-form-control-lg mb-2" name="password" value="" placeholder="Password" autocomplete="off"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Registered company address</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="address" value="@if(isset($user_data->address) && !empty($user_data->address)){!! $user_data->address !!}@endif" placeholder="Registered company address" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Registered company number</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="phone" value="@if(isset($user_data->phone) && !empty($user_data->phone)){!! $user_data->phone !!}@endif" placeholder="Registered company number" required />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Registered privacy policy(URL)</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="policy_url" value="@if(isset($user_data->policy_url) && !empty($user_data->policy_url)){!! $user_data->policy_url !!}@endif" placeholder="Registered privacy policy(URL)" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Recruiter Select</label>
                                                    <div>
                                                        @php
                                                            $recruiter_data = explode(",",$client_assign_recruiter);
                                                        @endphp
                                                        <select class="form-control select2 tz_user" name="recruiter_select[]" id="recruiter_select" multiple="multiple">
                                                            @if(!empty($recruiterList))
                                                                @foreach($recruiterList as $RKey => $recruiterList_value)
                                                                    <option value="{!! $recruiterList_value->id !!}" @if(in_array($recruiterList_value->id, $recruiter_data)) selected @endif>{!! $recruiterList_value->name !!}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>About</label>
                                                    <div>
                                                        <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="about" placeholder="About">@if(isset($client_detail->about) && !empty($client_detail->about)){!! $client_detail->about !!}@endif</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Facebook URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="facebook_url" value="@if(isset($client_detail->facebook_url) && !empty($client_detail->facebook_url)){!! $client_detail->facebook_url !!}@endif" placeholder="Facebook URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Linkedin URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="linkedin_url" value="@if(isset($client_detail->linkedin_url) && !empty($client_detail->linkedin_url)){!! $client_detail->linkedin_url !!}@endif" placeholder="Linkedin URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Youtube URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="youtube_url" value="@if(isset($client_detail->youtube_url) && !empty($client_detail->youtube_url)){!! $client_detail->youtube_url !!}@endif" placeholder="Youtube URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Instagram URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="instagram_url" value="@if(isset($client_detail->instagram_url) && !empty($client_detail->instagram_url)){!! $client_detail->instagram_url !!}@endif" placeholder="Instagram URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Twitter URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="twitter_url" value="@if(isset($client_detail->twitter_url) && !empty($client_detail->twitter_url)){!! $client_detail->twitter_url !!}@endif" placeholder="Twitter URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Video</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="video_file" value="" id="video_file" accept="video/mp4,video/x-m4v,video/*" onchange="Filevalidation()"/>
                                                        <input type="hidden" name="video" value="@if(isset($client_detail->video) && !empty($client_detail->video)){!! $client_detail->video !!}@endif"/>
                                                        <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Video</label>
                                                    </div>
                                                    @if(isset($client_detail->video) && !empty($client_detail->video))
                                                        @php
                                                            $video = url('uploads').'/client_profile/'.$client_detail->video;
                                                        @endphp
                                                    <a data-fancybox data-width="640" data-height="360" href="{!! $video !!}">
                                                        Video : {!! $client_detail->video !!}
                                                    </a>
                                                    @endif
                                                    <div class="fv-plugins-message-container">
                                                        <div data-field="video_file" data-validator="notEmpty" class="fv-help-block" id="size_error" style="display: none;">File too Big, please select a file less than 15mb</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Border Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="border_color" id="border_color" class="form-control form-control-lg form-control-solid" value="@if(isset($client_detail->border_color) && !empty($client_detail->border_color)){!! $client_detail->border_color !!}@endif" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Background Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="background_color" id="background_color" class="form-control form-control-lg form-control-solid" value="@if(isset($client_detail->background_color) && !empty($client_detail->background_color)){!! $client_detail->background_color !!}@endif" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Background Text Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="background_text_color" id="background_text_color" class="form-control form-control-lg form-control-solid" value="@if(isset($client_detail->background_text_color) && !empty($client_detail->background_text_color)){!! $client_detail->background_text_color !!}@endif" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Button Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="button_color" id="button_color" class="form-control form-control-lg form-control-solid" value="@if(isset($client_detail->button_color) && !empty($client_detail->button_color)){!! $client_detail->button_color !!}@endif" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Button Text Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="button_text_color" id="button_text_color" class="form-control form-control-lg form-control-solid" value="@if(isset($client_detail->button_text_color) && !empty($client_detail->button_text_color)){!! $client_detail->button_text_color !!}@endif" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Company Logo</label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="company_logo_file" accept="image/png, image/jpeg" id="site_header_logo_file" />
                                                                <label class="custom-file-label" for="company_logo_file">Choose file</label>
                                                            </div>
                                                            <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 150px,height 75px)</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        @if(!empty($user_data->company_logo) && file_exists('uploads/client_profile/'.$user_data->company_logo))
                                                            <div class="row justify-content-center align-items-center h-100">
                                                                <input type="hidden" name="company_logo" value="{!!$user_data->company_logo!!}" />
                                                                <div class="col-md-12 col-12">
                                                                    <div class="text-center">
                                                                        <div class="d-inline-block" style="padding: 15px;background: #9f9f9f;width: 30%;">
                                                                            <img src="{!!url('uploads').'/client_profile/'.$user_data->company_logo!!}" class="img-fluid"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group mb-3">
                                                            <label>Cover Image</label>
                                                            <div class="custom-file mb-4">
                                                                <input type="file" class="custom-file-input" name="cover_image_file" accept="image/png, image/jpeg" id="cover_image_file" />
                                                                <label class="custom-file-label" for="cover_image_file">Choose file</label>
                                                            </div>
                                                            <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 1920px,height 600px)</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        @if(!empty($user_data->cover_image) && file_exists('uploads/client_profile/'.$user_data->cover_image))
                                                            <div class="row justify-content-center align-items-center h-100">
                                                                <input type="hidden" name="cover_image" value="{!!$user_data->cover_image!!}" />
                                                                <div class="col-md-12 col-12">
                                                                    <div class="text-center">
                                                                        <div class="d-inline-block" style="padding: 15px;background: #9f9f9f;width: 30%;">
                                                                            <img src="{!!url('uploads').'/client_profile/'.$user_data->cover_image!!}" class="img-fluid"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label>Is only main client create offer?</label>
                                                    <div>
                                                        <div class="star-status-main">
                                                            <span class="switch switch-outline switch-icon switch-success">
                                                                <label data-toggle="tooltip" data-theme="dark">
                                                                    <input type="checkbox" class="click-stars-slider" name="offer_status" @if($user_data['offer_status'] == 1)checked="checked"@endif/>
                                                                    <span></span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label>Select Time slot</label>
                                                    <div class="col-form-label">
                                                        <div class="radio-inline">
                                                            <label class="radio">
                                                                <input type="radio" name="event_time_slot_select" value="1" @if($user_data['event_time_slot_select'] == 1)checked="checked"@endif/>
                                                                <span></span>
                                                                Normal interview flow
                                                            </label>
                                                            <label class="radio">
                                                                <input type="radio" name="event_time_slot_select" value="2" @if($user_data['event_time_slot_select'] == 2)checked="checked"@endif/>
                                                                <span></span>
                                                                Self Select
                                                            </label>
                                                        </div>
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

        function Filevalidation() {
            const fi = document.getElementById('video_file');
            // Check if any file is selected.
            if (fi.files.length > 0) {
                for (const i = 0; i <= fi.files.length - 1; i++) {
          
                    const fsize = fi.files.item(i).size;
                    const file = Math.round((fsize / 1024));
                    // The size of the file.
                    if (file >= 15360) {
                        $('#size_error').show();
                        $('#kt_form_submit_button').prop('disabled', true);
                    }else{
                        $('#size_error').hide();
                        $('#kt_form_submit_button').prop('disabled', false);
                    }
                }
            }
        }

    </script>

@stop
