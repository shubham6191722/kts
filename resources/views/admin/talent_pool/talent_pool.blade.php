@if(!empty($job_applied))
    @foreach($job_applied as $Ckey => $c_value)
        @php
            $company_logo = site_header_logo;
            $class_name = "no-image";
            
            if(isset($c_value->cover_image) && !empty($c_value->cover_image)){
                $company_logo = url('uploads').'/candidate/'.$c_value->id.'/'.$c_value->cover_image;
                $class_name = 'candidate-thumb';
            }
        @endphp
        <div class="col-xl-3 col-md-4 col-sm-4 col-12">
            <div class="card card-custom gutter-b card-stretch">
                <div class="top-candidate-wrap">
                    <a href="{{route($route_name.'.telantPootDetail',['id' => $c_value->client_slug])}}">
                    <div class="top-candidate-box">
                        <div class="tp-candidate-inner-box tp-candidate-inner-box-custom">
                            <div class="top-candidate-box-thumb {{$class_name}} bg-trans-default">
                                <img src="{{$company_logo}}" class="img-fluid img-circle" alt="" />
                            </div>
                            @if(isset($c_value->name) && !empty($c_value->name))
                                <div class="top-candidate-box-detail">
                                    <h4>{!! $c_value->name !!} @if(isset($c_value->lname) && !empty($c_value->lname)){!! $c_value->lname !!}@endif</h4>
                                    @php
                                        $location = 'United Kingdom';
                                        if(isset($c_value->location) && !empty($c_value->location)){
                                            $location = App\Models\Region::regionName($c_value->location);
                                        }
                                    @endphp
                                    @if(isset($location) && !empty($location))
                                        <div class="job-position d-flex justify-content-space-between">
                                            <div class="mt-3 mb-2">
                                                <span class="job-num"><i class="fa fa-map-marker-alt"></i> {!! $location !!}</span>
                                            </div>
                                            @if(isset($c_value->salary) && !empty($c_value->salary))
                                                <div class="mt-3 mb-2">
                                                    <span class="bg-warning tpc-status-custom">£ {!! $c_value->salary !!}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if(isset($c_value->noticeperiod) && !empty($c_value->noticeperiod))
                                        <div class="job-position d-flex justify-content-space-between">
                                            <div class="mt-3 mb-2">
                                                <span class="job-n-number-work"><strong>Notice period:-</strong>  {!! $c_value->noticeperiod !!}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($c_value->phone) && !empty($c_value->phone))
                                        <div class="job-position d-flex justify-content-space-between">
                                            <div class="mt-3 mb-2">
                                                <span class="job-n-number-work"><strong>Phone Number:-</strong>  {!! $c_value->phone !!}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($c_value->workbasepreference) && !empty($c_value->workbasepreference))
                                        <div class="job-position d-flex justify-content-space-between">
                                            <div class="mt-3 mb-2">
                                                <span class="job-n-number-work"><strong>Work Preference:-</strong>  {!! $c_value->workbasepreference !!}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @php
                            $key_skill = null;
                            $lastcount = 0;
                            if(isset($c_value->key_skills) && !empty($c_value->key_skills)){
                                $key_skill = explode(",",$c_value->key_skills);
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
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@endif