<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use App\Models\JobSkill;
use App\Models\SiteSetting;
use App\Models\JobCategory;

use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;

class SkillController extends Controller {

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
            $job_category = JobCategory::getAll();
            $skillList = JobSkill::skillList();
            return view('admin.skill.index')->with('skillList',$skillList)->with('job_category',$job_category);
        }else{
            return redirect()->route('home.index');
        }
       
        
    }

    public function create(Request $request) {

        if(Auth::check()){

            $request->validate([
                'skill_name' => 'required',
                    ], [
                'skill_name.required' => 'Please enter Skill Name!',
            ]);
    
            $skill_data = new JobSkill;
            $skill_data->skill_name = $request->skill_name;
            $skill_data->c_id = $request->c_id;
            $skill_data->created_at = date('Y-m-d H:i:s');
            
            if ($skill_data->save()) {
                return back()->with('success', 'skill successfully add.');
            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }
        
    }

    public function update(Request $request) {

        $request->validate([
            'skill_name' => 'required',
                ], [
            'skill_name.required' => 'Please enter Skill Name!',
        ]);

        $skill_data = JobSkill::find($request->id);;
        $skill_data->skill_name = $request->skill_name;
        $skill_data->c_id = $request->c_id;
        $skill_data->updated_at = date('Y-m-d H:i:s');

        if ($skill_data->save()) {

            return back()->with('success', 'skill successfully update.');
            
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

        $skill_data = JobSkill::find($request->id);
        $skill_data->deleted_at = date('Y-m-d H:i:s');

        if ($skill_data->save()) {
            return back()->with('success', 'skill successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}