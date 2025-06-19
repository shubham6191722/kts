<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model {

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

}
