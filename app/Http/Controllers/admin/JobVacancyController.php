<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\CustomFunction\CustomFunction;
use Config;
use File;

use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Country;
use App\Models\Region;
use App\Models\JobCategory;
use App\Models\JobOccupation;
use App\Models\JobLevel;
use App\Models\JobSectors;
use App\Models\JobCurrency;
use App\Models\JobVacancy;
use App\Models\JobSkill;
use App\Models\JobKeyWord;
use App\Models\JobWorkFlow;
use App\Models\Template;
use App\Models\Media;
use App\Models\Notifications;
use App\Models\RecruiterAssign;
use App\Models\SubCompany;

class JobVacancyController extends Controller {

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
    public function index(Request $request) {
     
        $q_jobvacancystatus = $q_jobvacancystage = $q_managed_by = $q_jobtenure = $q_locatedregion = $q_categoryid = $q_jobcategory1 = $q_user_select = $q_sub_company = $jobtitle = $hiring_manager = null;
        $search = null;
        $client = null;
        if(!empty($request->all())){
            $q_jobvacancystatus = $request->jobvacancystatus;
            $q_jobvacancystage = $request->jobvacancystage;
            $q_managed_by = $request->managed_by;
            $q_jobtenure = $request->jobtenure;
            $q_locatedregion = $request->locatedregion;
            $q_categoryid = $request->categoryid;
            $q_jobcategory1 = $request->jobcategory1;
            $q_user_select = $request->user_select;
            $q_sub_company = $request->sub_company;
            $jobtitle = $request->jobtitle;
            $hiring_manager = $request->hiringmanager;
            $search = 1;
        }
        $check_sub_company = 0;
        $sub_company_data = null;
        $get_hiring_manager = null;

        if(Auth::check()){
            $re_job_vacancy = null;
            if(Auth::user()->role == 1){
                $client = User::clientList();

                if(!empty($q_user_select) && $q_user_select != 'all'){
                    $sub_company_data = SubCompany::getSubCompany($q_user_select);
                }
                if(isset($sub_company_data) && !empty($sub_company_data) && count($sub_company_data)){
                    $check_sub_company = 1;
                }

                if(isset($search) && !empty($search)){
                    $job_vacancy = JobVacancy::getDirectSearch($q_user_select,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$q_sub_company);
                    $re_job_vacancy = JobVacancy::getReSourceSearch($q_user_select,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$q_sub_company);
                }else{
                    $job_vacancy = JobVacancy::getDirect();
                    $re_job_vacancy = JobVacancy::getReSource();
                }
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                
                $sub_company_data = SubCompany::getSubCompany($id);
                if(isset($sub_company_data) && !empty($sub_company_data) && count($sub_company_data)){
                    $check_sub_company = 1;
                }

                $get_hiring_manager = User::getHiringManager($id);

                if(isset($search) && !empty($search)){
                    $job_vacancy = JobVacancy::clientVacancySearchData($id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle,$q_sub_company,$hiring_manager);
                }else{
                    $job_vacancy = JobVacancy::clientVacancyData($id);
                }
            }elseif(Auth::user()->role == 3){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }
                $get_hiring_manager = User::getHiringManagerStaff($id);
                if(isset($search) && !empty($search)){
                    $job_vacancy = JobVacancy::staffVacancySearchData(Auth::user()->id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle,$q_sub_company,$hiring_manager);
                }else{
                    $job_vacancy = JobVacancy::staffVacancyData(Auth::user()->id);
                }
            }elseif(Auth::user()->role == 4){
                if(isset($search) && !empty($search)){
                    $job_vacancy = JobVacancy::recruiterVacancySearchData(Auth::user()->id,$q_jobvacancystatus, $q_jobvacancystage, $q_managed_by, $q_jobtenure, $q_locatedregion, $q_categoryid, $q_jobcategory1,$jobtitle);
                }else{
                    $job_vacancy = JobVacancy::recruiterVacancyData(Auth::user()->id);
                }
            }

            $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
            $jobvacancystage = Config::get('dropdown.jobvacancystage');

            $job_sectors = JobSectors::getAll();
            $region = Region::getValuer('GBR');
            $job_category = JobCategory::getAll();

            if(Auth::user()->role == 1){
                return view('admin.job.vacancy.resource_index')->with('re_job_vacancy',$re_job_vacancy)
                                                               ->with('job_vacancy',$job_vacancy)->with('jobvacancystatus',$jobvacancystatus)
                                                               ->with('jobvacancystage',$jobvacancystage)->with('job_sectors',$job_sectors)
                                                               ->with('region',$region)->with('job_category',$job_category)
                                                               ->with('q_managed_by',$q_managed_by)->with('client',$client)->with('sub_company_data',$sub_company_data)
                                                               ->with('check_sub_company',$check_sub_company);
            }else{
                return view('admin.job.vacancy.index')->with('re_job_vacancy',$re_job_vacancy)
                                                      ->with('job_vacancy',$job_vacancy)->with('jobvacancystatus',$jobvacancystatus)
                                                      ->with('jobvacancystage',$jobvacancystage)->with('job_sectors',$job_sectors)
                                                      ->with('region',$region)->with('job_category',$job_category)->with('sub_company_data',$sub_company_data)
                                                      ->with('check_sub_company',$check_sub_company)->with('get_hiring_manager',$get_hiring_manager);
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function add() {

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $id = Auth::user()->created_user_id;
        }else{
            $id = Auth::user()->id;
        }

        $country = Country::getAll();
        $region = Region::getSelectValue();
        $job_category = JobCategory::getAll();
        $job_occupation = JobOccupation::getSelectValue();
        $job_level = JobLevel::getAll();
        $job_sectors = JobSectors::getAll();
        $job_currency = JobCurrency::getAll();
        $client_data = User::clientJobVacancy();

        $jobKeyWordList = JobKeyWord::jobKeyWordList();

        $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
        $jobvacancystage = Config::get('dropdown.jobvacancystage');

        $media_pdf = Media::getPdf($id);
        $media_image = Media::getImage($id);
        $templateData = Template::getData(Auth::user()->id);

        $staff_data = User::staffList($id);

        $recruiter_assign_list = RecruiterAssign::getDataForCandidate($id);
        $recruiter_data = null;
        if(isset($recruiter_assign_list) && !empty($recruiter_assign_list)){
            $k = explode(",",$recruiter_assign_list->client_assign_recruiter);
            $recruiter_data = User::whereIn('id', $k)->where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        }


        $jobWorkFlow = '';
        if(Auth::check()){
            if(Auth::user()->role == 1){
                
            }elseif(Auth::user()->role == 3){
                $jobWorkFlow = JobWorkFlow::getUserWise(Auth::user()->created_user_id);
            }else{
                $jobWorkFlow = JobWorkFlow::getUserWise($id);
            }
        }

        $sub_company = '';
        $sub_company_check = false;
        if(Auth::check()){
            if(Auth::user()->role == 2){
                $sub_company = SubCompany::getSubCompany($id);
                if(count($sub_company)){
                    $sub_company_check = true;
                }
            }
        }

        return view('admin.job.vacancy.add')->with('country',$country)->with('region',$region)->with('job_category',$job_category)
                                            ->with('job_occupation',$job_occupation)->with('job_level',$job_level)->with('job_sectors',$job_sectors)
                                            ->with('job_currency',$job_currency)->with('client_data',$client_data)
                                            ->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)
                                            ->with('jobKeyWordList',$jobKeyWordList)->with('jobWorkFlow',$jobWorkFlow)
                                            ->with('templateData',$templateData)->with('media_pdf',$media_pdf)
                                            ->with('media_image',$media_image)->with('staff_data',$staff_data)
                                            ->with('recruiter_data',$recruiter_data)->with('sub_company',$sub_company)->with('sub_company_check',$sub_company_check);
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
        $job_occupation = JobOccupation::getValuer($id);
        $skillList = JobSkill::getValuer($id);

        if(isset($job_occupation) && !empty($job_occupation)){
            return response()->json(['stage_data' => $job_occupation,'skillList' => $skillList,'code' => 1]);
        }
        return response()->json(['stage_data' => $job_occupation,'skillList' => $skillList,'code' => 0]);
    }

