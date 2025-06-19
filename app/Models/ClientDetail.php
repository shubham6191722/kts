<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model {

    protected $table = 'client_detail'; 

    protected $fillable = [
        'client_id',
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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function getData($id) {
        $data = self::where('client_id', "=", $id)->where('deleted_at', "=", null)->first();
        return $data;
    }
    
}
