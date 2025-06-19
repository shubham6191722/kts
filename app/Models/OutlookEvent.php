<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutlookEvent extends Model {

    protected $table = 'outlook_event'; 

    protected $fillable = [
        'outlook_event_id',
        'event_id',
        'user_id',
        'full_data',
        'check_organizer',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function getOrganizer() {
        $data = self::where('check_organizer','=',1)->where('deleted_at','=',null)->get();
        return $data;
    }

}
