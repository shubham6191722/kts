<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementOption extends Model {

    protected $table = 'advertisement_option'; 

    protected $fillable = [
        'option_name',
        'client_id',
    ];

    public static function list($id) {
        return self::where('client_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }
    
    public static function optionName($client_id,$id) {
        $option_data = self::where('id','=',$id)->where('client_id','=',$client_id)->where('deleted_at','=',null)->first();
        $name = "-";
        if(isset($option_data->option_name) && !empty($option_data->option_name)){
            $name = $option_data->option_name;
        }
        return $name;
    }

}
