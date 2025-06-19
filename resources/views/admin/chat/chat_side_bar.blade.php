@if(isset($data) && !empty($data) && count($data))
    @foreach($data as $Mkey => $m_value)
        @php
            $job_vacancy = App\Models\JobVacancy::find($m_value['job_id']);

            $clientCompany = '';

            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                $clientCompany = App\Models\SubCompany::getSubCompanyName($job_vacancy->sub_company);
            }else{
                $check_sub_client_or_not = App\Models\User::checkSubClientOrNot($m_value['client_id']);
                $clientCompany = App\Models\User::clientCompany($check_sub_client_or_not);
            }

            if((Auth::user()->role == 2) || (Auth::user()->role == 3)){
                if($m_value['r_c_id']){
                    $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']).' - '.App\Models\User::clientCompany($m_value['r_c_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '<span class="label label-lg label-light-info label-inline">Agency candidate</span>';
                }else{
                    $chat_name = App\Models\User::getUserName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $check_job = App\Models\JobVacancy::checkJobResourceOrDirect($m_value['job_id']);
                    $label_name = '';
                    if(isset($check_job) && !empty($check_job)){
                        if($check_job == 'Resource'){
                            $label_name = '<span class="label label-lg label-light-warning label-inline">'.$check_job.' candidate</span>';
                        }else{
                            $label_name = '<span class="label label-lg label-light-dark label-inline">'.$check_job.' candidate</span>';
                        }
                    }
                }
                if(Auth::user()->role == 5){
                    $chat_name = App\Models\JobVacancy::jobName($m_value['job_id']).' - '.$clientCompany;
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '';
                }

                // if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                //     $chat_name = App\Models\User::getUserName($m_value['staff_id']).' ('.$clientCompany.')';
                //     $chat_image = strtoupper(substr($chat_name,0,1));
                //     $label_name = '<span class="label label-lg label-light-success label-inline">Internal1</span>';
                // }
                if(Auth::user()->role == 3){
                    if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                        $chat_name = App\Models\User::getUserName($m_value['client_id']).' ('.$clientCompany.')';
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $label_name = '<span class="label label-lg label-light-success label-inline">Internal</span>';
                    }
                }

                if(empty($m_value['job_id']) && empty($m_value['applied_id'])){
                    if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                        $chat_name = App\Models\User::getUserName($m_value['staff_id']).' ('.$clientCompany.')';
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $label_name = '<span class="label label-lg label-light-success label-inline">Internal</span>';
                    }else{
                        $chat_name = App\Models\User::getUserName($m_value['client_id']).' (Resource ATS)';
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $label_name = '<span class="label label-lg label-light-success label-inline">Internal</span>';
                    }
                    if(Auth::user()->role == 3){
                        if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                            $chat_name = App\Models\User::getUserName($m_value['client_id']).' ('.$clientCompany.')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $label_name = '<span class="label label-lg label-light-success label-inline">Internal</span>';
                        }
                    }
                }

            }else{
                if($m_value['r_c_id']){
                    $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']).' - '.App\Models\User::clientCompany($m_value['r_c_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '';
                    $check_admin_message = App\Models\MessageCount::checkMessageForAdmin($m_value['id']);
                    if(isset($check_admin_message) && !empty($check_admin_message)){
                        $label_name = '<span class="label label-lg label-light-warning label-inline">'.$check_admin_message.'</span>';
                    }
                }else{
                    $chat_name = App\Models\User::getUserName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '';
                }
                if(Auth::user()->role == 5){
                    $chat_name = App\Models\JobVacancy::jobName($m_value['job_id']).' - '.$clientCompany;
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '';
                    $check_admin_message = App\Models\MessageCount::checkMessageForAdmin($m_value['id']);
                    if(isset($check_admin_message) && !empty($check_admin_message)){
                        $label_name = '<span class="label label-lg label-light-warning label-inline">'.$check_admin_message.'</span>';
                    }
                }
                if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                    $chat_name = App\Models\User::getUserName($m_value['staff_id']).' ('.$clientCompany.')';
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    $label_name = '';
                }
                if(Auth::user()->role == 3){
                    if(isset($m_value['staff_id']) && !empty($m_value['staff_id'])){
                        $chat_name = App\Models\User::getUserName($m_value['client_id']).' ('.$clientCompany.')';
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $label_name = '';
                    }
                }
                if(Auth::user()->role == 1){
                    if(isset($m_value['created_id']) && !empty($m_value['created_id'])){
                        if(empty($m_value['job_id']) && empty($m_value['applied_id'])){
                            $clientCompany = App\Models\User::clientCompany($m_value['candidate_id']);
                            $chat_name = App\Models\User::getUserName($m_value['candidate_id']).' ('.$clientCompany.')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $label_name = '<span class="label label-lg label-light-success label-inline">Internal</span>';
                        }else{
                            if(isset($m_value['r_c_id']) && !empty($m_value['r_c_id'])){
                                $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']).' - '.App\Models\User::clientCompany($m_value['r_c_id']);
                                $chat_image = strtoupper(substr($chat_name,0,1));
                                $label_name = '<span class="label label-lg label-light-info label-inline">Agency candidate</span>';
                            }else{
                                $chat_name = App\Models\User::getUserName($m_value['candidate_id']).' - '.App\Models\JobVacancy::jobName($m_value['job_id']);
                                $chat_image = strtoupper(substr($chat_name,0,1));
                                $label_name = '';
                            }
                        }
                    }
                }
            }
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $client_id = Auth::user()->created_user_id;
            }else{
                $client_id = Auth::user()->id;
            }

            $check_user_delete = true;
            if(isset($m_value['candidate_id']) && !empty($m_value['candidate_id'])){
                $check_user_delete = App\Models\User::checkUserDelete($m_value['candidate_id']);
            }
        @endphp
        @if($check_user_delete)
            <div class="chat_message_on_click message_id_{{$m_value['id']}}" data-job-id="{{$m_value['job_id']}}" data-client-id="{{$m_value['client_id']}}" data-candidate-id="{{$m_value['candidate_id']}}" data-applied-id="{{$m_value['applied_id']}}" data-created-id="{{Auth::user()->id}}" data-r-c-id="{{$m_value['r_c_id']}}" data-message-id="{{$m_value['id']}}">
                <div class="d-flex align-items-center justify-content-between mb-5 bg-add">
                    <div class="d-flex align-items-center w-70">
                        <div class="symbol symbol-circle symbol-50 mr-3">
                            <span class="symbol-label font-size-h5 font-weight-bold">{{$chat_image}}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg">{{$chat_name}}  {!! $label_name !!}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-5 w-30">
                        <span class="text-muted font-weight-bold font-size-sm">{!! App\CustomFunction\CustomFunction::get_time_difference($m_value['updated_at']) !!}</span>
                        <div id="chat_message_count_{{$m_value['id']}}">
                            @if(Auth::user()->role == 5)
                                @if(isset($m_value['u_count']) && !empty($m_value['u_count']))
                                    <div class="message-count">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <span class="d-flex justify-content-center align-items-center dis-message-count">{{$m_value['u_count']}}</span>
                                        </span>
                                    </div>
                                @endif
                            @elseif(Auth::user()->role == 4)
                                @if(isset($m_value['u_count']) && !empty($m_value['u_count']))
                                    <div class="message-count">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <span class="d-flex justify-content-center align-items-center dis-message-count">{{$m_value['u_count']}}</span>
                                        </span>
                                    </div>
                                @endif
                            @elseif(Auth::user()->role == 3)
                                @if(empty($m_value['job_id']) && empty($m_value['applied_id']))
                                    @if(Auth::user()->id == $m_value['staff_id'])
                                        @if(isset($m_value['u_count']) && !empty($m_value['u_count']))
                                            <div class="message-count">
                                                <span class="d-flex justify-content-center align-items-center">
                                                    <span class="d-flex justify-content-center align-items-center dis-message-count">{{$m_value['u_count']}}</span>
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @elseif(Auth::user()->role == 2)
                                @if(empty($m_value['job_id']) && empty($m_value['applied_id']))
                                    @if(Auth::user()->id == $m_value['candidate_id'])
                                        @if(isset($m_value['u_count']) && !empty($m_value['u_count']))
                                            <div class="message-count">
                                                <span class="d-flex justify-content-center align-items-center">
                                                    <span class="d-flex justify-content-center align-items-center dis-message-count">{{$m_value['u_count']}}</span>
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if(isset($m_value['count']) && !empty($m_value['count']))
                                    <div class="message-count">
                                        <span class="d-flex justify-content-center align-items-center">
                                            <span class="d-flex justify-content-center align-items-center dis-message-count">{{$m_value['count']}}</span>
                                        </span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
