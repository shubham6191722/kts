<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobActivity extends Model {

    protected $table = 'job_activity';

    protected $fillable = [
        'client_id',
        'user_id',
        'job_id',
        'applied_id',
        'select_id',
        'select_id',
        'managed_by',
        'text',
        'description',
        'r_c_id',
        'mail_template',
    ];

    public static function getApplication($appliedid) {
        $job_activity = self::where('applied_id','=',$appliedid)->orderBy('id', 'desc')->where('deleted_at','=',null)->get();
        return $job_activity;
    }
    
    public static function getClientData($client_id) {
        $job_activity = self::where('client_id','=',$client_id)->limit(10)->orderBy('id', 'desc')->where('deleted_at','=',null)->get()->toArray();
        return $job_activity;
    }

}
