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

class OfferNotificationsController extends Controller
{

    /**
     * Offer Created Admin Reference
    */
    public static function notificationNewOfferAdminReference($data)
    {
        $user_id = $data->candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;

        $checkData = Notifications::where('user_id','=',1)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Admin No Reference
    */
    public static function notificationNewOfferAdminNoReference($data)
    {
        $user_id = $data->candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = 1;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $user_id;

        $checkData = Notifications::where('user_id','=',1)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Client Reference
    */
    public static function notificationNewOfferSelectClientReference($data)
    {
        
        $user_id = $data->candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = $job_vacancy->user_select;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;

        $checkData = Notifications::where('user_id','=',$job_vacancy->user_select)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Client No Reference
    */
    public static function notificationNewOfferSelectClientNoReference($data)
    {
        $user_id = $data->candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = $job_vacancy->user_select;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $user_id;

        $checkData = Notifications::where('user_id','=',$job_vacancy->user_select)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Staff Reference
    */
    public static function notificationNewOfferStaffReference($data,$value)
    {
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";

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
     * Offer Created Staff No Reference
    */
    public static function notificationNewOfferStaffNoReference($data,$value)
    {
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $created_user_id = $data->created_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['created_user_id'] = $created_user_id;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Candidate Reference
    */
    public static function notificationOfferCandidateReference($data,$candidate_id)
    {
        
        $user_id = $candidate_id;
        $job_applied_user = $data->candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $job_applied_user;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('r_c_id','=',$job_applied_user)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Created Candidate No Reference
    */
    public static function notificationOfferCandidateNoReference($data,$candidate_id)
    {
        $user_id = $candidate_id;

        $content = "New Offer Created";
        $notifications_type = "new_offer";
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $job_id = $data->vacancy_id;
        $created_user_id = $data->created_id;

        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $save_data = array();
        $save_data['user_id'] = $candidate_id;
        $save_data['job_id'] = $job_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['created_user_id'] = $created_user_id;
        $save_data['job_applied_user'] = $user_id;

        $checkData = Notifications::where('user_id','=',$candidate_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Accepted Staff Reference
    */
    public static function notificationOfferAcceptedStaffReference($data,$value){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

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
     * Offer Accepted Staff No Reference
    */
    public static function notificationOfferAcceptedStaffNoReference($data,$value){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Accepted Client Reference
    */
    public static function notificationOfferAcceptedClientReference($data){
        
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $user_select = $job_vacancy->user_select;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$user_select)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

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
     * Offer Accepted Client No Reference
    */
    public static function notificationOfferAcceptedClientNoReference($data){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $user_select = $job_vacancy->user_select;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$user_select)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Accepted Admin Reference
    */
    public static function notificationOfferAcceptedAdminReference($data){
        
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $user_select = 1;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$user_select)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

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
     * Offer Accepted Admin No Reference
    */
    public static function notificationOfferAcceptedAdminNoReference($data){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $user_select = 1;

        $content = "Offer accepted";
        $notifications_type = "offer_accepted";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$user_select)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Declined Staff Reference
    */
    public static function notificationOfferDeclinedStaffReference($data,$value){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

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
     * Offer Declined Staff No Reference
    */
    public static function notificationOfferDeclinedStaffNoReference($data,$value){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

        $save_data = array();
        $save_data['user_id'] = $value;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$value)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Declined Client Reference
    */
    public static function notificationOfferDeclinedClientReference($data){
        
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $user_select = $job_vacancy->user_select;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$user_select)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

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
     * Offer Declined Client No Reference
    */
    public static function notificationOfferDeclinedClientNoReference($data){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $user_select = $job_vacancy->user_select;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$user_select)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
     * Offer Declined Admin Reference
    */
    public static function notificationOfferDeclinedAdminReference($data){
        
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $user_select = 1;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $r_c_id;
        $save_data['r_c_id'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;
        $save_data['job_reference'] = $job_reference;

        $checkData = Notifications::where('user_id','=',$user_select)->where('r_c_id','=',$user_id)->where('job_applied_user','=',$r_c_id)->where('job_id','=',$job_id)->where('notifications_type','=',$notifications_type)->where('job_reference','=',$job_reference)->first();

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
     * Offer Declined Admin No Reference
    */
    public static function notificationOfferDeclinedAdminNoReference($data){
        
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $user_id = $data->candidate_id;
        $job_id = $job_vacancy->id;
        $user_select = 1;

        $content = "Offer Declined";
        $notifications_type = "offer_declined";

        $save_data = array();
        $save_data['user_id'] = $user_select;
        $save_data['job_id'] = $job_id;
        $save_data['job_applied_user'] = $user_id;
        $save_data['url'] = $job_vacancy->slug;
        $save_data['notifications_content'] = $content;
        $save_data['notifications_type'] = $notifications_type;
        $save_data['status'] = 0;

        $checkData = Notifications::where('user_id','=',$user_select)->where('job_id','=',$job_id)->where('job_applied_user','=',$user_id)->where('notifications_type','=',$notifications_type)->first();

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
