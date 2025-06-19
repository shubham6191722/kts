@extends('frontend.layouts.common')
@section('title', 'Talent Pool')

@section('headerscripts')
@stop

@section('content')
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row justify-content-center inner-header-page p-t-0 bg-none m-b-50">
                <div class="col-md-8">
                    <div class="left-side-container d-flex align-items-center">
                        @php
                            $company_logo = site_header_logo;
                            $class_name = "no-image";
                            
                            if(isset($candidate_data->cover_image) && !empty($candidate_data->cover_image)){
                                $company_logo = url('uploads').'/candidate/'.$candidate_data->id.'/'.$candidate_data->cover_image;
                                $class_name = 'candidate-thumb';
                            }
                        @endphp
                        <div class="freelance-image d-flex align-items-center">
                            <div class="top-candidate-box-thumb candidate-thumb bg-trans-default d-flex align-items-center justify-content-center m-0">
                                <img data-src="{{$company_logo}}" class="img-fluid img-circle m-0 lazyload" alt="">
                            </div>
                        </div>
                        <div class="header-details m-0">
                            
                            @if(isset($candidate_data->name) && !empty($candidate_data->name))
                                <h4>
                                    {!! $candidate_data->name !!} @if(isset($candidate_data->lname) && !empty($candidate_data->lname)){!! $candidate_data->lname !!}@endif
                                    @if(isset($candidate_detail->salary) && !empty($candidate_detail->salary))
                                        <span class="pull-right">£ {!! $candidate_detail->salary !!}</span>
                                    @endif
                                </h4>
                            @endif
                            @if(isset($candidate_detail->sector) && !empty($candidate_detail->sector))
                                <p>{!! App\Models\JobSectors::JobSectorsName($candidate_detail->sector) !!}</p>
                            @endif
                            <ul>
                                <li>
                                    @php
                                        $location = 'United Kingdom';
                                        if(isset($candidate_detail->location) && !empty($candidate_detail->location)){
                                            $location = App\Models\Region::regionNameGet($candidate_detail->location);
                                        }
                                    @endphp
                                    <img class="flag" src="{{url('assets/frontend')}}/img/gb.svg" alt=""> {!! $location !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8">
                    <div class="container-detail-box">
                    
                        <div class="apply-job-header">
                            @if(isset($candidate_detail->sector) && !empty($candidate_detail->sector))
                                <a href="javascript:void(0)" class="cl-success">
                                    <span>
                                        <i class="fa fa-building"></i> {!! App\Models\JobSectors::JobSectorsName($candidate_detail->sector) !!}
                                    </span>
                                </a>
                            @endif
                            <span><i class="fa fa-map-marker"></i>{!! $location !!}</span>
                        </div>
                        @if(isset($candidate_detail->description) && !empty($candidate_detail->description))
                            <div class="apply-job-detail">
                                {!! $candidate_detail->description !!}
                            </div>
                        @endif
                        
                        @php
                            $key_skill = null;
                            if(isset($candidate_detail->key_skills) && !empty($candidate_detail->key_skills)){
                                $key_skill = explode(",",$candidate_detail->key_skills);
                            }
                        @endphp
                        @if(isset($key_skill) && !empty($key_skill))
                            <div class="apply-job-detail">
                                <h5>Skills</h5>
                                <ul class="skills">
                                    @foreach($key_skill as $Kkey => $k_value)
                                        <li>{!! App\Models\JobSkill::getSkillName($k_value) !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footerscripts')
@stop