<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MessageCount extends Model {

    protected $table = 'message_count';

    protected $fillable = [
        'job_id',
        'client_id',
        'candidate_id',
        'applied_id',
        'staff_id',
        'created_id',
        'count',
        'u_count',
        'name',
        'deleted_at',
    ];

    public static function getAll() {
        $data = self::where('created_id','=',1)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
        return $data;
    }

    public static function getClientAll($id) {
        $data = self::where('client_id','=',$id)->where('created_id','=',null)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();
        return $data;
    }

    public static function getSubClientAll($sub_id,$id) {
        $data_1 = self::where('client_id','=',$id)->where('job_id','!=',null)->where('created_id','=',null)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();
        $data_2 = self::where('client_id','=',$sub_id)->where('created_id','=',null)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();

        $data = array_merge($data_1,$data_2);;
        return $data;
    }

    public static function getClient($id) {
        $data = self::where('candidate_id','=',$id)->where('created_id','=',1)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();
        return $data;
    }

    public static function getStaffAll($client_id,$id) {
        $data = self::where('client_id','=',$client_id)->where('created_id','=',null)->where('staff_id','=',null)->whereRaw('FIND_IN_SET('.$id.',staff_arr)')->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();
        return $data;
    }

    public static function getStaff($id) {
        $data = self::where('staff_id','=',$id)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get()->toArray();
        return $data;
    }

    public static function getRecruiter($id) {
        $data = self::where('r_c_id','=',$id)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
        return $data;
    }

    public static function getCandidate($id) {
        $data = self::where('candidate_id','=',$id)->where('deleted_at','=',null)->orderBy('updated_at', 'desc')->get();
        return $data;
    }

    public static function messageIdGet($client_id,$staff_id,$candidate_id,$applied_id,$job_id,$check_admin) {
        $staff = explode(",",$staff_id);

        $query = self::select('*');
        $query = $query->where('job_id','=',$job_id);
        $query = $query->where('client_id','=',$client_id);
        $query = $query->where('candidate_id','=',$candidate_id);
        $query = $query->where('created_id','=',$check_admin);
        $query = $query->where('applied_id','=',$applied_id);
        $query = $query->where('deleted_at','=',null);

        // if(isset($staff) && !empty($staff))
        // {
        //     $query->where(function($q) use ($staff){
        //         foreach($staff as $w_value){
        //             $q->orwhere(function($qw) use ($w_value){
        //                 $qw->whereRaw('FIND_IN_SET(?, staff_id)', [$w_value]);
        //             });
        //         }
        //     });
        // }

        $result = $query->first();

        $id = null;

        if(isset($result->id) && !empty($result->id)){
            $id = $result->id;
        }

        return $id;
    }

    public static function getChatName($message_id) {

        $query = self::select('*');
        $query = $query->where('id','=',$message_id);
        $query = $query->where('deleted_at','=',null);

        // if(isset($staff) && !empty($staff))
        // {
        //     $query->where(function($q) use ($staff){
        //         foreach($staff as $w_value){
        //             $q->orwhere(function($qw) use ($w_value){
        //                 $qw->whereRaw('FIND_IN_SET(?, staff_id)', [$w_value]);
        //             });
        //         }
        //     });
        // }

        $result = $query->orderBy('id','desc')->first();

        $name = null;

        if(isset($result->name) && !empty($result->name)){
            $name = $result->name;
        }

        return $name;
    }

    public static function dataSearchAll($search = null) {

        $job_applied = self::where('name','LIKE','%'. $search. '%')
                        ->where('deleted_at','=',null)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function dataStaffSearchAll($search = null) {

        $job_applied = self::where('name','LIKE','%'. $search. '%')
                        ->where('deleted_at','=',null)
                        ->where('staff_id','=',null)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function dataSearchGetRecruiter($id,$search = null) {

        $job_applied = self::where('r_c_id','=',$id)
                        ->where('name','LIKE','%'. $search. '%')
                        ->where('deleted_at','=',null)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function dataSearchGetCandidate($id,$search = null) {

        $query  = self::select('message_count.*', 'job_vacancy.jobtitle as jobtitle','users.company_name');
        // $query->leftJoin('users', function($join) {
        //     $join->on('message_count.candidate_id', '=', 'users.id');
        // });
        $query->leftJoin('users', function($join) {
            $join->on('message_count.client_id', '=', 'users.id');
        });
        $query->leftJoin('job_vacancy', function($join) {
            $join->on('message_count.job_id', '=', 'job_vacancy.id');
        });

        $query->where(function($q) use ($search){
            $q->orWhere(function($q) use ($search){
                $q->where('job_vacancy.jobtitle','LIKE','%'. $search. '%');
            });
            $q->orWhere(function($q) use ($search){
                $q->where('users.company_name','LIKE','%'. $search. '%');
            });
        });

        $query->where('message_count.deleted_at','=',null);
        $query->where('message_count.candidate_id','=',$id);
        $query->orderBy('message_count.updated_at', 'desc');

        $result = $query->get();

        return $result;
    }

    public static function getAllCount() {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }

    public static function getClientAllCount($id) {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('client_id','=',$id);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }

    public static function getStaffAllCount($id) {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('client_id','=',$id);
        $query = $query->where('staff_id','=',null);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }

    public static function getStaffCount($c_id,$s_id) {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('client_id','=',$c_id);
        $query = $query->where('staff_id','=',$s_id);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }

    public static function getRecruiterCount($r_id) {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('r_c_id','=',$r_id);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }
    public static function getCandidateCount($c_id) {
        $query = self::select('id','count','u_count','staff_id');
        $query = $query->where('candidate_id','=',$c_id);
        $query = $query->where('deleted_at','=',null);
        $result = $query->orderBy('updated_at','desc')->get()->toArray();
        return $result;
    }

    // public static function getAllCountDisplay() {
    //     $query = self::select('id','count','u_count','staff_id');
    //     $query = $query->where('deleted_at','=',null);
    //     $result = $query->orderBy('updated_at','desc')->get()->toArray();
    //     return $result;
    // }

    public static function getAllCountDisplay() {
        $countGet = self::where('created_id','=',1)
            ->select('count', DB::raw('SUM(count) as total'))
            ->where('deleted_at','=',null)
            ->get()->toArray();

        $count = $countGet[0]['total'];
        return $count;
    }

    public static function getClientAllCountDisplay($id) {
        $countGet = self::where('client_id','=',$id)
            ->select('count', DB::raw('SUM(count) as total'))
            ->where('deleted_at','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }

    public static function getClientCountDisplay($id) {
        $countGet = self::where('candidate_id','=',$id)
            ->select('u_count', DB::raw('SUM(u_count) as total'))
            ->where('created_id','=',1)
            ->where('deleted_at','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }

    public static function getStaffAllCountDisplay($id) {
        $countGet = self::where('client_id','=',$id)
            ->select('count', DB::raw('SUM(count) as total'))
            ->where('deleted_at','=',null)
            ->where('staff_id','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }

    public static function getStaffCountDisplay($c_id,$s_id) {
        $countGet = self::where('client_id','=',$c_id)
            ->select('u_count', DB::raw('SUM(u_count) as total'))
            ->where('staff_id','=',$s_id)
            ->where('deleted_at','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }

    public static function getRecruiterCountDisplay($r_id) {
        $countGet = self::where('r_c_id','=',$r_id)
            ->select('u_count', DB::raw('SUM(u_count) as total'))
            ->where('deleted_at','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }
    public static function getCandidateCountDisplay($c_id) {
        $countGet = self::where('candidate_id','=',$c_id)
            ->select('u_count', DB::raw('SUM(u_count) as total'))
            ->where('deleted_at','=',null)
            ->get()->toArray();
        $count = $countGet[0]['total'];
        return $count;
    }

    public static function checkMessageForAdmin($id) {
        $query = self::select('id','created_id')->where('id','=',$id)->where('deleted_at','=',null)->first();
        $result = null;
        if(isset($query->created_id) && !empty($query->created_id)){
            $result = 'Resource Talent';
        }
        return $result;
    }

    public static function checkClientToStaffMessage($staff_id,$client_id) {
        $query = self::select('id')->where('staff_id','=',$staff_id)->where('client_id','=',$client_id)->where('deleted_at','=',null)->first();
        return $query;
    }

}
