<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobEvent;
use App\Models\JobOffers;
use App\Models\JobApplied;
use App\Models\JobActivity;

class DashboardController extends Controller {

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

        $job_new = 1;
        $max_data = 20;

        $toDay = date("Y-m-d");
        $strtotime = strtotime('+14 day');
        $formDay = date("Y-m-d",$strtotime);

        if(Auth::check()){

            if(Auth::user()->role == 1){

                $active_candidate = User::where('role','=',5)->where('status','=',1)->count();
                $deactive_candidate = User::where('role','=',5)->where('status','=',0)->count();

                $active_client = User::where('role','=',2)->where('status','=',1)->count();
                $deactive_client = User::where('role','=',2)->where('status','=',0)->count();

                $manage_by_direct = JobVacancy::where('managed_by','=',2)->where('deleted_at','=',null)->count();
                $manage_by_re_source = JobVacancy::where('managed_by','=',1)->where('deleted_at','=',null)->count();
                
                $event = JobEvent::where('deleted_at','=',null)->count();
                $reject_offer = JobOffers::where('offer_status','=','2')->where('deleted_at','=',null)->count();
                $success_offer = JobOffers::where('offer_status','=','1')->where('deleted_at','=',null)->count();
                return view('admin.dashboard.admin_index')->with('active_candidate',$active_candidate)->with('deactive_candidate',$deactive_candidate)
                                                          ->with('active_client',$active_client)->with('deactive_client',$deactive_client)
                                                          ->with('manage_by_direct',$manage_by_direct)->with('manage_by_re_source',$manage_by_re_source)
                                                          ->with('event',$event)->with('reject_offer',$reject_offer)->with('success_offer',$success_offer);

            }elseif(Auth::user()->role == 2){

                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $user_id = Auth::user()->created_user_id;
                }else{
                    $user_id = Auth::user()->id;
                }

                $job_applied = JobApplied::clientNewJobAppliedData($user_id,$job_new,$max_data);
                $pending_offer = JobOffers::clientPendingData($user_id,$max_data);
                $job_event = JobEvent::clientEventsData($user_id,$toDay,$formDay,$max_data);

                $job_applied_count = count($job_applied);
                $pending_offer_count = count($pending_offer);
                $job_event_count = count($job_event);

                return view('admin.dashboard.client_index')->with('job_applied',$job_applied)->with('pending_offer',$pending_offer)->with('job_event',$job_event)
                                                           ->with('job_applied_count',$job_applied_count)->with('pending_offer_count',$pending_offer_count)
                                                           ->with('job_event_count',$job_event_count);

            }elseif(Auth::user()->role == 3){

                $user_id = Auth::user()->id;

                $job_vacancy = JobVacancy::whereRaw('FIND_IN_SET('.$user_id.',staff_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
                $job_applied = array();
                foreach($job_vacancy as $Jkey => $value){
                    $job_applied_data = JobApplied::where('job_id','=',$value->id)->where('job_new','=',$job_new)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
                    foreach($job_applied_data as $j_value){
                        $array_count = count($job_applied);
                        if($array_count <= $max_data){
                            array_push($job_applied, $j_value);
                        }
                    }
                }

                $pending_offer = array();
                foreach($job_vacancy as $Jkey => $value){
                    $pending_offer_data = JobOffers::where('vacancy_id','=',$value->id)->where('offer_status','=','0')->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
                    foreach($pending_offer_data as $a_value){
                        $array_count = count($job_applied);
                        if($array_count <= $max_data){
                            array_push($pending_offer, $a_value);
                        }
                    }
                }

                $job_event = array();
                foreach($job_vacancy as $Jkey => $value){
                    $job_applied_data = JobEvent::where('vacancy_id','=',$value->id)->whereBetween('confirm_date', [$toDay, $formDay])->where('deleted_at','=',null)->orderBy('id', 'asc')->get()->toArray();
                    foreach($job_applied_data as $e_value){
                        $array_count = count($job_event);
                        if($array_count <= $max_data){
                            array_push($job_event, $e_value);
                        }
                    }
                }

                $job_applied_count = count($job_applied);
                $pending_offer_count = count($pending_offer);
                $job_event_count = count($job_event);
                
                return view('admin.dashboard.staff_index')->with('job_applied',$job_applied)->with('pending_offer',$pending_offer)->with('job_event',$job_event)
                                                          ->with('job_applied_count',$job_applied_count)->with('pending_offer_count',$pending_offer_count)
                                                          ->with('job_event_count',$job_event_count);


            }elseif(Auth::user()->role == 4){
                $user_id = Auth::user()->id;

                $pending_offer = JobOffers::recruiterPendingData($user_id,$max_data);
                $pending_offer_count = count($pending_offer);

                $job_event = JobEvent::recruiterEventsData($user_id,$toDay,$formDay,$max_data);
                $job_event_count = count($job_event);
                
                $job_pending_event = JobEvent::pendingRecruiterEventsData($user_id,$toDay,$formDay,$max_data);
                $job_pending_event_count = count($job_pending_event);

                $job_vacancy = JobVacancy::recruiterVacancyDataAdd($user_id);
                $job_vacancy_count = count($job_vacancy);

                return view('admin.dashboard.recruiter_index')->with('pending_offer',$pending_offer)->with('pending_offer_count',$pending_offer_count)
                                                              ->with('job_event',$job_event)->with('job_event_count',$job_event_count)
                                                              ->with('job_vacancy',$job_vacancy)->with('job_vacancy_count',$job_vacancy_count)
                                                              ->with('job_pending_event',$job_pending_event)->with('job_pending_event_count',$job_pending_event_count);

            }

        }else{
            return redirect()->route('home.index');
        }       
    }
    
    public function clientActivity(Request $request) {

        $statusJobData = '';
        
        $user_id = Auth::user()->id;

        if(Auth::user()->role == 2){
            $job_activity = JobActivity::getClientData($user_id);
            $statusJobData = view('admin.dashboard.dashboard_data.client.job_activity_data')->with('job_activity', $job_activity)->render();
        }elseif(Auth::user()->role == 3){

            $job_vacancy = JobVacancy::whereRaw('FIND_IN_SET('.$user_id.',staff_arr)')->where('deleted_at','=',null)->orderBy('id', 'desc')->get();
            $job_activity = array();
            foreach($job_vacancy as $Jkey => $value){
                $job_applied_data = JobActivity::where('job_id','=',$value->id)->where('deleted_at','=',null)->orderBy('id', 'desc')->get()->toArray();
                foreach($job_applied_data as $e_value){
                    $array_count = count($job_activity);
                    if($array_count <= 20){
                        array_push($job_activity, $e_value);
                    }
                }
            }
            $statusJobData = view('admin.dashboard.dashboard_data.client.job_activity_data')->with('job_activity', $job_activity)->render();
        }

        return response()->json(['page' => $statusJobData, 'code' => 1]);

    }

}
