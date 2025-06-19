<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLeavingReason extends Model {

    protected $table = 'offer_leaving_reason'; 

    protected $fillable = [
        'offer_id',
        'applied_id',
        'vacancy_id',
        'client_id',
        'candidate_id',
        'job_reference',
        'r_c_id',
        'confirmed_start_date',
        'confirmed_leave_date',
        'reason_for_leaving',
        'week_count',
        'deleted_at',
    ];

    public static function findData($offer_id,$applied_id,$vacancy_id,$client_id,$candidate_id,$job_reference,$r_c_id) {
        return self::where('offer_id','=',$offer_id)
                    ->where('applied_id','=',$applied_id)
                    ->where('vacancy_id','=',$vacancy_id)
                    ->where('client_id','=',$client_id)
                    ->where('candidate_id','=',$candidate_id)
                    ->where('job_reference','=',$job_reference)
                    ->where('r_c_id','=',$r_c_id)
                    ->first();
    }

    public static function candidatesLeftCount($id) {
        return self::where('client_id','=',$id)->where('week_count','<=',8)->get()->toArray();
    }

}
