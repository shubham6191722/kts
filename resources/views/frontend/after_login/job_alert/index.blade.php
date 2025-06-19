@extends('admin.layouts.common')

@section('title', 'Settings')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
@stop

@section('content')

    @php
        $route_name = App\CustomFunction\CustomFunction::role_name();
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                                <li class="nav-item mr-3">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_user_notifications">
                                        <span class="nav-icon">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476" />
                                                        <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) " />
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-text font-size-lg">Job Alert</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="show active tab-pane px-7" id="kt_tab_user_notifications" role="tabpanel">
                                <form class="form" method="POST" action="{{ route('candidate.jobAlert')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label class="col-form-label">Notifications Alert</label>
                                                    <div class="">
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label data-toggle="tooltip" data-theme="dark" @if(isset($user_data->check_notification) && !empty($user_data->check_notification)) title="Notifications Active" @else title="Notifications De-Active" @endif>
                                                                <input type="checkbox" @if(isset($user_data->check_notification) && !empty($user_data->check_notification)) checked="checked" @endif name="check_notification"/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Job Category <span>(you can select multiple option.)</span></label>
                                                    <div>
                                                    @php
                                                        $category_id[0] = 0;
                                                        if(isset($user_data->categoryid) && !empty($user_data->categoryid)){
                                                            $category_id = explode(",",$user_data->categoryid); 
                                                        }
                                                    @endphp
                                                    <select class="form-control select2" name="categoryid[]" multiple="multiple">
                                                        @if(!empty($job_category))
                                                            @foreach($job_category as $CKey => $c_value)
                                                                <option value="{!! $c_value->category_id !!}" @if(in_array($c_value->category_id, $category_id)) selected @endif>{!! $c_value->category !!}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Employment type <small>(you can select multiple option.)</small></label>
                                                    <div>
                                                        @php
                                                            $emploment_type_id[0] = 0;
                                                            if(isset($user_data->emploment_type) && !empty($user_data->emploment_type)){
                                                                $emploment_type_id = explode(",",$user_data->emploment_type);    
                                                            }
                                                        @endphp
                                                        <select class="form-control select2" name="emploment_type[]" multiple="multiple">
                                                            <option value="permanent" @if(in_array('permanent', $emploment_type_id)) selected @endif>Permanent</option>
                                                            <option value="fixed-term-contract" @if(in_array('fixed-term-contract', $emploment_type_id)) selected @endif>Fixed term contract</option>
                                                            <option value="temporary" @if(in_array('temporary', $emploment_type_id)) selected @endif>Temporary</option>
                                                            <option value="part-time" @if(in_array('part-time', $emploment_type_id)) selected @endif>Part Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Hourly Salary</label>
                                                <div class="input-group input-group-lg ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-pound-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="number" name="hourly_salary" class="form-control form-control-lg" value="@if(isset($user_data->hourly_salary) && !empty($user_data->hourly_salary)){!! $user_data->hourly_salary !!}@endif" placeholder="Hourly Salary" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Annual Salary</label>
                                                <div class="input-group input-group-lg ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-pound-sign"></i>
                                                        </span>
                                                    </div>
                                                    <input type="number" name="annual_salary" class="form-control form-control-lg" value="@if(isset($user_data->annual_salary) && !empty($user_data->annual_salary)){!! $user_data->annual_salary !!}@endif" placeholder="Annual Salary" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label class="col-form-label">Radius Alert</label>
                                                    <div class="">
                                                        <span class="switch switch-outline switch-icon switch-success">
                                                            <label data-toggle="tooltip" data-theme="dark" @if(isset($user_data->check_radius) && !empty($user_data->check_radius)) title="Radius Active" @else title="Radius De-Active" @endif>
                                                                <input type="checkbox" @if(isset($user_data->check_radius) && !empty($user_data->check_radius)) checked="checked" @endif name="check_radius" id="check_radius"/>
                                                                <span></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-radius @if(isset($user_data->check_radius) && !empty($user_data->check_radius)) @else radius-hide @endif">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Postcode</label>
                                                    <div>
                                                        <input type="text" class="form-control form-control-lg custom-form-control-lg mb-2" id="postcode" name="postcode" @if(isset($user_data->postcode) && !empty($user_data->postcode)) value="{!! $user_data->postcode !!}" @endif placeholder="Postcode">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-radius @if(isset($user_data->check_radius) && !empty($user_data->check_radius)) @else radius-hide @endif">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Distance</label>
                                                    <div>
                                                        <select class="form-control distance-km" name="distance_km" id="distance_km">
                                                            <option value="">Distance</option>
                                                            <option value="5"  @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '5') selected @endif @endif >5 miles</option>
                                                            <option value="10" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '10') selected @endif @endif>10 miles</option>
                                                            <option value="15" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '15') selected @endif @endif>15 miles</option>
                                                            <option value="25" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '25') selected @endif @endif>25 miles</option>
                                                            <option value="50" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '50') selected @endif @endif>50 miles</option>
                                                            <option value="75" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '75') selected @endif @endif>75 miles</option>
                                                            <option value="100" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '100') selected @endif @endif>100 miles</option>
                                                            <option value="200" @if(isset($user_data->distance_km) && !empty($user_data->distance_km))@if($user_data->distance_km == '200') selected @endif @endif>200 miles</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer pb-0 mt-10 pl-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <button type="submit" class="btn btn-light-primary font-weight-bold">
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

@stop

@section('footerScripts')
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('.select2').select2({placeholder: "Please Select"});

                $('.summernote').summernote({
                    height: 150,
                    disableDragAndDrop:true,
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

        $('body').on('change', '.tz_categoryid', function() {
            var id = $(this).val();
            categoryIdAction(id);
        });
        
        $('body').on('change', '#check_radius', function(e) {
            if(e.target.checked == true){
                $(".check-radius").fadeIn();
                $("#postcode").attr("required","required");
                $("#distance_km").attr("required","required");
            }else{
                $(".check-radius").fadeOut();
                $("#postcode").removeAttr("required");
                $("#distance_km").removeAttr("required");
            }
        });

        $('body').on('change', '#check_salary', function(e) {
            if(e.target.checked == true){
                $(".check-salary").fadeIn();
                $("#to_salary").attr("required","required");
                $("#from_salary").attr("required","required");
            }else{
                $(".check-salary").fadeOut();
                $("#to_salary").removeAttr("required");
                $("#from_salary").removeAttr("required");
            }
        });

        "use strict";

        var KTUserEdit = function () {
            var avatar;

            var initUserForm = function() {
                avatar = new KTImageInput('kt_user_edit_avatar');
            }

            return {
                init: function() {
                    initUserForm();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTUserEdit.init();
        });

        function categoryIdAction(id) {

            $.ajax({
                url: "{{route('candidate.categoryidGet')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    id: id,
                    _token: csrf_token,
                },
                beforeSend: function() {
                    $('.job_skill').empty().select2();
                },
                success: function(data) {
                    if (data.code == 1) {
                        if (data.stage_data !='') {
                            var option = '';

                            var html = '';
                            $(data.skillList).each(function(index,item) { 
                                html += '<option value="' + item.id +'" >' +item.skill_name +'</option>';
                            });

                            $('.job_skill').append(html).trigger('change');
                            
                            $('.job_skill').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        } else {

                            html += '';
                            $('.job_skill').append(html).trigger('change');

                            $('.job_skill').trigger({
                                type: 'select2:select',
                                params: {
                                    data: data
                                }
                            });
                        }

                    } else {
                        show_toastr('error',data.msg, '');
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                }
            });
        }
    </script>
@stop
