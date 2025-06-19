<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Message;
use App\Models\MessageCount;
use App\Models\JobVacancy;
use App\Models\RecruiterCandidate;
use App\Jobs\OfflineCandidateJobs;
use App\Jobs\OfflineResourceJobs;
use App\Models\SubCompany;

Use Carbon\Carbon;
Use Session;

class ChatModalController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

    }

    public function index(Request $request) {
        $data = MessageCount::getAll();
        if(Auth::check()){
            if(Auth::user()->role == 1){
                // $data = MessageCount::getAll();
                // $staffData = User::clientList();
                $id = Auth::user()->id;
                $data = MessageCount::getAll();
                $staffData = User::clientListMessage($id);

            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $sub_id = Auth::user()->id;
                    $id = Auth::user()->created_user_id;
                    $chat_data = MessageCount::getSubClientAll($sub_id,$id);
                    $staff_data = array();
                }else{
                    $id = Auth::user()->id;
                    $chat_data = MessageCount::getClientAll($id);
                    $staff_data = MessageCount::getClient($id);
                }
                // $chat_data = MessageCount::getClientAll($id);
                // $staff_data = MessageCount::getClient($id);
                // if(empty($chat_data) && empty($chat_data)){
                //     $data = [];
                // }else{
                //     $arr_1 = [];
                //     $arr_2 = [];
                //     if(!empty($chat_data)){
                //         $arr_1 = $chat_data;
                //     }
                //     if(!empty($staff_data)){
                //         $arr_2 = $staff_data;
                //     }
                //     $data = array_merge($staff_data,$chat_data);
                //     usort($data, function($a, $b) {
                //         return $b['updated_at'] <=> $a['updated_at'];
                //     });
                // }
                $data = array_merge($staff_data,$chat_data);
                usort($data, function($a, $b) {
                    return $b['updated_at'] <=> $a['updated_at'];
                });
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $staffData = User::staffListMessage($id);
            }elseif(Auth::user()->role == 3){
                $client_id = Auth::user()->created_user_id;
                $id = Auth::user()->id;
                $chat_data = MessageCount::getStaffAll($client_id,$id);
                $staff_chat_data = MessageCount::getStaff(Auth::user()->id);
                $data = array_merge($staff_chat_data,$chat_data);
                usort($data, function($a, $b) {
                    return $b['updated_at'] <=> $a['updated_at'];
                });
                $staffData = null;
            }elseif(Auth::user()->role == 4){
                $data = MessageCount::getRecruiter(Auth::user()->id);
                $staffData = null;
            }elseif(Auth::user()->role == 5){
                $data = MessageCount::getCandidate(Auth::user()->id);
                $staffData = null;
            }
            return view('admin.chat.index')->with('data',$data)->with('staffData',$staffData);
        }else{
            return redirect()->route('home.index');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function chatModal(Request $request) {

        $job_id = $request->job_id;
        $client_id = $request->client_id;
        $candidate_id = $request->candidate_id;
        $applied_id = $request->applied_id;
        $created_id = $request->created_id;
        $r_c_id = $request->r_c_id;
        $message_id = $request->message_id;

        $job_vacancy = JobVacancy::find($job_id);

        if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
            $clientCompany = SubCompany::getSubCompanyName($job_vacancy->sub_company);
        }else{
            $check_sub_client_or_not = User::checkSubClientOrNot($client_id);
            $clientCompany = User::clientCompany($check_sub_client_or_not);
        }


        $statusJobData = null;
        if(isset($r_c_id) && !empty($r_c_id)){
            // $chatusername = RecruiterCandidate::recruiterCandidateName($candidate_id).' - '.JobVacancy::jobName($job_id).' - '.User::clientCompany($r_c_id);
            $chatusername = RecruiterCandidate::recruiterCandidateName($candidate_id).' - '.JobVacancy::jobName($job_id);
        }else{
            if(Auth::user()->role == 5){
                $chatusername = $clientCompany.' - '.JobVacancy::jobName($job_id);
            }else{
                $chatusername = User::getUserName($candidate_id).' - '.JobVacancy::jobName($job_id);
            }
            if(empty($job_id) && empty($applied_id) && empty($r_c_id)){
                $chatusername = User::getUserName($candidate_id).' ('.$clientCompany.')';
                if(Auth::user()->role == 3){
                    $chatusername = User::getUserName($client_id).' ('.$clientCompany.')';
                }
                if(Auth::user()->role == 1){
                    $client_id = $candidate_id;
                    $clientCompany = User::clientCompany($client_id);
                    $chatusername = User::getUserName($client_id).' ('.$clientCompany.')';
                }
                if(Auth::user()->role == 2){
                    $chat_c_role = User::getRoleChat($candidate_id);

                    if($chat_c_role == 'Client'){
                        $clientCompany = 'Resource ATS';
                        $chatusername = User::getUserName(1).' ('.$clientCompany.')';
                    }
                    if($chat_c_role == 'Staff'){
                        $client_id = $client_id;
                        $check_sub_client_or_not = User::checkSubClientOrNot($client_id);
                        $clientCompany = User::clientCompany($check_sub_client_or_not);
                        $chatusername = User::getUserName($candidate_id).' ('.$clientCompany.')';
                    }
                }
            }
        }

        if(isset($message_id) && !empty($message_id)){
            $message_get = Message::getMessage($message_id);
            $sendid = Auth::user()->id;
            $statusJobData = view('admin.chat.chat_message')->with('message_get', $message_get)->with('sendid', $sendid)->render();

            $message_count = MessageCount::find($message_id);
            if(Auth::user()->role == 5){
                $message_count->u_count = 0;
            }elseif(Auth::user()->role == 4){
                $message_count->u_count = 0;
            }else{
                if(empty($job_id) && empty($applied_id)){
                    if(Auth::user()->role == 3){
                        $message_count->u_count = 0;
                    }elseif(Auth::user()->role == 2){
                        if(isset($message_count->staff_id) && !empty($message_count->staff_id)){
                            $message_count->count = 0;
                        }else{
                            $message_count->u_count = 0;
                        }
                    }else{
                        $message_count->count = 0;
                    }
                }else{
                    $message_count->count = 0;
                }

            }
            $message_count->save();
        }
        return response()->json(['page' => $statusJobData,'chatusername' => $chatusername, 'code' => 1]);
    }


    public function sendChat(Request $request) {

        $job_id = $request->job_id;
        $client_id = $request->client_id;
        $candidate_id = $request->candidate_id;
        $applied_id = $request->applied_id;
        $created_id = $request->created_id;
        $r_c_id = $request->r_c_id;
        $message_id = $request->message_id;
        $message = $request->message;
        $staff_id = $request->staff_id;

        $job_vacancy = JobVacancy::find($job_id);

        if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
            $clientCompany = SubCompany::getSubCompanyName($job_vacancy->sub_company);
        }else{
            $check_sub_client_or_not = User::checkSubClientOrNot($client_id);
            $clientCompany = User::clientCompany($check_sub_client_or_not);
        }

        $staff_arr = null;
        if(isset($job_id) && !empty($job_id)){
            $staff_arr = JobVacancy::getStaffArr($job_id);
        }
        if(empty($message_id)){

            if(isset($r_c_id) && !empty($r_c_id)){
                $name = RecruiterCandidate::recruiterCandidateName($candidate_id).' - '.JobVacancy::jobName($job_id);
            }else{
                $name = User::getUserName($candidate_id).' - '.JobVacancy::jobName($job_id);
                if(isset($staff_id) && !empty($staff_id)){
                    $name = User::getUserName($candidate_id);
                }
            }

            $message_count = new MessageCount;
            $message_count->job_id = $job_id;
            $message_count->client_id = $client_id;
            $message_count->candidate_id = $candidate_id;
            $message_count->applied_id = $applied_id;
            $message_count->r_c_id = $r_c_id;
            if(Auth::user()->role != 1){
                if(isset($staff_id) && !empty($staff_id)){
                    $message_count->staff_id = $staff_id;
                }
            }
            $message_count->name = $name;
            $message_count->staff_arr = $staff_arr;
            if(Auth::user()->role == 1){
                $message_count->created_id = 1;
            }
            $message_count->save();
            $message_id = $message_count->id;
        }

        $message_count = MessageCount::find($message_id);
        $message_count->staff_arr = $staff_arr;

        if(Auth::user()->role == 1){
            $message_count->created_id = 1;
        }

        if(Auth::user()->role == 5){
            $count = $message_count->count;
            $message_count->count = $count + 1;
        }elseif(Auth::user()->role == 4){
            $count = $message_count->count;
            $message_count->count = $count + 1;
        }else{
            if(empty($job_id) && empty($applied_id)){
                if(Auth::user()->role == 3){
                    $count = $message_count->count;
                    $message_count->count = $count + 1;
                }
                if(Auth::user()->role == 2){
                    if(isset($message_count->staff_id) && !empty($message_count->staff_id)){
                        $count = $message_count->u_count;
                        $message_count->u_count = $count + 1;
                    }else{
                        $count = $message_count->count;
                        $message_count->count = $count + 1;
                    }
                }
                if(Auth::user()->role == 1){
                    $count = $message_count->count;
                    $message_count->u_count = $count + 1;
                }
            }else{
                $count = $message_count->u_count;
                $message_count->u_count = $count + 1;
            }
        }

        $message_count->save();

        $messageData = new Message;
        $messageData->job_id = $job_id;
        $messageData->client_id = $client_id;
        $messageData->candidate_id = $candidate_id;
        $messageData->applied_id = $applied_id;
        $messageData->r_c_id = $r_c_id;
        $messageData->created_id = $created_id;
        $messageData->message = $message;
        $messageData->message_id = $message_id;
        if(Auth::user()->role == 5){
            $messageData->from_user_id = $candidate_id;
            $messageData->to_user_id = $client_id;

            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();

            if(isset($message_count->created_id) && !empty($message_count->created_id)){
                $data = User::clientData(1);

                $timeFirst  = strtotime( $time);
                $timeSecond = strtotime($data->check_status);
                $differenceInSeconds = $timeFirst - $timeSecond;

                if($differenceInSeconds >= 600){
                    $client_company_name = $clientCompany;
                    $job_name = JobVacancy::jobName($job_id);
                    $message_data = $message;
                    $time = 1;
                    $candidate_id_data = 1;
                    $recruiter_name = $message_name = null;
                    $candidate_name = User::getUserName($candidate_id);
                    $message_name = User::getUserName($candidate_id);
                    if($message_count->created_id == Auth::user()->id){
                        $mail_send_id = $candidate_id;
                    }else{
                        $mail_send_id = 1;
                    }
                    $job = (new OfflineResourceJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id,$mail_send_id))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                }
            }else{
                $getStaffSelect = JobVacancy::getStaffSelect($job_id);
                if(isset($getStaffSelect->staff_arr) && !empty($getStaffSelect->staff_arr)){
                    $staff_arr = explode(",",$getStaffSelect->staff_arr);

                    foreach($staff_arr as $key => $value){
                        $data = $timeFirst = $timeSecond = $differenceInSeconds = $time = null;

                        $time = $current_time->toDateTimeString();
                        $data = User::clientData($value);

                        $timeFirst  = strtotime( $time);
                        $timeSecond = strtotime($data->check_status);
                        $differenceInSeconds = $timeFirst - $timeSecond;

                        if($differenceInSeconds >= 600){
                            $client_company_name = $clientCompany;
                            $job_name = JobVacancy::jobName($job_id);
                            $message_data = $message;
                            $time =  $key;
                            $candidate_id_data = $value;
                            $recruiter_name = $message_name = null;
                            $candidate_name = User::getUserName($candidate_id);
                            $message_name = User::getUserName($candidate_id);
                            $job = (new OfflineCandidateJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id))->delay(now()->addSeconds($time * 4));
                            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                        }
                    }
                }else{

                    $data = User::clientData($client_id);

                    $timeFirst  = strtotime( $time);
                    $timeSecond = strtotime($data->check_status);
                    $differenceInSeconds = $timeFirst - $timeSecond;

                    if($differenceInSeconds >= 600){
                        $client_company_name = $clientCompany;
                        $job_name = JobVacancy::jobName($job_id);
                        $message_data = $message;
                        $time = 1;
                        $candidate_id_data = $client_id;
                        $recruiter_name = $message_name = null;
                        $candidate_name = User::getUserName($candidate_id);
                        $message_name = User::getUserName($candidate_id);
                        $job = (new OfflineCandidateJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id))->delay(now()->addSeconds($time * 4));
                        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                    }

                }
            }

        }elseif(Auth::user()->role == 4){
            $messageData->from_user_id = $candidate_id;
            $messageData->to_user_id = $client_id;

            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();

            if(isset($message_count->created_id) && !empty($message_count->created_id)){
                $data = User::clientData(1);

                $timeFirst  = strtotime( $time);
                $timeSecond = strtotime($data->check_status);
                $differenceInSeconds = $timeFirst - $timeSecond;

                if($differenceInSeconds >= 600){
                    $client_company_name = $clientCompany;
                    $job_name = JobVacancy::jobName($job_id);
                    $message_data = $message;
                    $time = 1;
                    $candidate_id_data = $client_id;
                    $candidate_name = RecruiterCandidate::recruiterCandidateName($candidate_id);
                    $recruiter_name = $message_name = null;
                    if(isset($r_c_id) && !empty($r_c_id)){
                        $recruiter_name = User::getUserName($r_c_id);
                        $message_name = $recruiter_name;
                    }
                    if($message_count->created_id == Auth::user()->id){
                        $mail_send_id = $candidate_id_data;
                    }else{
                        $mail_send_id = 1;
                    }
                    $job = (new OfflineResourceJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id,$mail_send_id))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                }
            }else{
                $getStaffSelect = JobVacancy::getStaffSelect($job_id);
                if(isset($getStaffSelect->staff_arr) && !empty($getStaffSelect->staff_arr)){
                    $staff_arr = explode(",",$getStaffSelect->staff_arr);

                    foreach($staff_arr as $key => $value){
                        $data = $timeFirst = $timeSecond = $differenceInSeconds = $time = null;

                        $time = $current_time->toDateTimeString();
                        $data = User::clientData($value);

                        $timeFirst  = strtotime( $time);
                        $timeSecond = strtotime($data->check_status);
                        $differenceInSeconds = $timeFirst - $timeSecond;

                        if($differenceInSeconds >= 600){
                            $client_company_name = $clientCompany;
                            $job_name = JobVacancy::jobName($job_id);
                            $message_data = $message;
                            $time =  $key;
                            $candidate_id_data = $value;
                            $candidate_name = RecruiterCandidate::recruiterCandidateName($candidate_id);
                            $recruiter_name = $message_name = null;
                            if(isset($r_c_id) && !empty($r_c_id)){
                                $recruiter_name = User::getUserName($r_c_id);
                                $message_name = User::getUserName($r_c_id);
                            }
                            $job = (new OfflineCandidateJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id))->delay(now()->addSeconds($time * 4));
                            app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                        }
                    }
                }else{

                    $data = User::clientData($client_id);

                    $timeFirst  = strtotime( $time);
                    $timeSecond = strtotime($data->check_status);
                    $differenceInSeconds = $timeFirst - $timeSecond;

                    if($differenceInSeconds >= 600){
                        $client_company_name = $clientCompany;
                        $job_name = JobVacancy::jobName($job_id);
                        $message_data = $message;
                        $time = 1;
                        $candidate_id_data = $client_id;
                        $candidate_name = RecruiterCandidate::recruiterCandidateName($candidate_id);
                        $recruiter_name = $message_name = null;
                            if(isset($r_c_id) && !empty($r_c_id)){
                                $recruiter_name = User::getUserName($r_c_id);
                                $message_name = User::getUserName($client_id);
                            }
                        $job = (new OfflineCandidateJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id))->delay(now()->addSeconds($time * 4));
                        app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                    }

                }
            }
        }else{
            $messageData->from_user_id = $client_id;
            $messageData->to_user_id = $candidate_id;

            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();

            if(isset($message_count->created_id) && !empty($message_count->created_id)){
                // if(isset($r_c_id) && !empty($r_c_id)){
                //     $data = User::clientData($r_c_id);
                // }else{
                //     $data = User::clientData($candidate_id);
                // }
                //
                // if($data->role == 2){
                //     $client_id = 1;
                //     $data = User::clientData($client_id);
                // }

                if($message_count->created_id == Auth::user()->id){
                  if(isset($r_c_id) && !empty($r_c_id)){
                      $data = User::clientData($r_c_id);
                  }else{
                      $data = User::clientData($candidate_id);
                  }
                }else{
                    $client_id = 1;
                    $data = User::clientData($client_id);
                }


                $timeFirst  = strtotime( $time);
                $timeSecond = strtotime($data->check_status);
                $differenceInSeconds = $timeFirst - $timeSecond;
                if($differenceInSeconds >= 600){
                    $client_company_name = $clientCompany;
                    $job_name = JobVacancy::jobName($job_id);
                    $message_data = $message;
                    $time = 1;
                    $recruiter_name = $candidate_name = $message_name = null;
                    $get_message_name = User::getUserName(Auth::user()->id);
                    $get_companu_name = User::chatMessageCompanyName(Auth::user()->id);

                    if($data->role = 5){
                        if(isset($get_companu_name) && !empty($get_companu_name)){
                            $message_name = $get_message_name.' at '.$get_companu_name;
                        }else{
                            $message_name = $get_message_name;
                        }
                    }else{
                        if(isset($get_companu_name) && !empty($get_companu_name)){
                            $message_name = $get_message_name.' at '.$get_companu_name;
                        }else{
                            $message_name = $get_message_name;
                        }
                    }

                    $candidate_id_data = $candidate_id;
                    if(isset($r_c_id) && !empty($r_c_id)){
                        $candidate_name = RecruiterCandidate::recruiterCandidateName($candidate_id);

                        $get_message_name = User::getUserName(Auth::user()->id);
                        $get_companu_name = User::chatMessageCompanyName(Auth::user()->id);
                        if($data->role = 4){
                            $message_name = $get_message_name;
                        }else{
                            if(isset($get_companu_name) && !empty($get_companu_name)){
                                $message_name = $get_message_name.' at '.$get_companu_name;
                            }else{
                                $message_name = $get_message_name;
                            }
                        }

                        $candidate_id_data = $r_c_id;
                    }

                    if($message_count->created_id == Auth::user()->id){
                        $mail_send_id = $candidate_id_data;
                    }else{
                        $mail_send_id = 1;
                    }

                    $job = (new OfflineResourceJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id,$mail_send_id))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                }
            }else{
                if(isset($r_c_id) && !empty($r_c_id)){
                    $data = User::clientData($r_c_id);
                }else{
                    $data = User::clientData($candidate_id);
                }

                if(Auth::user()->id == $candidate_id){
                    $data = User::clientData($client_id);
                    $candidate_id = $client_id;
                }else{
                    $data = User::clientData($candidate_id);
                    $candidate_id = $candidate_id;
                }

                $timeFirst  = strtotime( $time);
                $timeSecond = strtotime($data->check_status);
                $differenceInSeconds = $timeFirst - $timeSecond;

                if($differenceInSeconds >= 600){
                    if(Auth::user()->role == 2){
                        $client_company_name = null;
                    }elseif(Auth::user()->role == 3){
                        $client_company_name = null;
                    }else{
                        $client_company_name = $clientCompany;
                    }
                    $job_name = JobVacancy::jobName($job_id);
                    $message_data = $message;
                    $time = 1;
                    $recruiter_name = $candidate_name = $message_name = null;

                    $get_message_name = User::getUserName(Auth::user()->id);
                    $get_companu_name = User::chatMessageCompanyName(Auth::user()->id);
                    if($data->role = 5){
                        $message_name = $get_message_name;
                    }else{
                        if(isset($get_companu_name) && !empty($get_companu_name)){
                            $message_name = $get_message_name.' at '.$get_companu_name;
                        }else{
                            $message_name = $get_message_name;
                        }
                    }

                    $candidate_id_data = $candidate_id;
                    if(isset($r_c_id) && !empty($r_c_id)){
                        $candidate_name = RecruiterCandidate::recruiterCandidateName($candidate_id);

                        $get_message_name = User::getUserName(Auth::user()->id);
                        $get_companu_name = User::clientCompany(Auth::user()->id);
                        if($data->role = 4){
                            $message_name = $get_message_name;
                        }else{
                            if(isset($get_companu_name) && !empty($get_companu_name)){
                                $message_name = $get_message_name.' at '.$get_companu_name;
                            }else{
                                $message_name = $get_message_name;
                            }
                        }

                        $candidate_id_data = $r_c_id;
                    }

                    $job = (new OfflineCandidateJobs($client_id, $candidate_id_data,$message_data,$client_company_name,$job_name,$candidate_name,$recruiter_name,$message_name,$job_id))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                }
            }
        }

        if((empty($job_id)) && (empty($applied_id))){
            if(Auth::user()->role == 2){
                if(isset($message_count->staff_id) && !empty($message_count->staff_id)){
                    $client_id = $request->client_id;
                    $messageData->from_user_id = $client_id;
                    $messageData->to_user_id = $candidate_id;
                }else{
                    $messageData->from_user_id = $candidate_id;
                    $messageData->to_user_id = $client_id;
                }
            }elseif(Auth::user()->role == 3){
                $client_id = $request->client_id;
                $messageData->from_user_id = $candidate_id;
                $messageData->to_user_id = $client_id;
            }elseif(Auth::user()->role == 1){
                $messageData->from_user_id = $client_id;
                $messageData->to_user_id = $candidate_id;
            }
        }

        $messageData->save();

        if(Auth::user()->role == 5){
            $chat_name = 'You';
            $chat_image = strtoupper(substr(Auth::user()->email,0,1));
        }elseif(Auth::user()->role == 4){
            $chat_name = RecruiterCandidate::recruiterCandidateName($candidate_id);
            // $chat_name = User::getUserName($r_c_id);
            $chat_image = strtoupper(substr($chat_name,0,1));
        }else{
            $chat_name = $clientCompany;
            $chat_image = strtoupper(substr($chat_name,0,1));
        }

        if(empty($job_id) && empty($applied_id)){
            $chat_name = User::getUserName($client_id).' ('.$clientCompany.')';
            $chat_image = strtoupper(substr($chat_name,0,1));
            $chat_c_role = User::getRoleChat($candidate_id);
            if($chat_c_role == 'Staff'){
                $check_sub_client_or_not = User::checkSubClientOrNot($client_id);
                $chat_name = User::getUserName($candidate_id).'('.User::clientCompany($check_sub_client_or_not).')';
                $chat_image = strtoupper(substr($chat_name,0,1));
            }

            if(Auth::user()->role == 2){
                // $chat_name = User::getUserName($client_id).' ('.$clientCompany.')';;
                // $chat_image = strtoupper(substr($chat_name,0,1));
                if(isset($message_count->staff_id) && !empty($message_count->staff_id)){
                    $chat_name = User::getUserName(Auth::user()->id).' ('.$clientCompany.')';
                    $chat_image = strtoupper(substr($chat_name,0,1));
                }else{
                    if(isset($message_count->created_id) && !empty($message_count->created_id)){
                        $client_id = $candidate_id;
                        $clientCompany = User::clientCompany($client_id);
                        $chat_name = User::getUserName($client_id).' ('.$clientCompany.')';;
                        $chat_image = strtoupper(substr($chat_name,0,1));
                    }else{
                        $chat_c_role = User::getRoleChat($value['candidate_id']);
                        $client_id = $messageData->client_id;
                        $clientCompany = User::clientCompany($client_id);
                        $chat_name = User::getUserName($client_id).' ('.$clientCompany.')';;
                        $chat_image = strtoupper(substr($chat_name,0,1));
                    }

                }
            }
            if(Auth::user()->role == 1){
                $chat_name = User::getUserName($client_id).' (Resource ATS)';;
                $chat_image = strtoupper(substr($chat_name,0,1));
            }
        }

        $chat_c_role = User::getRoleChat($created_id);
        $chat_c_name = null;
        if(isset($chat_c_role) && !empty($chat_c_role)){
            if(empty($messageData->job_id) && empty($messageData->applied_id) && empty($messageData->r_c_id)){

            }else{
                $chat_c_role = User::getRoleChat(Auth::user()->id);
                if(isset($chat_c_role) && !empty($chat_c_role)){
                    if(isset($chat_c_role) && !empty($chat_c_role)){
                        if($chat_c_role == 'Recruiter'){
                            $chat_c_name = '('.User::clientCompany(Auth::user()->id).')';
                        }else{
                            $chat_c_name = '('.User::clientName(Auth::user()->id).')';
                        }
                    }else{
                        $chat_c_name = '('.User::clientName(Auth::user()->id).')';
                    }
                }
            }
        }
        $statusJobData = view('admin.chat.from_chart')->with('message', $message)->with('chat_name', $chat_name)->with('chat_image', $chat_image)->with('chat_c_name', $chat_c_name)->render();

        return response()->json(['message_id' => $message_id,'message' => $statusJobData, 'code' => 1]);
    }

    public function userMessageAllData(Request $request) {

        $user_id = $request->user_id;
        $user_role = $request->user_role;

        if($user_role == 1){
            $data = MessageCount::getAll();
        }elseif($user_role == 2){
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            $chat_data = MessageCount::getClientAll($id);
            $staff_data = MessageCount::getClient(Auth::user()->id);
            $data = array_merge($staff_data,$chat_data);
            usort($data, function($a, $b) {
                return $b['updated_at'] <=> $a['updated_at'];
            });
        }elseif($user_role == 3){
            $client_id = Auth::user()->created_user_id;
            $id = Auth::user()->id;
            $chat_data = MessageCount::getStaffAll($client_id,$id);
            $staff_data = MessageCount::getStaff(Auth::user()->id);
            $data = array_merge($staff_data,$chat_data);
            usort($data, function($a, $b) {
                return $b['updated_at'] <=> $a['updated_at'];
            });
        }elseif($user_role == 4){
            $data = MessageCount::getRecruiter($user_id);
        }elseif($user_role == 5){
            $data = MessageCount::getCandidate($user_id);
        }
        $statusJobData = view('admin.chat.chat_side_bar')->with('data', $data)->render();
        return response()->json(['page' => $statusJobData,'code' => 1]);

    }

    public function userMessageAllDataSearch(Request $request) {

        $value = $request->search_value;
        $user_id = $request->user_id;
        $user_role = $request->user_role;

        if($user_role == 1){
            $data = MessageCount::dataSearchAll($value);
        }elseif($user_role == 2){
            $data = MessageCount::dataSearchAll($value);
        }elseif($user_role == 3){
            $data = MessageCount::dataStaffSearchAll($value);
        }elseif($user_role == 4){
            $data = MessageCount::dataSearchGetRecruiter($user_id,$value);
        }elseif($user_role == 5){
            $data = MessageCount::dataSearchGetCandidate($user_id,$value);
        }
        $statusJobData = view('admin.chat.chat_side_bar')->with('data', $data)->render();

        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }

    public static function viewChatCount(Request $request){
        $id = $request->user_id;
        $role = $request->user_role;
        $user_created_user = $request->user_created_user;
        if($role == 1){
            $data = MessageCount::getAllCount();
        }elseif($role  == 2){
            $data = MessageCount::getClientAllCount($id);
        }elseif($role  == 3){
            $chat_data = MessageCount::getStaffAllCount($user_created_user);
            $staff_chat_data = MessageCount::getStaffCount($user_created_user,$id);
            $data = array_merge($staff_chat_data,$chat_data);
        }elseif($role == 4){
            $data = MessageCount::getRecruiterCount($id);
        }elseif($role == 5){
            $data = MessageCount::getCandidateCount($id);
        }
        return response()->json(['datacount' => $data,'code' => 1]);
    }

    public static function viewMessage(Request $request){
        $id = Auth::user()->id;
        if(Auth::user()->role == 1){
            $data = MessageCount::getAllCountDisplay();
        }elseif(Auth::user()->role == 2){
            // if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
            //     $id = Auth::user()->created_user_id;
            // }else{
            //     $id = Auth::user()->id;
            // }
            $id = Auth::user()->id;
            $chat_data = MessageCount::getClientAllCountDisplay($id);
            $client_chat_data = MessageCount::getClientCountDisplay($id);
            $data = $client_chat_data + $chat_data;
        }elseif(Auth::user()->role == 3){
            $user_created_user = Auth::user()->created_user_id;
            $chat_data = MessageCount::getStaffAllCountDisplay($user_created_user);
            $staff_chat_data = MessageCount::getStaffCountDisplay($user_created_user,$id);
            $data = $staff_chat_data + $chat_data;
        }elseif(Auth::user()->role == 4){
            $data = MessageCount::getRecruiterCountDisplay($id);
        }elseif(Auth::user()->role == 5){
            $data = MessageCount::getCandidateCountDisplay($id);
            $data = (int)$data;
        }
        return response()->json(['count' => $data,'code' => 1]);
    }

}
