<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table = 'message'; 

    protected $fillable = [
        'job_id',
        'client_id',
        'candidate_id',
        'applied_id',
        'status',
        'staff_id',
        'created_id',
        'message',
        'message_id',
        'deleted_at',
    ];

    public static function getMessage($message_id) {
        

        $query = self::select('*');
        $query = $query->where('message_id','=',$message_id);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('id','asc')->get()->toArray();

        return $result;
    }
}
