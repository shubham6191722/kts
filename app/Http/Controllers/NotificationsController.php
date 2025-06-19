<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\MailNotificationInQueue;
use App\CustomFunction\CustomFunction;
use App\Http\Controllers\notification\EventNotificationsController;
use App\Http\Controllers\notification\OfferNotificationsController;
use App\Http\Controllers\notification\NewApplicationNotificationsController;
use App\Http\Controllers\notification\NewJobNotificationsController;
use App\Http\Controllers\notification\EventMailNotificationsController;
use App\Http\Controllers\notification\OfferMailNotificationsController;
use App\Http\Controllers\notification\NewApplicationMailNotificationsController;
use App\Http\Controllers\notification\MailNewJobNotificationsController;

use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Notifications;
use App\Models\UserDetail;
use App\Models\JobVacancy;
use App\Models\MailNotifications;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\OutlookEvent;
use App\Models\JobEvent;

class NotificationsController extends Controller
{

    /**
     * New Job Notifications
    */
    public static function notification($data){

        if(isset($data->staff_arr) && !empty($data->staff_arr)){
            $staff_select = explode(',', $data->staff_arr);
            foreach($staff_select as $StaffKey => $value){
                // if($data->managed_by == 2){

                    $s_id = $value;
                    NewJobNotificationsController::notificationNewJobStaff($data,$s_id);
                    MailNewJobNotificationsController::notificationNewJobStaffMail($data,$s_id);
                // }
        
            }
        }

        if(isset($data->recruiter_arr) && !empty($data->recruiter_arr)){
            $recruiter_select = explode(',', $data->recruiter_arr);
            foreach($recruiter_select as $RecruiterKey => $value){

                $r_id = $value;
                NewJobNotificationsController::notificationNewJobRecruiter($data,$r_id);
                MailNewJobNotificationsController::notificationNewJobRecruiterMail($data,$r_id);

            }
        }

        if($data->user_id != $data->user_select){
            if(isset($data->user_select) && !empty($data->user_select)){

                $client_id = $data->user_select;
                NewJobNotificationsController::notificationNewJobClient($data,$client_id);
                MailNewJobNotificationsController::notificationNewJobClientMail($data,$client_id);
                $clientList = User::clientListForClient($client_id);
                
                foreach($clientList as $c_key => $c_value){
                    $id = $c_value->id;
                    MailNewJobNotificationsController::notificationNewJobClientMail($data,$id);
                }

            }
        }

        if($data->managed_by == 1){

            NewJobNotificationsController::notificationNewJobAdmin($data);
            MailNewJobNotificationsController::notificationNewJobAdminMail($data);

        }

        return true;
    }

    /**
     * Update Job Notifications
    */
    public static function notificationUpdate($data){

        if(isset($data->staff_arr) && !empty($data->staff_arr)){
            $staff_select = explode(',', $data->staff_arr);
            foreach($staff_select as $StaffKey => $value){
                $s_id = $value;
                NewJobNotificationsController::notificationUpdateJobStaff($data,$s_id);
                MailNewJobNotificationsController::notificationNewJobStaffMail($data,$s_id);
            }
        }

        if(isset($data->recruiter_arr) && !empty($data->recruiter_arr)){
            $recruiter_select = explode(',', $data->recruiter_arr);
            foreach($recruiter_select as $RecruiterKey => $value){
                $r_id = $value;
                NewJobNotificationsController::notificationUpdateJobRecruiter($data,$r_id);
                MailNewJobNotificationsController::notificationNewJobRecruiterMail($data,$r_id);
            }
        }

        return true;
    }

