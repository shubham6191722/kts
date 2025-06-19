<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCurrency extends Model {

    protected $table = 'job_currency'; 

    protected $fillable = [
        'currency',
    ];

    public static function getAll() {
        return self::orderBy('currency', 'asc')->get();
    }

}