    public function pipelineGet(Request $request) {

        $id = $request->id;
        $jobWorkFlow = JobWorkFlow::getUserWise($id);

        $staff_list = User::staffList($id);

        $recruiter_assign_list = RecruiterAssign::getDataForCandidate($id);
        $recruiter_list = null;
        if(isset($recruiter_assign_list->client_assign_recruiter) && !empty($recruiter_assign_list->client_assign_recruiter)){
          $k = explode(",",$recruiter_assign_list->client_assign_recruiter);
          $recruiter_list = User::whereIn('id', $k)->where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        }

        $sub_company = SubCompany::getSubCompany($id);

        if(isset($jobWorkFlow) && !empty($jobWorkFlow)){
            return response()->json(['stage_data' => $jobWorkFlow,'staff_list' => $staff_list,'recruiter_list' => $recruiter_list,'sub_company' => $sub_company,'code' => 1]);
        }
        return response()->json(['stage_data' => $jobWorkFlow,'staff_list' => $staff_list,'recruiter_list' => $recruiter_list,'sub_company' => $sub_company,'code' => 0]);
    }

    public function subCompanyGet(Request $request) {

        $id = $request->id;
        $sub_company = SubCompany::getSubCompany($id);

        return response()->json(['sub_company' => $sub_company,'code' => 1]);
    }