    /**
     * New Application Notifications
    */
    public static function notificationNewApplication($job_id,$user_id){

        $job_vacancy = JobVacancy::find($job_id);

        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            $staff_select = explode(',', $job_vacancy->staff_arr);

            foreach($staff_select as $value){

                $s_id = $value;

                NewApplicationNotificationsController::notificationNewApplicationStaff($user_id,$job_vacancy,$s_id);

            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            if($job_vacancy->managed_by == 2){
                NewApplicationNotificationsController::notificationNewApplicationClient($user_id,$job_vacancy);
            }

        }

        if($job_vacancy->managed_by == 1){
            NewApplicationNotificationsController::notificationNewApplicationAdmin($user_id,$job_vacancy);
            NewApplicationMailNotificationsController::notificationMailNewApplicationAdmin($user_id,$job_vacancy);
        }

        return true;
    }

    /**
     * New Event Notifications
    */
    public static function notificationNewEvent($data){

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;

        $user_id_get = [];

        /** no need this notifiction */
        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            if($job_vacancy->managed_by == 2){
                $staff_select = explode(',', $job_vacancy->staff_arr);

                foreach($staff_select as $Skey => $value){

                    $staff_id = $value;
                    if(isset($data->job_reference) && !empty($data->job_reference)){
                        EventNotificationsController::notificationNewEventStaffReference($data,$value);
                    }else{
                        EventNotificationsController::notificationNewEventStaffNoReference($data,$value);
                    }

                    // if(isset($data->job_reference) && !empty($data->job_reference)){
                    //     EventMailNotificationsController::notificationMailNewEventStaffReference($data,$staff_id);
                    // }else{
                    //     EventMailNotificationsController::notificationMailNewEventStaffNoReference($data,$staff_id);
                    // }

                }
            }

        }

