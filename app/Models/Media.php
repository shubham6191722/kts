<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {

    protected $table = 'media'; 

    protected $fillable = [
        'user_id',
        'file_name',
        'file_type',
        'file_size',
        'deleted_at',
    ];

    public static function getData($id) {
        return self::where('user_id','=',$id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
    }

    public static function getPdf($id) {
        $strMissing = ['jpg','png','jpeg','gif'];
        $data = self::where('user_id','=',$id)->whereNotIn('file_type',$strMissing)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
    
    public static function getImage($id) {
        $strMissing = ['jpg','png','jpeg','gif'];
        $data = self::where('user_id','=',$id)->whereIn('file_type',$strMissing)->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
        return $data;
    }
}
