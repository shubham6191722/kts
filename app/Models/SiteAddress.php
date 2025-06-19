<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteAddress extends Model {

    protected $table = 'job_site_address'; 

    protected $fillable = [
        'site_title',
        'site_address',
        'client_id',
    ];

    public static function clientAddressGet($id) {
        return self::where('client_id','=',$id)->orderBy('id', 'desc')->get();
    }

    public static function addressGet($id) {
        $address = self::where('id','=',$id)->orderBy('id', 'desc')->first();
        $add = null;
        if(isset($address->site_address) && !empty($address->site_address)){
            $add = $address->site_address;
        }
        return $add;
    }

}
