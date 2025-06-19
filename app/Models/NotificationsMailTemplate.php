<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsMailTemplate extends Model {

    protected $table = 'notifications_mail_template'; 

    protected $fillable = [
        'role',
        'notifications_type',
        'email_subject',
        'email_description',
        'deleted_at',
    ];

    public static function getAll() {
        return self::where('deleted_at','=',null)->orderBy('id', 'asc')->get();
    }
    
    public static function jobApplication() {
        $data = self::orWhere('notifications_type','=','new_job_created')
                    ->orWhere('notifications_type','=','new_job_application')
                    ->where('deleted_at','=',null)
                    ->orderBy('id', 'asc')
                    ->get();
        return $data;
    }
    
    public static function jobEvents() {
        $data = self::orWhere('notifications_type','=','new_event')
                    ->orWhere('notifications_type','=','update_event')
                    ->orWhere('notifications_type','=','new_event_time_schedule')
                    ->orWhere('notifications_type','=','new_event_time_reject')
                    ->orWhere('notifications_type','=','new_event_time_cancel')
                    ->where('deleted_at','=',null)
                    ->orderBy('id', 'asc')
                    ->get();
        return $data;
    }

    public static function jobOffers() {
        $data = self::orWhere('notifications_type','=','offer_declined')
                    ->orWhere('notifications_type','=','offer_accepted')
                    ->orWhere('notifications_type','=','new_offer')
                    ->where('deleted_at','=',null)
                    ->orderBy('id', 'asc')
                    ->get();
        return $data;
    }
}