    public function create(Request $request) {
        $request->validate([
            'jobtitle' => 'required',
            'jobdescription' => 'required',
            'categoryid' => 'required',
            'occupationid' => 'required',
            'levelid' => 'required',
            'locatedregion' => 'required',
            'locatedcountry' => 'required',
            'jobcategory1' => 'required',
            "job_specification_file" => "mimes:pdf|max:10000",
            'video_file' => 'mimes:mp4,ogx,oga,ogv,ogg,webm|max:102400',
                ], [
            'jobtitle.required' => 'Please enter Job title!',
            'jobdescription.required' => 'Please enter Description!',
            'categoryid.required' => 'Please Select Job category!',
            'occupationid.required' => 'Please Select Job Occupation!',
            'locatedregion.required' => 'Please Select Region!',
            'locatedcountry.required' => 'Please Select Country!',
            'jobcategory1.required' => 'Please Select Markets 1!',
            'job_specification_file.mimes' => 'Please Select PDF File!',
            'video_file.max' => 'File too Big, please select a file less than 100mb!',
        ]);

        $random_no = CustomFunction::random_string(10);

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $user_id = Auth::user()->created_user_id;
        }else{
            $user_id = Auth::user()->id;
        }
        $folderName = '/job_vacancy';
        $folderPath = '';

        $input = $request->all();

        $skill = null;
        if($request->skillsrequired){
            $skill = implode(',', $request->skillsrequired);
        }

        $keyword = null;
        if($request->keywords){
            $keyword = implode(',', $request->keywords);
        }

        $job_specification = null;
        $specification_file_title = null;
        $specification_file_id = null;
        if($request->media_specification == 'media'){
            $job_specification = $request->specification_file_value;
            $specification_file_title = $request->specification_file_title;
            $specification_file_id = $request->specification_file_id;
        }else{
            if ($request->hasFile('job_specification_file')) {
                $file = $request->file('job_specification_file');
                $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                $job_specification = $fileName['name'];

                $file_name = $fileName['name'];
                $file_type = $fileName['extension'];
                $file_title = $fileName['file_title'];

                $specification_file_title = $file_title;

                $media = new Media;
                $media->user_id = $user_id;
                $media->file_name = $file_name;
                $media->file_type = $file_type;
                $media->file_title = $file_title;
                $media->save();
                $specification_file_id = $media->id;
            }
        }

        $cover_image = null;
        $hiring_manager_file_title = null;
        $hiring_manager_file_id = null;
        if($request->media_hiring_manager == 'media'){
            $cover_image = $request->hiring_manager_file_value;
            $hiring_manager_file_title = $request->hiring_manager_file_title;
            $hiring_manager_file_id = $request->hiring_manager_file_id;
        }else{
            if ($request->hasFile('cover_image_file')) {
                $file = $request->file('cover_image_file');
                $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                $cover_image = $fileName['name'];

                $file_name = $fileName['name'];
                $file_type = $fileName['extension'];
                $file_title = $fileName['file_title'];

                $hiring_manager_file_title = $file_title;

                $media = new Media;
                $media->user_id = $user_id;
                $media->file_name = $file_name;
                $media->file_type = $file_type;
                $media->file_title = $file_title;
                $media->save();
                $hiring_manager_file_id = $media->id;
            }
        }

