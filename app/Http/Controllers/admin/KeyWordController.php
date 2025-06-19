<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use App\Models\JobKeyWord;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;

class KeyWordController extends Controller {

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
            $jobKeyWordList = JobKeyWord::jobKeyWordList();
            return view('admin.skill.key_index')->with('jobKeyWordList',$jobKeyWordList);
        }else{
            return redirect()->route('home.index');
        }
       
        
    }

    public function create(Request $request) {

        if(Auth::check()){

            $request->validate([
                'keyword_name' => 'required',
                    ], [
                'keyword_name.required' => 'Please enter Skill Name!',
            ]);
    
            $skill_data = new JobKeyWord;
            $skill_data->keyword_name = $request->keyword_name;
            $skill_data->created_at = date('Y-m-d H:i:s');
            
            if ($skill_data->save()) {
                return back()->with('success', 'keyWord successfully add.');
            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }
        
    }

    public function update(Request $request) {

        $request->validate([
            'keyword_name' => 'required',
                ], [
            'keyword_name.required' => 'Please enter Skill Name!',
        ]);

        $skill_data = JobKeyWord::find($request->id);;
        $skill_data->keyword_name = $request->keyword_name;
        $skill_data->updated_at = date('Y-m-d H:i:s');

        if ($skill_data->save()) {

            return back()->with('success', 'keyWord successfully update.');
            
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

        $skill_data = JobKeyWord::find($request->id);

        if ($skill_data->delete()) {
            return back()->with('success', 'keyWord successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}