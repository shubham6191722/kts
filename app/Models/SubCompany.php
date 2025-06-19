<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCompany extends Model {

    protected $table = 'sub_company'; 

    protected $fillable = [
        'client_id',
        'company_name',
        'about',
        'facebook_url',
        'linkedin_url',
        'youtube_url',
        'instagram_url',
        'twitter_url',
        'benefits_image',
        'video',
        'border_color',
        'background_color',
        'background_text_color',
        'button_color',
        'button_text_color',
        'footer_background_color',
        'footer_icon_color',
        'cover_image',
        'company_logo',
        'deleted_at',
    ];

    public static function getSubCompany($id) {
        return self::where('client_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }
    
    public static function getSubCompanyName($id) {
        $data = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $company_name = '';
        if(isset($data->company_name) && !empty($data->company_name)){
            $company_name = $data->company_name;
        }
        return $company_name;
    }
    
    public static function getSubUserName($id) {
        $data = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $company_name = '';
        if(isset($data->company_name) && !empty($data->company_name)){
            $company_name = $data->company_name;
        }
        return $company_name;
    }
    
    public static function getSubCompanyData($id) {
        $data = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        return $data;
    }
}
