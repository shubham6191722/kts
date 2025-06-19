@extends('admin.layouts.common')

@section('title', 'Add Sub Company')

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
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3"></path>
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
                                    <form class="form" id="kt_form_2" method="POST" action="{{ route('rats-5768.createSubCompany')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            @if(Auth::check())
                                                @if(Auth::user()->role == 1)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Client Select<div class="lable-tooltip" data-toggle="tooltip" data-theme="dark" data-html="true" title="Select Client"><i class="fas fa-info-circle"></i></div></label>
                                                            <div>
                                                                <select class="form-control select2 tz_user" name="client_id" id="client_id" required>
                                                                    <option selected value=""></option>
                                                                        @if(!empty($client_data))
                                                                            @foreach($client_data as $client_dataKey => $client_data_value)
                                                                                <option value="{!! $client_data_value->id !!}">{!! $client_data_value->name !!} - {!! $client_data_value->company_name !!}</option>
                                                                            @endforeach
                                                                        @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sub Company Name</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="company_name" value="{{old('company_name')}}" placeholder="Sub Company Name" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Benefits Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="benefits_image_file" value="" id="benefits_image_file" accept=".jpg, .jpeg, .png"/>
                                                        <label class="custom-file-label" for="benefits_image_file" style="overflow: hidden;">Select Image</label>
                                                    </div>
                                                    <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 500px,height 500px)</small>
                                                </div>
                                            </div> --}}
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>About</label>
                                                    <div>
                                                        <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="about" placeholder="About">{{old('about')}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Facebook URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="facebook_url" value="{{old('facebook_url')}}" placeholder="Facebook URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Linkedin URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="linkedin_url" value="{{old('linkedin_url')}}" placeholder="Linkedin URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Youtube URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="youtube_url" value="{{old('youtube_url')}}" placeholder="Youtube URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Instagram URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="instagram_url" value="{{old('instagram_url')}}" placeholder="Instagram URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Twitter URL</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" name="twitter_url" value="{{old('twitter_url')}}" placeholder="Twitter URL" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Video</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="video_file" value="" id="video_file" accept="video/mp4,video/x-m4v,video/*" onchange="Filevalidation()"/>
                                                        <label class="custom-file-label" for="customFile" style="overflow: hidden;">Select Video</label>
                                                    </div>
                                                    <div class="fv-plugins-message-container">
                                                        <div data-field="video_file" data-validator="notEmpty" class="fv-help-block" id="size_error" style="display: none;">File too Big, please select a file less than 15mb</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Border Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1 ">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="border_color" id="border_color" class="form-control form-control-lg form-control-solid" value="{!! old('border_color','#ec613a') !!}" placeholder="000000"/>
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
                                                        <input type="color" name="background_color" id="background_color" class="form-control form-control-lg form-control-solid" value="{!! old('background_color','#f5f6f7') !!}" placeholder="000000"/>
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
                                                        <input type="color" name="background_text_color" id="background_text_color" class="form-control form-control-lg form-control-solid" value="{!! old('background_text_color','#000000') !!}" placeholder="000000"/>
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
                                                        <input type="color" name="button_color" id="button_color" class="form-control form-control-lg form-control-solid" value="{!! old('button_color','#ec613a') !!}" placeholder="000000"/>
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
                                                        <input type="color" name="button_text_color" id="button_text_color" class="form-control form-control-lg form-control-solid" value="{!! old('button_text_color','#ffffff') !!}" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Footer Background Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="footer_background_color" id="footer_background_color" class="form-control form-control-lg form-control-solid" value="{!! old('footer_background_color') !!}" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Footer Icon Color</label>
                                                    <div class="input-group input-group-lg input-group-solid input-bg-tr input-b-1">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-hashtag"></i>
                                                            </span>
                                                        </div>
                                                        <input type="color" name="footer_icon_color" id="footer_icon_color" class="form-control form-control-lg form-control-solid" value="{!! old('footer_icon_color') !!}" placeholder="000000"/>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Company Logo</label>
                                                    <div class="custom-file mb-4">
                                                        <input type="file" class="custom-file-input" name="company_logo_file" accept="image/png, image/jpeg" id="company_logo_file" required/>
                                                        <label class="custom-file-label" for="company_logo_file">Choose file</label>
                                                    </div>
                                                    <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 150px,height 75px)</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label>Cover Image</label>
                                                    <div class="custom-file mb-4">
                                                        <input type="file" class="custom-file-input" name="cover_image_file" accept="image/png, image/jpeg" id="cover_image_file" required/>
                                                        <label class="custom-file-label" for="cover_image_file">Choose file</label>
                                                    </div>
                                                    <small id="sh-text1" class="form-text text-muted">(png,jpg file allowed Max. Size 500kb,width 1920px,height 600px)</small>
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
                
                $('[data-switch=true]').bootstrapSwitch();

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
                client_id: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Client is required'
                            }
                        }
                    },
                    company_name: {
                        validators: {
                            notEmpty: {
                                message: 'Sub company name is required'
                            }
                        }
                    },
                    company_logo_file: {
                        validators: {
                            notEmpty: {
                                message: 'Company logo is required'
                            }
                        }
                    },
                    cover_image_file: {
                        validators: {
                            notEmpty: {
                                message: 'Cover image is required'
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

        // $('#recruiter_select').on('changed.bs.select', function() {
        //     // Revalidate field
        //     validator.revalidateField('recruiter_select[]');
        // });

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
