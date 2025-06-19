<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSectors extends Model {

    protected $table = 'job_sectors'; 

    protected $fillable = [
        'sector_id',
        'sector',
        'deleted_at',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->get();
    }

    public static function JobSectorsName($id) {
        $job_sectors_name = self::where('id','=',$id)->first();
        $sector = null;
        if(isset($job_sectors_name->sector) && !empty($job_sectors_name->sector)){
            $sector = $job_sectors_name->sector;
        }
        return $sector;
    }

}
