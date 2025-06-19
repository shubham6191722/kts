@extends('admin.layouts.common')

@section('title', 'Vacancy Detail')

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
                            <h3 class="card-label">Vacancy Detail</h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route($route_name.'.vacancyList')}}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                </span>List Vacancy</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row recruiter-data-span">
                                        <div class="card card-custom" id="kt_card_1" style="width: 100%;">
                                            <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                <div class="card-title">
                                                    <h3 class="card-label">Basic details</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Basic details">
                                                        <i class="ki ki-arrow-down icon-nm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if(isset($job_vacancy->jobtitle) && !empty($job_vacancy->jobtitle))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Title:  <span>{!! $job_vacancy->jobtitle !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification))
                                                        @php
                                                            $fileUrl = null;
                                                            if(isset($job_vacancy->job_specification) && !empty($job_vacancy->job_specification)){
                                                                $file = $job_vacancy->job_specification;
                                                                $check_ext = explode('.', $file);
                                                                $fileUrl = url('uploads').'/job_vacancy/'.$file;
                                                            }
                                                        @endphp
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Specification:  
                                                                    <span>
                                                                        <a href="{{$fileUrl}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 icon-bold" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
                                                                            <span class="svg-icon svg-icon-md">
                                                                                <i class="icon toast-title text-dark flaticon-download"></i>
                                                                            </span>
                                                                        </a>
                                                                    </span>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-custom" id="kt_card_2" style="width: 100%;">
                                            <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                <div class="card-title">
                                                    <h3 class="card-label">Remuneration</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Remuneration">
                                                        <i class="ki ki-arrow-down icon-nm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if(isset($job_vacancy->jobtenure) && !empty($job_vacancy->jobtenure))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                @php
                                                                    if($job_vacancy->jobtenure == 'permanent'){
                                                                        $jobtenure = 'Permanent';
                                                                    }elseif($job_vacancy->jobtenure == 'fixed-term-contract'){
                                                                        $jobtenure = 'Fixed term-contract';
                                                                    }elseif($job_vacancy->jobtenure == 'temporary'){
                                                                        $jobtenure = 'Temporary';
                                                                    }elseif($job_vacancy->jobtenure == 'part-time'){
                                                                        $jobtenure = 'Part time';
                                                                    }
                                                                @endphp
                                                                <h4>Employment Type:  <span>{!! $jobtenure !!}</span></h4>
                                                                <input type="hidden" id="jobtenure" value="{{$job_vacancy->jobtenure}}">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->startdate) && !empty($job_vacancy->startdate))
                                                        <div class="col-md-12 startdate jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                @php
                                                                    $newformat = null;
                                                                    if(isset($job_vacancy->startdate) && !empty($job_vacancy->startdate)){
                                                                        $time = strtotime($job_vacancy->startdate);
                                                                        $newformat = date('d-m-Y',$time);
                                                                    }
                                                                @endphp
                                                                <h4>Start Date:  <span>{!!  $newformat !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->duration) && !empty($job_vacancy->duration))
                                                        <div class="col-md-3 durationlength jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <h4>Duration Length:  <span>{!! $job_vacancy->duration !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->durationperiod) && !empty($job_vacancy->durationperiod))
                                                        <div class="col-md-12 durationperiod jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                @php
                                                                    if($job_vacancy->durationperiod == 'weeks'){
                                                                        $durationperiod = 'Weeks';
                                                                    }elseif($job_vacancy->durationperiod == 'months'){
                                                                        $durationperiod = 'Months';
                                                                    }elseif($job_vacancy->durationperiod == 'years'){
                                                                        $durationperiod = 'Years';
                                                                    }
                                                                @endphp
                                                                <h4>Duration Period:  <span>{!!  $durationperiod !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->weeklyworkinghours) && !empty($job_vacancy->weeklyworkinghours))
                                                        <div class="col-md-12 weeklyworkinghours jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <h4>Weekly hours:  <span>{!! $job_vacancy->weeklyworkinghours !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->ratelower) && !empty($job_vacancy->ratelower))
                                                        <div class="col-md-12 ratelower jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <h4>Hourly rate:  <span>£{!! App\CustomFunction\CustomFunction::number_format($job_vacancy->ratelower) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->rateupper) && !empty($job_vacancy->rateupper))
                                                        <div class="col-md-12 rateupper jobtenure-add jobtenure-hide">
                                                            <div class="form-group">
                                                                <h4>Annual salary:  <span>£{!! App\CustomFunction\CustomFunction::number_format($job_vacancy->rateupper) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-custom" id="kt_card_3" style="width: 100%;">
                                            <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                <div class="card-title">
                                                    <h3 class="card-label">Location & requirements</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Location & requirements">
                                                        <i class="ki ki-arrow-down icon-nm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if(isset($job_vacancy->locatedcountry) && !empty($job_vacancy->locatedcountry))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Country:  <span>{!!  App\Models\Country::countryName($job_vacancy->locatedcountry) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->locatedregion) && !empty($job_vacancy->locatedregion))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Region:  <span>{!!  App\Models\Region::regionName($job_vacancy->locatedregion) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->altlocation) && !empty($job_vacancy->altlocation))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Alt Location to City:  <span>{!! $job_vacancy->altlocation !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->locatedpostcode) && !empty($job_vacancy->locatedpostcode))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Postcode:  <span>{!! $job_vacancy->locatedpostcode !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-custom" id="kt_card_4" style="width: 100%;">
                                            <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                <div class="card-title">
                                                    <h3 class="card-label">Job details</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Job details">
                                                        <i class="ki ki-arrow-down icon-nm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if(isset($job_vacancy->categoryid) && !empty($job_vacancy->categoryid))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Category:  <span>{!! App\Models\JobCategory::categoryName($job_vacancy->categoryid) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->occupationid) && !empty($job_vacancy->occupationid))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Sub Category:  <span>{!! App\Models\JobOccupation::occupationName($job_vacancy->occupationid) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->levelid) && !empty($job_vacancy->levelid))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Level:  <span>{!! App\Models\JobLevel::levelName($job_vacancy->levelid) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->jobcategory1) && !empty($job_vacancy->jobcategory1))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Company Sector on vacancy:  <span>{!! App\Models\JobSectors::JobSectorsName($job_vacancy->jobcategory1) !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->skillsrequired) && !empty($job_vacancy->skillsrequired))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Skills: </h4>
                                                                <p>
                                                                    @php
                                                                        $skillsrequired  = $job_vacancy->skillsrequired;
                                                                        $skillsrequired_v = explode(",", $skillsrequired);
                                                                    @endphp
                                                                    <ul class="detail-list qualification">
                                                                        @foreach ($skillsrequired_v as $skillsrequired_v_1)
                                                                            <li>{{ App\Models\JobSkill::getSkillName($skillsrequired_v_1) }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->qualificationsrequired) && !empty($job_vacancy->qualificationsrequired))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Qualifications: </h4>
                                                                <p>
                                                                    {!! $job_vacancy->qualificationsrequired !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->jobdescription) && !empty($job_vacancy->jobdescription))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Job Advert: </h4>
                                                                <div>
                                                                    {!! $job_vacancy->jobdescription !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->jobvacancystatus) && !empty($job_vacancy->jobvacancystatus))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Select status: <span>{!! $jobvacancystatus[$job_vacancy->jobvacancystatus] !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->jobvacancystage) && !empty($job_vacancy->jobvacancystage))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Select vacancy stage: <span>{!! $jobvacancystage[$job_vacancy->jobvacancystage] !!}</span></h4>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-custom" id="kt_card_5" style="width: 100%;">
                                            <div class="card-header alert alert-custom alert-default card-header-hight-50">
                                                <div class="card-title">
                                                    <h3 class="card-label">Additional details</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Additional details">
                                                        <i class="ki ki-arrow-down icon-nm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if(isset($job_vacancy->infofromthehiringmanager) && !empty($job_vacancy->infofromthehiringmanager))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Info From The Hiring Manager: </h4>
                                                                <p>
                                                                    {!! $job_vacancy->infofromthehiringmanager !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->cover_image) && !empty($job_vacancy->cover_image))
                                                        {{-- <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Hiring Manager Image:  
                                                                    <span>
                                                                        <a href="" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download"> 
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
                                                                    </span>
                                                                </h4>
                                                            </div>
                                                        </div> --}}
                                                    @endif

                                                    @if(isset($job_vacancy->benefits) && !empty($job_vacancy->benefits))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Benefits: </h4>
                                                                @php
                                                                    $str     = $job_vacancy->benefits;
                                                                    $order   = array("\r\n", "\n", "\r");
                                                                    $replace = '<br/>';
                                                                    $benefits = str_replace($order, $replace, $str);
                                                                @endphp
                                                                <p>
                                                                {!! $benefits !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if(isset($job_vacancy->work_base_preference) && !empty($job_vacancy->work_base_preference))
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4>Work base preference: </h4>
                                                                <p>
                                                                    @php
                                                                        $work_base_preference  = $job_vacancy->work_base_preference;
                                                                        $work_base_preference_v = explode(",", $work_base_preference);
                                                                    @endphp
                                                                    <ul class="detail-list qualification">
                                                                        @foreach ($work_base_preference_v as $work_base_preference_v_1)
                                                                            <li>{{ $work_base_preference_v_1 }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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

        jobtenure($('#jobtenure').val());

        $('body').on('change', '#jobtenure', function() {
            var jobtenure_val = $(this).val();
            jobtenure(jobtenure_val);
        });

        function jobtenure(val) {
            var jobtenure_val = val;
            if(jobtenure_val === 'permanent'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide'); 
            }else if(jobtenure_val === 'fixed-term-contract'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide');
            }else if(jobtenure_val === 'temporary'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.ratelower').removeClass('jobtenure-hide');
            }else if(jobtenure_val === 'part-time'){
                $('.jobtenure-add').addClass('jobtenure-hide');
                $('.startdate').removeClass('jobtenure-hide');
                $('.duration').removeClass('jobtenure-hide');
                $('.durationperiod').removeClass('jobtenure-hide');
                $('.weeklyworkinghours').removeClass('jobtenure-hide');
                $('.ratelower').removeClass('jobtenure-hide');
                $('.rateupper').removeClass('jobtenure-hide');
            }else{
                $('.jobtenure-add').addClass('jobtenure-hide');
            }
        }

        var card = new KTCard('kt_card_1');
        var card2 = new KTCard('kt_card_2');
        var card3 = new KTCard('kt_card_3');
        var card4 = new KTCard('kt_card_4');
        var card5 = new KTCard('kt_card_5');

        setTimeout(function () {
            KTApp.unblock(card.getSelf());
            KTApp.unblock(card2.getSelf());
            KTApp.unblock(card3.getSelf());
            KTApp.unblock(card4.getSelf());
            KTApp.unblock(card5.getSelf());
        }, 2000);

    </script>
@stop
