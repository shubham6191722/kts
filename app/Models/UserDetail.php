<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model {

    protected $table = 'user_detail'; 

    protected $fillable = [
        'user_id',
        'salary',
        'location',
        'key_skills',
        'cv',
        'sector',
        'description',
        'workbasepreference',
        'noticeperiod',
        'n_location',
        'categoryid',
        'check_notification',
    ];

    public static function userDataGet($id) {
        $user_data = self::where('user_id', "=", $id)->first();
        return $user_data;
    }

    public static function keySkillGet($id) {
        $key_skills = self::where('user_id', "=", $id)->first();
        $key_skills_value = null;
        if(isset($key_skills->key_skills) && !empty($key_skills->key_skills)){
            $key_skills_value = $key_skills->key_skills;
        }
        return $key_skills_value;
    }

    public static function locationGet($id) {
        $location = self::where('user_id', "=", $id)->first();
        $location_value = null;
        if(isset($location->location) && !empty($location->location)){
            $location_value = $location->location;
        }
        return $location_value;
    }

}
