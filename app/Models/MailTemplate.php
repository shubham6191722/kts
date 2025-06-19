<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\CustomFunction\CustomFunction;

class MailTemplate extends Model
{

    protected $fillable = [
        'template_title',
        'email_subject',
        'email_description',
        'client_id',
        'cover_image',
        'sub_company',
    ];
    protected $table = 'mail_templates';
    protected $primaryKey = 'id';

    public static function getAll($id)
    {
        $data = self::where('client_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
    public static function getClientDataAll($id)
    {
        $data = self::where('client_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
    public static function getClientData($id)
    {
        $data = self::where('client_id','=',$id)->where('sub_company','=',null)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
    public static function getSubClientData($id,$sub_company)
    {
        $data = self::where('client_id','=',$id)->where('sub_company','=',$sub_company)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
    public static function getTemplateName($id)
    {
        $data = self::where('id','=',$id)->where('deleted_at','=',null)->first();
        $name = '';
        if(isset($data->template_title) && !empty($data->template_title)){
            $name = $data->template_title;
        }
        return $name;
    }

}
