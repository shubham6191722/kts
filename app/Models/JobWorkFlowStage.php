<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobWorkFlowStage extends Model {

    protected $table = 'job_workflow_stage'; 

    protected $fillable = [
        'workflow_id',
        'order',
        'stage_name',
        'deleted_at',
    ];

    public static function getWorkFlowWise($id) {
        
        $data = self::where('workflow_id','=',$id)->where('deleted_at','=',null)->orderBy('order', 'asc')->get();
        return $data;
    }

    public static function getWorkFlowCount($id) {
        return self::where('workflow_id','=',$id)->count();
    }

    public static function userStatus($id) {
        $status = self::where('workflow_id','=',$id)->orderBy('order', 'asc')->get();
        return $status;
    }

    public static function candidateStageGet($job_status,$job_workflow_id) {
        $status = self::where('workflow_id','=',$job_workflow_id)->where('order','=',$job_status)->orderBy('order', 'asc')->first();
        return $status;
    }

}
