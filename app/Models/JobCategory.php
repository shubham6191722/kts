<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model {

    protected $table = 'job_category'; 

    protected $fillable = [
        'category_id',
        'category',
    ];

    public static function getAll() {
        return self::orderBy('id', 'asc')->get();
    }

    public static function categoryName($id) {
        $category_name = self::where('category_id', "=", $id)->first();
        $category = null;
        if(isset($category_name->category) && !empty($category_name->category)){
            $category = $category_name->category;
        }
        return $category;
    }

}
