<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\JobApplied;
use App\Models\JobVacancy;
use App\Models\JobCategory;
use App\Models\Region;

class ClientJobController extends Controller {

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
    public function index(Request $request,$id) {

        if(isset($id) && !empty($id)){

            $user_data = User::where('client_slug','=',$id)->first();

            $job_category = JobCategory::getAll();
            $rateupper = JobVacancy::where('deleted_at','=',null)->orderBy('rateupper', 'desc')->first();
            $max_rateupper = '150000';

            $regionData = Region::getSelectValue();

            $jobtenure = null;
            if(isset($request->jobtenure) && !empty($request->jobtenure)){
                $jobtenure = $request->jobtenure;
            }

            $category = null;
            if(isset($request->categoryid) && !empty($request->categoryid)){
                $category = $request->categoryid;
            }

            $min_price = 0;
            if(isset($request->min_price) && !empty($request->min_price)){
                $min_price = $request->min_price;
            }

            $max_price = null;
            if(isset($request->max_price) && !empty($request->max_price)){
                $max_price = $request->max_price;
            }

            $job_title_skill = null;
            if(isset($request->job_title_skill) && !empty($request->job_title_skill)){
                $job_title_skill = $request->job_title_skill;
            }

            $region = null;

            $work_base_preference = null;
            if(isset($request->work_base_preference) && !empty($request->work_base_preference)){
                $work_base_preference = $request->work_base_preference;
            }

            $location_data = null;
            if(isset($request->location_data) && !empty($request->location_data)){
                $location_data = $request->location_data;
            }
            $latitude = null;
            if(isset($request->latitude) && !empty($request->latitude)){
                $latitude = $request->latitude;
            }
            $longitude = null;
            if(isset($request->longitude) && !empty($request->longitude)){
                $longitude = $request->longitude;
            }
            $distance_km = null;
            if(isset($request->distance_km) && !empty($request->distance_km)){
                $distance_km = $request->distance_km;
            }

            $job_data = JobVacancy::clientJobVacancyLive($user_data->id,$jobtenure,$category,$min_price,$max_price,$job_title_skill,$region,$work_base_preference,$location_data,$latitude,$longitude,$distance_km);

            $job_data->appends(['jobtenure' => $jobtenure,'category' => $category,'min_price' => $min_price,'max_price' => $max_price,'job_title_skill' => $job_title_skill,'region' => $region,'work_base_preference' => $work_base_preference,
                                'location_data' => $location_data,'latitude' => $latitude,'longitude' => $longitude,'distance_km' => $distance_km]);

            return view('frontend.client_job.index')->with('job_data',$job_data)->with('job_category',$job_category)->with('max_rateupper',$max_rateupper)->with('regionData',$regionData)
                                            ->with('job_title_skill',$job_title_skill)->with('region',$region)->with('min_price',$min_price)->with('max_price',$max_price)
                                            ->with('category',$category)->with('jobtenure',$jobtenure)->with('work_base_preference',$work_base_preference)->with('id',$id)
                                            ->with('location_data',$location_data)->with('latitude',$latitude)->with('longitude',$longitude)
                                            ->with('distance_km',$distance_km);

        }else{
            return redirect()->route('home.index');
        }
    }

}
