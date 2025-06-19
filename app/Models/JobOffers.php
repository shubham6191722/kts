<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\CustomFunction\CustomFunction;
use App\Models\JobVacancy;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class JobOffers extends Model {

    protected $table = 'job_offers';

    protected $fillable = [
        'applied_id',
        'vacancy_id',
        'client_id',
        'candidate_id',
        'offer_status',
        'offered_salary',
        'suggested_date',
        'description',
        'declined_reason',
        'created_id',
        'r_c_id',
        'job_reference',
        'offer_letter',
    ];

    public static function getAll() {
        // $offer_data = self::select('job_offers.*','job_offers.id as offer_id')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        $offer_data = self::select('users.id as users_client_id','users.deleted_at as client_deleted_at','job_offers.*')
                        ->leftJoin('users', function($join) {
                            $join->on('job_offers.client_id', '=', 'users.id');
                        })
                        ->where('job_offers.deleted_at','=',null)
                        ->where('users.deleted_at','=',null)
                        ->orderBy('job_offers.id', 'asc')
                        ->get();
        return $offer_data;
    }

    public static function getOfferData($applied_id,$user_id) {
        $offer_data = self::select('job_offers.*','job_offers.id as offer_id')->where('applied_id','=',$applied_id)->where('candidate_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'asc')->first();
        return $offer_data;
    }

    public static function offerClientGet($user_id) {
        $offer_data = self::select('job_offers.*','job_offers.id as offer_id')->where('client_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerStaffGet($user_id) {

        $offer_data = self::select('job_offers.*','job_vacancy.*','job_offers.id as offer_id')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_offers.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_offers.deleted_at','=',null)
                        ->whereRaw('FIND_IN_SET('.$user_id.',job_vacancy.staff_arr)')
                        ->orderBy('job_offers.id', 'desc')
                        ->get();
        return $offer_data;
    }

    public static function offerGet($offer_id,$user_id) {
        $offer_data = self::where('id','=',$offer_id)->where('candidate_id','=',$user_id)->where('deleted_at','=',null)->first();
        return $offer_data;
    }

    public static function offerRecruiterCandidateGet($offer_id,$user_id,$r_c_id) {
        $offer_data = self::where('id','=',$offer_id)->where('candidate_id','=',$user_id)->where('r_c_id','=',$r_c_id)->where('deleted_at','=',null)->first();
        return $offer_data;
    }

    public static function offerCandidateGet($user_id) {
        $offer_data = self::where('candidate_id','=',$user_id)->where('deleted_at','=',null)->get();
        return $offer_data;
    }

    public static function offerCandidatePanding($user_id) {
        $offer_data = self::where('offer_status','=','0')->where('candidate_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerCandidateAccepted($user_id) {
        $offer_data = self::where('offer_status','=','1')->where('candidate_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerCandidateDeclined($user_id) {
        $offer_data = self::where('offer_status','=','2')->where('candidate_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerRecruiterCandidatePanding($user_id) {
        $offer_data = self::where('offer_status','=','0')->where('r_c_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerRecruiterCandidateAccepted($user_id) {
        $offer_data = self::where('offer_status','=','1')->where('r_c_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerRecruiterCandidateDeclined($user_id) {
        $offer_data = self::where('offer_status','=','2')->where('r_c_id','=',$user_id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $offer_data;
    }

    public static function offerStaffAccepted($user_id) {

        $offer_data = self::select('job_offers.*','job_vacancy.*')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_offers.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_offers.deleted_at','=',null)
                        ->where('job_offers.offer_status','=','1')
                        ->whereRaw('FIND_IN_SET('.$user_id.',job_vacancy.staff_arr)')
                        ->count();

        return $offer_data;
    }

    public static function offerStaffDeclined($user_id) {

        $offer_data = self::select('job_offers.*','job_vacancy.*')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_offers.vacancy_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_offers.deleted_at','=',null)
                        ->where('job_offers.offer_status','=','2')
                        ->whereRaw('FIND_IN_SET('.$user_id.',job_vacancy.staff_arr)')
                        ->count();

        return $offer_data;
    }

    public static function clientPendingData($user_id,$max_data) {

        $offer_data = self::where('client_id','=',$user_id)->where('offer_status','=','0')->where('deleted_at','=',null)->orderBy('id', 'desc')->limit($max_data)->get()->toArray();
        return $offer_data;
    }
    
    public static function recruiterPendingData($user_id,$max_data) {

        $offer_data = self::where('r_c_id','=',$user_id)->where('offer_status','=','0')->where('deleted_at','=',null)->orderBy('id', 'desc')->limit($max_data)->get()->toArray();
        return $offer_data;
    }

    public static function offersPendingCount($id) {

        $offer_data = self::where('client_id','=',$id)->where('offer_status','=','0')->where('deleted_at','=',null)->orderBy('id', 'desc')->count();
        return $offer_data;
    }
    
    public static function offersPendingData($id) {

        $offer_data = self::where('client_id','=',$id)->where('offer_status','=','0')->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
        return $offer_data;
    }
    
    public static function candidatesWaitingCount($id) {

        $offer_data = self::where('client_id','=',$id)->where('offer_status','=','1')->where('suggested_date' , '>=' , Carbon::now()->toDateTimeString())->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
        return $offer_data;
    }

}
