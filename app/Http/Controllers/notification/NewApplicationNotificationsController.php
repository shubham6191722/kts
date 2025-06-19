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

class NewApplicationNotificationsController extends Controller
{

    /**
     * New Application Admin
    */
    public static function notificationNewApplicationAdmin($user_id,$job_vacancy)
    {
        
        $content = "New Job application";
        $notifications_type = "new_job_application";
        $job_id = $job_vacancy->id;

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_vacancy->id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * New Application Client
    */
    public static function notificationNewApplicationClient($user_id,$job_vacancy)
    {
        
        $content = "New Job application";
        $notifications_type = "new_job_application";
        $job_id = $job_vacancy->id;

        $save_data = array();
        $save_data['user_id'] = $job_vacancy->user_select;
        $save_data['job_id'] = $job_vacancy->id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$job_vacancy->user_select)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * New Application Staff
    */
    public static function notificationNewApplicationStaff($user_id,$job_vacancy,$s_id)
    {
        
        $content = "New Job application";
        $notifications_type = "new_job_application";
        $job_id = $job_vacancy->id;

        $save_data = array();
        $save_data['user_id'] = $s_id;
        $save_data['job_id'] = $job_vacancy->id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$s_id)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
