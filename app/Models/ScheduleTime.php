<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleTime extends Model {

    protected $table = 'schedule_time'; 

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'schedule_time',
        'time_distance',
    ];

    public static function findUserData($id) {
        return self::where('user_id','=',$id)->first();
    }
    
}
