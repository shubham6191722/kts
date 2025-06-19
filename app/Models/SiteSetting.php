<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model {

    protected $table = 'site_settings'; 

    protected $fillable = [
        'site_title',
        'site_favicon',
        'site_header_logo',
        'site_notification_email',

        'footer_address',
        'footer_email',
        'footer_number',
        'footer_copy_text',
        'site_footer_logo',
        'site_talent_logo',
    ];

    public static function getSiteEmail() {

        $user_name = self::first();
        $email = 'rachael.walsh@the-resource-group.co.uk';
        // $email = 'sunny.tzinfotech@gmail.com';
        if(isset($user_name->site_notification_email) && !empty($user_name->site_notification_email)){
            $email = $user_name->site_notification_email;
        }
        return $email;
    }

}
