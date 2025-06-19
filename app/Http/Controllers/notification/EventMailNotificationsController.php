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

class EventMailNotificationsController extends Controller
{

    /**
     * Event Mail Staff Reference
    */
    public static function notificationMailNewEventStaffReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Event Mail Staff No Reference
    */
    public static function notificationMailNewEventStaffNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
        $time = 1;


        $save_mail = array();
        $save_mail['r_c_id'] = $job_applied_user;
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['user_id'] = $staff_id;
        $save_mail['job_id'] = $job_id;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['status'] = 0;
        $save_mail['email'] = $email;
        $save_mail['job_reference'] = $job_reference;
        $save_mail['job_applied_user'] = $r_c_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Event Mail Select Staff Reference
    */
    public static function notificationMailNewEventSelectStaffReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Mail Select Staff No Reference
    */
    public static function notificationMailNewEventSelectStaffNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Mail Client Reference
    */
    public static function notificationMailNewEventClientReference($data,$client_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($client_id);
        $user_id = $client_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Mail Client No Reference
    */
    public static function notificationMailNewEventClientNoReference($data,$client_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

        $email = User::getEmail($client_id);
        $user_id = $client_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Event Mail Admin Reference
    */
    public static function notificationMailNewEventAdminReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Mail Admin No Reference
    */
    public static function notificationMailNewEventAdminNoReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

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
        $save_mail['job_reference'] = $job_reference;
        $save_mail['r_c_id'] = $r_c_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }


    /**
     * Event Mail Candidate Reference
    */
    public static function notificationMailNewEventCandidateReference($data,$candidate_id)
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

        $notifications_type = "new_event";

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
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Mail Candidate No Reference
    */
    public static function notificationMailNewEventCandidateNoReference($data,$candidate_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event";

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
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }


    /**
     * Event Update Mail Admin Reference
    */
    public static function notificationMailUpdateEventAdminReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Admin No Reference
    */
    public static function notificationMailUpdateEventAdminNoReference($data)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

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
        $save_mail['job_reference'] = $job_reference;
        $save_mail['r_c_id'] = $r_c_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Candidate Reference
    */
    public static function notificationMailUpdateEventCandidateReference($data,$candidate_id)
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

        $notifications_type = "update_event";

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
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Candidate No Reference
    */
    public static function notificationMailUpdateEventCandidateNoReference($data,$candidate_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

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
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Staff Reference
    */
    public static function notificationMailUpdateEventStaffReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Event Update Mail Staff No Reference
    */
    public static function notificationMailUpdateEventStaffNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
        $time = 1;


        $save_mail = array();
        $save_mail['r_c_id'] = $job_applied_user;
        $save_mail['created_user_id'] = $created_user_id;
        $save_mail['user_id'] = $staff_id;
        $save_mail['job_id'] = $job_id;
        $save_mail['notifications_type'] = $notifications_type;
        $save_mail['status'] = 0;
        $save_mail['email'] = $email;
        $save_mail['job_reference'] = $job_reference;
        $save_mail['job_applied_user'] = $r_c_id;
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Event Update Mail Select Staff Reference
    */
    public static function notificationMailUpdateEventSelectStaffReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        return true;
    }

    /**
     * Event Update Mail Select Staff No Reference
    */
    public static function notificationMailUpdateEventSelectStaffNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Client Reference
    */
    public static function notificationMailUpdateEventClientReference($data,$client_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($client_id);
        $user_id = $client_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Event Update Mail Client No Reference
    */
    public static function notificationMailUpdateEventClientNoReference($data,$client_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "update_event";

        $email = User::getEmail($client_id);
        $user_id = $client_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);


        return true;
    }

    /**
     * Schedule Event Time Staff Reference
    */
    public static function notificationMailNewScheduleEventTimeReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_schedule";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Schedule Event Time Staff No Reference
    */
    public static function notificationMailNewScheduleEventTimeNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_schedule";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Reject Event Time Staff Reference
    */
    public static function notificationMailNewRejectEventTimeReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_reject";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Reject Event Time Staff No Reference
    */
    public static function notificationMailNewRejectEventTimeNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_reject";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Cancel Event Time Staff Reference
    */
    public static function notificationMailNewCancelEventTimeReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_cancel";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

    /**
     * Cancel Event Time Staff No Reference
    */
    public static function notificationMailNewCancelEventTimeNoReference($data,$staff_id)
    {
        $link = route('home.index');

        $event_type = $data->event_type;
        $job_vacancy = JobVacancy::find($data->vacancy_id);
        $candidate_id = $data->user_id;
        $job_id = $job_vacancy->id;
        $job_reference = $data->job_reference;
        $r_c_id = $data->r_c_id;
        $created_user_id = $data->created_user_id;
        $job_applied_user = $data->user_id;

        $notifications_type = "new_event_time_cancel";

        $email = User::getEmail($staff_id);
        $user_id = $staff_id;
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
        $save_mail['created_at'] = date('Y-m-d H:i:s');
        $save_mail['updated_at'] = date('Y-m-d H:i:s');
        MailNotifications::insert($save_mail);
        $job = (new MailNotificationInQueue($user_id, $job_id, $email,$notifications_type,$candidate_id,$event_type,$link))->delay(now()->addSeconds($time * 4));
        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);

        return true;
    }

}
