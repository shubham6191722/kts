@if(!empty($message_get))
    @foreach($message_get as $key => $value)
        @php
            $job_vacancy = App\Models\JobVacancy::find($value['job_id']);

            $clientCompany = '';

            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                $clientCompany = App\Models\SubCompany::getSubCompanyName($job_vacancy->sub_company);
            }else{
                $clientCompany = App\Models\User::clientCompany($value['client_id']);
            }

            if(isset($value['r_c_id']) && !empty($value['r_c_id'])){
                $user_id = Auth::user()->id;
                $user_role = Auth::user()->role;
                $check_if = false;

                if($user_role == 1){
                    $check_if = false;
                    $chat_name = 'Resource ATS';
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }elseif ($user_role == 2) {
                    $check_if = false;
                    $chat_name = $clientCompany;
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }elseif ($user_role == 3) {
                    $check_if = false;
                    $chat_name = $clientCompany;
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }elseif($user_role == 4){
                    $check_if = false;
                    $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($value['candidate_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                }
                if($user_role == 4){
                    if($value['client_id'] != $value['from_user_id']){
                        $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($value['candidate_id']);
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $check_if = true;
                    }else{
                        $chat_name = $clientCompany;
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $check_if = false;
                    }
                }else{
                    if($value['client_id'] != $value['from_user_id']){
                        $chat_name = App\Models\RecruiterCandidate::recruiterCandidateName($value['candidate_id']);
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $check_if = false;
                    }else{
                        $chat_name = $clientCompany;
                        $chat_image = strtoupper(substr($chat_name,0,1));
                        $check_if = true;
                    }
                }

                $chat_c_role = App\Models\User::getRoleChat($value['created_id']);
                $chat_c_name = null;
                if(isset($chat_c_role) && !empty($chat_c_role)){
                    $chat_c_role = App\Models\User::getRoleChat(Auth::user()->id);
                    if($user_role == 4){
                        if($value['client_id'] != $value['from_user_id']){
                            $chat_c_name = '('.App\Models\User::clientCompany($value['created_id']).')';
                        }else{
                            $chat_c_name = '('.App\Models\User::clientName($value['created_id']).')';
                        }
                    }else{
                        if($value['client_id'] != $value['from_user_id']){
                            $chat_c_name = '('.App\Models\User::clientCompany($value['created_id']).')';
                        }else{
                            $chat_c_name = '('.App\Models\User::clientName($value['created_id']).')';
                        }
                    }
                }

            }else{
                $user_id = Auth::user()->id;
                $user_role = Auth::user()->role;
                $check_if = false;
                if($user_role == 1){
                    $check_if = false;
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }elseif ($user_role == 2) {
                    $check_if = false;
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }elseif ($user_role == 3) {
                    $check_if = false;
                    if($value['client_id'] == $value['from_user_id']){
                        $check_if = true;
                    }
                }

                if($value['client_id'] == $value['from_user_id']){
                    $chat_name = $clientCompany;
                    $chat_image = strtoupper(substr($chat_name,0,1));
                }

                if($value['client_id'] != $value['from_user_id']){
                    $chat_name = App\Models\User::getUserName($value['candidate_id']);
                    $chat_image = strtoupper(substr($chat_name,0,1));
                    if(Auth::user()->role == 5){
                        $check_if = true;
                        $chat_name = 'You';
                    }
                }


                if(empty($value['job_id']) && empty($value['applied_id']) && empty($value['r_c_id'])){
                    if(Auth::user()->role == 1 ){
                        if($value['to_user_id'] == Auth::user()->id){
                            $chat_name = App\Models\User::getUserName($value['candidate_id']).'('.App\Models\User::clientCompany($value['candidate_id']).')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = false;
                        }else{
                            $chat_name = App\Models\User::getUserName($value['client_id']).'(Resource ATS)';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = true;
                        }
                    }elseif(Auth::user()->role == 2 ){

                        if($value['to_user_id'] == Auth::user()->id){

                            $chat_c_role = App\Models\User::getRoleChat($value['client_id']);
                            if($chat_c_role == 'Admin'){
                                $chat_name = App\Models\User::getUserName($value['client_id']).'(Resource ATS)';
                                $chat_image = strtoupper(substr($chat_name,0,1));
                                $check_if = false;
                            }

                            $chat_c_role = App\Models\User::getRoleChat($value['candidate_id']);
                            if($chat_c_role == 'Staff'){
                                $check_sub_client_or_not = App\Models\User::checkSubClientOrNot($value['client_id']);
                                $chat_name = App\Models\User::getUserName($value['candidate_id']).'('.App\Models\User::clientCompany($check_sub_client_or_not).')';
                                $chat_image = strtoupper(substr($chat_name,0,1));
                                $check_if = false;
                            }

                        }else{

                            $chat_c_role = App\Models\User::getRoleChat($value['candidate_id']);
                            if($chat_c_role == 'Client'){
                                if($value['to_user_id'] == Auth::user()->id){
                                    $chat_name = App\Models\User::getUserName($value['client_id']).'(Resource ATS)';
                                    $chat_image = strtoupper(substr($chat_name,0,1));
                                    $check_if = false;
                                }else{
                                    $chat_name = App\Models\User::getUserName($value['candidate_id']).'('.App\Models\User::clientCompany($value['candidate_id']).')';
                                    $chat_image = strtoupper(substr($chat_name,0,1));
                                    $check_if = true;
                                }
                            }

                            if($chat_c_role == 'Staff'){
                                $check_sub_client_or_not = App\Models\User::checkSubClientOrNot($value['client_id']);
                                $chat_name = App\Models\User::getUserName($value['client_id']).'('.App\Models\User::clientCompany($check_sub_client_or_not).')';
                                $chat_image = strtoupper(substr($chat_name,0,1));
                                $check_if = true;
                            }
                        }
                    }elseif(Auth::user()->role == 3 ){
                        if($value['to_user_id'] == Auth::user()->id){
                            $check_sub_client_or_not = App\Models\User::checkSubClientOrNot($value['client_id']);
                            $chat_name = App\Models\User::getUserName($value['client_id']).'('.App\Models\User::clientCompany($check_sub_client_or_not).')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = false;
                        }else{
                            $check_sub_client_or_not = App\Models\User::checkSubClientOrNot($value['client_id']);
                            $chat_name = App\Models\User::getUserName(Auth::user()->id).'('.App\Models\User::clientCompany($check_sub_client_or_not).')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = true;
                        }
                    }else{
                        if($value['to_user_id'] == Auth::user()->id){
                            $chat_name = App\Models\User::getUserName($value['candidate_id']).'('.App\Models\User::clientCompany($value['client_id']).')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = false;
                        }else{
                            $chat_name = App\Models\User::getUserName($value['client_id']).'('.App\Models\User::clientCompany($value['client_id']).')';
                            $chat_image = strtoupper(substr($chat_name,0,1));
                            $check_if = true;
                        }
                    }
                }

                $chat_c_role = App\Models\User::getRoleChat($value['created_id']);
                $chat_c_name = null;
                if(isset($chat_c_role) && !empty($chat_c_role)){
                    if(empty($value['job_id']) && empty($value['applied_id']) && empty($value['r_c_id'])){

                    }else{
                        $chat_c_role = App\Models\User::getRoleChat(Auth::user()->id);
                        // if(isset($chat_c_role) && !empty($chat_c_role)){
                        //     $chat_c_name = '('.App\Models\User::clientName($value['created_id']).')';
                        // }
                        $chat_c_name = '('.App\Models\User::clientName($value['created_id']).')';
                    }
                }
            }
        @endphp
        @if($check_if)
            <div class="d-flex flex-column mb-5 align-items-end">
                <div class="d-flex align-items-center">
                    <div>
                        <span class="text-muted font-size-sm">{!! App\CustomFunction\CustomFunction::get_time_difference($value['updated_at']) !!}</span>
                        <a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{!! $chat_name !!} {!! $chat_c_name !!}</a>
                    </div>
                    <div class="symbol symbol-circle symbol-40 ml-3">
                        <span class="symbol-label font-size-h5 font-weight-bold">{!! $chat_image !!}</span>
                    </div>
                </div>
                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">{!! $value['message'] !!}</div>
            </div>
        @else
            <div class="d-flex flex-column mb-5 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-40 mr-3">
                        <span class="symbol-label font-size-h5 font-weight-bold">{!! $chat_image !!}</span>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">{!! $chat_name !!} {!! $chat_c_name !!}</a>
                        <span class="text-muted font-size-sm">{!! App\CustomFunction\CustomFunction::get_time_difference($value['updated_at']) !!}</span>
                    </div>
                </div>
                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">{!! $value['message'] !!}</div>
            </div>
        @endif
    @endforeach
@endif
