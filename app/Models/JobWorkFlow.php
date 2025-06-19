<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobWorkFlow extends Model {

    protected $table = 'job_workflow'; 

    protected $fillable = [
        'workflow_name',
        'user_id',
        'deleted_at',
    ];

    public static function getUserWise($id) {
        return self::where('user_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }
    public static function getAll() {
        return self::where('deleted_at','=',null)->orderBy('workflow_name', 'asc')->get();
    }

}