        if($job_vacancy->managed_by == 1){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventNotificationsController::notificationNewEventAdminReference($data);
            }else{
                EventNotificationsController::notificationNewEventAdminNoReference($data);
            }

                                
            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventMailNotificationsController::notificationMailNewEventAdminReference($data);
            }else{
                EventMailNotificationsController::notificationMailNewEventAdminNoReference($data);
            }
            $staff_id = 1;
        }

        if(isset($data->event_staff_select) && !empty($data->event_staff_select)){

            $event_staff_select = explode(',', $data->event_staff_select);
            foreach($event_staff_select as $ESkey => $e_value){

                $staff_id = $e_value;
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationNewEventSelectStaffReference($data,$staff_id);
                }else{
                    EventNotificationsController::notificationNewEventSelectStaffNoReference($data,$staff_id);
                }
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventMailNotificationsController::notificationMailNewEventSelectStaffReference($data,$staff_id);
                }else{
                    EventMailNotificationsController::notificationMailNewEventSelectStaffNoReference($data,$staff_id);
                }
                array_push($user_id_get,$e_value);

            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            if($job_vacancy->managed_by == 2){
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationNewEventSelectClientReference($data);
                }else{
                    EventNotificationsController::notificationNewEventSelectClientNoReference($data);
                }
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    $client_id = $job_vacancy->user_select;
                    EventMailNotificationsController::notificationMailNewEventClientReference($data,$client_id);
                    $clientList = User::clientListForClient($client_id);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        EventMailNotificationsController::notificationMailNewEventClientReference($data,$id);
                    }
                }else{
                    $client_id = $job_vacancy->user_select;
                    EventMailNotificationsController::notificationMailNewEventClientNoReference($data,$client_id);
                    $clientList = User::clientListForClient($client_id);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        EventMailNotificationsController::notificationMailNewEventClientNoReference($data,$id);
                    }
                }
                
            }
        }

        if(isset($candidate_id) && !empty($candidate_id)){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventNotificationsController::notificationNewEventCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    EventNotificationsController::notificationNewEventCandidateNoReference($data,$candidate_id);
                // }
            }

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventMailNotificationsController::notificationMailNewEventCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    EventMailNotificationsController::notificationMailNewEventCandidateNoReference($data,$candidate_id);
                // }
            }

        }


        $user_data = array_unique($user_id_get);

        $outlook_user = null;
        if(isset($user_data) && !empty($user_data)){
            $outlook_user = implode(',', $user_data);
        }

        $job_event = JobEvent::find($data->id);
        $job_event->outlook_user = $outlook_user;
        $job_event->save();

        return true;
    }

    /**
     * Update Event Notifications
    */
    public static function notificationUpdateEvent($data,$created_user_id){

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;

        $user_id_get = [];

        /** no need this notifiction */
        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            if($job_vacancy->managed_by == 2){
                $staff_select = explode(',', $job_vacancy->staff_arr);

                foreach($staff_select as $Skey => $value){

                    $staff_id = $value;

                    if(isset($data->job_reference) && !empty($data->job_reference)){
                        EventNotificationsController::notificationUpdateEventStaffReference($data,$staff_id);
                    }else{
                        EventNotificationsController::notificationUpdateEventStaffNoReference($data,$staff_id);
                    }

                    // if(isset($data->job_reference) && !empty($data->job_reference)){
                    //     EventMailNotificationsController::notificationMailNewEventStaffReference($data,$staff_id);
                    // }else{
                    //     EventMailNotificationsController::notificationMailNewEventStaffNoReference($data,$staff_id);
                    // }

                }
            }
        }

        if($job_vacancy->managed_by == 1){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventNotificationsController::notificationUpdateEventAdminReference($data);
            }else{
                EventNotificationsController::notificationUpdateEventAdminNoReference($data);
            }

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventMailNotificationsController::notificationMailUpdateEventAdminReference($data);
            }else{
                EventMailNotificationsController::notificationMailUpdateEventAdminNoReference($data);
            }

        }

        if(isset($data->event_staff_select) && !empty($data->event_staff_select)){
            $event_staff_select = explode(',', $data->event_staff_select);
            foreach($event_staff_select as $ESkey => $e_value){

                $staff_id = $e_value;
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationUpdateEventSelectStaffReference($data,$staff_id);
                }else{
                    EventNotificationsController::notificationUpdateEventSelectStaffNoReference($data,$staff_id);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventMailNotificationsController::notificationMailUpdateEventSelectStaffReference($data,$staff_id);
                }else{
                    EventMailNotificationsController::notificationMailUpdateEventSelectStaffNoReference($data,$staff_id);
                }

                array_push($user_id_get,$e_value);
            }
        }
        
        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            if($job_vacancy->managed_by == 2){
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationUpdateEventSelectClientReference($data);
                }else{
                    EventNotificationsController::notificationUpdateEventSelectClientNoReference($data);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    $client_id = $job_vacancy->user_select;
                    EventMailNotificationsController::notificationMailUpdateEventClientReference($data,$client_id);

                    $clientList = User::clientListForClient($client_id);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        EventMailNotificationsController::notificationMailUpdateEventClientReference($data,$id);
                    }
                }else{
                    $client_id = $job_vacancy->user_select;
                    EventMailNotificationsController::notificationMailUpdateEventClientNoReference($data,$client_id);

                    $clientList = User::clientListForClient($client_id);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        EventMailNotificationsController::notificationMailUpdateEventClientNoReference($data,$id);
                    }
                }
            }
            
        }
        
        if(isset($candidate_id) && !empty($candidate_id)){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventNotificationsController::notificationUpdateEventCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    EventNotificationsController::notificationUpdateEventCandidateNoReference($data,$candidate_id);
                // }
            }

            if(isset($data->job_reference) && !empty($data->job_reference)){
                EventMailNotificationsController::notificationMailUpdateEventCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    EventMailNotificationsController::notificationMailUpdateEventCandidateNoReference($data,$candidate_id);
                // }
            }

        }
        
        $user_data = array_unique($user_id_get);
        
        $outlook_user = null;
        if(isset($user_data) && !empty($user_data)){
            $outlook_user = implode(',', $user_data);
        }

        $job_event = JobEvent::find($data->id);
        $job_event->outlook_user = $outlook_user;
        $job_event->save();

        return true;
    }

    /**
     * Schedule Event Time Notifications
    */
    public static function notificationScheduleEventTime($data){

        if(isset($data->event_staff_select) && !empty($data->event_staff_select)){

            $event_staff_select = explode(',', $data->event_staff_select);
            foreach($event_staff_select as $ESkey => $e_value){

                $staff_id = $e_value;
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationNewScheduleEventTimeReference($data,$staff_id);
                }else{
                    EventNotificationsController::notificationNewScheduleEventTimeNoReference($data,$staff_id);
                }
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventMailNotificationsController::notificationMailNewScheduleEventTimeReference($data,$staff_id);
                }else{
                    EventMailNotificationsController::notificationMailNewScheduleEventTimeNoReference($data,$staff_id);
                }

            }
        }

        return true;
    }

    /**
     * Reject Event Time Notifications
    */
    public static function notificationRejectEventTime($data){

        if(isset($data->event_staff_select) && !empty($data->event_staff_select)){

            $event_staff_select = explode(',', $data->event_staff_select);
            foreach($event_staff_select as $ESkey => $e_value){

                $staff_id = $e_value;
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationNewRejectEventTimeReference($data,$staff_id);
                }else{
                    EventNotificationsController::notificationNewRejectEventTimeNoReference($data,$staff_id);
                }
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventMailNotificationsController::notificationMailNewRejectEventTimeReference($data,$staff_id);
                }else{
                    EventMailNotificationsController::notificationMailNewRejectEventTimeNoReference($data,$staff_id);
                }

            }
        }

        return true;
    }
    
    /**
     * Cancel Event Time Notifications
    */
    public static function notificationCancelEventTime($data){

        if(isset($data->event_staff_select) && !empty($data->event_staff_select)){

            $event_staff_select = explode(',', $data->event_staff_select);
            foreach($event_staff_select as $ESkey => $e_value){

                $staff_id = $e_value;
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventNotificationsController::notificationNewCancelEventTimeReference($data,$staff_id);
                }else{
                    EventNotificationsController::notificationNewCancelEventTimeNoReference($data,$staff_id);
                }
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    EventMailNotificationsController::notificationMailNewCancelEventTimeReference($data,$staff_id);
                }else{
                    EventMailNotificationsController::notificationMailNewCancelEventTimeNoReference($data,$staff_id);
                }

            }
        }

        return true;
    }

    /**
     * New Offer Notifications
    */
    public static function notificationNewOffer($data){

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $candidate_id = $data->candidate_id;

        if($job_vacancy->managed_by == 1){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                OfferNotificationsController::notificationNewOfferAdminReference($data);
            }else{
                OfferNotificationsController::notificationNewOfferAdminNoReference($data);
            }
          
            if(isset($data->job_reference) && !empty($data->job_reference)){
                OfferMailNotificationsController::notificationMailNewOfferAdminReference($data);
            }else{
                OfferMailNotificationsController::notificationMailNewOfferAdminNoReference($data);
            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            if($job_vacancy->managed_by == 2){

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferNotificationsController::notificationNewOfferSelectClientReference($data);
                }else{
                    OfferNotificationsController::notificationNewOfferSelectClientNoReference($data);
                }

            }
        }

        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            if($job_vacancy->managed_by == 2){
                $staff_select = explode(',', $job_vacancy->staff_arr);
                foreach($staff_select as $value){
                    if(isset($data->job_reference) && !empty($data->job_reference)){
                        OfferNotificationsController::notificationNewOfferStaffReference($data,$value);
                    }else{
                        OfferNotificationsController::notificationNewOfferStaffNoReference($data,$value);
                    }
                }
            }
        }

        if(isset($user_id) && !empty($user_id)){
            if(isset($data->job_reference) && !empty($data->job_reference)){
                $candidate_id = $data->r_c_id;
                OfferNotificationsController::notificationOfferCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    OfferNotificationsController::notificationOfferCandidateNoReference($data,$candidate_id);
                // }
            }
            if(isset($data->job_reference) && !empty($data->job_reference)){
                $candidate_id = $data->r_c_id;
                OfferMailNotificationsController::notificationMailNewOfferCandidateReference($data,$candidate_id);
            }else{
                // $check_user = User::checkUserActiveDeactive($candidate_id);
                // if($check_user){
                    OfferMailNotificationsController::notificationMailNewOfferCandidateNoReference($data,$candidate_id);
                // }
            }
        }

        return true;

    }

    /**
     * Offer Accepted Notifications
    */
    public static function notificationNewOfferAccepted($data){
        $job_vacancy = JobVacancy::find($data->vacancy_id);

        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            $staff_select = explode(',', $job_vacancy->staff_arr);

            foreach($staff_select as $SKey => $value){

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferNotificationsController::notificationOfferAcceptedStaffReference($data,$value);
                }else{
                    OfferNotificationsController::notificationOfferAcceptedStaffNoReference($data,$value);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferMailNotificationsController::notificationMailAcceptedStaffReference($data,$value);
                }else{
                    OfferMailNotificationsController::notificationMailAcceptedStaffNoReference($data,$value);
                }
            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            // if($job_vacancy->managed_by == 2){
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferNotificationsController::notificationOfferAcceptedClientReference($data);
                }else{
                    OfferNotificationsController::notificationOfferAcceptedClientNoReference($data);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    $value = $job_vacancy->user_select;
                    OfferMailNotificationsController::notificationMailAcceptedClientReference($data,$value);

                    $clientList = User::clientListForClient($value);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        OfferMailNotificationsController::notificationMailAcceptedClientReference($data,$id);
                    }
                }else{
                    $value = $job_vacancy->user_select;
                    OfferMailNotificationsController::notificationMailAcceptedClientNoReference($data,$value);

                    $clientList = User::clientListForClient($value);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        OfferMailNotificationsController::notificationMailAcceptedClientNoReference($data,$id);
                    }
                }
            // }

        }

        if($job_vacancy->managed_by == 1){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                OfferNotificationsController::notificationOfferAcceptedAdminReference($data);
            }else{
                OfferNotificationsController::notificationOfferAcceptedAdminNoReference($data);
            }
            if(isset($data->job_reference) && !empty($data->job_reference)){
                $value = 1;
                OfferMailNotificationsController::notificationMailAcceptedAdminReference($data,$value);
            }else{
                $value = 1;
                OfferMailNotificationsController::notificationMailAcceptedAdminNoReference($data,$value);
            }

        }

        return true;
    }

    /**
     * Offer Declined Notifications
    */
    public static function notificationNewOfferDeclined($data){
        $job_vacancy = JobVacancy::find($data->vacancy_id);

        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            $staff_select = explode(',', $job_vacancy->staff_arr);

            foreach($staff_select as $SKey => $value){

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferNotificationsController::notificationOfferDeclinedStaffReference($data,$value);
                }else{
                    OfferNotificationsController::notificationOfferDeclinedStaffNoReference($data,$value);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferMailNotificationsController::notificationMailDeclinedStaffReference($data,$value);
                }else{
                    OfferMailNotificationsController::notificationMailDeclinedStaffNoReference($data,$value);
                }
            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            // if($job_vacancy->managed_by == 2){
                
                if(isset($data->job_reference) && !empty($data->job_reference)){
                    OfferNotificationsController::notificationOfferDeclinedClientReference($data);
                }else{
                    OfferNotificationsController::notificationOfferDeclinedClientNoReference($data);
                }

                if(isset($data->job_reference) && !empty($data->job_reference)){
                    $value = $job_vacancy->user_select;
                    OfferMailNotificationsController::notificationMailDeclinedClientReference($data,$value);

                    $clientList = User::clientListForClient($value);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        OfferMailNotificationsController::notificationMailDeclinedClientReference($data,$id);
                    }
                }else{
                    $value = $job_vacancy->user_select;
                    OfferMailNotificationsController::notificationMailDeclinedClientNoReference($data,$value);

                    $clientList = User::clientListForClient($value);
                
                    foreach($clientList as $c_key => $c_value){
                        $id = $c_value->id;
                        OfferMailNotificationsController::notificationMailDeclinedClientNoReference($data,$id);
                    }
                }
            // }

        }

        if($job_vacancy->managed_by == 1){

            if(isset($data->job_reference) && !empty($data->job_reference)){
                OfferNotificationsController::notificationOfferDeclinedAdminReference($data);
            }else{
                OfferNotificationsController::notificationOfferDeclinedAdminNoReference($data);
            }

            if(isset($data->job_reference) && !empty($data->job_reference)){
                $value = 1;
                OfferMailNotificationsController::notificationMailDeclinedAdminReference($data,$value);
            }else{
                $value = 1;
                OfferMailNotificationsController::notificationMailDeclinedAdminNoReference($data,$value);
            }
        }

        return true;
    }

    public static function changeNotoficationStatus(Request $request){
        $id = $request->id;
        $value = $request->value;

        $notifications = Notifications::find($id);
        $notifications->status =  $value;
        $notifications->updated_at =  date('Y-m-d H:i:s');
        if ($notifications->save()) {
            return response()->json(['code' => 1]);
        }else{
            return response()->json(['code' => 0]);
        }
    }

    public static function markAllReadStatus(Request $request){
        $id = $request->id;
        if($id){
            Notifications::where('user_id','=',$id)->update(['status' => 1,'updated_at' => date('Y-m-d H:i:s')]);
            $Notifications_count = Notifications::where('user_id','=',$id)->where('status','=',0)->count();
            return response()->json(['msg' => $Notifications_count,'code' => 1]);
        }else{
            return response()->json(['code' => 0]);
        }
    }

    /**
     * Recruiter Candidate add Notifications
    */
    public static function notificationRecruiterCandidate($job_id,$user_id,$job_reference,$r_c_id){
        $job_vacancy = JobVacancy::find($job_id);

        if(isset($job_vacancy->staff_arr) && !empty($job_vacancy->staff_arr)){
            $staff_select = explode(',', $job_vacancy->staff_arr);

            foreach($staff_select as $value){
                $content = "New Job application";
                $notifications_type = "new_job_application";
                $save_data = array();
                $save_data['user_id'] = $value;
                $save_data['job_id'] = $job_vacancy->id;
                $save_data['job_applied_user'] = $user_id;
                $save_data['url'] = $job_vacancy->slug;
                $save_data['notifications_content'] = $content;
                $save_data['notifications_type'] = $notifications_type;
                $save_data['job_reference'] = $job_reference;
                $save_data['r_c_id'] = $r_c_id;
                $save_data['status'] = 0;

                $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('r_c_id','=',$r_c_id)->where('notifications_type','=',$notifications_type)->first();

                if($checkData){
                    $save_data['updated_at'] = date('Y-m-d H:i:s');
                    Notifications::where('id','=',$checkData->id)->update($save_data);
                }else{
                    $save_data['created_at'] = date('Y-m-d H:i:s');
                    $save_data['updated_at'] = date('Y-m-d H:i:s');
                    Notifications::insert($save_data);
                }
            }
        }

        if(isset($job_vacancy->user_select) && !empty($job_vacancy->user_select)){
            if($job_vacancy->managed_by == 2){
                $content = "New Job application";
                $notifications_type = "new_job_application";
                $save_data = array();
                $save_data['user_id'] = $job_vacancy->user_select;
                $save_data['job_id'] = $job_vacancy->id;
                $save_data['job_applied_user'] = $user_id;
                $save_data['url'] = $job_vacancy->slug;
                $save_data['notifications_content'] = $content;
                $save_data['notifications_type'] = $notifications_type;
                $save_data['job_reference'] = $job_reference;
                $save_data['r_c_id'] = $r_c_id;
                $save_data['status'] = 0;

                $checkData = Notifications::where('user_id','=',$job_vacancy->user_select)->where('job_id','=',$job_id)->where('r_c_id','=',$r_c_id)->where('notifications_type','=',$notifications_type)->first();

                if($checkData){
                    $save_data['updated_at'] = date('Y-m-d H:i:s');
                    Notifications::where('id','=',$checkData->id)->update($save_data);
                }else{
                    $save_data['created_at'] = date('Y-m-d H:i:s');
                    $save_data['updated_at'] = date('Y-m-d H:i:s');
                    Notifications::insert($save_data);
                }
            }

        }

        if($job_vacancy->managed_by == 1){

            $content = "New Job application";
            $notifications_type = "new_job_application";
            $save_data = array();
            $save_data['user_id'] = 1;
            $save_data['job_id'] = $job_vacancy->id;
            $save_data['job_applied_user'] = $user_id;
            $save_data['url'] = $job_vacancy->slug;
            $save_data['notifications_content'] = $content;
            $save_data['notifications_type'] = $notifications_type;
            $save_data['job_reference'] = $job_reference;
            $save_data['r_c_id'] = $r_c_id;
            $save_data['status'] = 0;

            $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$job_id)->where('r_c_id','=',$r_c_id)->where('notifications_type','=',$notifications_type)->first();

            if($checkData){
                $save_data['updated_at'] = date('Y-m-d H:i:s');
                Notifications::where('id','=',$checkData->id)->update($save_data);
            }else{
                $save_data['created_at'] = date('Y-m-d H:i:s');
                $save_data['updated_at'] = date('Y-m-d H:i:s');
                Notifications::insert($save_data);
            }

            $email = User::getEmail(1);

            $siteSetting = SiteSetting::first();

            if (isset($siteSetting) && !empty($siteSetting)) {
                if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                    $email = $siteSetting->site_notification_email;
                }
            }

            $job_id = $job_vacancy->id;
            $user_id = 1;
            $time = 2;

            $save_mail = array();
            $save_mail['user_id'] = $user_id;
            $save_mail['email'] = $email;
            $save_mail['job_id'] = $job_id;
            $save_mail['status'] = 0;
            $save_mail['notifications_type'] = $notifications_type;
            $save_mail['job_reference'] = $job_reference;
            $save_mail['r_c_id'] = $r_c_id;

            $link = route('home.index');
            $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('r_c_id','=',$r_c_id)->where('notifications_type','=',$notifications_type)->first();
            if($checkMailData){
                $save_mail['updated_at'] = date('Y-m-d H:i:s');
                MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
            }else{
                $save_mail['created_at'] = date('Y-m-d H:i:s');
                MailNotifications::insert($save_mail);
                $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$link))->delay(now()->addSeconds($time * 4));
                app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
            }

        }

        return true;
    }

    /**
     * Notification count referesh every 10 min
    */
    public static function viewNotification(Request $request){
        $id = Auth::user()->id;
        if(Auth::user()->role == 2){
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
        }
        $notificationData = view('admin.layouts.notification_view')->render();
        $Notifications_count = Notifications::where('user_id','=',$id)->where('status','=',0)->count();
        return response()->json(['count' => $Notifications_count,'notification' => $notificationData,'code' => 1]);
    }
    
    /**
     * Notification count referesh every 10 min
    */
    public static function checkLoginStatus(Request $request){
        if(isset($request->id) && !empty($request->id)){
            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();
            $user = User::find($request->id);
            $user->check_status = $time;
            $user->save();
            return response()->json(['code' => 1]);
        }
    }
}
