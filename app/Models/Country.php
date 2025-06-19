<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $table = 'country'; 

    protected $fillable = [
        'countrycode',
        'country',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->get();
    }

    public static function countryName($id) {
        $country_name = self::where('countrycode', "=", $id)->first();
        $country = null;
        if(isset($country_name->country) && !empty($country_name->country)){
            $country = $country_name->country;
        }
        return $country;
    }

}
