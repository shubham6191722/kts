@extends('frontend.layouts.common')
@section('title', 'Talent Pool')

@section('headerscripts')
@stop

@section('content')
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row extra-mrg">
                <div class="wrap-search-filter">
                    <form>
                        <div class="row justify-content-center">
                            <div class="col-md-3 col-sm-3">
                                <select class="form-control select2" id="s-category">
                                    <option value="">&nbsp;</option>
                                    @foreach($job_skill as $SKey => $job_skill_value)
                                        <option value="{!! $job_skill_value->id !!}">{!! $job_skill_value->skill_name !!}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3 col-sm-3">
                                <select class="form-control select2" id="r-category">
                                    <option value="">&nbsp;</option>
                                    @foreach($region as $SKey => $r_value)
                                        <option value="{!! $r_value->id !!}">{!! $r_value->region !!}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3 col-sm-3">
                                <button type="submit" class="btn btn-primary full-width">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                @if(!empty($candidate_data))
                    @foreach($candidate_data as $Ckey => $c_value)
                        @php
                            $company_logo = site_header_logo;
                            $class_name = "no-image";
                            
                            if(isset($c_value->cover_image) && !empty($c_value->cover_image)){
                                $company_logo = url('uploads').'/candidate/'.$c_value->id.'/'.$c_value->cover_image;
                                $class_name = 'candidate-thumb';
                            }
                            $user_data = App\Models\UserDetail::userDataGet($c_value->id);
                        @endphp
                        <div class="col-md-4 col-sm-6">
                            <div class="top-candidate-wrap">
                                <div class="top-candidate-box">
                                    @if(isset($user_data->salary) && !empty($user_data->salary))<h4 class="flc-rate bg-warning tpc-status-custom">£{!! $user_data->salary !!}</h4>@endif
                                    <div class="tp-candidate-inner-box tp-candidate-inner-box-custom">
                                        <div class="top-candidate-box-thumb {{$class_name}} bg-trans-default">
                                            <img data-src="{{$company_logo}}" class="img-fluid img-circle lazyload" alt="" />
                                        </div>
                                        @if(isset($c_value->name) && !empty($c_value->name))
                                            <div class="top-candidate-box-detail">
                                                <h4>{!! $c_value->name !!} @if(isset($c_value->lname) && !empty($c_value->lname)){!! $c_value->lname !!}@endif</h4>
                                                @php
                                                    $location = null;
                                                    $check_location = App\Models\UserDetail::locationGet($c_value->id);
                                                    if(isset($check_location) && !empty($check_location)){
                                                        $location = explode(",",$check_location);
                                                    }
                                                @endphp
                                                @if(isset($location) && !empty($location))
                                                    <div class="job-position">
                                                        <div class="mt-3 mb-2">
                                                            @foreach($location as $Lkey => $l_value)
                                                                @if($Lkey == 0)
                                                                    <span class="job-num"><i class="fa fa-map-marker"></i> {!! App\Models\Region::regionNameGet($l_value) !!}</span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    @php
                                        $key_skill = null;
                                        $check_skill = App\Models\UserDetail::keySkillGet($c_value->id);
                                        $lastcount = 0;
                                        if(isset($check_skill) && !empty($check_skill)){
                                            $key_skill = explode(",",$check_skill);
                                            $count = count($key_skill);
                                            $lastcount = $count - 2;
                                        }
                                    @endphp
                                    @if(isset($key_skill) && !empty($key_skill))
                                        <div class="top-candidate-box-extra bt-2">

                                            <ul>
                                                @foreach($key_skill as $Kkey => $k_value)
                                                    @if($Kkey == 0)
                                                        <li>{!! App\Models\JobSkill::getSkillName($k_value) !!}</li>
                                                    @endif
                                                    @if($Kkey == 1)
                                                        <li>{!! App\Models\JobSkill::getSkillName($k_value) !!}</li>
                                                    @endif
                                                @endforeach
                                                @if($lastcount > 0)
                                                    <li class="more-skill bg-primary">+{{$lastcount}}</li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{route('home.talentPoolDetail',['id' => $c_value->client_slug])}}" class="btn btn-paid-candidate bt-1">View Detail</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="talent-pagination row">
                {{ $candidate_data->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
@stop

@section('footerscripts')
@stop