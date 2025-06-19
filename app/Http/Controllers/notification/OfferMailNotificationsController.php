<?php

namespace App\Http\Controllers\notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\MailNotificationInQueue;
use App\Jobs\RecruiterMailNotificationInQueue;
use App\CustomFunction\CustomFunction;

use Mail;

use App\Models\Notifications;
use App\Models\UserDetail;
use App\Models\JobVacancy;
use App\Models\MailNotifications;
use App\Models\User;
use App\Models\SiteSetting;

class OfferMailNotificationsController extends Controller
{

    /**
     * Offer Created Mail Admin Reference
    */
    public static function notificationMailNewOfferAdminReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_offer";

        $email = User::getEmail(1);

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                $email = $siteSetting->site_notification_email;
            }
        }

        $user_id = 1;
        $time = 1;

        $save_mail = array();
        $save_mail['r_c_id'] = $job_applied_user;
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['user_id'] = $user_id;
        $save_mail['job_id'] = $job_id;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['status'] = 0;
        $save_mail['email'] = $email;
        $save_mail['job_reference'] = $job_reference;
        $save_mail['job_applied_user'] = $r_c_id;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('r_c_id','=',$r_c_id)->where('job_applied_user','=',$job_applied_user)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Created Mail Admin No Reference
    */
    public static function notificationMailNewOfferAdminNoReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_offer";

        $email = User::getEmail(1);

        $siteSetting = SiteSetting::first();

        if (isset($siteSetting) && !empty($siteSetting)) {
            if(isset($siteSetting->site_notification_email) && !empty($siteSetting->site_notification_email)){
                $email = $siteSetting->site_notification_email;
            }
        }

        $user_id = 1;
        $time = 1;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['job_reference'] = 0;
        $save_mail['r_c_id'] = $candidate_id;
        
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
     * Offer Created Mail Candidate Reference
    */
    public static function notificationMailNewOfferCandidateReference($data,$candidate_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_offer";

        $email = User::getEmail($candidate_id);
        $user_id = $candidate_id;
        $time = 1;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['job_reference'] = $job_reference;
        
        $checkMailData = MailNotifications::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();
        if($checkMailData){
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::where('id','=',$checkMailData->id)->update($save_mail);
        }else{
            $save_mail['created_at'] = date('Y-m-d H:i:s');
            $save_mail['updated_at'] = date('Y-m-d H:i:s');
            MailNotifications::insert($save_mail);
            $candidate_id = $data->candidate_id;
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Created Mail Candidate No Reference
    */
    public static function notificationMailNewOfferCandidateNoReference($data,$candidate_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;

        $notifications_type = "new_offer";

        $email = User::getEmail($candidate_id);
        $user_id = $candidate_id;
        $time = 1;

        $save_mail = array();
        $save_mail['user_id'] = $user_id;
        $save_mail['email'] = $email;
        $save_mail['job_id'] = $job_id;
        $save_mail['status'] = 0;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['job_reference'] = 0;
        
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
     * Offer Accepted Mail Staff Reference
    */
    public static function notificationMailAcceptedStaffReference($data,$value)
    {
        $link = route('home.index');

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Accepted Mail Staff No Reference
    */
    public static function notificationMailAcceptedStaffNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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
     * Offer Accepted Mail Client Reference
    */
    public static function notificationMailAcceptedClientReference($data,$value)
    {
        $link = route('home.index');

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Accepted Mail Client No Reference
    */
    public static function notificationMailAcceptedClientNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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
     * Offer Accepted Mail Admin Reference
    */
    public static function notificationMailAcceptedAdminReference($data,$value)
    {
        $link = route('home.index');

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Accepted Mail Admin No Reference
    */
    public static function notificationMailAcceptedAdminNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer accepted";
        $notifications_type = "offer_accepted";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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
     * Offer Declined Mail Staff Reference
    */
    public static function notificationMailDeclinedStaffReference($data,$value)
    {
        $link = route('home.index');

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Declined Mail Staff No Reference
    */
    public static function notificationMailDeclinedStaffNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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
     * Offer Declined Mail Client Reference
    */
    public static function notificationMailDeclinedClientReference($data,$value)
    {
        $link = route('home.index');
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Declined Mail Client No Reference
    */
    public static function notificationMailDeclinedClientNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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
     * Offer Declined Mail Admin Reference
    */
    public static function notificationMailDeclinedAdminReference($data,$value)
    {
        $link = route('home.index');

        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        $r_c_id = $data->r_c_id;

        $email = User::getEmail($value);
        $user_id = $value;
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
            $job = (new RecruiterMailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,null,$r_c_id,$link))->delay(now()->addSeconds($time * 4));
            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }
        
        return true;
    }

    /**
     * Offer Declined Mail Admin No Reference
    */
    public static function notificationMailDeclinedAdminNoReference($data,$value)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $job_vacancy->id;
        $content = "Offer Declined";
        $notifications_type = "offer_declined";
        $candidate_id = $data->candidate_id;
        
        $email = User::getEmail($value);
        $user_id = $value;
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

    

}
