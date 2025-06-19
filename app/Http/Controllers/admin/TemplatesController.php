<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\CustomFunction\CustomFunction;
use Config;

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

class TemplatesController extends Controller {

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

        if(Auth::check()){
            $id = Auth::user()->id;
            $template_data = Template::getData($id);
            return view('admin.job.template.index')->with('id',$id)->with('template_data',$template_data);
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function update(Request $request) {

        $request->validate([
            'template_name' => 'required',
                ], [
            'template_name.required' => 'Please enter Template Name!',
        ]);

        $template_data = Template::find($request->id);
        $template_data->template_name = $request->template_name;
        $template_data->updated_at = date('Y-m-d H:i:s');
        if ($template_data->save()) {

            return back()->with('success', 'Templates successfully update.');
            
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

        $template_data = Template::find($request->id);

        if ($template_data->delete()) {

            return back()->with('success', 'Job Vacancy successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function saveVacancyTemplate(Request $request) {

        $request->validate([
            'id' => 'required',
            'template_name' => 'required',
                ], [
            'id.required' => 'Please try again!',
            'template_name.required' => 'Please enter Template Name!',
        ]);

        $random_no = CustomFunction::random_string(10);

        $job_vacancy = JobVacancy::find($request->id);

        $template_data = new Template;
        $template_data->user_id = Auth::user()->id;
        $template_data->template_name = $request->template_name;
        $template_data->template_id = $request->id;
        $template_data->managed_by = $job_vacancy->managed_by;
        $template_data->user_select = $job_vacancy->user_select;
        $template_data->jobtitle = $job_vacancy->jobtitle;
        $template_data->jobtenure = $job_vacancy->jobtenure;
        $template_data->startdate = $job_vacancy->startdate;
        $template_data->duration = $job_vacancy->duration;
        $template_data->lengthofcontract = $job_vacancy->lengthofcontract;
        $template_data->durationperiod = $job_vacancy->durationperiod;
        $template_data->weeklyworkinghours = $job_vacancy->weeklyworkinghours;
        $template_data->ratelower = $job_vacancy->ratelower;
        $template_data->rateupper = $job_vacancy->rateupper;
        $template_data->locatedcountry = $job_vacancy->locatedcountry;
        $template_data->locatedregion = $job_vacancy->locatedregion;
        $template_data->altlocation = $job_vacancy->altlocation;
        $template_data->locatedpostcode = $job_vacancy->locatedpostcode;
        $template_data->categoryid = $job_vacancy->categoryid;
        $template_data->occupationid = $job_vacancy->occupationid;
        $template_data->levelid = $job_vacancy->levelid;
        $template_data->jobdescription = $job_vacancy->jobdescription;
        $template_data->skillsrequired = $job_vacancy->skillsrequired;
        $template_data->qualificationsrequired = $job_vacancy->qualificationsrequired;
        $template_data->infofromthehiringmanager = $job_vacancy->infofromthehiringmanager;
        $template_data->keywords = $job_vacancy->keywords;
        $template_data->jobcategory1 = $job_vacancy->jobcategory1;
        $template_data->jobvacancystatus = $job_vacancy->jobvacancystatus;
        $template_data->jobvacancystage = $job_vacancy->jobvacancystage;
        $template_data->cover_image = $job_vacancy->cover_image;
        $template_data->hiring_manager_file_title = $job_vacancy->hiring_manager_file_title;
        $template_data->slug = $random_no;
        $template_data->job_specification = $job_vacancy->job_specification;
        $template_data->specification_file_title = $job_vacancy->specification_file_title;
        $template_data->jobworkflow_id = $job_vacancy->jobworkflow_id;
        $template_data->media_specification = $job_vacancy->media_specification;
        $template_data->media_hiring_manager = $job_vacancy->media_hiring_manager;

        $template_data->benefits = $job_vacancy->benefits;
        $template_data->work_base_preference = $job_vacancy->work_base_preference;
        $template_data->staff_select = $job_vacancy->staff_select;
        $template_data->recruiter_select = $job_vacancy->recruiter_select;
        $template_data->staff_arr = $job_vacancy->staff_arr;
        $template_data->recruiter_arr = $job_vacancy->recruiter_arr;
        $template_data->sub_company = $job_vacancy->sub_company;

        $template_data->benefits_image = $job_vacancy->benefits_image;
        $template_data->benefits_file_title = $job_vacancy->benefits_file_title;


        $template_data->save();

        if ($template_data->save()) {
            return back()->with('success', 'Templates successfully save!');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function templateGet(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $template_data = Template::find($request->id);

        if(isset($template_data) && !empty($template_data)){
            return response()->json(['template_data' => $template_data,'code' => 1]);
        }
        return response()->json(['template_data' => $template_data,'code' => 0]);
    }

}
