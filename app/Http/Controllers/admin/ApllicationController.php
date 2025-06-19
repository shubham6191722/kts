<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;
use App\Jobs\UnsuccessFullMailSend;

use App\Models\User;
use App\Models\JobApplied;
use App\Models\JobVacancy;
use App\Models\JobWorkFlowStage;
use App\Models\JobEvent;
use App\Models\JobActivity;
use App\Models\JobOffers;
use App\Models\SiteAddress;
use App\Models\MailTemplate;
use App\Models\BenefitPackage;
use App\Models\RecruiterCandidate;
use App\Models\Message;
use App\Models\MessageCount;
use App\Models\SubCompany;
use App\Models\ApplicationNote;


class ApllicationController extends Controller {

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
    public function index($id) {

        $data = JobVacancy::find($id);
        $jobworkflow_id = $data->jobworkflow_id;

        $job_name = JobVacancy::jobName($id);
        $user_id = JobVacancy::jobUser($id);
        $job_workflow_stage = JobWorkFlowStage::getWorkFlowWise($data->jobworkflow_id);

        // $mail_template_client = MailTemplate::getClientData($data->user_select);
        if(Auth::user()->role == 1){
            if($data->managed_by == 1){
                $user_id_template = Auth::user()->id;
                $mail_template_client = MailTemplate::getClientData($user_id_template);
            }else{
                if(isset($data->sub_company) && !empty($data->sub_company)){
                    $mail_template_client = MailTemplate::getSubClientData($data->user_select,$data->sub_company);
                }else{
                    $mail_template_client = MailTemplate::getClientData($data->user_select);
                }
            }
        }else{
            if(isset($data->sub_company) && !empty($data->sub_company)){
                $mail_template_client = MailTemplate::getSubClientData($data->user_select,$data->sub_company);
            }else{
                $mail_template_client = MailTemplate::getClientData($data->user_select);
            }
        }

        // if(isset($data->sub_company) && !empty($data->sub_company)){
        //     $mail_template_client = MailTemplate::getSubClientData($data->user_select,$data->sub_company);
        // }else{
        //     $mail_template_client = MailTemplate::getClientData($data->user_select);
        // }

        if(isset($data->sub_company) && !empty($data->sub_company)){
            $company = SubCompany::getSubCompanyName($data->sub_company);
        }else{
            $company = User::clientCompany($data->user_select);
        }

        return view('admin.application.index')->with('job_name',$job_name)->with('job_workflow_stage',$job_workflow_stage)->with('user_id',$user_id)->with('id',$id)
                                              ->with('jobworkflow_id',$jobworkflow_id)->with('mail_template_client',$mail_template_client)->with('job_id',$id)
                                              ->with('sub_company',$company);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function statusJobDataGet(Request $request) {

        $jobId = $request->jobid;
        $jobStatus = $request->jobstatus;
        $jobStage = $request->jobstage;
        $jobNew = $request->jobnew;

        $data = JobApplied::jobStatusDataGet($jobId,$jobStatus,$jobStage,$jobNew);
        $count_data = JobApplied::jobStatusCountDataGet($jobId,$jobStage);

        $qualified = $count_data['qualified'];
        $unsuccessful = $count_data['unsuccessful'];
        $new = $count_data['new'];

        $statusJobData = view('admin.application.application_side_bar')->with('data', $data)->render();
        return response()->json(['page' => $statusJobData,'qualified' => $qualified,'unsuccessful' => $unsuccessful,'new' => $new, 'code' => 1]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function chageStateSattus(Request $request) {


        $changevalue = $request->changevalue;
        $job = $request->job;
        $id = $request->id;

        $data_status = $request->data_status;
        $data_stage = $request->data_stage;
        $data_id = $request->data_id;
        $data_flowid = $request->data_flowid;
        $data_new = $request->data_new;

        foreach ($id as $val){
            // Code Here
            $jobData = JobApplied::find($val);
            $job_vacancy = JobVacancy::find($data_id);
            $workflow_id = $job_vacancy->jobworkflow_id;

            if($job == 'job_status'){

                if($jobData->job_new == 1){
                    $change_name_1 = 'New';
                }else{
                    $change_name_1 = '';
                }

                if($jobData->job_status == 1){
                    $change_name_2 = 'Successful';
                }else{
                    $change_name_2 = 'Unsuccessful';
                }

                if($changevalue == 1){
                    $change_name_3 = 'Successful';
                    $jobData->unsuccessful_mail_send = '0';
                }else{
                    $change_name_3 = 'Unsuccessful';
                }

                if(isset($change_name_1) && !empty($change_name_1)){
                    $text = 'job status changed from '.$change_name_1.' to '.$change_name_3.'.';
                }else{
                    $text = 'job status changed from '.$change_name_2.' to '.$change_name_3.'.';
                }

                $jobData->job_status = $changevalue;
                $jobData->job_new = $data_new;
            }
            if($job == 'job_stage'){

                $satge_data_1 = JobWorkFlowStage::candidateStageGet($jobData->job_stage,$workflow_id);
                $satge_name_1 = $satge_data_1->stage_name;

                $satge_data_2 = JobWorkFlowStage::candidateStageGet($changevalue,$workflow_id);
                $satge_name_2 = $satge_data_2->stage_name;

                $jobData->job_stage = $changevalue;
                $jobData->job_new = $data_new;
                $text = 'job stage changed from '. $satge_name_1 .' to '. $satge_name_2 .'.';
            }
            $jobData->update();

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $jobData->user_id;
            $JobActivity->client_id = $jobData->client_id;
            $JobActivity->job_id = $jobData->job_id;
            $JobActivity->managed_by = $jobData->managed_by;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $jobData->id;
            $JobActivity->text = $text;
            $JobActivity->save();
        }

        if($job == 'job_stage'){
            $msg = "Stage updated successfully";
        }else{
            $msg = "Status updated successfully";
        }

        return response()->json(['data_status' => $data_status,'data_stage' => $data_stage,'data_id' => $data_id,'data_flowid' => $data_flowid,'data_new' => $data_new,'msg' => $msg, 'code' => 1]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function chageCount(Request $request) {

        $data_id = $request->data_id;
        $jobid = $request->jobid;
        $user_id = $request->user_id;
        $job_status = JobWorkFlowStage::userStatus($data_id);
        $jobCount_arr = [];

        foreach ($job_status as $val){
            $jobCount = JobApplied::jobCount($val->order,$jobid);
            $jobCount_arr[$val->order] = $jobCount;
        }
        return response()->json(['jobCount_arr' => $jobCount_arr, 'code' => 1]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobDataGet(Request $request) {

        $appliedid = $request->appliedid;
        $data = JobApplied::find($appliedid);

        $user_client = User::clientDataData($data->client_id);
        $user_staff = User::staffList($data->client_id);
        $user_clent = User::clientListForClient($data->client_id);
        $staff_data = $user_staff->concat($user_clent)->shuffle();
        $staff = $staff_data->concat($user_client)->shuffle();

        $event = JobEvent::getAll($appliedid);

        $event_data = @json_encode($event, true);

        $job_activity = JobActivity::getApplication($appliedid);

        $user_id = $data->user_id;

        $job_offer = JobOffers::getOfferData($appliedid,$user_id);

        $site_address_data = SiteAddress::clientAddressGet($data->client_id);

        $JobVacancy = JobVacancy::find($data->job_id);
        if(Auth::user()->role == 1){
            if($JobVacancy->managed_by == 1){
                $user_id = Auth::user()->id;
                $mail_template = MailTemplate::getClientData($user_id);
            }else{
                if(isset($JobVacancy->sub_company) && !empty($JobVacancy->sub_company)){
                    $mail_template = MailTemplate::getSubClientData($data->client_id,$JobVacancy->sub_company);
                }else{
                    $mail_template = MailTemplate::getClientData($data->client_id);
                }
            }
        }else{
            if(isset($JobVacancy->sub_company) && !empty($JobVacancy->sub_company)){
                $mail_template = MailTemplate::getSubClientData($data->client_id,$JobVacancy->sub_company);
            }else{
                $mail_template = MailTemplate::getClientData($data->client_id);
            }
        }

        $benefit_package = BenefitPackage::list($data->client_id);

        $client_id = $data->client_id;
        $staff_data  = User::staffIdGet($data->client_id);
        $staff_id  = null;
        if(isset($staff_data) && !empty($staff_data)){
            $staff_id  = implode(",",$staff_data);
        }

        $candidate_id  = $data->user_id;
        $applied_id  = $appliedid;
        $job_id  = $data->job_id;

        $r_c_id = null;
        if(isset($data->job_reference) && !empty($data->job_reference)){
            $r_c_id = RecruiterCandidate::getId($data->user_id);
        }

        $managed_by = null;
        if(isset($JobVacancy->managed_by) && !empty($JobVacancy->managed_by) && ($JobVacancy->managed_by == 1)){
            $managed_by = $JobVacancy->managed_by;
        }

        $check_admin = null;
        if(Auth::user()->role == 1){
            $check_admin = Auth::user()->id;
        }

        $message_id = MessageCount::messageIdGet($client_id,$staff_id,$candidate_id,$applied_id,$job_id,$check_admin);

        $statusJobData = view('admin.application.appliction_data')->with('data', $data)->with('staff', $staff)->with('event_data', $event_data)
                                                                  ->with('event', $event)->with('job_activity', $job_activity)
                                                                  ->with('job_offer', $job_offer)->with('site_address_data', $site_address_data)
                                                                  ->with('mail_template', $mail_template)->with('benefit_package', $benefit_package)
                                                                  ->with('client_id', $client_id)->with('staff_id', $staff_id)
                                                                  ->with('candidate_id', $candidate_id)->with('applied_id', $applied_id)
                                                                  ->with('job_id', $job_id)->with('r_c_id', $r_c_id)->with('message_id', $message_id)
                                                                  ->with('check_admin', $check_admin)->with('managed_by', $managed_by)->render();
        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobNameSearch(Request $request) {
        $value = $request->search_value;
        $jobId = $request->data_id;
        $jobStatus = $request->data_status;
        $jobStage = $request->data_stage;
        $jobNew = $request->jobnew;

        $data = JobApplied::jobStatusDataGetSearch($jobId,$jobStatus,$jobStage,$jobNew,$value);
        $statusJobData = view('admin.application.application_side_bar')->with('data', $data)->render();

        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }

    public function fileDownload($id=null) {


        if(isset($id) && !empty($id)){

            $result = JobApplied::find($id);

            $file_name = $result->cv_file;
            $job_id = $result->job_id;
            $file_path = url('uploads') . '/job_applied/'.$job_id.'/';
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

    // Save a Moodgram Chat

    public function unsuccessfulMailSend(Request $request){
        $id = $request->id;
        $mail_template_id = $request->unsuccessful_mail_template;
        $client_id = $request->client_id;
        $created_id = $request->created_id;
        foreach ($id as $key => $val){
            $jobData = JobApplied::find($val);

            $time = $key;
            $user_id = $jobData->user_id;
            $job_id = $request->job_id;
            $job_reference = $jobData->job_reference;
            // if($jobData->unsuccessful_mail_send == '0'){
                $job = (new UnsuccessFullMailSend($user_id,$job_id,$mail_template_id,$client_id,$job_reference,$created_id))->delay(now()->addSeconds($time * 4));
                app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
            // }

            $jobData->unsuccessful_mail_send = '1';
            $jobData->save();


        }
        return response()->json(['msg'=>'Mail sent successfully', 'code' => 1]);
    }

    public function thumbsStatusChange(Request $request){
        $id = $request->data_id;
        $value = $request->data_value;
        $class = $request->data_class;
        $remove_class = $request->data_remove_class;
        $jobData = JobApplied::find($id);
        $jobData->thumbs_status = $value;
        $jobData->save();

        if ($jobData->save()) {
            return response()->json(['msg' => 'data updated successfully.','class' => $class,'remove_class' => $remove_class,'code' => 1]);
        } else {
            return response()->json(['msg' => 'Please try again!','code' => 0]);
        }
    }

    public function noteSubmit(Request $request){

        $note = $request->user_note;
        $id = $request->user_note_id;
        $created_user_id = $request->created_user_id;


        $job_applied = JobApplied::find($id);
        $job_applied->note_status = 1;
        $job_applied->save();

        $jobData = New ApplicationNote;
        $jobData->note = $note;
        $jobData->created_user_id = $created_user_id;
        $jobData->applied_id = $id;
        $jobData->save();

        if ($jobData->save()) {
            return response()->json(['msg' => 'Note saved successfully.','code' => 1]);
        } else {
            return response()->json(['msg' => 'Please try again!','code' => 0]);
        }
    }

    public function noteGet(Request $request){

        $id = $request->user_note_id;

        $noteData = ApplicationNote::getDataAll($id);

        $statusJobData = view('admin.application.application_note')->with('noteData', $noteData)->render();

        return response()->json(['note' => $statusJobData,'code' => 1]);
    }

}
