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

class NewApplicationMailNotificationsController extends Controller
{

    /**
     * New Application Admin Mail
    */
    public static function notificationMailNewApplicationAdmin($user_id,$job_vacancy)
    {
        $link = route('home.index');

        $event_type = null;
        $notifications_type = "new_job_application";
        $candidate_id = $user_id;
        $job_id = $job_vacancy->id;
        
        $email = User::getEmail(1);

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                $email = $siteSetting->site_notification_email;
            }
        }

        $c_id = $user_id;
        $user_id = 1;
        $time = 2;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['job_applied_user'] = $c_id;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('job_applied_user','=',$c_id)->where('notifications_type','=',$notifications_type)->first();
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

}
