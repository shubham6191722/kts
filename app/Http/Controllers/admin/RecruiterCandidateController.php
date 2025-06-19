<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Hash;
use Mail;
use Session;

use App\Http\Controllers\NotificationsController;

use App\Models\Region;
use App\Models\JobVacancy;
use App\Models\JobApplied;
use App\Models\RecruiterCandidate;
use App\Models\JobEvent;
use App\Models\JobOffers;
use App\Models\JobActivity;
use App\Models\Notifications;
use App\Models\MessageCount;
use App\Models\Message;
use App\Models\OfferLeavingReason;

class RecruiterCandidateController extends Controller {

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
    public function index(){

        if(Auth::check()){
            $id = Auth::user()->id;
            $recruiter_candidate = RecruiterCandidate::recruiterDataGet($id);
            return view('admin.recruiter_add_candidate.index')->with('id',$id)->with('recruiter_candidate',$recruiter_candidate);
        }else{
            return redirect()->route('home.index');
        }

    }

    public function add(){

        if(Auth::check()){
            $job_vacancy = JobVacancy::recruiterVacancyDataAdd(Auth::user()->id);
            $region = Region::getSelectValue();
            return view('admin.recruiter_add_candidate.add')->with('job_vacancy',$job_vacancy)->with('region',$region);
        }else{
            return redirect()->route('home.index');
        }
        
    }
    
    public function create(Request $request){

        
        $request->validate([
            'cv_file' => 'required|mimes:pdf,docx,doc',
            'fname' => 'required',
            'lname' => 'required',
            'notice_period' => 'required',
            'salary_expectations' => 'required',
            'work_base_preferences' => 'required',
                ], [
            'cv_file.mimes' => 'CV allow only pdf file.',
            'cv_file.required' => 'Please select CV.',
            'cv_file.max' => 'CV should be less than 3 mb.',
            'fname.required' => 'First Name is required!',
            'lname.required' => 'Last Name is required!',
            'notice_period.required' => 'Notice Period is required!',
            'salary_expectations.required' => 'Salary Expectations is required!',
            'work_base_preferences.required' => 'Work Base Preferences is required!',
        ]);

        $job_id = $request->job_id;
        $recruiter_id = $request->recruiter_id;
        $job_reference = '1';
        $folderName = '/job_applied/'.$job_id;

        $job_vacancy_data =  JobVacancy::recruiterVacancyGetData($job_id);

        $cv_file = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $fileName = CustomFunction::fileUpload($file, null, $folderName);
            $cv_file = $fileName;
        }

        $recruiter_candidate = new RecruiterCandidate;
        $recruiter_candidate->recruiter_id = $recruiter_id;
        $recruiter_candidate->job_id = $job_id;
        $recruiter_candidate->fname = $request->fname;
        $recruiter_candidate->lname = $request->lname;
        $recruiter_candidate->notice_period = $request->notice_period;
        $recruiter_candidate->salary_expectations = $request->salary_expectations;
        $recruiter_candidate->work_base_preferences = $request->work_base_preferences;
        $recruiter_candidate->cv = $cv_file;

