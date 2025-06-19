<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLevel extends Model {

    protected $table = 'job_levels'; 

    protected $fillable = [
        'levels_id',
        'level',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->get();
    }

    public static function levelName($id) {
        $levels_name = self::where('levels_id', "=", $id)->first();
        $level = null;
        if(isset($levels_name->level) && !empty($levels_name->level)){
            $level = $levels_name->level;
        }
        return $level;
    }

}
