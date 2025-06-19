<?php

namespace App\Http\Controllers\notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\MailNotificationInQueue;
use App\CustomFunction\CustomFunction;

use Mail;

use App\Models\Notifications;
use App\Models\UserDetail;
use App\Models\JobVacancy;
use App\Models\MailNotifications;
use App\Models\User;
use App\Models\SiteSetting;

class EventNotificationsController extends Controller
{

    /**
     * Event Staff Reference
    */
    public static function notificationNewEventStaffReference($data,$value)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Staff No Reference
    */
    public static function notificationNewEventStaffNoReference($data,$value)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Select Staff Reference
    */
    public static function notificationNewEventSelectStaffReference($data,$staff_id)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = $staff_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$staff_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Select Staff No Reference
    */
    public static function notificationNewEventSelectStaffNoReference($data,$staff_id)
    {
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = null;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['user_id'] = $staff_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = '0';

        $checkData = Notifications::where('user_id','=',$staff_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Client Reference
    */
    public static function notificationNewEventSelectClientReference($data)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = $data->client_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$data->client_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Client No Reference
    */
    public static function notificationNewEventSelectClientNoReference($data)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['user_id'] = $data->client_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$data->client_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Admin Reference
    */
    public static function notificationNewEventAdminReference($data)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = 1;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',1)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Admin No Reference
    */
    public static function notificationNewEventAdminNoReference($data)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_title;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $candidate_id;
        $save_data['r_c_id'] = null;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = 0;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }
    
    /**
     * Event Candidate Reference
    */
    public static function notificationNewEventCandidateReference($data,$candidate_id)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = 1;
        $candidate_id = $candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_type." - ".$job_vacancy->jobtitle;
        $notifications_type = "new_event";


        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Candidate No Reference
    */
    public static function notificationNewEventCandidateNoReference($data,$candidate_id)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "New event created - ".$data->event_type." - ".$job_vacancy->jobtitle;
        $notifications_type = "new_event";

        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }



    /**
     * Event Update Staff Reference
    */
    public static function notificationUpdateEventStaffReference($data,$value)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Update Staff No Reference
    */
    public static function notificationUpdateEventStaffNoReference($data,$value)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Update Select Staff Reference
    */
    public static function notificationUpdateEventSelectStaffReference($data,$staff_id)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = $staff_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$staff_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Update Select Staff No Reference
    */
    public static function notificationUpdateEventSelectStaffNoReference($data,$staff_id)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = null;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['user_id'] = $staff_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = '0';

        $checkData = Notifications::where('user_id','=',$staff_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Update Client Reference
    */
    public static function notificationUpdateEventSelectClientReference($data)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = $data->client_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$data->client_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Update Client No Reference
    */
    public static function notificationUpdateEventSelectClientNoReference($data)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['user_id'] = $data->client_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$data->client_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Event Update Admin Reference
    */
    public static function notificationUpdateEventAdminReference($data)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = 1;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',1)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Update Admin No Reference
    */
    public static function notificationUpdateEventAdminNoReference($data)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $candidate_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_title;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }
    
    /**
     * Event Update Candidate Reference
    */
    public static function notificationUpdateEventCandidateReference($data,$candidate_id)
    {
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = 1;
        $candidate_id = $candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_type." - ".$job_vacancy->jobtitle;
        $notifications_type = "update_event";


        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Event Update Candidate No Reference
    */
    public static function notificationUpdateEventCandidateNoReference($data,$candidate_id)
    {
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->client_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event updated - ".$data->event_type." - ".$job_vacancy->jobtitle;
        $notifications_type = "update_event";

        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Schedule Event Time Staff Reference
    */
    public static function notificationNewScheduleEventTimeReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event time schedule - ".$data->event_title;
        $notifications_type = "new_event_time_schedule";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Schedule Event Time Staff No Reference
    */
    public static function notificationNewScheduleEventTimeNoReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event time schedule - ".$data->event_title;
        $notifications_type = "new_event_time_schedule";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Reject Event Time Staff Reference
    */
    public static function notificationNewRejectEventTimeReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event time reject - ".$data->event_title;
        $notifications_type = "new_event_time_reject";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Reject Event Time Staff No Reference
    */
    public static function notificationNewRejectEventTimeNoReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event time reject - ".$data->event_title;
        $notifications_type = "new_event_time_reject";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

    /**
     * Cancel Event Time Staff Reference
    */
    public static function notificationNewCancelEventTimeReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }
        
        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content = "Event Cancel - ".$data->event_title;
        $notifications_type = "new_event_time_cancel";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * Cancel Event Time Staff No Reference
    */
    public static function notificationNewCancelEventTimeNoReference($data,$value)
    {

        $user_data = User::find($value);
        if($user_data->role == 2){
            if(isset($user_data->created_user_id) && !empty($user_data->created_user_id)){
                $value = $user_data->created_user_id;
            }else{
                $value = $value;
            }
        }else{
            $value = $value;
        }

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->user_id;
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;

        $content =  "Event Cancel - ".$data->event_title;
        $notifications_type = "new_event_time_cancel";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['r_c_id'] = $r_c_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        return true;
    }

}
