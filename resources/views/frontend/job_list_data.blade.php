@if(!empty($job_data))
    @foreach($job_data as $key => $value)
        @php
            $client_data = App\Models\User::clientData($value->user_select);
            $client_detail = App\Models\ClientDetail::getData($value->user_select);

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
        <div class="newjob-list-layout">
            <a href="{{route('getJobDetail',['id' => $value->slug])}}" class="newjob-list-custom">
                <div class="d-flex align-items-center mobile-center">
                    <div class="brows-job-company-img job-company-custom m-0">
                        <img data-src="{{$company_logo}}" class="img-responsive lazyload" alt="">
                    </div>
                    <div class="cll-caption m-0">
                        <h4>
                            @if(isset($value->jobtitle) && !empty($value->jobtitle)){!! $value->jobtitle !!}@endif

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