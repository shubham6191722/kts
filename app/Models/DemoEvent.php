<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoEvent extends Model {

    protected $table = 'demo_event'; 

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
