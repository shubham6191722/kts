<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class JobApplied extends Model {

    protected $table = 'job_applied';

    protected $fillable = [
        'user_id',
        'job_id',
        'client_id',
        'cv_file',
        'notice_period',
        'salary_expectations',
        'work_base_preferences',
        'managed_by',
        'job_status',
        'job_stage',
        'job_title',
        'job_workflow_id',
        'job_new',
        'job_advertised',
        'job_reference',
        'unsuccessful_mail_send',
        'thumbs_status',
        'note_status',
        'created_user_id',
        'note',
        'deleted_at',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->where('deleted_at','=',null)->get();
    }

    public static function checkAppliedJob($job_id,$user_id) {
        $job_applied = self::where('job_id','=',$job_id)->where('user_id','=',$user_id)->where('deleted_at','=',null)->first();
        return $job_applied;
    }

    public static function checkAppliedJobCount($user_id) {
        $job_applied = self::where('job_id','=',$user_id)->where('deleted_at','=',null)->count();
        return $job_applied;
    }

    public static function appliedJob($user_id) {
        $job_applied = self::where('job_id','=',$user_id)->where('deleted_at','=',null)->get();
        return $job_applied;
    }

    public static function jobCount($id,$job_id) {
        $job_applied = self::where('job_stage','=',$id)->where('job_id','=',$job_id)->where('deleted_at','=',null)->get()->count();
        return $job_applied;
    }

    public static function jobStatusDataGet($jobId,$jobStatus,$jobStage,$jobNew,$search = null) {

        $job_applied = self::select('job_applied.*', 'users.name')
                        ->leftJoin('users', function($join) {
                            $join->on('job_applied.user_id', '=', 'users.id');
                        })
                        ->where('job_id','=',$jobId)
                        ->where('job_status','=',$jobStatus)
                        ->where('job_stage','=',$jobStage)
                        ->where('job_new','=',$jobNew)
                        // ->where('name','LIKE','%'. $search. '%')
                        ->where('job_applied.deleted_at','=',null)
                        ->orderBy('job_applied.updated_at', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function jobStatusDataGetSearch($jobId,$jobStatus,$jobStage,$jobNew,$search = null) {

        $job_applied = self::select('job_applied.*', 'users.name')
                        ->leftJoin('users', function($join) {
                            $join->on('job_applied.user_id', '=', 'users.id');
                        })
                        ->where('job_id','=',$jobId)
                        ->where('job_status','=',$jobStatus)
                        ->where('job_stage','=',$jobStage)
                        ->where('job_new','=',$jobNew)
                        // ->where('name','LIKE','%'. $search. '%')
                        ->where('job_applied.deleted_at','=',null)
                        ->orderBy('job_applied.updated_at', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function jobStatusCountDataGet($jobid,$statusid) {


        $new = self::where('job_id','=',$jobid)
                        ->where('job_status','=',1)
                        ->where('job_stage','=',$statusid)
                        ->where('job_new','=',1)
                        ->where('deleted_at','=',null)
                        ->count();

        $qualified = self::where('job_id','=',$jobid)
                        ->where('job_status','=',1)
                        ->where('job_stage','=',$statusid)
                        ->where('job_new','=',0)
                        ->where('deleted_at','=',null)
                        ->count();

        $unsuccessful = self::where('job_id','=',$jobid)
                        ->where('job_status','=',0)
                        ->where('job_stage','=',$statusid)
                        ->where('job_new','=',0)
                        ->where('deleted_at','=',null)
                        ->count();

        $data['qualified'] = $qualified;
        $data['unsuccessful'] = $unsuccessful;
        $data['new'] = $new;
        return $data;
    }

    public static function jobCandidateGet($user_id) {
        $job_applied = self::select('job_applied.*', 'users.company_name', 'users.email','users.company_logo','job_vacancy.jobtitle','job_vacancy.slug','job_vacancy.sub_company')
                        ->leftJoin('users', function($join) {
                            $join->on('job_applied.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_applied.job_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_applied.user_id','=',$user_id)
                        ->where('job_applied.deleted_at','=',null)
                        ->get();
        return $job_applied;
    }

    public static function appliedUserData($user_id) {
        $date = date("Y-m-d",time()-3600*24*90);
        $job_applied = self::select('job_applied.*', 'users.company_name','users.email','users.phone','users.company_logo','job_vacancy.jobtitle','job_vacancy.slug','job_vacancy.jobdescription','job_vacancy.altlocation','job_vacancy.locatedregion','job_vacancy.sub_company')
                        ->leftJoin('users', function($join) {
                            $join->on('job_applied.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_applied.job_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_applied.user_id','=',$user_id)
                        ->where("job_applied.created_at",">",$date)
                        ->where('job_applied.deleted_at','=',null)
                        ->orderBy('job_applied.id', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function appliedUserArchiveData($user_id) {
        $date = date("Y-m-d",time()-3600*24*90);
        $job_applied = self::select('job_applied.*', 'users.company_name','users.email','users.phone','users.company_logo','job_vacancy.jobtitle','job_vacancy.slug','job_vacancy.jobdescription','job_vacancy.altlocation','job_vacancy.locatedregion','job_vacancy.sub_company')
                        ->leftJoin('users', function($join) {
                            $join->on('job_applied.client_id', '=', 'users.id');
                        })
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_applied.job_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_applied.user_id','=',$user_id)
                        ->where("job_applied.created_at","<",$date)
                        // ->where('job_applied.deleted_at','=',null)
                        ->orderBy('job_applied.id', 'desc')
                        ->get();
        return $job_applied;
    }

    public static function getData($id) {
        return self::orderBy('id', 'asc')->where('deleted_at','=',null)->first();
    }

    public static function hiringManager($id) {
        $job_applied = self::select('job_applied.id','job_applied.deleted_at','job_vacancy.staff_arr')
                        ->leftJoin('job_vacancy', function($join) {
                            $join->on('job_applied.job_id', '=', 'job_vacancy.id');
                        })
                        ->where('job_applied.job_id','=',$id)
                        ->where('job_applied.deleted_at','=',null)
                        ->first();

        $staff_arr = null;
        if(isset($job_applied->staff_arr) && !empty($job_applied->staff_arr)){
            $staff_arr = $job_applied->staff_arr;
        }
        return $staff_arr;
    }

    public static function talentPoolUser($id,$job_skill = null,$region = null,$talent_name = null) {
        $query = self::select('job_applied.user_id','job_applied.client_id','users.id','users.name','users.lname','users.phone','users.cover_image','users.client_slug','users.deleted_at','users.talent_pool_status','user_detail.salary','user_detail.location','user_detail.key_skills','user_detail.cv','user_detail.sector','user_detail.description','user_detail.noticeperiod','user_detail.workbasepreference');

        $query->leftJoin('users', function($join) {
            $join->on('job_applied.user_id', '=', 'users.id');
        });
        $query->leftJoin('user_detail', function($join) {
            $join->on('job_applied.user_id', '=', 'user_detail.user_id');
        });

        if(isset($job_skill) && !empty($job_skill)){
            $query->whereRaw('FIND_IN_SET('.$job_skill.',user_detail.sector)');
        }

        if(isset($region) && !empty($region)){
            $query->whereRaw('FIND_IN_SET('.$region.',user_detail.location)');
        }

        if(isset($talent_name) && !empty($talent_name)){

            $skill_data = JobSkill::select('id')->where('skill_name','LIKE','%'. $talent_name. '%')->get()->toArray();
            foreach($skill_data as $s_value){
                $query->orwhere(function($q) use ($s_value){
                    $q->whereRaw('FIND_IN_SET('.$s_value['id'].',user_detail.key_skills)');
                });

            }
            $query->orwhere(function($q) use ($talent_name){
                $q->orwhere('users.name', 'LIKE', '%'. $talent_name. '%');
                $q->orwhere('users.lname', 'LIKE', '%'. $talent_name. '%');
            });
        }

        $query->where('job_applied.client_id','=',$id);
        $query->where('users.talent_pool_status','=','1');
        $query->orderBy('users.id', 'desc');
        $query->groupBy('job_applied.user_id');
        $query->where('users.deleted_at','=',null);
        $job_applied = $query->get();
        // $job_applied = $query->paginate(12);

        return $job_applied;
    }

    public static function talentPoolUserAll($job_skill = null,$region = null,$talent_name = null) {

        $query = self::select('job_applied.user_id','job_applied.client_id','users.id','users.name','users.lname','users.phone','users.cover_image','users.client_slug','users.talent_pool_status','user_detail.salary','user_detail.location','user_detail.key_skills','user_detail.cv','user_detail.sector','user_detail.description');

        $query->leftJoin('users', function($join) {
            $join->on('job_applied.user_id', '=', 'users.id');
        });

        $query->leftJoin('user_detail', function($join) {
            $join->on('job_applied.user_id', '=', 'user_detail.user_id');
        });

        if(isset($job_skill) && !empty($job_skill)){
            $query->whereRaw('FIND_IN_SET('.$job_skill.',user_detail.key_skills)');
        }

        if(isset($region) && !empty($region)){
            $query->whereRaw('FIND_IN_SET('.$region.',user_detail.location)');
        }

        if(isset($talent_name) && !empty($talent_name)){

            $skill_data = JobSkill::select('id')->where('skill_name','LIKE','%'. $talent_name. '%')->get()->toArray();
            foreach($skill_data as $s_value){
                $query->orwhere(function($q) use ($s_value){
                    $q->whereRaw('FIND_IN_SET('.$s_value['id'].',user_detail.key_skills)');
                });

            }
            $query->orwhere(function($q) use ($talent_name){
                $q->orwhere('users.name', 'LIKE', '%'. $talent_name. '%');
                $q->orwhere('users.lname', 'LIKE', '%'. $talent_name. '%');
            });
        }

        $query->where('users.talent_pool_status','=','1');
        $query->orderBy('users.id', 'desc');
        $query->groupBy('job_applied.user_id');
        $job_applied = $query->get();

        // $job_applied = $query->paginate(12);
        return $job_applied;
    }

    public static function recruiterCandidateAppliedJob($user_id,$job_reference,$job_id) {
        $job_applied = self::where('user_id','=',$user_id)->where('job_id','=',$job_id)->where('job_reference','=',$job_reference)->where('deleted_at','=',null)->first();
        return $job_applied;
    }

    public static function clientNewJobAppliedData($user_id,$job_new,$max_data) {
        $job_applied = self::where('client_id','=',$user_id)->where('job_new','=',$job_new)->where('deleted_at','=',null)->orderBy('id', 'desc')->limit($max_data)->get()->toArray();
        return $job_applied;
    }

    public static function reportDataGetOffice($user_id,$client_id,$startdate,$enddate) {

        $query = self::query();

        $query = $query->where('client_id',$user_id);
        $query->where('work_base_preferences','=',"Office");

        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        }

        $query = $query->where('deleted_at','=',null)->count();
        return $query;
    }

    public static function reportDataGetRemote($user_id,$client_id,$startdate,$enddate) {

        $query = self::query();

        $query = $query->where('client_id',$user_id);
        $query->where('work_base_preferences','=',"Remote");

        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        }

        $query = $query->where('deleted_at','=',null)->count();
        return $query;
    }

    public static function reportDataGetHybrid($user_id,$client_id,$startdate,$enddate) {

        $query = self::query();

        $query = $query->where('client_id',$user_id);
        $query->where('work_base_preferences','=',"Hybrid");

        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        }

        $query = $query->where('deleted_at','=',null)->count();
        return $query;
    }

    public static function reportDataGetAdvertisementSource($user_id,$job_advertised_id,$startdate,$enddate) {

        $query = self::query();

        $query = $query->where('client_id',$user_id);
        $query->where('job_advertised','=',$job_advertised_id);

        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        }

        $query = $query->where('deleted_at','=',null)->count();
        return $query;
    }

}
