<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\CustomFunction\CustomFunction;
use App\Models\JobVacancy;
use Illuminate\Support\Arr;

class JobsAlert extends Model {

    protected $table = 'job_alert';

    protected $fillable = [
        'user_id',
        'email',
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
