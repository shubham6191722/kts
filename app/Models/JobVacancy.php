<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;

class JobVacancy extends Model {

    protected $table = 'job_vacancy';

    protected $fillable = [
        'managed_by',
        'user_select',
        'sub_company',
        'cover_image',
        'hiring_manager_file_title',
        'hiring_manager_file_id',
        'jobtitle',
        'jobtenure',
        'startdate',
        'duration',
        'lengthofcontract',
        'durationperiod',
        'weeklyworkinghours',
        'ratelower',
        'rateupper',
        'ratefrequency',
        'ratecurrency',
        'locatedcountry',
        'locatedregion',
        'altlocation',
        'locatedpostcode',
        'categoryid',
        'occupationid',
        'levelid',
        'jobdescription',
        'skillsrequired',
        'qualificationsrequired',
        'keywords',
        'jobcategory1',
        'jobcategory2',
        'jobcategory3',
        'jobcategory4',
        'jobvacancystatus',
        'jobvacancystage',
        'job_specification',
        'specification_file_title',
        'specification_file_id',
        'infofromthehiringmanager',
        'jobworkflow_id',
        'slug',
        'media_specification',
        'media_hiring_manager',
        'benefits',
        'work_base_preference',
        'benefits_image',
        'benefits_file_title',
        'benefits_file_id',
        'column',
        'user_id',
        'staff_select',
        'recruiter_select',
        'staff_arr',
        'recruiter_arr',
        'longitude',
        'latitude',
    ];

    public static function getAll() {
        return self::where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function clientVacancyData($id) {
        return self::where('user_select','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }
    
    public static function clientVacancySearchData($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle,$sub_company,$hiring_manager) {
        $query = self::where('user_select','=',$id);
        
        if(!empty($jobtitle) && isset($jobtitle)){
            $query = $query->where(function($q) use ($jobtitle){
                $q->orwhere('jobtitle', 'LIKE', '%'. $jobtitle. '%');
            });
        }
        if(!empty($hiring_manager) && isset($hiring_manager) && $q_jobvacancystatus != 'all'){
            $check_user = User::checkUserStaffClient($hiring_manager);
            if($check_user == 'staff'){
                $query = $query->whereRaw('FIND_IN_SET('.$hiring_manager.',staff_arr)');
            }else{
                $query = $query->where('staff_arr','=',null);
            }
        }
        if(!empty($q_jobvacancystatus) && $q_jobvacancystatus != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystatus) {
                $q->where('jobvacancystatus','=',$q_jobvacancystatus);
            });
        }
        if(!empty($sub_company) && $sub_company != 'all'){
            $query = $query->Where(function($q) use($sub_company) {
                $q->where('sub_company','=',$sub_company);
            });
        }
        if(!empty($q_jobvacancystage) && $q_jobvacancystage != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystage) {
                $q->where('jobvacancystage','=',$q_jobvacancystage);
            });
        }
        if(!empty($q_managed_by) && $q_managed_by != 'all'){
            $query = $query->Where(function($q) use($q_managed_by) {
                $q->where('managed_by','=',$q_managed_by);
            });
        }
        if(!empty($q_jobtenure) && $q_jobtenure != 'all'){
            $query = $query->Where(function($q) use($q_jobtenure) {
                $q->where('jobtenure','=',$q_jobtenure);
            });
        }
        if(!empty($q_locatedregion) && $q_locatedregion != 'all'){
            $query = $query->Where(function($q) use($q_locatedregion) {
                $q->where('locatedregion','=',$q_locatedregion);
            });
        }
        if(!empty($q_categoryid) && $q_categoryid != 'all'){
            $query = $query->Where(function($q) use($q_categoryid) {
                $q->where('categoryid','=',$q_categoryid);
            });
        }
        if(!empty($q_jobcategory1) && $q_jobcategory1 != 'all'){
            $query = $query->Where(function($q) use($q_jobcategory1) {
                $q->where('jobcategory1','=',$q_jobcategory1);
            });
        }

