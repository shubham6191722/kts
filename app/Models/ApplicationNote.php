<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationNote extends Model {

    protected $table = 'application_note'; 

    protected $fillable = [
        'applied_id',
        'created_user_id',
        'note',
    ];

    public static function getDataAll($id) {
        return self::where('applied_id','=',$id)->orderBy('id', 'desc')->get();
    }
}
