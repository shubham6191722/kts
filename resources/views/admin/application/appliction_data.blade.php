@if(isset($data) && !empty($data))
    @php
        $user_id = $data->user_id;
        if($data->job_reference == '0'){
            $check_user = App\Models\User::checkUserActiveDeactive($user_id);
        }else{
            $check_user = true;
        }
    @endphp
    <ul class="nav gap-column mb-5">
        <li class="nav-item">
            <a class="nav-link appliction-tab-btn active" data-toggle="tab" href="#my_detail">Detail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link appliction-tab-btn" data-toggle="tab" id="tab_my_activity" href="#my_activity">Activity</a>
        </li>
    </ul>
    <div class="card card-custom card-stretch gutter-b custom-box">
        <div class="card-body p-6">
            <div class="tab-content mt-5" id="myActivityDetail">
                <div class="active tab-pane px-7" id="my_detail" role="tabpanel">
                    <div class="head-bar d-flex flex-md-row flex-column justify-content-between align-items-center">
                        <div class="icon-bar">
                            <ul class="mb-0 d-flex align-items-center list-unstyled">
                                {{-- @if($check_user) --}}
                                <li>
                                    <span data-toggle="modal" data-target="#kt_modal_mail">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-theme="dark" data-html="true" title="Mail">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </span>
                                </li>
                                {{-- <li>
                                    <span data-toggle="modal" data-target="#">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-theme="dark" data-html="true" title="Wish list">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    </span>
                                </li> --}}
                                <li>
                                    <span data-toggle="modal" data-target="#kt_modal_add_event">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-theme="dark" data-html="true" title="Interview">
                                            <i class="fas fa-calendar-alt"></i>
                                        </a>
                                    </span>
                                </li>
                                @if(Auth::user()->role == 1)
                                    @if($managed_by == 1)
                                        <li>
                                            <a href="javascript:void(0);" class="kt_chat_modal_open" id="kt_chat_modal_open" data-toggle="tooltip" data-theme="dark" data-html="true" title="Message" data-job-id="{!! $job_id !!}" data-client-id="{!! $client_id !!}" data-candidate-id="{!! $candidate_id !!}" data-applied-id="{!! $applied_id !!}" data-created-id="{{Auth::user()->id}}" data-r-c-id="{!! $r_c_id !!}" data-message-id="{{ $message_id }}" >
                                                <i class="fab fa-rocketchat"></i>
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a href="javascript:void(0);" class="kt_chat_modal_open" id="kt_chat_modal_open" data-toggle="tooltip" data-theme="dark" data-html="true" title="Message" data-job-id="{!! $job_id !!}" data-client-id="{!! $client_id !!}" data-candidate-id="{!! $candidate_id !!}" data-applied-id="{!! $applied_id !!}" data-created-id="{{Auth::user()->id}}" data-r-c-id="{!! $r_c_id !!}" data-message-id="{{ $message_id }}" >
                                            <i class="fab fa-rocketchat"></i>
                                        </a>
                                    </li>
                                @endif
                                @php
                                    $check_action = true;
                                    if(Auth::user()->role == 3){
                                        $check_data = App\Models\User::clientData(Auth::user()->created_user_id);
                                        if($check_data->offer_status == '0'){
                                            $check_action = true;
                                        }
                                        if ($check_data->offer_status == '1') {
                                            $check_action = false;
                                        }
                                    }
                                @endphp
                                @if($check_action)
                                    <li>
                                        <span data-toggle="modal" data-target="#kt_modal_offer">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-theme="dark" data-html="true" title="Offer">
                                                <i class="fas fa-pound-sign"></i>
                                            </a>
                                        </span>
                                    </li>
                                @endif
                                {{-- @endif --}}
                            </ul>
                        </div>
                        <div class="select-block mt-md-0 mt-4">
                            {{-- @if($check_user) --}}
                                <select class="form-control change_data_attr applided_change_stage" title="Choose one of the following..." tabindex="null" data-flowid="{!! $data->job_workflow_id !!}" data-stage="{!! $data->job_stage !!}" data-status="{!! $data->job_status !!}" data-id="{!! $data->job_id !!}" data-value="{!! $data->id !!}" data-new="0">
                                    <option value="" selected="selected" disabled>Make a decision on candidate</option>
                                    <option value="1">Successful</option>
                                    <option value="0">Unsuccessful</option>
                                </select>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="detail-bio">
                        <div class="detail-block mt-5">
                            <ul class="d-flex flex-column mb-0 p-0">
                                @php
                                    if($data->job_reference == "1"){
                                        $applictionUserName = App\Models\RecruiterCandidate::recruiterCandidateName($data->user_id);
                                        $town = '<span class="label label-lg label-light-primary label-inline">Recruitere</span>';
                                        $email = '';
                                        $applictionUserName = App\Models\RecruiterCandidate::recruiterCandidateName($data->user_id);


                                        $applictionUserName = App\Models\RecruiterCandidate::recruiterCandidateName($data->user_id);

                                        $getId = App\Models\RecruiterCandidate::getId($data->user_id);

                                        $clientData = App\Models\User::clientData($getId);

                                        if(isset($clientData->name) && !empty($clientData->name)){
                                            $name = $clientData->name;
                                        }
                                        if(isset($clientData->lname) && !empty($clientData->lname)){
                                            $lname = $clientData->lname;
                                        }
                                        if(isset($name) && !empty($name)){
                                            $recruitere_name = $name;
                                        }
                                        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                                            $recruitere_name = $name.' '.$lname;
                                        }

                                        if(isset($clientData->company_name) && !empty($clientData->company_name)){
                                            $company_name = $clientData->company_name;
                                        }

                                        $town = '<span class="label label-lg label-light-primary label-inline text-capitalize">Recruitere</span> <span class="label label-lg label-light-dark label-inline text-capitalize">'.$recruitere_name.'</span>';

                                        $email = $clientData->email;

                                        if(isset($data->managed_by) && !empty($data->managed_by)){
                                            if($data->managed_by == 1){
                                                $managed_by = '<span class="label label-lg label-light-primary label-inline">Re:Source</span> <span class="label label-lg label-light-info label-inline">Recruiter</span>';
                                            }else{
                                                $managed_by = '<span class="label label-lg label-light-warning label-inline">Direct</span> <span class="label label-lg label-light-info label-inline">Recruiter</span>';
                                            }
                                        }
                                        $number = '--';
                                    }else{
                                        $clientData = App\Models\User::clientData($data->user_id);
                                        if(isset($clientData->name) && !empty($clientData->name)){
                                            $name = $clientData->name;
                                        }
                                        if(isset($clientData->lname) && !empty($clientData->lname)){
                                            $lname = $clientData->lname;
                                        }
                                        if(isset($name) && !empty($name)){
                                            $applictionUserName = $name;
                                        }
                                        if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                                            $applictionUserName = $name.' '.$lname;
                                        }
                                        $number = '--';
                                        if(isset($clientData->phone) && !empty($clientData->phone)){
                                            $number = '+'.$clientData->c_code.''.$clientData->phone;
                                        }
                                        $town = $data->j_town;
                                        $email = $clientData->email;
                                    }
                                @endphp
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">name</p>
                                    <p class="mb-0 text-capitalize">{!! $applictionUserName !!}</p>
                                </li>
                                @if($data->job_reference == "1")
                                    <li class="d-flex justify-content-between align-items-center">
                                        <p class="title mb-0">Company Name</p>
                                        <p class="mb-0">{!! $company_name !!}</p>
                                    </li>
                                @else
                                @endif
                                @if($data->job_reference == "1")
                                @else
                                    <li class="d-flex justify-content-between align-items-center">
                                        <p class="title mb-0">location</p>
                                        <p class="mb-0">@if(isset($town) && !empty($town)){!! $town !!}@else{{'-'}}@endif</p>
                                    </li>
                                @endif
                                <li class="d-flex justify-content-between align-items-center">
                                    @if($data->job_reference == "1")
                                    <p class="title mb-0">Recruiter Email</p>
                                    @else
                                    <p class="title mb-0">Email</p>
                                    @endif
                                    <a href="#">{!! $email !!}</a>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">Salary</p>
                                    <p class="mb-0">@if(isset($data->salary_expectations) && !empty($data->salary_expectations))£{!! App\CustomFunction\CustomFunction::number_format($data->salary_expectations) !!}@endif</p>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">Phone Number</p>
                                    <p class="mb-0">{!! $number !!}</p>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">Notice Period</p>
                                    <p class="mb-0">@if(isset($data->notice_period) && !empty($data->notice_period)){!! $data->notice_period !!}@endif</p>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">Work Base Preference</p>
                                    <p class="mb-0">@if(isset($data->work_base_preferences) && !empty($data->work_base_preferences)){!! $data->work_base_preferences !!}@endif</p>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <p class="title mb-0">Advertisement Source</p>
                                    <p class="mb-0">@if(isset($data->job_advertised) && !empty($data->job_advertised)) {!! App\Models\AdvertisementOption::optionName($data->client_id,$data->job_advertised) !!} @else - @endif</p>
                                </li>

                                @if(isset($data->british_passport) && !empty($data->british_passport))
                                    <li class="d-flex justify-content-between align-items-center">
                                        <p class="title mb-0">Do you hold a British passport?</p>
                                        <p class="mb-0">@if($data->british_passport == 2) Yes @else No @endif</p>
                                    </li>
                                @endif

                                @if($data->british_passport == 1)
                                    @if(isset($data->work_in_the_uk_do_you_hold) && !empty($data->work_in_the_uk_do_you_hold))
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="title mb-0">What rights to work in the UK do you hold?</p>
                                            <p class="mb-0">{!! $data->work_in_the_uk_do_you_hold !!}</p>
                                        </li>
                                    @endif
                                @endif
                                @if($data->british_passport == 1)
                                    @if(isset($data->visa_expire_date) && !empty($data->visa_expire_date))
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="title mb-0">When does your visa expire?</p>
                                            @php
                                                $visa_expire_date = null;

                                                if(isset($data->visa_expire_date) && !empty($data->visa_expire_date)){
                                                    $time = strtotime($data->visa_expire_date);
                                                    $visa_expire_date = date('d-m-Y',$time);
                                                }
                                            @endphp
                                            <p class="mb-0">{!! $visa_expire_date !!}</p>
                                        </li>
                                    @endif
                                @endif
                                @if($data->british_passport == 1)
                                    @if($data->require_visa_sponsorship == 2)
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="title mb-0">Do you require VISA sponsorship?</p>
                                            <p class="mb-0">@if($data->require_visa_sponsorship == 2) No @else Yes @endif</p>
                                        </li>

                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="iframe-block mt-5">
                        @php
                            $fileUrl = null;
                            if(isset($data->cv_file) && !empty($data->cv_file)){
                                $file = $data->cv_file;
                                $check_ext = explode('.', $file);
                                $fileUrl = url('uploads').'/job_applied/'.$data->job_id.'/'.$file;
                            }
                        @endphp
                        @if(isset($fileUrl) && !empty($fileUrl))
                            @if($check_ext[1] == 'pdf')
                                <iframe src="{{$fileUrl}}#view=FitH" frameborder="0" height="400px" width="100%"></iframe>
                            @else
                                <div class="detail-block mt-5">
                                    <ul class="d-flex flex-column mb-0 p-0">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <p class="title mb-0 title-bold-custom">Download CV</p>
                                            <p class="mb-0">
                                                <a href="{{$fileUrl}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2 download-cv-btn" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download CV">
                                                    <span class="svg-icon svg-icon-md">
                                                        <i class="icon-xl fas fa-download app-download-color"></i>
                                                    </span>
                                                </a>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="tab-pane px-7" id="my_activity" role="tabpanel">
                    <div class="timeline timeline-6 timeline-6-custom mt-3">
                        @if(!empty($job_activity))
                            @foreach($job_activity as $AKey => $a_value)
                                @php
                                    $clientData = App\Models\User::clientData($a_value->user_id);

                                    $name = '';
                                    if(isset($clientData->name) && !empty($clientData->name)){
                                        $name = $clientData->name;
                                    }
                                    $lname = '';
                                    if(isset($clientData->lname) && !empty($clientData->lname)){
                                        $lname = $clientData->lname;
                                    }
                                    if(isset($name) && !empty($name)){
                                        $userName = $name;
                                    }
                                    if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                                        $userName = $name.' '.$lname;
                                    }

                                    if($clientData->role == 1){
                                        $text_class = 'text-success';
                                    }elseif($clientData->role == 2){
                                        $text_class = 'text-primary';
                                    }elseif($clientData->role == 3){
                                        $text_class = 'text-warning';
                                    }elseif($clientData->role == 4){
                                        $text_class = 'text-dark';
                                    }else{
                                        $text_class = 'text-info';
                                    }

                                    $tooltip_text = "Changed By: ".$userName;
                                    $text_action = $a_value->text;
                                    if($a_value->text === 'Mail Send.'){
                                        $tooltip_text = $tooltip_text.'<br/><br/>'.$a_value->description;
                                        $text_action = $a_value->text.' <span>'.App\Models\MailTemplate::getTemplateName($a_value->mail_template).'</span> (<span>'.App\Models\User::getUserName($a_value->user_id).'</sapn>)';
                                    }

                                @endphp

                                <div class="timeline-item align-items-start">
                                    @php
                                        $time = App\CustomFunction\CustomFunction::get_date_time_forment($a_value->created_at);
                                    @endphp
                                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg timeline-label-custom" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">{!! $time !!}</div>
                                    <div class="timeline-badge" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">
                                        <i class="fa fa-genderless {{$text_class}} icon-xl"></i>
                                    </div>
                                    <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3" data-placement="left" data-toggle="tooltip" data-theme="dark" data-html="true" title="{!! $tooltip_text !!}">{!! $text_action !!}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


