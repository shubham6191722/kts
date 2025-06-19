<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model {

    protected $table = 'job_skill'; 

    protected $fillable = [
        'skill_name',
        'c_id',
    ];

    public static function skillList() {
        return self::where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function getValuer($id) {
        return self::where('c_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function getSkillName($id) {

        $skill_data = self::where('id', "=", $id)->first();
        $skill_name = null;
        if(isset($skill_data->skill_name) && !empty($skill_data->skill_name)){
            $skill_name = $skill_data->skill_name;
        }
        return $skill_name;

    }
}
