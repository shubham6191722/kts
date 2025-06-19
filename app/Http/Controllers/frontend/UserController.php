<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\CustomFunction\CustomFunction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Region;
use App\Models\JobVacancy;
use App\Models\JobSkill;
use App\Models\UserDetail;
use App\Models\SiteSetting;
use App\Models\JobCategory;
use App\Models\JobEvent;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class UserController extends BaseController {

    public function __construct() {

    }

    /**
     *
     * @return type
     */

    public function getIndex(Request $request)
    {

        $job_data = JobVacancy::jobVacancyLive();
        $count = JobVacancy::jobVacancyLive()->count();
        $job_skill = JobSkill::skillList();
        $region = Region::getSelectValue();
        $job_category = JobCategory::getAll();
        return view('frontend.index')->with('job_data',$job_data)->with('count',$count)->with('region',$region)->with('job_skill',$job_skill)->with('job_category',$job_category);

    }

    public function jobList(Request $request)
    {
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

        $job_data = JobVacancy::jobVacancyLiveAll($jobtenure,$category,$min_price,$max_price,$job_title_skill,$region,$work_base_preference,$location_data,$latitude,$longitude,$distance_km);
        $job_data->appends(['jobtenure' => $jobtenure,'category' => $category,'min_price' => $min_price,'max_price' => $max_price,'job_title_skill' => $job_title_skill,'region' => $region,'work_base_preference' => $work_base_preference,
                            'location_data' => $location_data,'latitude' => $latitude,'longitude' => $longitude,'distance_km' => $distance_km]);

        return view('frontend.list_job')->with('job_data',$job_data)->with('job_category',$job_category)->with('max_rateupper',$max_rateupper)->with('regionData',$regionData)
                                        ->with('job_title_skill',$job_title_skill)->with('region',$region)->with('min_price',$min_price)->with('max_price',$max_price)
                                        ->with('category',$category)->with('jobtenure',$jobtenure)->with('work_base_preference',$work_base_preference)
                                        ->with('location_data',$location_data)->with('latitude',$latitude)->with('longitude',$longitude)
                                        ->with('distance_km',$distance_km);
    }
    
    public function jobListData(Request $request)
    {
        $job_category = JobCategory::getAll();
        $rateupper = JobVacancy::where('deleted_at','=',null)->orderBy('rateupper', 'desc')->first();
        $max_rateupper = '120000';

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

        $job_data = JobVacancy::jobVacancyLiveAll($jobtenure,$category,$min_price,$max_price,$job_title_skill,$region,$work_base_preference,$location_data,$latitude,$longitude,$distance_km);

        $statusJobData = view('frontend.job_list_data')->with('job_data', $job_data)->render();
        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }
    
    public function jobSearchLatLong(Request $request)
    {
        
        $locatedpostcode = $request->location_data;
        $lat_long = CustomFunction::getZipcode($locatedpostcode);
        $latitude  = $lat_long['lat'];
        $longitude = $lat_long['lng'];
        return response()->json(['latitude' => $latitude, 'longitude' => $longitude, 'code' => 1]);

    }

    public function rCategoryidGet(Request $request) {

        $id = $request->id;
        $skillList = JobSkill::getValuer($id);

        if(isset($skillList) && !empty($skillList)){
            return response()->json(['skillList' => $skillList,'code' => 1]);
        }
        return response()->json(['skillList' => $skillList,'code' => 0]);
    }

    public function termsCondition(Request $request,$id = null) {

        $siteSettingData = SiteSetting::where('site_title','=','termsCondition')->first();

        if(isset($siteSettingData) && !empty($siteSettingData)){
            $title = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_favicon)));
            $description = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_notification_email)));
        }else{
            $title = 'Terms and Condition';
            $description = '';
        }
        
        return view('frontend.terms_condition')->with('title',$title)->with('description',$description);
    }
    
    public function privacyPolicy(Request $request) {

        $siteSettingData = SiteSetting::where('site_title','=','privacyPolicy')->first();
        
        if(isset($siteSettingData) && !empty($siteSettingData)){
            $title = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_favicon)));
            $description = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_notification_email)));
        }else{
            $title = 'Privacy Policy';
            $description = '';
        }

        return view('frontend.terms_condition')->with('title',$title)->with('description',$description);
    }
    
    public function getGDPR(Request $request) {

        $siteSettingData = SiteSetting::where('site_title','=','gdpr')->first();
        
        if(isset($siteSettingData) && !empty($siteSettingData)){
            $title = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_favicon)));
            $description = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_notification_email)));
        }else{
            $title = 'GDPR';
            $description = '';
        }

        return view('frontend.terms_condition')->with('title',$title)->with('description',$description);
    }

    public function updateEventNormal(Request $request) {
        $start_date = date('Y-m-d');
        $date = date("Y-m-d", strtotime("-1 day", strtotime($start_date)));
        $data = JobEvent::getAllPastEvent($date);
        dd($data);
    }
    
    public function mailDemoFunction(Request $request) {
        try {

            $siteSetting = SiteSetting::first();
            $site_title  = $site_header_logo = null;

            $site_header_logo = url('assets/frontend').'/img/logo.png';
            if (isset($siteSetting) && !empty($siteSetting)) {
                $site_title = $siteSetting->site_title;
                if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                    $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
                }
            }
    
            $email = 'sunny.tzinfotech@gmail.com';
            $data = [
                'siteTitle' => $site_title,
                'siteHeaderLogo' => $site_header_logo,
                'name' => 'Test User',
                'password' => '12312',
                'email' => 'test@gmail.com',
                'link' => 'https://www.google.co.in/',
                
            ];

            $email_subject = 'Test Mail';
            Mail::send('frontend.email_template.client_registration', $data, function ($message) use ($email, $email_subject) {
                $message->to($email)->subject($email_subject);
            });

            dd('mail send');

        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
            dd($error_msg);
        }
    }

}