<div class="modal fade" id="kt_modal_add_event" tabindex="-1" aria-labelledby="staticBackdrop" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-650px modal-xl">
        <div class="modal-content">
            <div class="form" id="kt_modal_add_event_form" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold" data-kt-calendar="title">Add Interview</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary kt_modal_add_event_close" data-id="kt_modal_add_event">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-9">
                        @if($data->job_reference == "1")
                            <h3 class="fw-bold" data-kt-calendar="title" style="display: flex;align-items: center;gap: 10px;">Candidate Name
                                    <span class="text-muted d-flex justify-content-center align-items-center gap-10">{!! $applictionUserName !!}
                                    {{-- <span class="label label-lg label-light-dark label-inline">{!! $company_name !!}</span> --}}
                                </span>
                            </h3>
                        @else
                            <h3 class="fw-bold" data-kt-calendar="title" style="display: flex;align-items: center;gap: 10px;">Candidate Name <span class="text-muted d-flex justify-content-center align-items-center gap-10">{!! $applictionUserName !!}</span></h3>
                        @endif
                    </div>
                    {{-- <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold required mb-2">Interview Title</label>
                            <div>
                                <input type="text" class="form-control" placeholder="" name="event_title" required />
                            </div>
                        </div>
                    </div> --}}
                    @php
                        $check_time_slot = null;
                        if(isset($data->client_id) && !empty($data->client_id)){
                            $check_time_slot = App\Models\User::checkTimeSolt($data->client_id);
                        }
                    @endphp

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="fv-row mb-9">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">Interview Stage</label>
                                    <div>
                                        <select class="form-control event_type" name="event_type" id="ev_event_type" required placeholder="Please Select">
                                            <option disabled selected>Please Select</option>
                                            <option value="Phone screen">Phone screen</option>
                                            <option value="1st interview">1st interview</option>
                                            <option value="2nd interview">2nd interview</option>
                                            <option value="3rd interview">3rd interview</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <div class="fv-row mb-9">
                                <div class="form-group">

                                    <input type="hidden" name="applied_id" id="ev_applied_id" value="@if(isset($data->id) && !empty($data->id)){!! $data->id !!}@endif" />
                                    <input type="hidden" name="vacancy_id" id="ev_vacancy_id" value="@if(isset($data->job_id) && !empty($data->job_id)){!! $data->job_id!!}@endif" />
                                    <input type="hidden" name="client_id" id="ev_client_id" value="@if(isset($data->client_id) && !empty($data->client_id)){!! $data->client_id!!}@endif" />
                                    <input type="hidden" name="user_id" id="ev_user_id" value="@if(isset($data->user_id) && !empty($data->user_id)){!! $data->user_id!!}@endif" />
                                    <input type="hidden" name="job_reference" id="ev_job_reference" value="@if(isset($data->job_reference) && !empty($data->job_reference)){!! $data->job_reference!!}@endif" />
                                    @if($data->job_reference == "1")
                                        @php
                                            $getId = App\Models\RecruiterCandidate::getId($data->user_id);
                                        @endphp
                                        <input type="hidden" name="r_c_id" id="ev_r_c_id" value="{!! $getId !!}" />
                                    @else
                                        <input type="hidden" name="r_c_id" id="ev_r_c_id" value="" />
                                    @endif

                                    <label class="fs-6 fw-semibold mb-2">Select attendees <small>(you can select multiple attendees users.)</small></label>
                                    <div class="select2_input_100">
                                        <select class="form-control select2 @if($check_time_slot == 2) staff_select_event  @endif" name="event_staff_select" id="ev_event_staff_select" multiple="multiple">
                                            @if(!empty($staff))
                                                @foreach($staff as $SKey => $s_value)
                                                    <option value="{!! $s_value->id !!}">{!! App\Models\User::getUserName($s_value->id) !!} @if($s_value->role == 2)( Main Client )@endif</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Interview type</label>
                            <div>
                                <select class="form-control interview_type" name="interview_type" id="ev_interview_type" required placeholder="Please Select">
                                    <option disabled selected>Please Select</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9" id="video_interview">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">video link</label>
                            <div>
                                <textarea type="text" class="form-control summernote" placeholder="" name="video_link" id="ev_video_link"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9" id="face_to_face_interview">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Interview Address</label>
                            <div>
                                <select class="form-control address_select" name="address_select" id="ev_address_select" placeholder="Please Select">
                                    <option disabled selected value>Please Select</option>
                                    @if(!empty($site_address_data))
                                        @foreach($site_address_data as $site_address_data => $s_a_value)
                                            <option value="{!! $s_a_value->id !!}">{!! $s_a_value->site_title !!}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Additional Information</label>
                            <div>
                                <textarea type="text" class="form-control" placeholder="" name="event_description" id="ev_event_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-lg-2 g-10">
                        <div class="col-md-6 col-sm-12 col-12" @if($check_time_slot == 1) style="display:block;" @else style="display:none;" @endif>
                            <div class="fv-row mb-9">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">Interview Date</label>
                                    <div>
                                        @php
                                            $tomorrow = date("d-m-Y", strtotime("+1 day"));
                                        @endphp
                                        <input class="form-control date" type="text" name="event_date" placeholder="Pick a date" id="ev_event_date" readonly value="{!! $tomorrow !!}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12" data-kt-calendar="datepicker" id="" @if($check_time_slot == 1) style="display:block;" @else style="display:none;" @endif>
                            <div class="fv-row mb-9">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">Interview Time</label>
                                    <div>
                                        <input class="form-control" type="text" name="event_time" placeholder="Pick a time" id="ev_event_time"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12" id=""  @if($check_time_slot == 2) style="display:block;" @else style="display:none;" @endif>
                            <div class="fv-row mb-9">
                                <div class="form-group">
                                    <label class="fs-6 fw-semibold mb-2">Time Slot Duration</label>
                                    <div>
                                        <select class="form-control" name="time_distance" id="ev_time_distance" required placeholder="Please Select">
                                            <option value="30">30</option>
                                            <option value="60" selected>60</option>
                                            <option value="90">90</option>
                                            <option value="120">120</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="check_time_slot" id="ev_check_time_slot" value="{!! $check_time_slot !!}"/>
                    <div class="row g-10" @if($check_time_slot == 2) style="display:block;" @else style="display:none;" @endif>
                        <div class="col-12">
                            <div class="" id="ev_event_time_label"></div>
                            <ul class="nav nav-stretch nav-pills nav-pills-custom nav-pills-active-custom d-flex mb-8 gap-5 align-items-center" id="ev_event_date_schedule">
                            </ul>
                            <div class="" id="ev_event_time_label_2"></div>
                            <div class="tab-content mb-6 add-bg-dray" id="ev_event_time_schedule">
                            </div>
                            <div class="" id="ev_event_time_label_3" style="display: none;"></div>
                            <div class="mb-6" id="ev_event_time_schedule_new_input">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" data-id="kt_modal_add_event" class="btn btn-light me-3 kt_modal_add_event_cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary kt_modal_add_event_submit" id="kt_modal_add_event_submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
                {{-- <div class="modal-footer flex-center">
                    <button type="reset" data-id="kt_modal_add_event" class="btn btn-light me-3 kt_modal_add_event_cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary kt_modal_add_event_submit" id="kt_modal_add_event_submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_offer" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-650px">
        <div class="modal-content">
            <div class="form" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold" data-kt-calendar="title">Offer of employment</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2 w-100 d-block"><b>Company:</b> {!! App\Models\User::clientCompany($data->client_id) !!}</label>
                            <label class="fs-6 fw-semibold mb-2 w-100 d-block"><b>Job Title:</b> {!! App\Models\JobVacancy::jobName($data->job_id) !!}</label>
                            @php
                                $hiring_manager = App\Models\JobApplied::hiringManager($data->job_id);
                                $hiring_manager_arr = explode(",",$hiring_manager);
                                $count = count($hiring_manager_arr);
                                if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                    $hiring = $hiring_manager_arr[0];
                                }else{
                                    $hiring = $data->client_id;
                                }
                            @endphp
                            <label class="fs-6 fw-semibold mb-2  w-100 d-block"><b>Hiring Manager:</b> {!! App\Models\User::getUserName($hiring) !!}</label>
                            <div>
                                <input type="hidden" name="applied_id" id="offer_applied_id" value="@if(isset($data->id) && !empty($data->id)){!! $data->id !!}@endif" />
                                <input type="hidden" name="vacancy_id" id="offer_vacancy_id" value="@if(isset($data->job_id) && !empty($data->job_id)){!! $data->job_id!!}@endif" />
                                <input type="hidden" name="client_id" id="offer_client_id" value="@if(isset($data->client_id) && !empty($data->client_id)){!! $data->client_id!!}@endif" />
                                <input type="hidden" name="user_id" id="offer_user_id" value="@if(isset($data->user_id) && !empty($data->user_id)){!! $data->user_id!!}@endif" />
                                <input type="hidden" name="job_reference" id="offer_job_reference" value="@if(isset($data->job_reference) && !empty($data->job_reference)){!! $data->job_reference!!}@endif" />
                                @if($data->job_reference == "1")
                                    @php
                                        $getId = App\Models\RecruiterCandidate::getId($data->user_id);
                                    @endphp
                                    <input type="hidden" name="r_c_id" id="offer_r_c_id" value="{!! $getId !!}" />
                                @else
                                    <input type="hidden" name="r_c_id" id="offer_r_c_id" value="" />
                                @endif
                                @if(isset($job_offer) && !empty($job_offer))
                                <input type="hidden" name="id" id="offer_id" value="@if(isset($job_offer->id) && !empty($job_offer->id)){!! $job_offer->id!!}@endif" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold required mb-2">Offered salary</label>
                            <div>
                                <div class="input-group input-group-lg ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-pound-sign"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" placeholder="Offered salary" name="offer_offered_salary" id="offer_offered_salary" value="@if(isset($job_offer->offered_salary) && !empty($job_offer->offered_salary)){!!$job_offer->offered_salary !!}@endif" required />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Suggested start date</label>
                            <div>
                                @php
                                    $newformat = null;
                                    if(isset($job_offer->suggested_date) && !empty($job_offer->suggested_date)){
                                        $time = strtotime($job_offer->suggested_date);

                                        $newformat = date('d-m-Y',$time);
                                    }
                                @endphp
                                <div class="input-group input-group-lg ">
                                    {{-- <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div> --}}
                                    <input class="form-control date" type="text" name="offer_suggested_date" id="offer_suggested_date" placeholder="Suggested start date" id="event_date" value="{!! $newformat !!}" required readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold required mb-2">Select Benefit Package</label>
                            <div>
                                <div>
                                    <select class="form-control interview_type" name="offer_benefit_package" id="offer_benefit_package"
                                        data-c-id="@if(isset($data->client_id) && !empty($data->client_id)){!! $data->client_id!!}@endif">
                                        <option value="" selected="selected" disabled="">Please Select</option>
                                        @if(!empty($benefit_package))
                                            @foreach($benefit_package as $bKey => $b_value)
                                                <option value="{!! $b_value->id !!}">{!! $b_value->title !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Benefits Package</label>
                            <div>
                                <textarea type="text" class="form-control" placeholder="" name="offer_description" id="offer_description" rows="5">@if(isset($job_offer->description) && !empty($job_offer->description)){!! $job_offer->description !!}@endif</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-9">
                        <div class="form-group">
                            <label class="fs-6 fw-semibold mb-2">Official offer letter</label>
                            <div class="custom-file mb-4">
                                <input type="file" class="custom-file-input offer_letter_data" name="offer_letter_file" accept="image/png, image/jpeg,application/pdf" id="offer_letter_file" data-id="{!! $data->user_id !!}" />
                                <label class="custom-file-label" for="offer_letter_file">Choose file</label>
                            </div>
                            <div class="w-100" id="error_msg_{{$data->user_id}}" style="display: none;">
                                <div class="alert alert-danger alert-block">
                                    <strong>Try to upload file less than 2MB!</strong>
                                    <button type="button" class="close fl-right b-none" data-id="{{$data->user_id}}">×</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-space-between">
                                <div>
                                    <small id="sh-text1" class="form-text text-muted">(png,jpg,pdf file allowed Max. Size 2mb)</small>
                                </div>
                                @if(isset($job_offer->offer_letter) && !empty($job_offer->offer_letter))
                                <div>
                                    @php
                                        $offer_letter_file = url('uploads').'/offer_letter/'.$job_offer->offer_letter;
                                    @endphp
                                    <input type="hidden" name="offer_letter" id="offer_letter" value="@if(isset($job_offer->offer_letter) && !empty($job_offer->offer_letter)){{$job_offer->offer_letter}}@endif"/>
                                    <a href="{{$offer_letter_file}}" class="btn btn-sm btn-light btn-hover-primary btn-icon mr-2" target="_blank" data-theme="dark" data-html="true" title="" data-toggle="tooltip" data-target="#skillEdit_0" data-original-title="Download">
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
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" data-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="offer_submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_mail" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="form" method="POST">
                @csrf
                <div class="modal-header">
                    <h2 class="fw-bold" data-kt-calendar="title">Mail</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row">
                        <div class="form-group m-0">
                            <label class="fs-6 fw-semibold required mb-2">Mail Template</label>
                            <div>
                                <div>
                                    <select class="form-control interview_type" name="mail_template" id="mail_template" required
                                        data-a-id="@if(isset($data->id) && !empty($data->id)){!! $data->id !!}@endif"
                                        data-v-id="@if(isset($data->job_id) && !empty($data->job_id)){!! $data->job_id!!}@endif"
                                        data-c-id="@if(isset($data->client_id) && !empty($data->client_id)){!! $data->client_id!!}@endif"
                                        data-u-id="@if(isset($data->user_id) && !empty($data->user_id)){!! $data->user_id!!}@endif"
                                        data-j-r-id="@if(isset($data->job_reference) && !empty($data->job_reference)){!! $data->job_reference!!}@endif"
                                        data-created-id="@if(isset(Auth::user()->id) && !empty(Auth::user()->id)){!! Auth::user()->id !!}@endif" >
                                        <option value="" selected="selected" disabled="">Please Select</option>
                                        @if(!empty($mail_template))
                                            @foreach($mail_template as $MKey => $m_value)
                                                <option value="{!! $m_value->id !!}">{!! $m_value->template_title !!}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="applied_id" id="mail_applied_id" value="@if(isset($data->id) && !empty($data->id)){!! $data->id !!}@endif" />
                                    <input type="hidden" name="vacancy_id" id="mail_vacancy_id" value="@if(isset($data->job_id) && !empty($data->job_id)){!! $data->job_id!!}@endif" />
                                    <input type="hidden" name="client_id" id="mail_client_id" value="@if(isset($data->client_id) && !empty($data->client_id)){!! $data->client_id!!}@endif" />
                                    <input type="hidden" name="user_id" id="mail_user_id" value="@if(isset($data->user_id) && !empty($data->user_id)){!! $data->user_id!!}@endif" />
                                    <input type="hidden" name="job_reference" id="mail_job_reference" value="@if(isset($data->job_reference) && !empty($data->job_reference)){!! $data->job_reference!!}@endif" />
                                    <input type="hidden" name="created_id" id="mail_created_id" value="{{Auth::user()->id}}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-0 mt-5">
                            <button type="button" data-toggle="modal" data-target="#kt_modal_mail_preview" id="btn_kt_modal_mail_preview" class="btn btn-info me-3 m-auto">Preview</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" data-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="mail_submit">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {

        "use strict";

        $('.select2').select2({placeholder: "Please Select"});

        $('.date').datepicker({
            rtl: KTUtil.isRTL(),
            autoclose: true,
            startDate: new Date(),
            // daysOfWeekHighlighted: "0,6",
            daysOfWeekDisabled: [0, 6],
            todayHighlight: true,
            format: 'dd-mm-yyyy',
        });

        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }
        var time = formatAMPM(dt);
        $("#ev_event_time").timepicker();

        $('body').on('click', '#kt_calendar_add', function(e) {
            $('#kt_modal_add_event').modal('show');
        });

        $('body').on('click', '.kt_modal_add_event_close', function(e) {
            e.preventDefault();
            var modal_name = $(this).attr('data-id');
            closeButton(modal_name);
        });

        $('body').on('click', '.kt_modal_add_event_cancel', function(e) {
            e.preventDefault();
            var modal_name = $(this).attr('data-id');
            closeButton(modal_name);
        });

        $('body').on('change', '.interview_type', function() {
            var value_interview = $(this).val();
            if(value_interview === "Video interview"){
                $('#video_interview').show();
                $('#face_to_face_interview').hide();
                $('#face_to_face_interview select[name="address_select"]').val('');
            }
            if(value_interview === "Telephone call"){
                $('#video_interview').hide();
                $('#face_to_face_interview').hide();
                $('#face_to_face_interview select[name="address_select"]').val('');
            }
            if(value_interview === "Face to face interview"){
                $('#video_interview').hide();
                $('#face_to_face_interview').show();
                $('#video_interview textarea[name="video_link"]').val('');
            }
        });

        $('body').on('change', '.event_type', function() {
            var value_interview = $(this).val();
            if(value_interview === "Phone screen"){
                $('#ev_interview_type').empty();
                $('#video_interview').hide();
                $('#face_to_face_interview').hide();

                var option = '<option disabled selected>Please Select</option>';
                option += '<option value="Telephone call">Telephone call</option>';
                option += '<option value="Video interview">Video interview</option>';
                $('#ev_interview_type').append(option).trigger('change');

            }else{
                $('#ev_interview_type').empty();
                $('#video_interview').hide();
                $('#face_to_face_interview').hide();

                var option = '<option disabled selected>Please Select</option>';
                option += '<option value="Face to face interview">Face to face interview</option>';
                option += '<option value="Video interview">Video interview</option>';
                $('#ev_interview_type').append(option).trigger('change');
            }
        });

    });

    function closeButton(modal_name) {
        Swal.fire({
            text: "Are you sure you would like to cancel?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, cancel it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                setTimeout(function () {
                    $('#'+modal_name).modal('hide');
                    $('#ev_event_type').prop('selectedIndex',0);
                    $('#ev_event_staff_select').val([]).trigger("change");
                    $('#ev_interview_type').prop('selectedIndex',0);
                    $('#ev_video_link').val('');
                    $('#ev_address_select').val('');
                    $('#ev_event_description').val('');
                    // $('#ev_event_date').val('');
                    $('#ev_address_select').prop('selectedIndex',0);;
                    $('#video_interview').css('display','none');
                    $('#face_to_face_interview').css('display','none');
                    // $('#ev_interview_type').css('display','none');
                }, 500);
            }
        });
    }

    var KTCalendarBasic = function() {

        var settings = {};

        var initTooltip = function(el) {
            var theme = el.data('theme') ? 'tooltip-' + el.data('theme') : '';
            var width = el.data('width') == 'auto' ? 'tooltop-auto-width' : '';
            var trigger = el.data('trigger') ? el.data('trigger') : 'hover';

            $(el).tooltip({
                trigger: trigger,
                template: '<div class="tooltip ' + theme + ' ' + width + '" role="tooltip">\
                    <div class="arrow"></div>\
                    <div class="tooltip-inner"></div>\
                </div>'
            });
        }

        var initTooltips = function() {
            // init bootstrap tooltips
            $('[data-toggle="tooltip"]').each(function() {
                initTooltip($(this));
            });
        }

        var initPopover = function(el) {
            var skin = el.data('skin') ? 'popover-' + el.data('skin') : '';
            var triggerValue = el.data('trigger') ? el.data('trigger') : 'hover';

            el.popover({
                trigger: triggerValue,
                template: '\
                <div class="popover ' + skin + '" role="tooltip">\
                    <div class="arrow"></div>\
                    <h3 class="popover-header"></h3>\
                    <div class="popover-body"></div>\
                </div>'
            });
        }

        var initPopovers = function() {
            // init bootstrap popover
            $('[data-toggle="popover"]').each(function() {
                initPopover($(this));
            });
        }

        var initFileInput = function() {
            // init bootstrap popover
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        }

        var initScroll = function() {
            $('[data-scroll="true"]').each(function() {
                var el = $(this);

                KTUtil.scrollInit(this, {
                    mobileNativeScroll: true,
                    handleWindowResize: true,
                    rememberPosition: (el.data('remember-position') == 'true' ? true : false),
                    height: function() {
                        if (KTUtil.isBreakpointDown('lg') && el.data('mobile-height')) {
                            return el.data('mobile-height');
                        } else {
                            return el.data('height');
                        }
                    }
                });
            });
        }

        var initAlerts = function() {
            // init bootstrap popover
            $('body').on('click', '[data-close=alert]', function() {
                $(this).closest('.alert').hide();
            });
        }

        var initCard = function(el, options) {
            // init card tools
            var el = $(el);
            var card = new KTCard(el[0], options);
        }

        var initCards = function() {
            // init card tools
            $('[data-card="true"]').each(function() {
                var el = $(this);
                var options = {};

                if (el.data('data-card-initialized') !== true) {
                    initCard(el, options);
                    el.data('data-card-initialized', true);
                }
            });
        }

        var initStickyCard = function() {
            if (typeof Sticky === 'undefined') {
                return;
            }

            var sticky = new Sticky('[data-sticky="true"]');
        }

        var initAbsoluteDropdown = function(context) {
            var dropdownMenu;

            if (!context) {
                return;
            }

            $('body').on('show.bs.dropdown', context, function(e) {
                dropdownMenu = $(e.target).find('.dropdown-menu');
                $('body').append(dropdownMenu.detach());
                dropdownMenu.css('display', 'block');
                dropdownMenu.position({
                    'my': 'right top',
                    'at': 'right bottom',
                    'of': $(e.relatedTarget),
                });
            }).on('hide.bs.dropdown', context, function(e) {
                $(e.target).append(dropdownMenu.detach());
                dropdownMenu.hide();
            });
        }

        var initAbsoluteDropdowns = function() {
            $('body').on('show.bs.dropdown', function(e) {
                // e.target is always parent (contains toggler and menu)
                var $toggler = $(e.target).find("[data-attach='body']");
                if ($toggler.length === 0) {
                    return;
                }
                var $dropdownMenu = $(e.target).find('.dropdown-menu');
                // save detached menu
                var $detachedDropdownMenu = $dropdownMenu.detach();
                // save reference to detached menu inside data of toggler
                $toggler.data('dropdown-menu', $detachedDropdownMenu);

                $('body').append($detachedDropdownMenu);
                $detachedDropdownMenu.css('display', 'block');
                $detachedDropdownMenu.position({
                    my: 'right top',
                    at: 'right bottom',
                    of: $(e.relatedTarget),
                });
            });

            $('body').on('hide.bs.dropdown', function(e) {
                var $toggler = $(e.target).find("[data-attach='body']");
                if ($toggler.length === 0) {
                    return;
                }
                // access to reference of detached menu from data of toggler
                var $detachedDropdownMenu = $toggler.data('dropdown-menu');
                // re-append detached menu inside parent
                $(e.target).append($detachedDropdownMenu.detach());
                // hide dropdown
                $detachedDropdownMenu.hide();
            });
        };

        return {
            init: function(settingsArray) {
                if (settingsArray) {
                    settings = settingsArray;
                }

                KTApp.initComponents();
            },

            initComponents: function() {
                initScroll();
                initTooltips();
                initPopovers();
                initAlerts();
                initFileInput();
                initCards();
                initStickyCard();
                initAbsoluteDropdowns();
            },

            initTooltips: function() {
                initTooltips();
            },

            initTooltip: function(el) {
                initTooltip(el);
            },

            initPopovers: function() {
                initPopovers();
            },

            initPopover: function(el) {
                initPopover(el);
            },

            initCard: function(el, options) {
                initCard(el, options);
            },

            initCards: function() {
                initCards();
            },

            initSticky: function() {
                initSticky();
            },

            initAbsoluteDropdown: function(context) {
                initAbsoluteDropdown(context);
            },

            block: function(target, options) {
                var el = $(target);

                options = $.extend(true, {
                    opacity: 0.05,
                    overlayColor: '#000000',
                    type: '',
                    size: '',
                    state: 'primary',
                    centerX: true,
                    centerY: true,
                    message: '',
                    shadow: true,
                    width: 'auto'
                }, options);

                var html;
                var version = options.type ? 'spinner-' + options.type : '';
                var state = options.state ? 'spinner-' + options.state : '';
                var size = options.size ? 'spinner-' + options.size : '';
                var spinner = '<span class="spinner ' + version + ' ' + state + ' ' + size + '"></span';

                if (options.message && options.message.length > 0) {
                    var classes = 'blockui ' + (options.shadow === false ? 'blockui' : '');

                    html = '<div class="' + classes + '"><span>' + options.message + '</span>' + spinner + '</div>';

                    var el = document.createElement('div');

                    $('body').prepend(el);
                    KTUtil.addClass(el, classes);
                    el.innerHTML = html;
                    options.width = KTUtil.actualWidth(el) + 10;
                    KTUtil.remove(el);

                    if (target == 'body') {
                        html = '<div class="' + classes + '" style="margin-left:-' + (options.width / 2) + 'px;"><span>' + options.message + '</span><span>' + spinner + '</span></div>';
                    }
                } else {
                    html = spinner;
                }

                var params = {
                    message: html,
                    centerY: options.centerY,
                    centerX: options.centerX,
                    css: {
                        top: '30%',
                        left: '50%',
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none',
                        width: options.width
                    },
                    overlayCSS: {
                        backgroundColor: options.overlayColor,
                        opacity: options.opacity,
                        cursor: 'wait',
                        zIndex: (target == 'body' ? 1100 : 10)
                    },
                    onUnblock: function() {
                        if (el && el[0]) {
                            KTUtil.css(el[0], 'position', '');
                            KTUtil.css(el[0], 'zoom', '');
                        }
                    }
                };

                if (target == 'body') {
                    params.css.top = '50%';
                    $.blockUI(params);
                } else {
                    var el = $(target);
                    el.block(params);
                }
            },

            unblock: function(target) {
                if (target && target != 'body') {
                    $(target).unblock();
                } else {
                    $.unblockUI();
                }
            },

            blockPage: function(options) {
                return KTApp.block('body', options);
            },

            unblockPage: function() {
                return KTApp.unblock('body');
            },

            getSettings: function() {
                return settings;
            }
        };
    }();

    jQuery(document).ready(function() {
        KTCalendarBasic.init();
    });
</script>
<script>
    var KTCkeditor = function() {
        // Private functions
        var demos = function() {
            $('.summernote').summernote({
                height: 100,
                disableDragAndDrop:true,
                dialogsInBody: true,
                toolbar: [
                    // ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['insert', ['link']],
                    // ['para', ['ul', 'ol', 'paragraph']],
                    // ['table', ['table']],
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
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTCkeditor.init();
    });
</script>
