@if(!empty($job_applied))
    @foreach($job_applied as $key => $value)
        @php
            if(isset($value->company_logo) && !empty($value->company_logo)){
                $logo =  url('uploads').'/client_profile/'.$value->company_logo;
            }else{
                $logo = site_header_logo;
            }
            $job_id = $value->job_id;
            $client_id = $value->client_id;
            $candidate_id = $value->user_id;
            $applied_id = $value->id;
            $staff_id = null;
            $r_c_id = null;
            $check_admin = null;
            if(isset($value->job_reference) && !empty($value->job_reference)){
                $r_c_id = App\Models\RecruiterCandidate::getId($value->user_id);
            }
            $message_id = App\Models\MessageCount::messageIdGet($client_id,$staff_id,$candidate_id,$applied_id,$job_id,$check_admin);

            $company_name = $value->company_name;
            if(isset($value->sub_company) && !empty($value->sub_company)){
                $client_detail = App\Models\SubCompany::getSubCompanyData($value->sub_company);
                $logo =  url('uploads').'/client_profile/'.$client_detail->company_logo;
                $company_name = $client_detail->company_name;
            }
        @endphp
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-custom gutter-b card-stretch position-relative">
                <a href="#">
                    <div class="card-body pt-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center mb-5">
                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                <div class="symbol h-50 align-self-center img-fluid p-5px bg-light">
                                    <img alt="Pic" src="{{$logo}}" class="object-fit-contain">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                @if(isset($value->jobtitle) && !empty($value->jobtitle))
                                <p class="text-dark font-weight-bold font-size-h4 mb-0">{!! $value->jobtitle !!}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            @if(isset($value->locatedregion) && !empty($value->locatedregion))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Company:</span>
                                    <span class="text-muted font-weight-bold text-right">{!! $company_name !!}</span>
                                </div>
                            @endif
                            
                            @if(isset($value->locatedregion) && !empty($value->locatedregion))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Location:</span>
                                    <span class="text-muted font-weight-bold text-right">{!! App\Models\Region::regionName($value->locatedregion) !!}</span>
                                </div>
                            @endif
                            
                            @if(isset($value->work_base_preferences) && !empty($value->work_base_preferences))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Work Base Preferences:</span>
                                    <span class="text-muted font-weight-bold text-right">{!! $value->work_base_preferences !!}</span>
                                </div>
                            @endif

                            @if(isset($value->salary_expectations) && !empty($value->salary_expectations))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Salary:</span>
                                    <span class="text-muted font-weight-bold text-right">£{!! $value->salary_expectations !!}</span>
                                </div>
                            @endif
                            @php
                                $hiring_manager = App\Models\JobApplied::hiringManager($value->job_id);
                                $hiring_manager_arr = explode(",",$hiring_manager);
                                $count = count($hiring_manager_arr);
                                if(isset($hiring_manager_arr[0]) && !empty($hiring_manager_arr[0])){
                                    $hiring = $hiring_manager_arr[0];
                                }else{
                                    $hiring = $value->client_id;
                                }
                            @endphp

                            @if(isset($hiring) && !empty($hiring))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Hiring Manager:</span>
                                    <span class="text-muted font-weight-bold text-right">{!! App\Models\User::getUserName($hiring) !!}</span>
                                </div>
                            @endif

                            @if($value->job_new == 0)
                                @if($value->job_status == 1)
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Status:</span>
                                        <div>
                                            <span class="label label-lg label-light-success label-inline">Success</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Stage:</span>
                                        <div>
                                            @php
                                                $job_stage = $value->job_stage;
                                                $job_workflow_id = $value->job_workflow_id;
                                                $satge_name = App\Models\JobWorkFlowStage::candidateStageGet($job_stage,$job_workflow_id);
                                            @endphp
                                            <span class="label label-lg label-light-primary label-inline">@if(isset($satge_name->stage_name) && !empty($satge_name->stage_name)){!! $satge_name->stage_name !!}@endif</span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Status:</span>
                                        <div>
                                            <span class="label label-lg label-light-danger label-inline">Unsuccessful</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Stage:</span>
                                        <div>
                                            @php
                                                $job_stage = $value->job_stage;
                                                $job_workflow_id = $value->job_workflow_id;
                                                $satge_name = App\Models\JobWorkFlowStage::candidateStageGet($job_stage,$job_workflow_id);
                                            @endphp
                                            <span class="label label-lg label-light-primary label-inline">@if(isset($satge_name->stage_name) && !empty($satge_name->stage_name)){!! $satge_name->stage_name !!}@endif</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Status:</span>
                                    <div>
                                        <span class="label label-lg label-light-warning label-inline">Pending</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-dark-75 font-weight-bolder mr-2">Stage:</span>
                                    <div>
                                        @php
                                            $job_stage = $value->job_stage;
                                            $job_workflow_id = $value->job_workflow_id;
                                            $satge_name = App\Models\JobWorkFlowStage::candidateStageGet($job_stage,$job_workflow_id);
                                        @endphp
                                        <span class="label label-lg label-light-primary label-inline">@if(isset($satge_name->stage_name) && !empty($satge_name->stage_name)){!! $satge_name->stage_name !!}@endif</span>
                                    </div>
                                </div>
                            @endif

                            @if(isset($message_id) && !empty($message_id))
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="javascript:void(0);" class="btn btn-sm btn-light-primary fw-bold kt_chat_modal_open" id="kt_chat_modal_open" data-job-id="{!! $job_id !!}" data-client-id="{!! $client_id !!}" data-candidate-id="{!! $candidate_id !!}" data-applied-id="{!! $applied_id !!}" data-created-id="{{Auth::user()->id}}" data-r-c-id="{!! $r_c_id !!}" data-message-id="{{ $message_id }}">Send Message</a>
                            </div>
                            @endif

                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@endif