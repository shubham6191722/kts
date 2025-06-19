<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailNotifications extends Model {

    // use SoftDeletes;

    protected $table = 'mail_notifications';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'email',
        'job_id',
        'notifications_type',
		'status',
		'job_applied_user',
		'r_c_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
