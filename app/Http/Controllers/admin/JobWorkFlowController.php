<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use App\Models\JobWorkFlow;
use App\Models\JobWorkFlowStage;
use App\Models\SiteSetting;

use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;

class JobWorkFlowController extends Controller {

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
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            $workFlowList = JobWorkFlow::getUserWise($id);
            return view('admin.job_workflow.index')->with('workFlowList',$workFlowList)->with('id',$id);
        }else{
            return redirect()->route('home.index');
        }


    }

    public function create(Request $request) {

        if(Auth::check()){

            $request->validate([
                'name' => 'required',
                    ], [
                'name.required' => 'Please enter Wokr Flow Name!',
            ]);

            $job_workflow_data = new JobWorkFlow;
            $job_workflow_data->workflow_name = $request->name;
            $job_workflow_data->user_id = $request->client_id;
            $job_workflow_data->created_at = date('Y-m-d H:i:s');

            if ($job_workflow_data->save()) {

                $id = $job_workflow_data->id;
                $role_name = CustomFunction::role_name();
    
                $route_name = $role_name.'.jobWorkFlowStage';
                return redirect()->route($route_name,['id' => $id])->with('success', 'Job Work Flow successfully add.');
            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function update(Request $request) {

        $request->validate([
            'name' => 'required',
                ], [
            'name.required' => 'Please enter Wokr Flow Name!',
        ]);

        $job_workflow_data = JobWorkFlow::find($request->id);

        $job_workflow_data->workflow_name = $request->name;
        $job_workflow_data->updated_at = date('Y-m-d H:i:s');
        if ($job_workflow_data->save()) {

            return back()->with('success', 'Job Work Flow successfully updated.');

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

        $skill_data = JobWorkFlow::find($request->id);
        $skill_data->deleted_at = date('Y-m-d H:i:s');

        if ($skill_data->save()) {
            return back()->with('success', 'Job Work Flow successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function jobWorkFlowStage($id) {

        $count = JobWorkFlowStage::getWorkFlowCount($id);
        $count = $count + 1;
        $stageList = JobWorkFlowStage::getWorkFlowWise($id);
        return view('admin.job_workflow.list_stage')->with('id',$id)->with('count',$count)->with('stageList',$stageList);
    }

    public function jobWorkFlowStageCreate(Request $request) {

        if(Auth::check()){

            $request->validate([
                'name' => 'required',
                'order' => 'required',
                    ], [
                'name.required' => 'Please enter Name!',
                'order.required' => 'Please enter order!',
            ]);

            $job_workflow_stage_data = new JobWorkFlowStage;
            $job_workflow_stage_data->stage_name = $request->name;
            $job_workflow_stage_data->order = $request->order;
            $job_workflow_stage_data->workflow_id = $request->id;
            $job_workflow_stage_data->created_at = date('Y-m-d H:i:s');

            if ($job_workflow_stage_data->save()) {

                return back()->with('success', 'Job Work Flow Stage successfully add.');
            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function jobWorkFlowStageUpdate(Request $request) {

        $request->validate([
            'name' => 'required',
            'order' => 'required',
                ], [
            'name.required' => 'Please enter Wokr Flow Name!',
            'order.required' => 'Please enter order!',
        ]);

        $job_workflow_data = JobWorkFlowStage::find($request->id);

        $job_workflow_data->stage_name = $request->name;
        $job_workflow_data->order = $request->order;
        $job_workflow_data->updated_at = date('Y-m-d H:i:s');
        if ($job_workflow_data->save()) {

            return back()->with('success', 'Job Work Flow Stage successfully updated.');

        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function jobWorkFlowStageDelete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $skill_data = JobWorkFlowStage::find($request->id);
        $skill_data->deleted_at = date('Y-m-d H:i:s');

        if ($skill_data->save()) {
            return back()->with('success', 'Job Work Flow Stage successfully delete.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
