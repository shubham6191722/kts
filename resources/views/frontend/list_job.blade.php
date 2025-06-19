@extends('frontend.layouts.common')

@section('title', 'Search Vacancies')

@section('headerscripts')
@stop

@section('content')
    <div class="clearfix"></div>
    <section class="inner-header-title lazyload" data-src="{{url('assets/frontend')}}/img/bn2.jpg" data-overlay="6">
        <div class="container">
            <h1>Search Vacancies</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="advance-search job-list-tz-width-custom">
        <div class="container">
            <div class="row">

                <div class="col-xl-4 col-lg-4 col-sm-12">
                    <div class="full-sidebar-wrap">

                        <a href="javascript:void(0)" onclick="openNav()" class="btn btn-dark full-width mrg-bot-20 hidden-lg hidden-md hidden-xl"><i class="ti-filter mrg-r-5"></i>Filter Search</a>

                        <div class="show-hide-sidebar mobile-filter" id="filter-sidebar">

                            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="ti-close"></i></a>

                            <form action="{{route('home.jobList.post')}}" method="POST" id="search_clear">
                                @csrf
                                <div class="sidebar-widgets">
                                    <div class="ur-detail-wrap colps-wrap">

                                        <div class="ur-detail-wrap-header">
                                            <h4 class="colps-head" data-toggle="collapse" href="#jb-search" role="button" aria-expanded="true" aria-controls="jb-search">Search</h4>
                                        </div>
                                        <div class="collapse in" id="jb-search">
                                            <div class="ur-detail-wrap-body">
                                                <div class="input-with-icon">
                                                    <input type="text" class="form-control" placeholder="Job Title or Skill" id="job_title_skill" name="job_title_skill" value="@if(isset($job_title_skill) && !empty($job_title_skill)){{$job_title_skill}}@endif">
                                                </div>
                                                <div class="input-with-icon">
                                                    <input type="text" class="form-control" placeholder="Town or Postcode..." id="location_data" name="location_data" autocomplete="off" value="@if(isset($location_data) && !empty($location_data)){{$location_data}}@endif">
                                                    <input type="hidden" name="latitude" id="latitude" value="@if(isset($latitude) && !empty($latitude)){{$latitude}}@endif">
                                                    <input type="hidden" name="longitude" id="longitude" value="@if(isset($longitude) && !empty($longitude)){{$longitude}}@endif">
                                                </div>
                                                <div class="input-with-icon">
                                                    <select class="form-control distance-km" name="distance_km" >
                                                        <option value="">Distance</option>
                                                        <option value="5"  @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '5') selected @endif @endif >5 miles</option>
                                                        <option value="10" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '10') selected @endif @endif>10 miles</option>
                                                        <option value="15" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '15') selected @endif @endif>15 miles</option>
                                                        <option value="25" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '25') selected @endif @endif>25 miles</option>
                                                        <option value="50" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '50') selected @endif @endif>50 miles</option>
                                                        <option value="75" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '75') selected @endif @endif>75 miles</option>
                                                        <option value="100" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '100') selected @endif @endif>100 miles</option>
                                                        <option value="200" @if(isset($distance_km) && !empty($distance_km))@if($distance_km == '200') selected @endif @endif>200 miles</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar-widgets">
                                    <div class="ur-detail-wrap colps-wrap p">

                                        <div class="ur-detail-wrap-header">
                                            <h4 class="colps-head z-index-999" data-toggle="collapse" href="#jb-location" role="button" aria-expanded="true" aria-controls="jb-location">Job Category</h4>
                                        </div>
                                        <div class="collapse in" id="jb-location">
                                            <div class="ur-detail-wrap-body">
                                                @php
                                                    $category_data = array();
                                                    if(isset($category) && !empty($category))
                                                    {
                                                        $category_data = $category;
                                                    }
                                                @endphp
                                                <select class="form-control select2 m-0" id="s-category" name="categoryid[]" multiple>
                                                    @foreach($job_category as $JCKey => $j_c_value)
                                                        <option value="{!! $j_c_value->category_id !!}" @if(in_array($j_c_value->category_id, $category_data)) selected @endif>{!! $j_c_value->category !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar-widgets">
                                    <div class="ur-detail-wrap colps-wrap">

                                        <div class="ur-detail-wrap-header">
                                            <h4 class="colps-head" data-toggle="collapse" href="#jb-Compensation" role="button" aria-expanded="true" aria-controls="jb-Compensation">Salary</h4>
                                        </div>
                                        <div class="collapse in" id="jb-Compensation">
                                            <div class="pb-3 pt-3">
                                                <div class="flex relative justify-center items-center h-20 w-full mx-auto rounded">
                                                    <div class="slider-amount range-slider">
                                                        <div class="progress"></div>
                                                    </div>
                                                    <div class="range-input">
                                                        <input type="range" class="range-min" min="0" max="{{$max_rateupper - 1000}}" step="1000" name="min_price_slider" value="@if(isset($min_price) && !empty($min_price)){{$min_price}}@else{{0}}@endif" >
                                                        <input type="range" class="range-max" min="1000" max="{{$max_rateupper}}" step="1000" name="max_price_slider" value="@if(isset($max_price) && !empty($max_price)){{$max_price}}@else{{$max_rateupper}}@endif" >
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center gap-2" style="padding: 15px 0;">
                                                        <div class="min-value numberVal  w-45 price-input">
                                                            <input type="number" class="w-100 price-range-field input-min" min="0" max="{{$max_rateupper - 1000}}" id="min_price" name="min_price" value="@if(isset($min_price) && !empty($min_price)){{$min_price}}@else{{0}}@endif" readonly>
                                                        </div>
                                                        <div> to </div>
                                                        <div class="max-value numberVal  w-45 price-input">
                                                            <input type="number" class="border w-100 price-range-field input-max" min="1000" max="{{$max_rateupper}}" id="max_price" name="max_price" value="@if(isset($max_price) && !empty($max_price)){{$max_price}}@else{{$max_rateupper}}@endif" readonly>
                                                        </div>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar-widgets">
                                    <div class="ur-detail-wrap colps-wrap">

                                        <div class="ur-detail-wrap-header">
                                            <h4 class="colps-head" data-toggle="collapse" href="#jb-types" role="button" aria-expanded="true" aria-controls="jb-types">Employment type</h4>
                                        </div>
                                        <div class="collapse in" id="jb-types">
                                            <div class="ur-detail-wrap-body">
                                                <ul class="advance-list">
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            @php
                                                                $jobtenure_data = array();
                                                                if(isset($jobtenure) && !empty($jobtenure))
                                                                {
                                                                    $jobtenure_data = $jobtenure;
                                                                }
                                                            @endphp
                                                            <input type="checkbox" id="job_e_1" name="jobtenure[]" value="permanent" @if(in_array('permanent', $jobtenure_data)) checked @endif>
                                                            <label for="job_e_1"></label>
                                                        </span>
                                                        Permanent
                                                    </li>
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="job_e_2" name="jobtenure[]" value="fixed-term-contract" @if(in_array('fixed-term-contract', $jobtenure_data)) checked @endif>
                                                            <label for="job_e_2"></label>
                                                        </span>
                                                        Fixed term-contract
                                                    </li>
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="job_e_3" name="jobtenure[]" value="temporary" @if(in_array('temporary', $jobtenure_data)) checked @endif>
                                                            <label for="job_e_3"></label>
                                                        </span>
                                                        Temporary
                                                    </li>
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="job_e_4" name="jobtenure[]" value="part-time" @if(in_array('part-time', $jobtenure_data)) checked @endif>
                                                            <label for="job_e_4"></label>
                                                        </span>
                                                        Part Time
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sidebar-widgets">
                                    <div class="ur-detail-wrap colps-wrap">

                                        <div class="ur-detail-wrap-header">
                                            <h4 class="colps-head" data-toggle="collapse" href="#jb-work-base-preference" role="button" aria-expanded="true" aria-controls="jb-work-base-preference">Work Base Preference</h4>
                                        </div>
                                        <div class="collapse in" id="jb-work-base-preference">
                                            <div class="ur-detail-wrap-body">
                                                <ul class="advance-list">
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            @php
                                                                $work_base_data = array();
                                                                if(isset($work_base_preference) && !empty($work_base_preference))
                                                                {
                                                                    $work_base_data = $work_base_preference;
                                                                }
                                                            @endphp
                                                            <input type="checkbox" id="job_w_1" name="work_base_preference[]" value="Office" @if(in_array('Office', $work_base_data)) checked @endif>
                                                            <label for="job_w_1"></label>
                                                        </span>
                                                        Office
                                                    </li>
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="job_w_2" name="work_base_preference[]" value="Remote" @if(in_array('Remote', $work_base_data)) checked @endif>
                                                            <label for="job_w_2"></label>
                                                        </span>
                                                        Remote
                                                    </li>
                                                    <li>
                                                        <span class="custom-checkbox">
                                                            <input type="checkbox" id="job_w_3" name="work_base_preference[]" value="Hybrid" @if(in_array('Hybrid', $work_base_data)) checked @endif>
                                                            <label for="job_w_3"></label>
                                                        </span>
                                                        Hybrid
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="apply-btn btn theme-btn btn-shortlist" id="apply_btn">Apply</button>
                                    <button type="button" class="clear-btn btn theme-btn btn-clear" id="clear_btn" onclick="clearBtn()">Reset</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>

                <div class="col-xl-8 col-lg-8 col-sm-12">

                    <div class="row">
                        <div class="col-md-12" id="job_list_data">
                            @if(!empty($job_data))
                                @foreach($job_data as $key => $value)
                                    @php
                                        // $client_data = App\Models\User::clientData($value->user_select);
                                        $client_detail = App\Models\ClientDetail::getData($value->user_select);
                                        if(isset($value->sub_company) && !empty($value->sub_company)){
                                            $client_data = App\Models\SubCompany::getSubCompanyData($value->sub_company);
                                        }else{
                                            $client_data = App\Models\User::clientData($value->user_select);
                                        }

                                        $company_name = 'Company Name';
                                        $company_logo = url('assets/frontend').'/img/com-2.png';

                                        if(isset($client_data->company_name) && !empty($client_data->company_name)){
                                            $company_name = $client_data->company_name;
                                        }
                                        if(isset($client_data->company_logo) && !empty($client_data->company_logo)){
                                            $company_logo = url('uploads').'/client_profile/'.$client_data->company_logo;
                                        }

                                        $button_color_class = null;
                                        $button_color = null;
                                        if(isset($client_detail->button_color) && !empty($client_detail->button_color)){
                                            $button_color = $client_detail->button_color;
                                            $button_color_class = 'button_color_'.$value->user_select;
                                        }

                                        $button_text_color = null;
                                        if(isset($client_detail->button_text_color) && !empty($client_detail->button_text_color)){
                                            $button_text_color = $client_detail->button_text_color;
                                        }
                                    @endphp

                                    {{-- <style>
                                        .button_color_{{$value->user_select}}{
                                            border-color: {{$button_color}} !important;
                                            background: {{$button_color}} !important;
                                            color: {{$button_text_color}} !important;
                                        }
                                        .button_color_{{$value->user_select}}{
                                            opacity: 1;
                                        }
                                    </style> --}}
                                    <div class="newjob-list-layout">
                                        <a href="{{route('getJobDetail',['id' => $value->slug])}}" class="newjob-list-custom">
                                            <div class="d-flex align-items-center mobile-center">
                                                <div class="brows-job-company-img job-company-custom m-0">
                                                    <img data-src="{{$company_logo}}" class="img-responsive lazyload" alt="">
                                                </div>
                                                <div class="cll-caption m-0">
                                                    <h4>@if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif
                                                        @if(isset($value->jobtenure) && !empty($value->jobtenure))
                                                            @if($value->jobtenure == 'permanent')
                                                                <span class="jb-status full-time">Permanent</span>
                                                            @endif
                                                            @if($value->jobtenure == 'part-time')
                                                                <span class="jb-status part-time">Part Time</span>
                                                            @endif
                                                            @if($value->jobtenure == 'fixed-term-contract')
                                                                <span class="jb-status permanent">Fixed term contract</span>
                                                            @endif
                                                            @if($value->jobtenure == 'temporary')
                                                                <span class="jb-status freelanc">Temporary</span>
                                                            @endif
                                                        @endif
                                                    </h4>
                                                    <ul>
                                                        <li><i class="fa fa-map-marker"></i> @if(isset($value->altlocation) && !empty($value->altlocation)){!! $value->altlocation !!}@endif</li>
                                                        <li><i class="fa fa-money"></i>UP TO £@if(isset($value->rateupper) && !empty($value->rateupper)){!! App\CustomFunction\CustomFunction::number_format($value->rateupper) !!}@endif DOE </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="cll-right">
                                                <div class="btn theme-btn btn-shortlist {{$button_color_class}}"><i class="ti-arrow-right"></i>View</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center job_list_pagination">
                            {{ $job_data->links('vendor.pagination.custom') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop

@section('footerscripts')
    <script type="text/javascript" src="{{url('assets/frontend')}}/js/script.js"></script>
    <script>

        function openNav() {
            $('#filter-sidebar').addClass('active');
            $('body').addClass("overflow-hidden");
        }

        function closeNav() {
            $('#filter-sidebar').removeClass('active');
            $('body').removeClass('overflow-hidden');
        }

        function clearBtn() {
            window.location.href = "{{route('home.jobList')}}";
            document.getElementById("search_clear").reset();
        }

        var searchInput = 'location_data';

        $(document).on('change', '#'+searchInput, function () {
            var location_data = $('#'+searchInput).val();
            searchInputVal(location_data);
        });

        function searchInputVal(location_data) {

            var csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('home.jobSearchLatLong')}}",
                dataType: 'json',
                type: 'post',
                data: {
                    location_data: location_data,
                    _token: csrf_token,
                },
                success: function(data) {
                    if (data.code == 1) {
                        $('#latitude').val(data.latitude);
                        $('#longitude').val(data.longitude);
                    }
                },
                error: function(jqXhr, textStatus,errorThrown) {
                    show_toastr('error','Please try again','');
                }
            });
        }

    </script>
@stop
