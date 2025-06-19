@extends('admin.layouts.common')

@section('title', 'Settings')

@section('headerScripts')
<link rel="stylesheet" href="{!!url('assets/backend')!!}/css/fancybox.css" />
<link href="{{url('assets/frontend')}}/css/intlTelInput.css" rel="stylesheet">
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
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_my_account_setting">
                                        <span class="nav-icon">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-text font-size-lg">Profile</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_user_change_password">
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
                                        <span class="nav-text font-size-lg">Change Password</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_user_delete_profile">
                                        <span class="nav-icon">
                                            <span class="svg-icon">
                                                <i class="fas fa-user-times"></i>
                                            </span>
                                        </span>
                                        <span class="nav-text font-size-lg">Delete Profile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="show active tab-pane px-7" id="kt_tab_my_account_setting" role="tabpanel">
                                <form class="form" id="kt_form_2" method="POST" action="{{ route($route_name.'.accountSetting')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-12 text-left">Profile Image</label>
                                                        <div class="col-12">
                                                            <div class="image-input image-input-empty image-input-outline" id="kt_user_edit_avatar" style="background-image: url({{url('uploads')}}/candidate/{{Auth::user()->id}}/@if(isset(Auth::user()->cover_image) && !empty(Auth::user()->cover_image)){!! Auth::user()->cover_image !!}@endif)">
                                                                <div class="image-input-wrapper"></div>
                                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                                    <input type="file" class="custom-file-input" name="profile_file" value="" id="profile_file" accept=".jpg, .jpeg, .png" />
                                                                </label>
                                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="old_profile_file" value="@if(isset(Auth::user()->cover_image) && !empty(Auth::user()->cover_image)){!! Auth::user()->cover_image !!}@endif"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <div>
                                                            <input type="text" class="form-control form-control-lg" name="fname" value="{!! old('fname',Auth::user()->name) !!}" placeholder="First Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Last name</label>
                                                        <div>
                                                            <input type="text" class="form-control form-control-lg" name="lname" value="{!! old('lname',Auth::user()->lname) !!}" placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <div>
                                                            <input type="text" name="phone" class="form-control form-control-lg" value="{!! old('phone',Auth::user()->phone) !!}" placeholder="Phone Number" id="c_number"/>
                                                            <input type="hidden" id="c_code" name="c_code" value="@if(isset(Auth::user()->c_code) && !empty(Auth::user()->c_code)){!! Auth::user()->c_code !!}@endif">
                                                        <input type="hidden" id="country_code" name="country_code" value="@if(isset(Auth::user()->country_code) && !empty(Auth::user()->country_code)){!! Auth::user()->country_code !!}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email Address</label>
                                                        <div class="input-group input-group-lg input-group-solid">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            <input type="email" name="email" class="form-control form-control-lg" value="{!! old('email',Auth::user()->email) !!}" placeholder="Email" @if(Auth::check()) @if(Auth::user()->role != 1) readonly @endif @endif />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Current Work Email</label>
                                                        <div class="input-group input-group-lg">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            <input type="email" name="c_w_email" class="form-control form-control-lg" value="@if(isset($user_data->c_w_email) && !empty($user_data->c_w_email)){!! $user_data->c_w_email !!}@endif" placeholder="Current Work Email" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Location</label>
                                                            <div>
                                                                @php
                                                                    $location_id = null;
                                                                    if(isset($user_data->location) && !empty($user_data->location)){
                                                                        $location_id = $user_data->location;
                                                                    }
                                                                @endphp
                                                                <select class="form-control select2" name="location">
                                                                    <option selected></option>
                                                                    @if(!empty($region))
                                                                        @foreach($region as $SKey => $r_value)
                                                                            <option value="{!! $r_value->region_id !!}" @if($r_value->region_id == $location_id) selected @endif>{!! $r_value->region !!}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Salary</label>
                                                        <div class="input-group input-group-lg ">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-pound-sign"></i>
                                                                </span>
                                                            </div>
                                                            <input type="number" name="salary" class="form-control form-control-lg" value="@if(isset($user_data->salary) && !empty($user_data->salary)){!! $user_data->salary !!}@endif" placeholder="Salary" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>CV</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="cv_file" value="" id="cv_file" accept="application/pdf,application/msword,.doc, .docx" />
                                                                <input type="hidden" name="old_cv_file" value="@if(isset($user_data->cv) && !empty($user_data->cv)){!! $user_data->cv !!}@endif"/>
                                                                <label class="custom-file-label" for="cv_file" style="overflow: hidden;">Select File</label>
                                                            </div>
                                                            @php
                                                                $fileUrl = null;
                                                                if(isset($user_data->cv) && !empty($user_data->cv)){
                                                                    $file = $user_data->cv;
                                                                    $check_ext = explode('.', $file);
                                                                    $fileUrl = url('uploads').'/candidate/'.Auth::user()->id.'/'.$file;
                                                                }
                                                            @endphp
                                                            @if(isset($fileUrl) && !empty($fileUrl))
                                                                <small id="specification_file_select">
                                                                    Download File
                                                                    <a @if($check_ext[1] == 'pdf') target="_blank" @endif href="{{url('uploads')}}/candidate/{{Auth::user()->id}}/@if(isset($user_data->cv) && !empty($user_data->cv)){!! $user_data->cv !!}@endif" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                                    <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"></rect>
                                                                                    <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "></path>
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                    </a>
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Notice period</label>
                                                            <div>
                                                                @php
                                                                    $noticeperiod = null;
                                                                    if(isset($user_data->noticeperiod) && !empty($user_data->noticeperiod)){
                                                                        $noticeperiod = $user_data->noticeperiod;
                                                                    }
                                                                @endphp
                                                                <select class="form-control select2" name="noticeperiod">
                                                                    <option selected value=""></option>
                                                                    <option value="Available Now"   @if('Available Now' == $noticeperiod) selected @endif>Available Now</option>
                                                                    <option value="1 Weeks Notice"  @if('1 Weeks Notice' == $noticeperiod) selected @endif>1 Weeks Notice</option>
                                                                    <option value="2 Weeks Notice"  @if('2 Weeks Notice' == $noticeperiod) selected @endif>2 Weeks Notice</option>
                                                                    <option value="1 Months Notice" @if('1 Months Notice' == $noticeperiod) selected @endif>1 Months Notice</option>
                                                                    <option value="2 Months Notice" @if('2 Months Notice' == $noticeperiod) selected @endif>2 Months Notice</option>
                                                                    <option value="3 Months Notice" @if('3 Months Notice' == $noticeperiod) selected @endif>3 Months Notice</option>
                                                                    <option value="6 months Notice" @if('6 months Notice' == $noticeperiod) selected @endif>6 months Notice</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Job Specialism</label>
                                                            <div>
                                                                @php
                                                                    $sector_id = null;
                                                                    if(isset($user_data->sector) && !empty($user_data->sector)){
                                                                        $sector_id = $user_data->sector;
                                                                    }
                                                                @endphp
                                                                <select class="form-control select2 tz_categoryid" name="sector" id="profile_sector">
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
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Skills <span>(you can select multiple option.)</span></label>
                                                            <div>
                                                                @php
                                                                    $key_skills[0] = 0;
                                                                    if(isset($user_data->key_skills) && !empty($user_data->key_skills)){
                                                                        $key_skills = explode(",",$user_data->key_skills);
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Work preference <span>(you can select multiple option.)</span></label>
                                                            <div>
                                                                @php
                                                                    $workbasepreference[0] = 0;
                                                                    if(isset($user_data->workbasepreference) && !empty($user_data->workbasepreference)){
                                                                        $workbasepreference = explode(",",$user_data->workbasepreference);
                                                                    }
                                                                @endphp
                                                                <select class="form-control select2" name="workbasepreference[]" id="workbasepreference" multiple="multiple">
                                                                    <option value="Office" @if(in_array('Office', $workbasepreference)) selected @endif>Office</option>
                                                                    <option value="Remote" @if(in_array('Remote', $workbasepreference)) selected @endif>Remote</option>
                                                                    <option value="Hybrid" @if(in_array('Hybrid', $workbasepreference)) selected @endif>Hybrid</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Cover letter</label>
                                                            <div>
                                                                <textarea type="text" class="form-control form-control-lg mb-2 summernote" name="description" placeholder="Cover letter" required>@if(isset($user_data->description) && !empty($user_data->description)){!! $user_data->description !!}@endif</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Activate talent pool</label>
                                                            <div class="">
                                                                <span class="switch switch-outline switch-icon switch-success">
                                                                    <label data-toggle="tooltip" data-theme="dark" @if(isset(Auth::user()->talent_pool_status) && !empty(Auth::user()->talent_pool_status)) title="Activate talent pool" @else title="De-Activate talent pool" @endif>
                                                                        <input type="checkbox" @if(isset(Auth::user()->talent_pool_status) && !empty(Auth::user()->talent_pool_status)) checked="checked" @endif  name="talent_pool" value="1"/>
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
                                                            <label>Profile Status</label>
                                                            <div class="">
                                                                <span class="switch switch-outline switch-icon switch-success">
                                                                    <label data-toggle="tooltip" data-theme="dark" @if(isset(Auth::user()->deleted_at) && !empty(Auth::user()->deleted_at)) title="De-Active Profile" @else title="Active Profile" @endif>
                                                                        <input type="checkbox" @if(isset(Auth::user()->deleted_at) && !empty(Auth::user()->deleted_at)) @else checked="checked" @endif  name="active_status" value="1"/>
                                                                        <span></span>
                                                                    </label>
                                                                </span>
                                                            </div>
                                                        </div>
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
                            <div class="tab-pane px-7" id="kt_tab_user_change_password" role="tabpanel">
                                <form class="form" method="POST" action="{{ route($route_name.'.changePassword')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Current Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid mb-2" name="current_password" placeholder="Current password" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="new_password" placeholder="New password" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm Password</label>
                                                        <div>
                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="confirm_password" placeholder="Confirm Password" />
                                                        </div>
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
                            <div class="tab-pane px-7" id="kt_tab_user_delete_profile" role="tabpanel">
                                <div class="row">
                                    <button type="button" class="btn btn-danger mr-2" id="all_delete_candidate" data-candidate="{!! Auth::user()->id !!}">Delete Profile</button>
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
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/intlTelInput.min.js"></script>
    <script src="{!!url('assets/backend')!!}/js/fancybox.umd.js"></script>
    <script>
        "use strict";

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

        $('.select2').on('change', function(){
            var name = $(this).attr('name');
            if((name == "skillsrequired[]") || (name == "workbasepreference[]") || (name == "n_location[]") || (name == "categoryid[]") || (name == "emploment_type[]")){
                var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?\",.";
                var stringValue = name;
                for (var i = 0; i < specialChars.length; i++) {
                    stringValue = stringValue.replace(new RegExp("\\" + specialChars[i], "g"), "");
                }
            }else{

                var c_name = name.replace(/[_\W]+/g, "");
                validator.revalidateField(c_name);
            }
        });

        jQuery(document).ready(function() {
            KTSelect2.init();
        });

        var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
        var formSubmitButton =document.getElementById('kt_form_submit_button');

        var validator = FormValidation.formValidation(
            document.getElementById('kt_form_2'), {
                fields: {
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
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Phone Number is required'
                            }
                        }
                    },
                    skillsrequired: {
                        validators: {
                            choice: {
                                min:1,
                                message: 'Please select at least 1 options'
                            }
                        }
                    },
                    location: {
                        validators: {
                            notEmpty: {
                                message: 'Location is required'
                            }
                        }
                    },
                    sector: {
                        validators: {
                            notEmpty: {
                                message: 'Sector is required'
                            }
                        }
                    },
                    salary: {
                        validators: {
                            notEmpty: {
                                message: 'Salary is required'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Cover letter is required '
                            }
                        }
                    },
                    noticeperiod: {
                        validators: {
                            notEmpty: {
                                message: 'Notice period is required'
                            }
                        }
                    },
                    workbasepreference: {
                        validators: {
                            notEmpty: {
                                message: 'Work base preference is required'
                            },
                            choice: {
                                min:1,
                                message: 'Please select at least 1 options'
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

            var csrf_token = $('meta[name="csrf-token"]').attr('content');
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
    <script>
        var token = $("meta[name='csrf-token']").attr("content");

        $('body').on('click', '#all_delete_candidate', function() {
            var candidate_id = $(this).attr('data-candidate');

            var this_button = $(this);
            Swal.fire({
                title: "Are you sure to deleted this profile?",
                text: "All data will be deleted permanently.",
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function(result) {
                if (result.value) {

                    $.ajax({
                        url: "{{route('candidate.deleteCandidateProfile')}}",
                        type: 'POST',
                        data: {
                            "candidate_id": candidate_id,
                            "_token": token,
                        },
                        beforeSend: function () {
                            $.LoadingOverlay("show");
                        },success: function (data){
                            setTimeout(function () {
                                $.LoadingOverlay("hide");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }, 200);
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            $.LoadingOverlay("hide");
                            show_toastr('error', 'Please try again!','');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        let input = document.querySelector("#c_number");

        var code_data = '{{Auth::user()->c_code}}';
        var initial_country = '{{Auth::user()->country_code}}';

        let iti = intlTelInput(input, {
            initialCountry: initial_country,
            separateDialCode: true,
            nationalMode: false,
        });

        $(window).on("load", function() {
            intlTelInputGlobals.loadUtils("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.1/js/utils.js");
        });

        input.addEventListener("countrychange", function() {
            var code = iti.getSelectedCountryData().dialCode;
            var c_code = iti.getSelectedCountryData().iso2;
            $('#c_code').val(code);
            $('#country_code').val(c_code);
        });

    </script>
    <script>
        $('body').on('click', '.disconnected_this', function() {
            var id = $(this).attr('data-id');
            var this_button = $(this);
            Swal.fire({
                title: "Are you sure to disconnect your outlook calendar ?",
                text: "",
                icon: "warning",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Yes, Disconnect it!"
            }).then(function(result) {
                if (result.value) {
                    this_button.next().submit();
                }
            });
        });

    </script>
@stop
