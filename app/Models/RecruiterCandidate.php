<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruiterCandidate extends Model {

    protected $table = 'recruiter_candidate'; 

    protected $fillable = [
        'recruiter_id',
        'job_id',
        'fname',
        'lname',
        'notice_period',
        'salary_expectations',
        'work_base_preferences',
        'cv',
        'deleted_at',
    ];

    public static function recruiterDataGet($id) {
        return self::where('recruiter_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function recruiterCandidateData($id) {
        $recruiterData = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        return $recruiterData;
    }

    public static function recruiterCandidateName($id) {
        $recruiterData = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $name = '';
        $fname = '';
        $lname = '';
        if(isset($recruiterData->fname) && !empty($recruiterData->fname)){
            $fname = $recruiterData->fname;
        }
        if(isset($recruiterData->lname) && !empty($recruiterData->lname)){
            $lname = $recruiterData->lname;
        }

        if(isset($fname) && !empty($fname)){
            $name = $fname;
        }
        if(isset($lname) && !empty($lname)){
            $name = $fname.' '.$lname;
        }
        return $name;
    }
    
    public static function getId($id) {
        $recruiterData = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        // $name = '';
        // $fname = '';
        // $lname = '';
        // if(isset($recruiterData->fname) && !empty($recruiterData->fname)){
        //     $fname = $recruiterData->fname;
        // }
        // if(isset($recruiterData->lname) && !empty($recruiterData->lname)){
        //     $lname = $recruiterData->lname;
        // }

        // if(isset($fname) && !empty($fname)){
        //     $name = $fname;
        // }
        // if(isset($lname) && !empty($lname)){
        //     $name = $fname.' '.$lname;
        // }
        return $recruiterData->recruiter_id;
    }

}
