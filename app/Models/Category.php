<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'job_category'; 

    protected $fillable = [
        'category_id',
        'category',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->get();
    }

}
