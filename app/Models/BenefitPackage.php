<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitPackage extends Model {

    protected $table = 'benefit_package'; 

    protected $fillable = [
        'client_id',
        'title',
        'description',
    ];

    public static function list($id) {
        return self::where('client_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }
    
    public static function benefitTitle($client_id,$id) {
        $option_data = self::where('id','=',$id)->where('client_id','=',$client_id)->where('deleted_at','=',null)->first();
        $name = "-";
        if(isset($option_data->title) && !empty($option_data->title)){
            $name = $option_data->title;
        }
        return $name;
    }

}
