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

class MailNewJobNotificationsController extends Controller
{

    /**
     * New Job Notifications Admin Mail
    */
    public static function notificationNewJobAdminMail($data)
    {
        $link = route('home.index');

        $candidate_id = $event_type = null;
        $notifications_type = "new_job_created";
        
        $email = User::getEmail(1);

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                $email = $siteSetting->site_notification_email;
            }
        }

        $job_id = $data->id;
        $user_id = 1;
        $time = 2;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();
        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }
    
    
    /**
     * New Job Notifications Client Mail
    */
    public static function notificationNewJobClientMail($data,$client_id)
    {
        $link = route('home.index');

        $candidate_id = $event_type = null;
        $notifications_type = "new_job_created";
        
        $email = User::getEmail($client_id);
        $job_id = $data->id;
        $user_id = $client_id;
        $time = 1;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();
        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * New Job Notifications Recruiter Mail
    */
    public static function notificationNewJobRecruiterMail($data,$r_id)
    {
        $link = route('home.index');

        $candidate_id = $event_type = null;
        $notifications_type = "new_job_created";
        
        $email = User::getEmail($r_id);
        $job_id = $data->id;
        $user_id = $r_id;

        $RecruiterKey = $r_id;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();
        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($RecruiterKey * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * New Job Notifications Staff Mail
    */
    public static function notificationNewJobStaffMail($data,$s_id)
    {
        $link = route('home.index');
        
        $candidate_id = $event_type = null;
        $notifications_type = "new_job_created";
        
        $email = User::getEmail($s_id);
        $job_id = $data->id;
        $user_id = $s_id;

        $StaffKey = $s_id;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;

        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();
        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($StaffKey * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }

        return true;
    }

}