        $benefits_image = null;
        $benefits_file_title = null;
        $benefits_file_id = null;
        if($request->media_benefits == 'media'){
            $benefits_image = $request->benefits_file_value;
            $benefits_file_title = $request->benefits_file_title;
            $benefits_file_id = $request->benefits_file_id;
        }else{
            if ($request->hasFile('benefits_image_file')) {
                $file = $request->file('benefits_image_file');
                $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                $benefits_image = $fileName['name'];

                $file_name = $fileName['name'];
                $file_type = $fileName['extension'];
                $file_title = $fileName['file_title'];

                $benefits_file_title = $file_title;

                $media = new Media;
                $media->user_id = $user_id;
                $media->file_name = $file_name;
                $media->file_type = $file_type;
                $media->file_title = $file_title;
                $media->save();
                $benefits_file_id = $media->id;
            }
        }

        $work_base_preference = null;
        if($request->work_base_preference){
            $work_base_preference = implode(',', $request->work_base_preference);
        }

        $staff = array();
        if($request->staff_select){
            foreach($request->staff_select as $SKey => $s_value){
                $s_val = 'job_'.$s_value.'_vacancy';
                array_push($staff,$s_val);
            }
        }

        $staff_json = json_encode($staff);
        $staff_arr = null;
        if($request->staff_select){
            $staff_arr = implode(',', $request->staff_select);
        }

        $recruiter = array();
        if($request->recruiter_select){
            foreach($request->recruiter_select as $RKey => $r_value){
                $r_val = 'job_'.$r_value.'_vacancy';
                array_push($recruiter,$r_val);
            }
        }

        $recruiter_json = json_encode($recruiter);
        $recruiter_arr = null;
        if($request->recruiter_select){
            $recruiter_arr = implode(',', $request->recruiter_select);
        }


        $startdate = null;
        if($request->jobtenure != 'permanent'){
            if($request->startdate){
                $startdate = date('Y-m-d H:i:s', strtotime($request->startdate));
            }
        }

        $sub_company = null;
        if($request->sub_company){
            $sub_company = $request->sub_company;
        }

        $locatedpostcode = $latitude = $longitude = null;
        if($request->locatedpostcode){
            $locatedpostcode = $request->locatedpostcode;
            $lat_long = CustomFunction::getZipcode($locatedpostcode);
            $latitude  = $lat_long['lat'];
            $longitude = $lat_long['lng'];
        }

        $video_name = null;

        if ($request->hasFile('video_file')) {

            $file = $request->file('video_file');

            $random_no = CustomFunction::random_string(3);

            $fileName = $file->getClientOriginalName();
            $folder = substr($fileName, 0, strpos($fileName, '.'));
            $string = str_replace(' ', '-', $folder);
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

            $video_name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();
            $folderName = '/job_vacancy/';

            $file->move('uploads' . $folderName, $video_name);
        }


        $job_vacancy = new JobVacancy;
        $job_vacancy->managed_by = $request->managed_by;
        $job_vacancy->user_select = $request->user_select;
        $job_vacancy->sub_company = $sub_company;
        $job_vacancy->jobtitle = $request->jobtitle;
        $job_vacancy->jobtenure = $request->jobtenure;
        $job_vacancy->startdate = $startdate;
        $job_vacancy->duration = $request->duration;
        $job_vacancy->lengthofcontract = $request->lengthofcontract;
        $job_vacancy->durationperiod = $request->durationperiod;
        $job_vacancy->weeklyworkinghours = $request->weeklyworkinghours;
        $job_vacancy->ratelower = $request->ratelower;
        $job_vacancy->rateupper = $request->rateupper;
        $job_vacancy->locatedcountry = $request->locatedcountry;
        $job_vacancy->locatedregion = $request->locatedregion;
        $job_vacancy->altlocation = $request->altlocation;
        $job_vacancy->locatedpostcode = $locatedpostcode;
        $job_vacancy->categoryid = $request->categoryid;
        $job_vacancy->occupationid = $request->occupationid;
        $job_vacancy->levelid = $request->levelid;
        $job_vacancy->jobdescription = $request->jobdescription;
        $job_vacancy->skillsrequired = $skill;
        $job_vacancy->qualificationsrequired = $request->qualificationsrequired;
        $job_vacancy->infofromthehiringmanager = $request->infofromthehiringmanager;
        $job_vacancy->keywords = $keyword;
        $job_vacancy->jobcategory1 = $request->jobcategory1;
        $job_vacancy->jobvacancystatus = $request->jobvacancystatus;
        $job_vacancy->jobvacancystage = $request->jobvacancystage;
        $job_vacancy->cover_image = $cover_image;
        $job_vacancy->hiring_manager_file_title = $hiring_manager_file_title;
        $job_vacancy->hiring_manager_file_id = $hiring_manager_file_id;
        $job_vacancy->user_id = $user_id;
        $job_vacancy->slug = $random_no;
        $job_vacancy->job_specification = $job_specification;
        $job_vacancy->specification_file_title = $specification_file_title;
        $job_vacancy->specification_file_id = $specification_file_id;
        $job_vacancy->jobworkflow_id = $request->jobworkflow_id;
        $job_vacancy->benefits = $request->benefits;
        $job_vacancy->work_base_preference = $work_base_preference;

