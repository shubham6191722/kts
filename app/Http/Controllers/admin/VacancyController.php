<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Country;
use App\Models\Region;
use App\Models\Category;
use App\Models\Occupation;

class VacancyController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
       
        return view('admin.job.vacancy.index');
    }

    public function add() {

        $country = Country::getAll();
        $region = Region::getSelectValue();
        $category = Category::getAll();
        $occupation = Occupation::getSelectValue();
        return view('admin.job.vacancy.add')->with('country',$country)->with('region',$region)->with('category',$category)->with('occupation',$occupation);
    }
    
    public function regionGet(Request $request) {

        $id = $request->id;
        $region = Region::getValuer($id);

        if(isset($region) && !empty($region)){
            return response()->json(['stage_data' => $region,'code' => 1]);
        }
        return response()->json(['stage_data' => $region,'code' => 0]);
    }
    
    public function categoryidGet(Request $request) {

        $id = $request->id;
        $occupation = Occupation::getValuer($id);

        if(isset($occupation) && !empty($occupation)){
            return response()->json(['stage_data' => $occupation,'code' => 1]);
        }
        return response()->json(['stage_data' => $occupation,'code' => 0]);
    }

}
