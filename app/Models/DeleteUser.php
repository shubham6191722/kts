<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteUser extends Model {

    protected $table = 'delete_user'; 

    protected $fillable = [
        'user_id',
        'user_data',
    ];
}
