<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOccupation extends Model {

    protected $table = 'job_occupation'; 

    protected $fillable = [
        'occupation_id',
        'categoryid',
        'occupation',
    ];

    public static function getSelectValue() {
        return self::where('categoryid','=',1)->orderBy('id', 'asc')->get();
    }

    public static function getValuer($id) {
        return self::where('categoryid','=',$id)->orderBy('id', 'asc')->get();
    }

    public static function occupationName($id) {
        $occupation_name = self::where('occupation_id', "=", $id)->first();
        $occupation = null;
        if(isset($occupation_name->occupation) && !empty($occupation_name->occupation)){
            $occupation = $occupation_name->occupation;
        }
        return $occupation;
    }

}