        if ($recruiter_candidate->save()) {

            $job_applied = new JobApplied;
            $job_applied->job_id = $job_id;
            $job_applied->notice_period = $request->notice_period;
            $job_applied->salary_expectations = $request->salary_expectations;
            $job_applied->work_base_preferences = $request->work_base_preferences;
            $job_applied->cv_file = $cv_file;
            $job_applied->job_status = 1;
            $job_applied->job_stage = 1;
            
            $job_applied->job_workflow_id = $job_vacancy_data['job_workflow_id'];
            $job_applied->client_id = $job_vacancy_data['client_id'];
            $job_applied->managed_by = $job_vacancy_data['managed_by'];
            $job_applied->job_reference = "1";
            $job_applied->thumbs_status = 0;

            $job_applied->user_id = $recruiter_candidate->id;
            $job_applied->save();

            $r_c_id = $recruiter_candidate->id;

            NotificationsController::notificationRecruiterCandidate($request->job_id,$recruiter_id,$job_reference,$r_c_id);

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.recruiterCandidateList';

            return redirect()->route($route_name)->with('success', 'Candidate add successfully.');

        } else {
            return back()->with('error', 'Oh no. An error has occurred. Please check you have completed all the fields!');
        }
        
    }

    public function edit($id){

        if(Auth::check()){
            $job_vacancy = JobVacancy::recruiterVacancyData(Auth::user()->id);
            $region = Region::getSelectValue();
            $recruiter_candidate_data = RecruiterCandidate::find($id);
            return view('admin.recruiter_add_candidate.edit')->with('job_vacancy',$job_vacancy)->with('region',$region)->with('recruiter_candidate_data',$recruiter_candidate_data);
        }else{
            return redirect()->route('home.index');
        }
        
    }

    public function update(Request $request){

        $request->validate([
            'cv_file' => 'mimes:pdf,docx,doc',
            'fname' => 'required',
            'lname' => 'required',
            'notice_period' => 'required',
            'salary_expectations' => 'required',
            'work_base_preferences' => 'required',
                ], [
            'cv_file.mimes' => 'CV allow only pdf file.',
            'cv_file.required' => 'Please select CV.',
            'cv_file.max' => 'CV should be less than 3 mb.',
            'fname.required' => 'First Name is required!',
            'lname.required' => 'Last Name is required!',
            'notice_period.required' => 'Notice Period is required!',
            'salary_expectations.required' => 'Salary Expectations is required!',
            'work_base_preferences.required' => 'Work Base Preferences is required!',
        ]);

        $job_id = $request->job_id;
        $recruiter_id = $request->recruiter_id;
        $job_reference = '1';
        $folderName = '/job_applied/'.$job_id;

        $job_vacancy_data =  JobVacancy::recruiterVacancyGetData($job_id);

        $cv_file = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $fileName = CustomFunction::fileUpload($file, null, $folderName);
            CustomFunction::removeFile($request->cv_file_old, $folderName);
            $cv_file = $fileName;
        }else{
            $cv_file = $request->cv_file_old;
        }

        $recruiter_candidate = RecruiterCandidate::find($request->id);
        $recruiter_candidate->recruiter_id = $recruiter_id;
        $recruiter_candidate->job_id = $job_id;
        $recruiter_candidate->fname = $request->fname;
        $recruiter_candidate->lname = $request->lname;
        $recruiter_candidate->notice_period = $request->notice_period;
        $recruiter_candidate->salary_expectations = $request->salary_expectations;
        $recruiter_candidate->work_base_preferences = $request->work_base_preferences;
        $recruiter_candidate->cv = $cv_file;

        if ($recruiter_candidate->save()) {

            $job_applied = JobApplied::where('user_id','=',$request->id)->where('job_id','=',$job_id)->where('job_reference','=','1')->where('deleted_at','=',null)->first();
            if(isset($job_applied) && !empty($job_applied)){
                $job_applied->job_id = $job_id;
                $job_applied->notice_period = $request->notice_period;
                $job_applied->salary_expectations = $request->salary_expectations;
                $job_applied->work_base_preferences = $request->work_base_preferences;
                $job_applied->cv_file = $cv_file;
                
                $job_applied->job_workflow_id = $job_vacancy_data['job_workflow_id'];
                $job_applied->client_id = $job_vacancy_data['client_id'];
    
                $job_applied->user_id = $request->id;
                $job_applied->save();
    
                $r_c_id = $request->id;
    
                $role_name = CustomFunction::role_name();
    
                $route_name = $role_name.'.recruiterCandidateList';
    
                return redirect()->route($route_name)->with('success', 'Candidate edit successfully.');
            }else{
                return back()->with('error', 'Oh no. An error has occurred. Please check you have completed all the fields!');
            }
        } else {
            return back()->with('error', 'Oh no. An error has occurred. Please check you have completed all the fields!');
        }
        
    }

    public function recruiterDownloadCV($id=null) {
        
        if(isset($id) && !empty($id)){

            $result = RecruiterCandidate::find($id);
            
            $file_name = $result->cv;
            $job_id = $result->job_id;
            $file_path = url('uploads') . 'uploads/job_applied/'.$job_id.'/';
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

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $recruiter_candidate = RecruiterCandidate::find($request->id);
        $recruiter_candidate->deleted_at = date('Y-m-d H:i:s');
        
        $date = Carbon::now();

        $job_id = $recruiter_candidate->job_id;

        $job_event = JobEvent::where('r_c_id','=',$job_id)->where('job_reference','=','1')->where('user_id','=',Auth::user()->id)->get();

        if(isset($job_event) && !empty($job_event)){

            foreach($job_event as $JEkey => $je_value){
                $job_event =  JobEvent::find($je_value->id);
                $job_event->deleted_at = $date;
                $job_event->save();
            }
        }

        $job_offers = JobOffers::where('candidate_id','=',$job_id)->where('job_reference','=','1')->where('r_c_id','=',Auth::user()->id)->get();

        foreach($job_offers as $JOkey => $jo_value){
            $job_offer =  JobOffers::find($jo_value->id);
            $job_offer->deleted_at = $date;
            $job_offer->save();
        }
        
        $job_applied = JobApplied::where('user_id','=',$request->id)->where('job_id','=',$job_id)->where('job_reference','=','1')->first();
        $job_applied->deleted_at = date('Y-m-d H:i:s');
        $job_applied->save();
        
        $job_offers = JobActivity::where('applied_id','=',$job_applied->id)->get();
        foreach($job_offers as $JOkey => $jo_value){
            $job_offer =  JobActivity::find($jo_value->id);
            $job_offer->deleted_at = $date;
            $job_offer->save();
        }

        MessageCount::where('candidate_id','=',$request->id)->where('r_c_id','=',Auth::user()->id)->delete();
        Message::where('candidate_id','=',$request->id)->where('r_c_id','=',Auth::user()->id)->delete();

        if ($recruiter_candidate->save()) {
            return back()->with('success', 'Candidate delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
