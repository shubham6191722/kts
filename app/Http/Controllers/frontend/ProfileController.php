<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;
use Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CustomFunction\CustomFunction;
use Carbon\Carbon;
use Session;
use File;

use App\Models\User;
use App\Models\JobSkill;
use App\Models\Region;
use App\Models\UserDetail;
use App\Models\JobSectors;
use App\Models\JobCategory;

use App\Models\Notifications;
use App\Models\MessageCount;
use App\Models\Message;
use App\Models\JobOffers;
use App\Models\JobEvent;
use App\Models\JobApplied;
use App\Models\JobActivity;
use App\Models\DeleteUser;
use App\Models\OfferLeavingReason;

class ProfileController extends Controller {

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

        $user_id = Auth::user()->id;

        $region = Region::getSelectValue();
        $sector = JobSectors::getAll();

        $user_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

        $job_category = JobCategory::getAll();
        $job_skill = null;
        if(isset($user_data->sector) && !empty($user_data->sector)){
            $job_skill = JobSkill::getValuer($user_data->sector);
        }

        return view('frontend.after_login.setting.index')->with('job_skill',$job_skill)->with('region',$region)->with('user_data',$user_data)
                                                         ->with('sector',$sector)->with('job_category',$job_category);

    }

    public function jobAlertSetting() {

        $user_id = Auth::user()->id;

        $region = Region::getSelectValue();
        $sector = JobSectors::getAll();

        $user_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

        $job_category = JobCategory::getAll();
        $job_skill = null;
        if(isset($user_data->sector) && !empty($user_data->sector)){
            $job_skill = JobSkill::getValuer($user_data->sector);
        }

        return view('frontend.after_login.job_alert.index')->with('job_skill',$job_skill)->with('region',$region)->with('user_data',$user_data)
                                                         ->with('sector',$sector)->with('job_category',$job_category);

    }

    public function accountSetting(Request $request) {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
                ], [
            'fname.required' => 'Please enter your Firstname!',
            'fname.required' => 'Please enter your Lastname!',
        ]);

        $key_skills = null;
        if($request->skillsrequired){
            $key_skills = implode(',', $request->skillsrequired);
        }

        $location = null;
        if($request->location){
            $location = $request->location;
        }

        $sector = null;
        if($request->sector){
            $sector = $request->sector;
        }

        $salary = null;
        if($request->salary){
            $salary = $request->salary;
        }

        $workbasepreference = null;
        if($request->workbasepreference){
            $workbasepreference = implode(',', $request->workbasepreference);
        }

        $noticeperiod = null;
        if($request->noticeperiod){
            $noticeperiod = $request->noticeperiod;
        }

        $c_w_email = null;
        if($request->c_w_email){
            $c_w_email = $request->c_w_email;
        }

        $talent_pool = "0";
        if(isset($request->talent_pool) && !empty($request->talent_pool)){
            $talent_pool = $request->talent_pool;
        }

        $active_status = Carbon::now();
        if(isset($request->active_status) && !empty($request->active_status)){
            $active_status = null;
        }

        $user_id = Auth::user()->id;

        $folderName = '/candidate/';
        $folderPath = $user_id;

        $cv = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $old_file = null;
            if($request->old_cv_file){
                $old_file = $request->old_cv_file;
            }
            $fileName = CustomFunction::cvUpload($file, $old_file, $folderName,$folderPath);
            $cv = $fileName['name'];
        }else{
            if($request->old_cv_file){
                $cv = $request->old_cv_file;
            }
        }

        $profile = null;
        if ($request->hasFile('profile_file')) {
            $file = $request->file('profile_file');
            $old_file = null;
            if($request->old_profile_file){
                $old_file = $request->old_profile_file;
            }
            $fileName = CustomFunction::cvUpload($file, $old_file, $folderName,$folderPath);
            $profile = $fileName['name'];
        }else{
            if($request->old_profile_file){
                $profile = $request->old_profile_file;
            }
        }

        $check_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

        if(isset($check_data) && !empty($check_data)){
            $user_detail = UserDetail::find($check_data->id);
        }else{
            Auth::user()->talent_pool_status = "1";
            $user_detail = new UserDetail;
        }

        $description = CustomFunction::remove_html_tags($request->description, array('script','iframe','small','span','br'));

        $user_detail->user_id = $user_id;
        $user_detail->salary = $salary;
        $user_detail->location = $location;
        $user_detail->key_skills = $key_skills;
        $user_detail->cv = $cv;
        $user_detail->sector = $sector;
        $user_detail->description = $description;
        $user_detail->workbasepreference = $workbasepreference;
        $user_detail->noticeperiod = $noticeperiod;
        $user_detail->c_w_email = $c_w_email;
        $user_detail->save();

        Auth::user()->name = $request->fname;
        Auth::user()->lname = $request->lname;
        Auth::user()->email = $request->email;
        Auth::user()->phone = $request->phone;
        Auth::user()->cover_image = $profile;
        Auth::user()->talent_pool_status = $talent_pool;
        Auth::user()->c_code = $request->c_code;
        Auth::user()->country_code = $request->country_code;
        Auth::user()->deleted_at = $active_status;

        if (Auth::user()->save()) {

            return redirect()->back()->with("success", "Your account has been updated");
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|required_with:confirm_password|same:confirm_password|min:6',
            'confirm_password' => 'required',
                ], [
            'current_password.required' => 'Please enter Current Password',
            'new_password.required' => 'Please enter New Password',
            'new_password.min' => 'New Password must be minimum 6 characters',
            'new_password.same' => 'New Password and Confirm Password must be same',
            'confirm_password.required' => 'Please Re-enter New Password',
        ]);

        if (Hash::check($request->current_password, Auth::user()->password)) {
            Auth::user()->password = Hash::make($request->new_password);
            if (Auth::user()->save()) {
                return redirect()->back()->with("success", "Password changed successfully");
            }
            return back()->with('error', 'Password was not changed, please try again.');
        } else {
            return back()->with('error', 'Your current password is incorrect the password was not changed!');
        }
    }

    public function jobAlert(Request $request) {

        $n_location = null;
        if($request->n_location){
            $n_location = implode(',', $request->n_location);
        }

        $emploment_type = null;
        if($request->emploment_type){
            $emploment_type = implode(',', $request->emploment_type);
        }

        $categoryid = null;
        if($request->categoryid){
            $categoryid = implode(',', $request->categoryid);
        }

        $check_notification = "0";
        if($request->check_notification){
            $check_notification = "1";
        }

        $check_radius = "0";
        $postcode = $distance_km = $latitude = $longitude = null;
        if($request->check_radius){
            $check_radius = "1";
            if($request->postcode){
                $postcode = $request->postcode;
                $lat_long = CustomFunction::getZipcode($postcode);
                $latitude  = $lat_long['lat'];
                $longitude = $lat_long['lng'];
            }
            if($request->distance_km){
                $distance_km = $request->distance_km;
            }
        }

        $hourly_salary = null;
        if($request->hourly_salary){
            $hourly_salary = $request->hourly_salary;
        }

        $annual_salary = null;
        if($request->annual_salary){
            $annual_salary = $request->annual_salary;
        }

        $user_id = Auth::user()->id;

        $check_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

        if(isset($check_data) && !empty($check_data)){
            $user_detail = UserDetail::find($check_data->id);
        }else{
            Auth::user()->talent_pool_status = "1";
            $user_detail = new UserDetail;
        }

        $user_detail->user_id = $user_id;
        $user_detail->n_location = $n_location;
        $user_detail->categoryid = $categoryid;
        $user_detail->check_notification = $check_notification;
        $user_detail->postcode = $postcode;

        $user_detail->check_radius = $check_radius;
        $user_detail->latitude = $latitude;
        $user_detail->longitude = $longitude;
        $user_detail->distance_km = $distance_km;
        $user_detail->emploment_type = $emploment_type;
        $user_detail->hourly_salary = $hourly_salary;
        $user_detail->annual_salary = $annual_salary;
        $user_detail->save();

        if ($user_detail->save()) {
            return redirect()->back()->with("success", "Your Job Alert has been updated");
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

    public function categoryidGet(Request $request) {

        $id = $request->id;
        $skillList = JobSkill::getValuer($id);

        if(isset($skillList) && !empty($skillList)){
            return response()->json(['skillList' => $skillList,'code' => 1]);
        }
        return response()->json(['skillList' => $skillList,'code' => 0]);
    }

    public function deleteCandidateProfile(Request $request) {

        $candidate_id = $request->candidate_id;

        $date = Carbon::now();

        $notification = Notifications::where('user_id','=',$candidate_id)->where('job_reference','=','0')->delete();
        $notification_applied = Notifications::where('job_applied_user','=',$candidate_id)->where('job_reference','=','0')->delete();
        $messageCount = MessageCount::where('candidate_id','=',$candidate_id)->where('r_c_id','=',null)->delete();
        $message = Message::where('candidate_id','=',$candidate_id)->where('r_c_id','=',null)->delete();
        $offer_leaving_reason = OfferLeavingReason::where('candidate_id','=',$candidate_id)->where('r_c_id','=',null)->delete();

        $job_applied = JobApplied::where('user_id','=',$candidate_id)->where('job_reference','=','0')->get();

        if(isset($job_applied) && !empty($job_applied) && count($job_applied)){
            foreach($job_applied as $JAkey => $ja_value){
                $job_applied =  JobApplied::find($ja_value->id);
                $job_applied->deleted_at = $date;

                $file = url('uploads') . '/job_applied/' . $ja_value->job_id .'/'.$job_applied->cv_file;
                if (File::exists($file)) {
                    unlink($file);
                }

                $job_applied->cv_file = null;
                $job_applied->save();

                $job_event = JobEvent::where('applied_id','=',$ja_value->id)->where('job_reference','=','0')->where('r_c_id','=',null)->get();

                foreach($job_event as $JEkey => $je_value){
                    $job_event =  JobEvent::find($je_value->id);
                    $job_event->deleted_at = $date;
                    $job_event->save();
                }

                $job_offers = JobOffers::where('applied_id','=',$ja_value->id)->where('job_reference','=',null)->where('r_c_id','=',null)->get();

                foreach($job_offers as $JOkey => $jo_value){
                    $job_offer =  JobOffers::find($jo_value->id);
                    $job_offer->deleted_at = $date;
                    $job_offer->save();
                }

                $job_offers = JobActivity::where('applied_id','=',$ja_value->id)->get();

                foreach($job_offers as $JOkey => $jo_value){
                    $job_offer =  JobActivity::find($jo_value->id);
                    $job_offer->deleted_at = $date;
                    $job_offer->save();
                }
            }
        }


        $path = url('uploads').'/candidate/'.$candidate_id;
        if (File::exists($path)){
            File::deleteDirectory($path);
        }
        User::find($candidate_id)->delete();
        UserDetail::where('user_id','=',$candidate_id)->delete();

        Auth::logout();
        Session::flush();

        return response()->json(['code' => 0]);
    }

}
