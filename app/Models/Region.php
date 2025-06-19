<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {

    protected $table = 'region'; 

    protected $fillable = [
        'region_id',
        'countrycode',
        'country',
    ];

    public static function getSelectValue() {
        return self::where('countrycode','=','GBR')->orderBy('region', 'asc')->get();
    }
    
    public static function getValuer($id) {
        return self::where('countrycode','=',$id)->orderBy('id', 'asc')->get();
    }

    public static function regionName($id) {
        $region_name = self::where('region_id', "=", $id)->first();
        $region = null;
        if(isset($region_name->region) && !empty($region_name->region)){
            $region = $region_name->region;
        }
        return $region;
    }

    public static function regionNameGet($id) {
        $region_name = self::where('id', "=", $id)->first();
        $region = null;
        if(isset($region_name->region) && !empty($region_name->region)){
            $region = $region_name->region;
        }
        return $region;
    }

}
