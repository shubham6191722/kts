<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model {

    // use SoftDeletes;

    protected $table = 'notifications';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'job_id',
        'job_applied_user',
        'notifications_type',
		'notifications_content',
		'job_reference',
		'r_c_id',
		'url',
		'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function getNotification($id) {
        
        $notification_unread = self::where('user_id', "=", $id)->where('status','=',0)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
        $notification_unread_count = count($notification_unread);
        
        $notification_read = null;
        if($notification_unread_count <= 15){
            $limit = 15 - $notification_unread_count;
            $notification_read = self::where('user_id', "=", $id)->where('status','=',1)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->limit($limit)->get();
        }

        if(isset($notification_read) && !empty($notification_read)){
            $merged = $notification_unread->merge($notification_read);
            $notification_data = $merged->all();

        }else{
            $notification_data = $notification_unread;
        }
        return $notification_data;
    }


    public static function getNotificationCount($id) {
        
        $notification_unread = self::where('user_id', "=", $id)->where('status','=',0)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        $notification_unread_count = count($notification_unread);
        
        return $notification_unread_count;
    }


}
