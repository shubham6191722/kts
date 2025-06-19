<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

    protected $table = 'templates';

    protected $fillable = [
        'user_id',
        'template_name',
        'template_id',
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
        'staff_select',
        'recruiter_select',
        'staff_arr',
        'recruiter_arr',
        'benefits_image',
        'benefits_file_title',
        'benefits_file_id',
        'deleted_at',
    ];

    public static function checkTempalte($user_id,$template_id) {
        $data = self::where('template_id','=',$template_id)->where('user_id','=',$user_id)->orderBy('id', 'desc')->first();
        return $data;
    }

    public static function getData($id) {
        $data = self::where('user_id','=',$id)->orderBy('id', 'desc')->get();
        return $data;
    }

}