        $job_vacancy->media_specification = $request->media_specification;
        $job_vacancy->media_hiring_manager = $request->media_hiring_manager;

        $job_vacancy->staff_select = $staff_json;
        $job_vacancy->recruiter_select = $recruiter_json;
        $job_vacancy->staff_arr = $staff_arr;
        $job_vacancy->recruiter_arr = $recruiter_arr;

        $job_vacancy->latitude  = $latitude;
        $job_vacancy->longitude = $longitude;

        $job_vacancy->benefits_image = $benefits_image;
        $job_vacancy->benefits_file_title = $benefits_file_title;
        $job_vacancy->benefits_file_id = $benefits_file_id;
        $job_vacancy->video = $video_name;

        if ($job_vacancy->save()) {
            if($request->managed_by == 1){
                $user_data = User::find($request->user_select);
                $user_data->company_credits = $user_data->company_credits - 1;
                $user_data->save();
            }

            NotificationsController::notification($job_vacancy);

            $folderName = '/job_applied/'.$job_vacancy->id;
            File::makeDirectory(url('uploads').$folderName, 0777, true, true);

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.vacancyList';

            return redirect()->route($route_name)->with('success', 'You have successfully Add Job Vacancy.');
        } else {
            return back()->with('error', 'Please try again!');
        }

    }

    public function edit($id) {

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $user_id = Auth::user()->created_user_id;
        }else{
            $user_id = Auth::user()->id;
        }

        $job_vacancy = JobVacancy::find($id);

        $country = Country::getAll();
        $region = Region::getValuer($job_vacancy->locatedcountry);
        $job_category = JobCategory::getAll();
        $job_occupation = JobOccupation::getValuer($job_vacancy->categoryid);
        $job_level = JobLevel::getAll();
        $job_sectors = JobSectors::getAll();
        $job_currency = JobCurrency::getAll();
        $client_data = User::clientJobVacancy();

        $skillList = JobSkill::getValuer($job_vacancy->categoryid);
        $jobKeyWordList = JobKeyWord::jobKeyWordList();

        $media_pdf = Media::getPdf($user_id);
        $media_image = Media::getImage($user_id);

        $jobWorkFlow = JobWorkFlow::getUserWise($job_vacancy->user_select);

        $staff_data = User::staffList($job_vacancy->user_select);

        $recruiter_assign_list = RecruiterAssign::getDataForCandidate($job_vacancy->user_select);
        $recruiter_data = null;
        if(isset($recruiter_assign_list) && !empty($recruiter_assign_list)){
            $k = explode(",",$recruiter_assign_list->client_assign_recruiter);
            $recruiter_data = User::whereIn('id', $k)->where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
        }

        $sub_company_check = false;
        $sub_company = SubCompany::getSubCompany($job_vacancy->user_select);
        if(count($sub_company)){
            $sub_company_check = true;
        }

        $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
        $jobvacancystage = Config::get('dropdown.jobvacancystage');

        return view('admin.job.vacancy.edit')->with('job_vacancy',$job_vacancy)->with('country',$country)->with('region',$region)
                                            ->with('job_category',$job_category)->with('job_occupation',$job_occupation)->with('job_level',$job_level)
                                            ->with('job_sectors',$job_sectors)->with('job_currency',$job_currency)->with('client_data',$client_data)
                                            ->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)
                                            ->with('skillList',$skillList)->with('jobKeyWordList',$jobKeyWordList)->with('jobWorkFlow',$jobWorkFlow)
                                            ->with('media_pdf',$media_pdf)->with('media_image',$media_image)->with('staff_data',$staff_data)
                                            ->with('recruiter_data',$recruiter_data)->with('sub_company_check',$sub_company_check);
    }

    public function update(Request $request) {

        $request->validate([
            'jobtitle' => 'required',
            'jobdescription' => 'required',
            'categoryid' => 'required',
            'occupationid' => 'required',
            'levelid' => 'required',
            'locatedregion' => 'required',
            'locatedcountry' => 'required',
            'jobcategory1' => 'required',
            "job_specification_file" => "mimes:pdf|max:10000",
            'video_file' => 'mimes:mp4,ogx,oga,ogv,ogg,webm|max:102400',
                ], [
            'jobtitle.required' => 'Please enter Job title!',
            'jobdescription.required' => 'Please enter Description!',
            'categoryid.required' => 'Please Select Job category!',
            'occupationid.required' => 'Please Select Job Occupation!',
            'locatedregion.required' => 'Please Select Region!',
            'locatedcountry.required' => 'Please Select Country!',
            'jobcategory1.required' => 'Please Select Markets 1!',
            'job_specification_file.mimes' => 'Please Select PDF File!',
            'video_file.max' => 'File too Big, please select a file less than 100mb!',
        ]);

        $input = $request->all();

        if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            $user_id = Auth::user()->created_user_id;
        }else{
            $user_id = Auth::user()->id;
        }

        $skill = null;
        if($request->skillsrequired){
            $skill = implode(',', $request->skillsrequired);
        }

        $keyword = null;
        if($request->keywords){
            $keyword = implode(',', $request->keywords);
        }

        $folderName = '/job_vacancy';
        $folderPath = $request->user_select;
        $folderPath = '';


        $specification_file_title = null;
        $specification_file_id = null;
        if(isset($request->specification_file_title) && !empty($request->specification_file_title)){
            $specification_file_title = $request->specification_file_title;
        }
        if(isset($request->specification_file_id) && !empty($request->specification_file_id)){
            $specification_file_id = $request->specification_file_id;
        }

        $hiring_manager_file_title = null;
        $hiring_manager_file_id = null;
        if(isset($request->hiring_manager_file_title) && !empty($request->hiring_manager_file_title)){
            $hiring_manager_file_title = $request->hiring_manager_file_title;
        }
        if(isset($request->hiring_manager_file_id) && !empty($request->hiring_manager_file_id)){
            $hiring_manager_file_id = $request->hiring_manager_file_id;
        }

        $benefits_file_title = null;
        $benefits_file_id = null;
        if(isset($request->benefits_file_title) && !empty($request->benefits_file_title)){
            $benefits_file_title = $request->benefits_file_title;
        }
        if(isset($request->benefits_file_id) && !empty($request->benefits_file_id)){
            $benefits_file_id = $request->benefits_file_id;
        }

        $job_specification = null;
        if(isset($request->media_specification) && !empty($request->media_specification)){
            if($request->media_specification == 'media'){
                if(isset($request->specification_file_value) && !empty($request->specification_file_value)){
                    $job_specification = $request->specification_file_value;
                }else{
                    $job_specification = $request->job_specification;
                }

            }elseif($request->media_specification == 'select'){
                if ($request->hasFile('job_specification_file')) {
                    $file = $request->file('job_specification_file');
                    $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                    $job_specification = $fileName['name'];

                    $file_name = $fileName['name'];
                    $file_type = $fileName['extension'];
                    $file_title = $fileName['file_title'];

                    $specification_file_title = $file_title;

                    $media = new Media;
                    $media->user_id = $user_id;
                    $media->file_name = $file_name;
                    $media->file_type = $file_type;
                    $media->file_title = $file_title;
                    $media->save();
                    $specification_file_id = $media->id;
                }else{
                    if(isset($request->job_specification) && !empty($request->job_specification)){
                        $job_specification = $request->job_specification;
                    }
                }
            }
        }

        $cover_image = null;
        if(isset($request->media_hiring_manager) && !empty($request->media_hiring_manager)){
            if($request->media_hiring_manager == 'media'){
                if(isset($request->hiring_manager_file_value) && !empty($request->hiring_manager_file_value)){
                    $cover_image = $request->hiring_manager_file_value;
                }else{
                    $cover_image = $request->cover_image;
                }

            }elseif($request->media_hiring_manager == 'select'){
                if ($request->hasFile('cover_image_file')) {
                    $file = $request->file('cover_image_file');
                    $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                    $cover_image = $fileName['name'];

                    $file_name = $fileName['name'];
                    $file_type = $fileName['extension'];
                    $file_title = $fileName['file_title'];

                    $hiring_manager_file_title = $file_title;

                    $media = new Media;
                    $media->user_id = $user_id;
                    $media->file_name = $file_name;
                    $media->file_type = $file_type;
                    $media->file_title = $file_title;
                    $media->save();
                    $hiring_manager_file_id = $media->id;
                }else{
                    if(isset($request->cover_image) && !empty($request->cover_image)){
                        $cover_image = $request->cover_image;
                    }
                }
            }
        }

        $benefits_image = null;
        if(isset($request->media_benefits) && !empty($request->media_benefits)){
            if($request->media_benefits == 'media'){
                if(isset($request->benefits_file_value) && !empty($request->benefits_file_value)){
                    $benefits_image = $request->benefits_file_value;
                }else{
                    $benefits_image = $request->benefits_image;
                }

            }elseif($request->media_benefits == 'select'){
                if ($request->hasFile('benefits_image_file')) {
                    $file = $request->file('benefits_image_file');
                    $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                    $benefits_image = $fileName['name'];

                    $file_name = $fileName['name'];
                    $file_type = $fileName['extension'];
                    $file_title = $fileName['file_title'];

                    $benefits_file_title = $file_title;

                    $media = new Media;
                    $media->user_id = $user_id;
                    $media->file_name = $file_name;
                    $media->file_type = $file_type;
                    $media->file_title = $file_title;
                    $media->save();
                    $benefits_file_id = $media->id;
                }else{
                    if(isset($request->benefits_image) && !empty($request->benefits_image)){
                        $benefits_image = $request->benefits_image;
                    }
                }
            }
        }

        $work_base_preference = null;
        if($request->work_base_preference){
            $work_base_preference = implode(',', $request->work_base_preference);
        }

        $staff = array();
        if($request->staff_select){
            foreach($request->staff_select as $SKey => $s_value){
                $s_val = 'job_'.$s_value.'_vacancy';
                array_push($staff,$s_val);
            }
        }

        $staff_json = json_encode($staff);
        $staff_arr = null;
        if($request->staff_select){
            $staff_arr = implode(',', $request->staff_select);
        }

        $recruiter = array();
        if($request->recruiter_select){
            foreach($request->recruiter_select as $RKey => $r_value){
                $r_val = 'job_'.$r_value.'_vacancy';
                array_push($recruiter,$r_val);
            }
        }

        $recruiter_json = json_encode($recruiter);
        $recruiter_arr = null;
        if($request->recruiter_select){
            $recruiter_arr = implode(',', $request->recruiter_select);
        }

        $startdate = null;
        if($request->jobtenure != 'permanent'){
            if($request->startdate){
                $startdate = date('Y-m-d H:i:s', strtotime($request->startdate));
            }
        }

        $locatedpostcode = $latitude = $longitude = null;
        if($request->locatedpostcode){
            $locatedpostcode = $request->locatedpostcode;
            $lat_long = CustomFunction::getZipcode($locatedpostcode);
            $latitude  = $lat_long['lat'];
            $longitude = $lat_long['lng'];
        }

        $video_name = null;

        if ($request->hasFile('video_file')) {

            $file = $request->file('video_file');

            $random_no = CustomFunction::random_string(3);

            $fileName = $file->getClientOriginalName();
            $folder = substr($fileName, 0, strpos($fileName, '.'));
            $string = str_replace(' ', '-', $folder);
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

            $video_name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();
            $folderName = '/job_vacancy/';


            $file->move('uploads' . $folderName, $video_name);

            if(isset($request->video) && !empty($request->video)){
                $old_video = $request->video;
                $old_file = url('uploads') . $folderName . '/' . $old_video;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
        }else{
            $video_name = $request->video;
        }

        $job_vacancy = JobVacancy::find($request->id);
        $job_vacancy->jobtitle = $request->jobtitle;
        $job_vacancy->jobtenure = $request->jobtenure;
        $job_vacancy->startdate = $startdate;
        $job_vacancy->duration = $request->duration;
        $job_vacancy->lengthofcontract = $request->lengthofcontract;
        $job_vacancy->durationperiod = $request->durationperiod;
        $job_vacancy->weeklyworkinghours = $request->weeklyworkinghours;
        $job_vacancy->ratelower = $request->ratelower;
        $job_vacancy->rateupper = $request->rateupper;
        $job_vacancy->locatedcountry = $request->locatedcountry;
        $job_vacancy->locatedregion = $request->locatedregion;
        $job_vacancy->altlocation = $request->altlocation;
        $job_vacancy->locatedpostcode = $locatedpostcode;
        $job_vacancy->categoryid = $request->categoryid;
        $job_vacancy->occupationid = $request->occupationid;
        $job_vacancy->levelid = $request->levelid;
        $job_vacancy->jobdescription = $request->jobdescription;
        $job_vacancy->skillsrequired = $skill;
        $job_vacancy->qualificationsrequired = $request->qualificationsrequired;
        $job_vacancy->infofromthehiringmanager = $request->infofromthehiringmanager;
        $job_vacancy->keywords = $keyword;
        $job_vacancy->jobcategory1 = $request->jobcategory1;
        $job_vacancy->jobvacancystatus = $request->jobvacancystatus;
        $job_vacancy->jobvacancystage = $request->jobvacancystage;
        $job_vacancy->cover_image = $cover_image;
        $job_vacancy->hiring_manager_file_title = $hiring_manager_file_title;
        $job_vacancy->hiring_manager_file_id = $hiring_manager_file_id;
        $job_vacancy->job_specification = $job_specification;
        $job_vacancy->specification_file_title = $specification_file_title;
        $job_vacancy->specification_file_id = $specification_file_id;
        $job_vacancy->jobworkflow_id = $request->jobworkflow_id;
        $job_vacancy->benefits = $request->benefits;
        $job_vacancy->work_base_preference = $work_base_preference;

        $job_vacancy->staff_select = $staff_json;
        $job_vacancy->recruiter_select = $recruiter_json;
        $job_vacancy->staff_arr = $staff_arr;
        $job_vacancy->recruiter_arr = $recruiter_arr;

        $job_vacancy->latitude  = $latitude;
        $job_vacancy->longitude = $longitude;

        $job_vacancy->benefits_image = $benefits_image;
        $job_vacancy->benefits_file_title = $benefits_file_title;
        $job_vacancy->benefits_file_id = $benefits_file_id;
        $job_vacancy->video = $video_name;

        if ($job_vacancy->save()) {

            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.vacancyList';

            NotificationsController::notificationUpdate($job_vacancy);

            return redirect()->route($route_name)->with('success', 'You have successfully Update Job Vacancy.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $job_vacancy = JobVacancy::find($request->id);
        $job_vacancy->deleted_at = date('Y-m-d H:i:s');

        if ($job_vacancy->save()) {

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.vacancyList';

            return redirect()->route($route_name)->with('success', 'Job Vacancy successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function updateStatus(Request $request) {

        $id = $request->id;
        $change_value = $request->change_value;
        $value = $request->value;

        $job_vacancy = JobVacancy::find($id);
        $job_vacancy->$change_value = $value;

        if ($job_vacancy->save()) {
            return response()->json(['msg' => 'Vacancy status successfully updated.','code' => 1]);
        } else {
            return response()->json(['msg' => 'Please try again!','code' => 0]);
        }
    }

    public function recruiterViewVacancy($id) {

        $job_vacancy = JobVacancy::find($id);

        $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
        $jobvacancystage = Config::get('dropdown.jobvacancystage');

        return view('admin.job.vacancy.recruiter_vacancy_view')->with('job_vacancy',$job_vacancy)
                                            ->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage);
    }

    public function recruiterDownloadVacancy($id=null) {


        if(isset($id) && !empty($id)){

            $result = JobVacancy::find($id);


            $file_name = $result->job_specification;
            $job_id = $result->id;
            $file_path = url('uploads') . '/job_vacancy/'.$job_id.'/';
            $file_full_path = $file_path.$file_name;
            $headers = array(
                'Content-Type' => 'application/msword',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                'Content-Type' => 'application/vnd.ms-word.document.macroEnabled.12',
                'Content-Type' => 'application/vnd.ms-word.template.macroEnabled.12',
            );

            return response()->download($file_full_path,$file_name,$headers);

        }else{
            return redirect('/');
        }

    }

    public function getUserVacancy(Request $request) {

        $id = $request->id;
        if(isset($id) && !empty($id)){
            $vacancy_data = JobVacancy::getVacancyTitle($id);
            if(isset($vacancy_data) && !empty($vacancy_data)){
                return response()->json(['vacancy_data' => $vacancy_data,'code' => 1]);
            }
            return response()->json(['vacancy_data' => $vacancy_data,'code' => 0]);
        }else{
            return response()->json(['vacancy_data' => null,'code' => 0]);
        }
    }
}
