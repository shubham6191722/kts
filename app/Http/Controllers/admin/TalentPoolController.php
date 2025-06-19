<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;

use App\Models\JobApplied;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\JobSectors;
use App\Models\Region;


class TalentPoolController extends Controller {

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

            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            
            if(Auth::user()->role == 3){
                $id = Auth::user()->id;
            }
            $job_skill = JobSectors::getAll();
            $region = Region::getSelectValue();

            return view('admin.talent_pool.index')->with('job_skill',$job_skill)->with('region',$region);
        }else{
            return redirect()->route('home.index');
        }
    }

    public function talentSearch(Request $request) {
        if(Auth::check()){
            $id = Auth::user()->id;

            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            
            if(Auth::user()->role == 3){
                $id = Auth::user()->id;
            }
            
            $data = $request->all();
            $job_skill = $request->job_skill;
            $region = $request->region;
            $talent_name = $request->talent_name;

            if($id == 1){
                $JobApplied = JobApplied::talentPoolUserAll($job_skill,$region,$talent_name);
            }elseif(Auth::user()->role == 2){   
                $JobApplied = JobApplied::talentPoolUser($id,$job_skill,$region,$talent_name);
            }elseif(Auth::user()->role == 3){
                $id = Auth::user()->created_user_id;
                $JobApplied = JobApplied::talentPoolUser($id,$job_skill,$region,$talent_name);
            }

            $route_name = CustomFunction::role_name();

            $statusJobData = view('admin.talent_pool.talent_pool')->with('job_applied', $JobApplied)->with('route_name', $route_name)->render();
            return response()->json(['page' => $statusJobData, 'code' => 1]);
        }
    }


    public function talentPoolDetail($id)
    {
        if($id){
            $candidate_data = User::candidateDataGet($id);
            $candidate_detail = UserDetail::userDataGet($candidate_data->id);
            return view('admin.talent_pool.detail')->with('candidate_data',$candidate_data)->with('candidate_detail',$candidate_detail);
        }else{
            return redirect()->back();
        }

    }

    public function fileDownload($id=null) {
    
        if(isset($id) && !empty($id)){

            $result = UserDetail::find($id);
            $file_name = $result->cv;
            $user_id = $result->user_id;
            $file_path = url('uploads') . '/candidate/'.$user_id.'/';
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


}
