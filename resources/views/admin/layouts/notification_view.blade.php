@php
    $u_id = Auth::user()->id;
    if(Auth::user()->role == 2){
        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $u_id = Auth::user()->created_user_id;
        }else{
            $u_id = Auth::user()->id;
        }
    }
    $notification = App\Models\Notifications::getNotification($u_id);
    $route_name = App\CustomFunction\CustomFunction::role_name();
    $url = $route_name.".dashboard";
    $route = route($url);
    $notofication_name = '';
    $name = '';
@endphp
@if(isset($notification) && !empty($notification))
    @foreach($notification as $Nkey => $noti_value)

        @if($noti_value->notifications_type == 'new_job_created')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".vacancyList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_id = App\Models\JobVacancy::jobUser($noti_value->job_id);
                    $user_name = App\Models\User::clientCompany($user_id);
                    $name = '<span class="text-bold-500">'.$jobName.'</span> by <span class="text-bold-500">'.$user_name.'</span>';
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".vacancyList";
                    $route = route($url);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $jobData = App\Models\JobVacancy::jobGet($noti_value->job_id);
                    $getRole = App\Models\User::getRole($jobData->user_id);
                    $notofication_name = 'New job created by <span class="text-bold-500">'.$getRole.'</span>';
                    $name = $jobName;
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".vacancyList";
                    $route = route($url);
                    $notofication_name = 'New job created';
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_id = App\Models\JobVacancy::jobUser($noti_value->job_id);
                    $user_name = App\Models\User::clientCompany($user_id);
                    $name = '<span class="text-bold-500">'.$jobName.'</span> by <span class="text-bold-500">'.$user_name.'</span>';
                }elseif(Auth::user()->role == 4){
                    $notofication_name = 'New job created';
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_id = App\Models\JobVacancy::jobUser($noti_value->job_id);
                    $user_name = App\Models\User::clientCompany($user_id);
                    $name = '<span class="text-bold-500">'.$jobName.'</span> by <span class="text-bold-500">'.$user_name.'</span>';
                }
            @endphp
        @endif
        
        @if($noti_value->notifications_type == 'new_job_application')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".jobApplied";
                    $route = route($url,["id" => $noti_value->job_id]);
                    $notofication_name = 'New job application received';
                    $userName = App\Models\User::getUserName($noti_value->job_applied_user);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $name = '<span class="text-bold-500">'.$userName.'</span> applied on <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::clientCompany($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$recruiterName.'</span>, add new job application for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".jobApplied";
                    $route = route($url,["id" => $noti_value->job_id]);
                    $notofication_name = 'New job application received';
                    $userName = App\Models\User::getUserName($noti_value->job_applied_user);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $name = '<span class="text-bold-500">'.$userName.'</span> applied on <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::clientCompany($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$recruiterName.'</span>, add new job application for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".jobApplied";
                    $route = route($url,["id" => $noti_value->job_id]);
                    $notofication_name = 'New job application received';
                    $userName = App\Models\User::getUserName($noti_value->job_applied_user);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $name = '<span class="text-bold-500">'.$userName.'</span> applied on <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::clientCompany($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$recruiterName.'</span>, add new job application for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'new_event')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $notofication_name = $noti_value->notifications_content;
                    $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    $url = $route_name.".dashboard";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'update_event')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $notofication_name = $noti_value->notifications_content;
                    $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    $url = $route_name.".dashboard";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'new_offer')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));

                    $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'(Recruiter Candidate).</span>';
                    }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));

                    $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'(Recruiter Candidate).</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));

                    $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = '<span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'(Recruiter Candidate).</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                    $notofication_name = 'New offer received';
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $name = 'In <span class="text-bold-500">'.$jobName.'</span> created by <span class="text-bold-500">'.$clien_name.'</span> for <span class="text-bold-500">'.$user_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    $url = $route_name.".offerGet";
                    $route = route($url);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $notofication_name = 'New offer received';
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> created by  <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'offer_accepted')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                    
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'offer_declined')
            @php
                if(Auth::user()->role == 1){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".offerList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $name = 'By <span class="text-bold-500">'.$user_name.'</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $user_name = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->r_c_id);
                        $recruiterName = App\Models\User::getUserName($noti_value->job_applied_user);
                        $name = 'By <span class="text-bold-500">'.$user_name.'(Recruiter Candidate)</span> for <span class="text-bold-500">'.$jobName.'</span>';
                    }
                }
            @endphp
        @endif

        @if($noti_value->notifications_type == 'new_event_time_schedule')
            @php
                if(Auth::user()->role == 1){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                    //     $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    //     $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                    //     $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $notofication_name = $noti_value->notifications_content;
                    // $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    // $url = $route_name.".dashboard";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif
        
        @if($noti_value->notifications_type == 'new_event_time_reject')
            @php
                if(Auth::user()->role == 1){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                    //     $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    //     $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                    //     $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $notofication_name = $noti_value->notifications_content;
                    // $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    // $url = $route_name.".dashboard";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif
        
        @if($noti_value->notifications_type == 'new_event_time_cancel')
            @php
                if(Auth::user()->role == 1){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                    //     $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    //     $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                    //     $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    // }
                }elseif(Auth::user()->role == 2){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';

                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 3){
                    $url = $route_name.".eventList";
                    $route = route($url);
                    $notofication_name = $noti_value->notifications_content;
                    $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    $user_name = App\Models\User::getUserName($noti_value->job_applied_user);
                    $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    if(isset($noti_value->r_c_id) && !empty($noti_value->r_c_id)){
                        $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                        $recruiterName = App\Models\User::getUserName($noti_value->r_c_id);
                        $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                    }
                }elseif(Auth::user()->role == 4){
                    // $url = $route_name.".eventList";
                    // $route = route($url);
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $notofication_name = $noti_value->notifications_content;
                    // $cname = App\Models\RecruiterCandidate::recruiterCandidateName($noti_value->job_applied_user);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }elseif(Auth::user()->role == 5){
                    // $url = $route_name.".dashboard";
                    // $route = route($url);
                    // $notofication_name = $noti_value->notifications_content;
                    // $jobName = App\Models\JobVacancy::jobName($noti_value->job_id);
                    // $clien_name = App\Models\User::clientCompany(App\Models\JobVacancy::jobUser($noti_value->job_id));
                    // $created_user = App\Models\User::getUserName($noti_value->created_user_id);
                    // $name = 'For <span class="text-bold-500">'.$jobName.'</span> assigned by <span class="text-bold-500">'.$clien_name.'</span>';
                }
            @endphp
        @endif

        <a href="javascript:;" class="navi-item notifi-custom @if($noti_value->status == 0) click-chage-status @else click-notification-url @endif" data-id="{!! $noti_value->id !!}" data-action="status" data-value="1" data-url="{!! $route !!}">
            <div class="navi-link rounded">
                <div class="symbol symbol-50 mr-3">
                    <div class="symbol-label">
                        <i class="flaticon-bell text-success icon-lg"></i>
                    </div>
                </div>
                <div class="navi-text">
                    <div class="font-weight-bold font-size-lg">{!! $notofication_name !!}</div>
                    <div class="text-muted">{!! $name !!}</div>
                </div>
            </div>
        </a>
    @endforeach
@endif