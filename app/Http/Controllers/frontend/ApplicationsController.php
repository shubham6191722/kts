<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\JobApplied;
use App\Models\User;

class ApplicationsController extends Controller {

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

        return view('frontend.after_login.appliction.index');

    }

    public function archiveData() {

        return view('frontend.after_login.appliction.candidate_archive_data');

    }

    public function applicationGet($id) {

        $job_applied = JobApplied::getData($id);
        return view('frontend.after_login.appliction.application_detail');

    }

    public function applicationData(Request $request) {

        $user_id = $request->id;
        $job_applied = JobApplied::appliedUserData($user_id);

        $statusJobData = view('frontend.after_login.appliction.applicatio_data')->with('job_applied', $job_applied)->render();
        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }
    
    public function applicationArchiveData(Request $request) {

        $user_id = $request->id;
        $job_applied = JobApplied::appliedUserArchiveData($user_id);

        $statusJobData = view('frontend.after_login.appliction.applicatio_data')->with('job_applied', $job_applied)->render();
        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }
    
    public function archiveCandidate(Request $request) {

        $id = $request->id;
        $job_applied = JobApplied::find($id);
        $job_applied->deleted_at = date('Y-m-d H:i:s');
        $job_applied->job_status = 1;
        $job_applied->job_stage = 1;
        $job_applied->job_new = "1";

        if ($job_applied->save()) {
            $msg = 'Applications successfully deleted.';
            return response()->json(['msg' => $msg,'code' => 1]);
        } else {
            return response()->json(['code' => 0]);
        }

    }



}
