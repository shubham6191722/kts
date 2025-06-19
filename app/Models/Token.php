<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model {

    protected $table = 'token'; 

    protected $fillable = [
        'user_id',
        'userName',
        'userEmail',
        'userTimeZone',
        'accessToken',
        'expires',
        'refreshToken',
        'resourceOwnerId',
        'values_token_type',
        'values_scope',
        'values_ext_expires_in',
        'values_id_token',
    ];

    public static function getUserData($user_id) {
        $data = self::where('user_id','=',$user_id)->first();
        return $data;
    }

}