        $query = $query->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $query;
    }

    public static function staffVacancyData($id) {
        $vacancyData = self::whereRaw('FIND_IN_SET('.$id.',staff_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $vacancyData;
    }

    public static function staffVacancySearchData($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle,$q_sub_company,$hiring_manager) {
        $query = self::whereRaw('FIND_IN_SET('.$id.',staff_arr)');

        if(!empty($jobtitle) && isset($jobtitle)){
            $query = $query->where(function($q) use ($jobtitle){
                $q->orwhere('jobtitle', 'LIKE', '%'. $jobtitle. '%');
            });
        }

        if(!empty($hiring_manager) && isset($hiring_manager) && $q_jobvacancystatus != 'all'){
            $check_user = User::checkUserStaffClient($hiring_manager);
            if($check_user == 'staff'){
                $query = $query->whereRaw('FIND_IN_SET('.$hiring_manager.',staff_arr)');
            }else{
                $query = $query->where('staff_arr','=',null);
            }
        }

        if(!empty($q_jobvacancystatus) && $q_jobvacancystatus != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystatus) {
                $q->where('jobvacancystatus','=',$q_jobvacancystatus);
            });
        }
        if(!empty($q_jobvacancystage) && $q_jobvacancystage != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystage) {
                $q->where('jobvacancystage','=',$q_jobvacancystage);
            });
        }
        if(!empty($q_managed_by) && $q_managed_by != 'all'){
            $query = $query->Where(function($q) use($q_managed_by) {
                $q->where('managed_by','=',$q_managed_by);
            });
        }
        if(!empty($q_jobtenure) && $q_jobtenure != 'all'){
            $query = $query->Where(function($q) use($q_jobtenure) {
                $q->where('jobtenure','=',$q_jobtenure);
            });
        }
        if(!empty($q_locatedregion) && $q_locatedregion != 'all'){
            $query = $query->Where(function($q) use($q_locatedregion) {
                $q->where('locatedregion','=',$q_locatedregion);
            });
        }
        if(!empty($q_categoryid) && $q_categoryid != 'all'){
            $query = $query->Where(function($q) use($q_categoryid) {
                $q->where('categoryid','=',$q_categoryid);
            });
        }
        if(!empty($q_jobcategory1) && $q_jobcategory1 != 'all'){
            $query = $query->Where(function($q) use($q_jobcategory1) {
                $q->where('jobcategory1','=',$q_jobcategory1);
            });
        }

        $query = $query->where('deleted_at','=',null)->orderBy('id', 'desc')->get();

        // $vacancyData = self::whereRaw('FIND_IN_SET('.$id.',staff_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $query;
    }

    public static function recruiterVacancyData($id) {
        $vacancyData = self::whereRaw('FIND_IN_SET('.$id.',recruiter_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $vacancyData;
    }

    public static function recruiterVacancySearchData($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle) {
        $query = self::whereRaw('FIND_IN_SET('.$id.',recruiter_arr)');

        if(!empty($jobtitle) && isset($jobtitle)){
            $query = $query->where(function($q) use ($jobtitle){
                $q->orwhere('jobtitle', 'LIKE', '%'. $jobtitle. '%');
            });
        }
        if(!empty($q_jobvacancystatus) && $q_jobvacancystatus != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystatus) {
                $q->where('jobvacancystatus','=',$q_jobvacancystatus);
            });
        }
        if(!empty($q_jobvacancystage) && $q_jobvacancystage != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystage) {
                $q->where('jobvacancystage','=',$q_jobvacancystage);
            });
        }
        if(!empty($q_managed_by) && $q_managed_by != 'all'){
            $query = $query->Where(function($q) use($q_managed_by) {
                $q->where('managed_by','=',$q_managed_by);
            });
        }
        if(!empty($q_jobtenure) && $q_jobtenure != 'all'){
            $query = $query->Where(function($q) use($q_jobtenure) {
                $q->where('jobtenure','=',$q_jobtenure);
            });
        }
        if(!empty($q_locatedregion) && $q_locatedregion != 'all'){
            $query = $query->Where(function($q) use($q_locatedregion) {
                $q->where('locatedregion','=',$q_locatedregion);
            });
        }
        if(!empty($q_categoryid) && $q_categoryid != 'all'){
            $query = $query->Where(function($q) use($q_categoryid) {
                $q->where('categoryid','=',$q_categoryid);
            });
        }
        if(!empty($q_jobcategory1) && $q_jobcategory1 != 'all'){
            $query = $query->Where(function($q) use($q_jobcategory1) {
                $q->where('jobcategory1','=',$q_jobcategory1);
            });
        }

        $query = $query->where('deleted_at','=',null)->orderBy('id', 'desc')->get();

        // $vacancyData = self::whereRaw('FIND_IN_SET('.$id.',recruiter_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $query;
    }

    public static function recruiterVacancyDataAdd($id) {
        $vacancyData = self::whereRaw('FIND_IN_SET('.$id.',recruiter_arr)')->where('jobvacancystatus','=',2)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $vacancyData;
    }


    public static function jobVacancyLive() {
        return self::where('jobvacancystatus','=','2')->where('deleted_at','=',null)->limit(9)->orderBy('id', 'desc')->get();
    }

    public static function jobVacancyLiveAll($jobtenure,$category,$min_price,$max_price,$job_title_skill,$region,$work_base,$location_data,$latitude,$longitude,$distance_km) {
        
        $lat_log = null;
        if(isset($latitude) && !empty($latitude))
        {
            /* replace 6371000 with 6371 for kilometer and 3956 for miles */
            $haversine = "(
                3959 * acos(
                    cos(radians(" .$latitude. "))
                    * cos(radians(`latitude`))
                    * cos(radians(`longitude`) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. ")) * sin(radians(`latitude`))
                )
            )";

            $query = self::select('*');
            $query->selectRaw("$haversine AS distance");
        }else{
            $query = self::select('*');
        }

        if(isset($jobtenure) && !empty($jobtenure))
        {
            if(is_array($jobtenure))
            {
                $query = $query->whereIn('jobtenure',$jobtenure);
            }
            else{
                $query = $query->where('jobtenure',$jobtenure);
            }
        }

        if(isset($category) && !empty($category))
        {
            if(is_array($category))
            {
                $query = $query->whereIn('categoryid',$category);
            }
            else{
                $query = $query->where('categoryid',$category);
            }
        }

        if((isset($min_price) && !empty($min_price)) || (isset($max_price) && !empty($max_price)))
        {
            
            if(empty($min_price)){
                $min_price = 0 ;
            }
            $query->where(function($q) use ($min_price,$max_price)
            {
                $q->whereBetween('rateupper',[$min_price, $max_price]);
            });
        }

        if(isset($job_title_skill) && !empty($job_title_skill))
        {
            $query->where(function($q) use ($job_title_skill){
                $skill_data = JobSkill::select('id')->where('skill_name','LIKE','%'. $job_title_skill. '%')->get()->toArray();
                foreach($skill_data as $s_value){
                    $q->orwhere(function($qs) use ($s_value){
                        $qs->whereRaw('FIND_IN_SET('.$s_value['id'].',skillsrequired)');
                    });
                    
                }
                $q->orwhere(function($qj) use ($job_title_skill){
                    $qj->where('jobtitle', 'LIKE', '%'. $job_title_skill. '%');
                });
            });
        }

        if(isset($region) && !empty($region))
        {
            // $query->where(function($q) use ($region){
            //     $q->where('locatedregion', $region);
            // });
        }

        if(isset($work_base) && !empty($work_base))
        {
            $query->where(function($q) use ($work_base){
                foreach($work_base as $w_value){
                    $q->orwhere(function($qw) use ($w_value){
                        $qw->whereRaw('FIND_IN_SET(?, work_base_preference)', [$w_value]);
                    });
                }
            });
        }
        
        if((isset($latitude) && !empty($latitude)) && (isset($longitude) && !empty($longitude)))
        {
            if(isset($distance_km) && !empty($distance_km))
            {
                $query->having('distance', '<', $distance_km);
            }
        }

        $query = $query->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->orderBy('id', 'desc');

        $result = $query->paginate(10);
        return $result;
    }

    public static function clientJobVacancyLive($client_id,$jobtenure,$category,$min_price,$max_price,$job_title_skill,$region,$work_base,$location_data,$latitude,$longitude,$distance_km) {

        $lat_log = null;
        if(isset($latitude) && !empty($latitude))
        {
            /* replace 6371000 with 6371 for kilometer and 3956 for miles */
            $haversine = "(
                3959 * acos(
                    cos(radians(" .$latitude. "))
                    * cos(radians(`latitude`))
                    * cos(radians(`longitude`) - radians(" .$longitude. "))
                    + sin(radians(" .$latitude. ")) * sin(radians(`latitude`))
                )
            )";

            $query = self::select('*');
            $query->selectRaw("$haversine AS distance");
        }else{
            $query = self::select('*');
        }

        if(isset($jobtenure) && !empty($jobtenure))
        {
            if(is_array($jobtenure))
            {
                $query = $query->whereIn('jobtenure',$jobtenure);
            }
            else{
                $query = $query->where('jobtenure',$jobtenure);
            }
        }

        if(isset($category) && !empty($category))
        {
            if(is_array($category))
            {
                $query = $query->whereIn('categoryid',$category);
            }
            else{
                $query = $query->where('categoryid',$category);
            }
        }

        if((isset($min_price) && !empty($min_price)) || (isset($max_price) && !empty($max_price)))
        {
            
            if(empty($min_price)){
                $min_price = 0 ;
            }
            $query->where(function($q) use ($min_price,$max_price)
            {
                $q->whereBetween('rateupper',[$min_price, $max_price]);
            });
        }

        if(isset($job_title_skill) && !empty($job_title_skill))
        {
            $query->where(function($q) use ($job_title_skill){
                $skill_data = JobSkill::select('id')->where('skill_name','LIKE','%'. $job_title_skill. '%')->get()->toArray();
                foreach($skill_data as $s_value){
                    $q->orwhere(function($qs) use ($s_value){
                        $qs->whereRaw('FIND_IN_SET('.$s_value['id'].',skillsrequired)');
                    });
                    
                }
                $q->orwhere(function($qj) use ($job_title_skill){
                    $qj->where('jobtitle', 'LIKE', '%'. $job_title_skill. '%');
                });
            });
        }

        if(isset($region) && !empty($region))
        {
            $query->where(function($q) use ($region){
                $q->where('locatedregion', $region);
            });
        }

        if(isset($work_base) && !empty($work_base))
        {
            $query->where(function($q) use ($work_base){
                foreach($work_base as $w_value){
                    $q->orwhere(function($qw) use ($w_value){
                        $qw->whereRaw('FIND_IN_SET(?, work_base_preference)', [$w_value]);
                    });
                }
            });
        }

        if((isset($latitude) && !empty($latitude)) && (isset($longitude) && !empty($longitude)))
        {
            if(isset($distance_km) && !empty($distance_km))
            {
                $query->having('distance', '<', $distance_km);
            }
        }

        $query = $query->where('user_select','=',$client_id)->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->orderBy('id', 'desc');

        $result = $query->paginate(10);

        return $result;
    }

    public static function jobVacancyFind($id) {
        return self::where('slug','=',$id)->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->first();
    }

    public static function jobName($id) {
        $job_name = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $jobtitle = null;
        if(isset($job_name->jobtitle) && !empty($job_name->jobtitle)){
            $jobtitle = $job_name->jobtitle;
        }
        return $jobtitle;
    }

    public static function jobUser($id) {
        $job_name = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $user_select = null;
        if(isset($job_name->user_select) && !empty($job_name->user_select)){
            $user_select = $job_name->user_select;
        }
        return $user_select;
    }

    public static function jobGet($id) {
        $job_name = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        return $job_name;
    }

    public static function clientJobGet($id) {
        $job_data = self::where('user_select','=',$id)->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $job_data;
    }

    public static function reSourceAll() {
        return self::where('managed_by','=',1)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function recruiterVacancyGetData($id) {
        $data = array();
        $vacancyData = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $data['managed_by'] = $vacancyData->managed_by;
        $data['client_id'] = $vacancyData->user_select;
        $data['job_workflow_id'] = $vacancyData->jobworkflow_id;
        return $data;
    }

    public static function jobVacancySendBulk($date) {
        $vacancyData = self::whereDate('created_at','=',$date)->where('deleted_at','=',null)->get();
        return $vacancyData;
    }
    
    public static function candidateNotification($value,$date) {
        
        $query = self::select('*');

        if(isset($value->categoryid) && !empty($value->categoryid)){
            $categoryid = explode(",", $value->categoryid);
            $query = $query->where(function($q) use ($categoryid){
                
                foreach($categoryid as $c_id){
                    $q->orwhere(function($qs) use ($c_id){
                        $qs->whereRaw('FIND_IN_SET('.$c_id.',categoryid)');
                    });
                    
                }
            });
        }
        if(isset($value->emploment_type) && !empty($value->emploment_type)){
            $emploment_type = explode(",", $value->emploment_type);
            $query = $query->where(function($q) use ($emploment_type){
                foreach($emploment_type as $e_type){
                    $q->orwhere(function($qt) use ($e_type){
                        $qt->where('jobtenure','=',$e_type);
                    });
                    
                }
            });
            
        }
        if((isset($value->hourly_salary) && !empty($value->hourly_salary)) || (isset($value->annual_salary) && !empty($value->annual_salary))){
            $hourly_salary = $value->hourly_salary;
            $annual_salary = $value->annual_salary;
            $query = $query->where(function($q) use ($hourly_salary,$annual_salary){
                if(isset($annual_salary) && !empty($annual_salary)){
                    $q->orwhere(function($qa) use ($annual_salary){
                        $qa->where('rateupper','<=',$annual_salary);
                    });
                }
                if(isset($hourly_salary) && !empty($hourly_salary)){
                    $q->orwhere(function($qh) use ($hourly_salary){
                        $qh->where('ratelower','<=',$hourly_salary);
                    });
                }
                
            });
            
        }
        $query = $query->whereDate('created_at','=',$date)->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();

        $result = $query;
        return $result;
    }
    
    public static function candidateNotificationRadius($value,$date) {
        
        /* replace 6371000 with 6371 for kilometer and 3956 for miles */
        $latitude = $value->latitude;
        $longitude = $value->longitude;
        $distance_km = $value->distance_km;

        $haversine = "(
            3959 * acos(
                cos(radians(" .$latitude. "))
                * cos(radians(`latitude`))
                * cos(radians(`longitude`) - radians(" .$longitude. "))
                + sin(radians(" .$latitude. ")) * sin(radians(`latitude`))
            )
        )";

        $query = self::select('*');

        $query->selectRaw("$haversine AS distance");

        if(isset($value->categoryid) && !empty($value->categoryid)){
            $categoryid = explode(",", $value->categoryid);
            $query = $query->where(function($q) use ($categoryid){
                
                foreach($categoryid as $c_id){
                    $q->orwhere(function($qs) use ($c_id){
                        $qs->whereRaw('FIND_IN_SET('.$c_id.',categoryid)');
                    });
                    
                }
            });
        }
        if(isset($value->emploment_type) && !empty($value->emploment_type)){
            $emploment_type = explode(",", $value->emploment_type);
            $query = $query->where(function($q) use ($emploment_type){
                foreach($emploment_type as $e_type){
                    $q->orwhere(function($qt) use ($e_type){
                        $qt->where('jobtenure','=',$e_type);
                    });
                    
                }
            });
            
        }
        if((isset($value->hourly_salary) && !empty($value->hourly_salary)) || (isset($value->annual_salary) && !empty($value->annual_salary))){
            $hourly_salary = $value->hourly_salary;
            $annual_salary = $value->annual_salary;
            $query = $query->where(function($q) use ($hourly_salary,$annual_salary){
                if(isset($annual_salary) && !empty($annual_salary)){
                    $q->orwhere(function($qa) use ($annual_salary){
                        $qa->where('rateupper','<=',$annual_salary);
                    });
                }
                if(isset($hourly_salary) && !empty($hourly_salary)){
                    $q->orwhere(function($qh) use ($hourly_salary){
                        $qh->where('ratelower','<=',$hourly_salary);
                    });
                }
                
            });
            
        }
        if(isset($distance_km) && !empty($distance_km))
        {
            $query->having('distance', '<', $distance_km);
        }
        $query = $query->whereDate('created_at','=',$date)->where('jobvacancystatus','=','2')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();

        $result = $query;
        return $result;
    }

    public static function reportJobTitle($id) {
        
        $query = self::select('id','jobtitle');
        $query = $query->where('jobvacancystatus','=',3)->where('jobvacancystage','=',5)->where('user_select','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
        $result = $query;
        return $result;
    }
    
    
    public static function timeToHireAll($id,$j_id,$j_c_id,$startdate,$enddate) {
        
        $query = self::select(['id','jobtitle','categoryid','created_at','updated_at',DB::raw('DATEDIFF(updated_at, created_at) + 1 as date_difference')]);
        $query = $query->where('user_select','=',$id);
        $query = $query->where(function($q){
            // $q->orwhere(function($qa){
            //     $qa->where('jobvacancystatus','=',3);
            // });
            // $q->orwhere(function($qh){
            //     $qh->where('jobvacancystage','=',5);
            // });
            $q->where('jobvacancystage','=',5);
            $q->where('jobvacancystatus','=',3);
        });

        if(isset($j_id) && !empty($j_id)){
            if($j_id != 'all'){
                $query = $query->where('id', '=', $j_id);
            }
        }

        if(isset($j_c_id) && !empty($j_c_id)){
            if($j_c_id != 'all'){
                $query = $query->where('categoryid', '=', $j_c_id);
            }
        }

        // if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        // {
        //     $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        // }
        
        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->where(
                function($q) use($startdate,$enddate){
                    $q->where(function($qa) use($startdate,$enddate){
                        $qa->whereBetween('created_at',[$startdate, $enddate]);
                    });
                    $q->Orwhere(function($qh) use($startdate,$enddate){
                        $qh->whereBetween('updated_at',[$startdate, $enddate]);
                    });
                });
        }

        $query = $query->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
        $result = $query;

        $count = 0;
        foreach($result as $Rkey => $r_value){
            $count = $count + $r_value['date_difference'];
        }
        $result_count = count($result);
        $totle = null;
        if($result_count > 0){
            $totle = $count / $result_count;
            $totle = intval(round($totle));
        }

        $data = array();
        $data['totle_day'] = $totle;
        $data['result'] = $result;

        return $data;
    }

    public static function liveVacancyCount($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',2)->where('deleted_at','=',null)->orderBy('id', 'desc')->count();
    }
    
    public static function liveVacancyData($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',2)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
    }
    
    public static function jobsFilledCount($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',3)->where('deleted_at','=',null)->orderBy('id', 'desc')->count();
    }
    
    public static function jobsFilledData($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',3)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
    }
    
    public static function jobsonholdCount($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',5)->where('deleted_at','=',null)->orderBy('id', 'desc')->count();
    }
    
    public static function jobsonholdData($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',5)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
    }
    
    public static function jobsCancelledCount($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',4)->where('deleted_at','=',null)->orderBy('id', 'desc')->count();
    }
    
    public static function jobsCancelledData($id){
        return self::where('user_select','=',$id)->where('jobvacancystatus','=',4)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
    }
    
    public static function getStaffSelect($id){
        return self::where('id','=',$id)->first();
    }
    
    public static function getStaffArr($id){
        $data = self::where('id','=',$id)->first();
        $staff_arr = null;
        if(isset($data->staff_arr) && !empty($data->staff_arr)){
            $staff_arr = $data->staff_arr;
        }
        return $staff_arr;
    }
    
    public static function getReSource(){
        $data = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*')
                        ->leftJoin('users', function($join) {
                            $join->on('job_vacancy.user_select', '=', 'users.id');
                        })
                        ->where('job_vacancy.managed_by','=',1)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->where('users.deleted_at','=',null)
                        ->orderBy('job_vacancy.id', 'desc')
                        ->get();
        return $data;
    }

    public static function getReSourceSearch($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$sub_company){
        // $data = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*')
        //                 ->leftJoin('users', function($join) {
        //                     $join->on('job_vacancy.user_select', '=', 'users.id');
        //                 })
        //                 ->where('job_vacancy.managed_by','=',1)
        //                 ->where('job_vacancy.deleted_at','=',null)
        //                 ->where('users.deleted_at','=',null)
        //                 ->orderBy('job_vacancy.id', 'desc')
        //                 ->get();
        // return $data;

        $query = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*');

        $query = $query->leftJoin('users', function($join) {
                            $join->on('job_vacancy.user_select', '=', 'users.id');
                        });

        if(!empty($id) && $id != 'all'){
            $query = $query->Where(function($q) use($id) {
                $q->where('job_vacancy.user_select','=',$id);
            });
        }
        if(!empty($sub_company) && $sub_company != 'all'){
            $query = $query->Where(function($q) use($sub_company) {
                $q->where('job_vacancy.sub_company','=',$sub_company);
            });
        }
        if(!empty($q_jobvacancystatus) && $q_jobvacancystatus != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystatus) {
                $q->where('job_vacancy.jobvacancystatus','=',$q_jobvacancystatus);
            });
        }
        if(!empty($q_jobvacancystage) && $q_jobvacancystage != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystage) {
                $q->where('job_vacancy.jobvacancystage','=',$q_jobvacancystage);
            });
        }
        
        $query = $query->where('job_vacancy.managed_by','=',1);
        
        if(!empty($q_jobtenure) && $q_jobtenure != 'all'){
            $query = $query->Where(function($q) use($q_jobtenure) {
                $q->where('job_vacancy.jobtenure','=',$q_jobtenure);
            });
        }
        if(!empty($q_locatedregion) && $q_locatedregion != 'all'){
            $query = $query->Where(function($q) use($q_locatedregion) {
                $q->where('job_vacancy.locatedregion','=',$q_locatedregion);
            });
        }
        if(!empty($q_categoryid) && $q_categoryid != 'all'){
            $query = $query->Where(function($q) use($q_categoryid) {
                $q->where('job_vacancy.categoryid','=',$q_categoryid);
            });
        }
        if(!empty($q_jobcategory1) && $q_jobcategory1 != 'all'){
            $query = $query->Where(function($q) use($q_jobcategory1) {
                $q->where('job_vacancy.jobcategory1','=',$q_jobcategory1);
            });
        }
        $query = $query->where('job_vacancy.deleted_at','=',null)->where('users.deleted_at','=',null)->orderBy('job_vacancy.id', 'desc')->get();
        return $query;
    }
    
    public static function getDirect(){
        $data = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*')
                        ->leftJoin('users', function($join) {
                            $join->on('job_vacancy.user_select', '=', 'users.id');
                        })
                        ->where('job_vacancy.managed_by','=',2)
                        ->where('job_vacancy.deleted_at','=',null)
                        ->where('users.deleted_at','=',null)
                        ->orderBy('job_vacancy.id', 'desc')
                        ->get();
        
        return $data;
    }
    
    public static function getDirectSearch($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$sub_company){
        // $data = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*')
        //                 ->leftJoin('users', function($join) {
        //                     $join->on('job_vacancy.user_select', '=', 'users.id');
        //                 })
        //                 ->where('job_vacancy.managed_by','=',2)
        //                 ->where('job_vacancy.deleted_at','=',null)
        //                 ->where('users.deleted_at','=',null)
        //                 ->orderBy('job_vacancy.id', 'desc')
        //                 ->get();
        // return $data;
        
        
        $query = self::select('users.id as client_id','users.deleted_at as client_deleted_at','job_vacancy.*');

        $query = $query->leftJoin('users', function($join) {
                            $join->on('job_vacancy.user_select', '=', 'users.id');
                        });

        if(!empty($id) && $id != 'all'){
            $query = $query->Where(function($q) use($id) {
                $q->where('job_vacancy.user_select','=',$id);
            });
        }
        if(!empty($sub_company) && $sub_company != 'all'){
            $query = $query->Where(function($q) use($sub_company) {
                $q->where('job_vacancy.sub_company','=',$sub_company);
            });
        }
        if(!empty($q_jobvacancystatus) && $q_jobvacancystatus != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystatus) {
                $q->where('job_vacancy.jobvacancystatus','=',$q_jobvacancystatus);
            });
        }
        if(!empty($q_jobvacancystage) && $q_jobvacancystage != 'all'){
            $query = $query->Where(function($q) use($q_jobvacancystage) {
                $q->where('job_vacancy.jobvacancystage','=',$q_jobvacancystage);
            });
        }
        
        $query = $query->where('job_vacancy.managed_by','=',2);
        
        if(!empty($q_jobtenure) && $q_jobtenure != 'all'){
            $query = $query->Where(function($q) use($q_jobtenure) {
                $q->where('job_vacancy.jobtenure','=',$q_jobtenure);
            });
        }
        if(!empty($q_locatedregion) && $q_locatedregion != 'all'){
            $query = $query->Where(function($q) use($q_locatedregion) {
                $q->where('job_vacancy.locatedregion','=',$q_locatedregion);
            });
        }
        if(!empty($q_categoryid) && $q_categoryid != 'all'){
            $query = $query->Where(function($q) use($q_categoryid) {
                $q->where('job_vacancy.categoryid','=',$q_categoryid);
            });
        }
        if(!empty($q_jobcategory1) && $q_jobcategory1 != 'all'){
            $query = $query->Where(function($q) use($q_jobcategory1) {
                $q->where('job_vacancy.jobcategory1','=',$q_jobcategory1);
            });
        }
        $query = $query->where('job_vacancy.deleted_at','=',null)->where('users.deleted_at','=',null)->orderBy('job_vacancy.id', 'desc')->get();
        return $query;
    }

    public static function getVacancyTitle($id) {

        if($id == 'all'){
            $query = self::select('id','jobtitle')->where('managed_by','=',1)->where('deleted_at','=',null)->get(); 
        }else{
            $query = self::select('id','jobtitle')->where('managed_by','=',1)->where('user_select','=',$id)->where('deleted_at','=',null)->get();
        }
        return $query;
    }
    
    public static function checkJobResourceOrDirect($id) {

        $query = self::select('id','managed_by')->where('id','=',$id)->where('deleted_at','=',null)->first();
        $name = '';
        if(isset($query) && !empty($query)){
            if($query->managed_by == 1){
                $name = 'Resource';
            }
            if($query->managed_by == 2){
                $name = 'Direct';
            }
        }
        
        return $name;
    }

}
