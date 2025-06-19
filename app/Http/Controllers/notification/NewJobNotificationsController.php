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

class NewJobNotificationsController extends Controller
{

    /**
     * New Job Notifications Admin
    */
    public static function notificationNewJobAdmin($data)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

        if($checkData){
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['created_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }

        $email = User::getEmail(1);

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                $email = $siteSetting->site_notification_email;
            }
        }
        
        return true;
    }

    /**
     * New Job Notifications Client
    */
    public static function notificationNewJobClient($data,$client_id)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = $client_id;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$client_id)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

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
     * New Job Notifications Recruiter
    */
    public static function notificationNewJobRecruiter($data,$r_id)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = $r_id;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$r_id)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

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
     * New Job Notifications Recruiter
    */
    public static function notificationUpdateJobRecruiter($data,$r_id)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = $r_id;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;

        $checkData = Notifications::where('user_id','=',$r_id)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

        if($checkData){
            $save_data['status'] = 1;
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['status'] = 0;
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

    /**
     * New Job Notifications Staff
    */
    public static function notificationNewJobStaff($data,$s_id)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = $s_id;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$s_id)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

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
     * Update Job Notifications Staff
    */
    public static function notificationUpdateJobStaff($data,$s_id)
    {
        
        $content = "New job created";
        $notifications_type = "new_job_created";
        $save_data = array();
        $save_data['user_id'] = $s_id;
        $save_data['job_id'] = $data->id;
        $save_data['url'] = $data->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;

        $checkData = Notifications::where('user_id','=',$s_id)->where('job_id','=',$data->id)->where('notifications_type','=',$notifications_type)->first();

        if($checkData){
            $save_data['status'] = 1;
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::where('id','=',$checkData->id)->update($save_data);
        }else{
            $save_data['status'] = 0;
            $save_data['created_at'] = date('Y-m-d H:i:s');
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            Notifications::insert($save_data);
        }
        
        return true;
    }

}
