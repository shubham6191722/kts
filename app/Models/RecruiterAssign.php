<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruiterAssign extends Model {

    protected $table = 'recruiter_assign'; 

    protected $fillable = [
        'client_id',
        'client_assign_recruiter',
    ];

    public static function getDataForCandidate($id) {
        return self::where('client_id','=',$id)->first();
    }
    
}
