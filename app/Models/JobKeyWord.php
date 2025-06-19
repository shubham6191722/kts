<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobKeyWord extends Model {

    protected $table = 'job_keyword'; 

    protected $fillable = [
        'keyword_name',
    ];

    public static function jobKeyWordList() {
        return self::orderBy('id', 'desc')->get();
    }
}
