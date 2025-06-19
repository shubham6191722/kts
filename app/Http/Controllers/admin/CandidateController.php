<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Region;
use App\Models\JobCategory;
use App\Models\JobSkill;
use App\Models\UserDetail;

class CandidateController extends Controller {

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
       
        $r_region = Region::getSelectValue();
        $candidateList = User::candidateList();
        $job_category = JobCategory::getAll();
        return view('admin.candidate.index')->with('candidateList',$candidateList)->with('r_region',$r_region)->with('job_category',$job_category);
    }

    public function statusUpdate(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $name = $request->name;

        $new_user = User::find($request->id);
        if($name == "talent_pool_status"){
            $value = $new_user->talent_pool_status;
            if($value == 0){
                $new_user->talent_pool_status = "1";
            }else{
                $new_user->talent_pool_status = "0";
            }
        }

        if ($new_user->save()) {
            return response()->json(['msg' => 'Status successfully update.','code' => 1]);
        } else {
            return response()->json(['msg' => 'Please try again!','code' => 0]);
        }
    }

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $new_user = User::find($request->id);
        $new_user->deleted_at = date('Y-m-d H:i:s');
        $new_user->status = 0;

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.candidateList';

            return redirect()->route($route_name)->with('success', 'Candidate delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function edit($id) {

        $candidateList = User::candidateListData($id);
        $r_region = Region::getSelectValue();
        $job_category = JobCategory::getAll();

        $job_skill = null;
        if(isset($candidateList->sector) && !empty($candidateList->sector)){
            $job_skill = JobSkill::getValuer($candidateList->sector);
        }
        return view('admin.candidate.edit')->with('candidateList',$candidateList)->with('r_region',$r_region)->with('job_category',$job_category)
        ->with('job_skill',$job_skill);
    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'salary' => 'required',
            'noticeperiod' => 'required',
                ], [
            'name.required' => 'Please enter your First name!',
            'lname.required' => 'Please enter your Last name!',
            'phone.required' => 'Please enter your Phone number!',
            'salary.required' => 'Please enter your salary!',
            'noticeperiod.required' => 'Please enter your noticeperiod!',
        ]);

        $user_id = $request->id;

        $location = null;
        if($request->location){
            $location = $request->location;
        }

        $salary = null;
        if($request->salary){
            $salary = $request->salary;
        }

        $noticeperiod = null;
        if($request->noticeperiod){
            $noticeperiod = $request->noticeperiod;
        }

        $workbasepreference = null;
        if($request->workbasepreference){
            $workbasepreference = implode(',', $request->workbasepreference);
        }

        $sector = null;
        if($request->sector){
            $sector = $request->sector;
        }

        $key_skills = null;
        if($request->skillsrequired){
            $key_skills = implode(',', $request->skillsrequired);
        }

        $check_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

        if(isset($check_data) && !empty($check_data)){
            $user_detail = UserDetail::find($check_data->id);
            $user_data = User::find($user_id);
        }else{
            $user_detail = new UserDetail;
            $user_data = User::find($user_id);
        }


        $user_detail->user_id = $user_id;
        $user_detail->location = $location;
        $user_detail->salary = $salary;
        $user_detail->noticeperiod = $noticeperiod;
        $user_detail->workbasepreference = $workbasepreference;
        $user_detail->sector = $sector;
        $user_detail->key_skills = $key_skills;
        $user_detail->save();

        $user_data->name = $request->name;
        $user_data->lname = $request->lname;
        $user_data->phone = $request->phone;
        $user_data->town = $request->town;
        $user_data->c_code = $request->c_code;
        $user_data->country_code = $request->country_code;

        if ($user_data->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.candidateList';
            return redirect()->route($route_name)->with('success', 'candidate account has been updated successfully.');
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }
}
