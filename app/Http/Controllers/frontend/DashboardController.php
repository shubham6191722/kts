<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobOffers;
use App\Models\JobApplied;
use App\Models\JobEvent;

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

        $user_id = Auth::user()->id;

        $job_new = 1;
        $max_data = 20;

        $toDay = date("Y-m-d");
        $strtotime = strtotime('+14 day');
        $formDay = date("Y-m-d",$strtotime);

        $job_applied = JobApplied::jobCandidateGet($user_id);
        $offer_data = JobOffers::offerCandidatePanding($user_id);
        $offer_data_count = JobOffers::offerCandidatePanding($user_id)->count();

        $job_event = JobEvent::candidateEventsData($user_id,$toDay,$formDay,$max_data);
        $job_event_count = count($job_event);
        
        
        $job_pending_event = JobEvent::pendingCandidateEventsData($user_id,$toDay,$formDay,$max_data);
        $job_pending_event_count = count($job_pending_event);

        $event = JobEvent::eventCandidateGet($user_id);

        $event_data = @json_encode($event, true);
       
        return view('frontend.after_login.dashboard.index')->with('job_applied',$job_applied)->with('event_data',$event_data)->with('event',$event)
                                                           ->with('offer_data',$offer_data)->with('offer_data_count',$offer_data_count)
                                                           ->with('job_event',$job_event)->with('job_event_count',$job_event_count)
                                                           ->with('job_pending_event',$job_pending_event)->with('job_pending_event_count',$job_pending_event_count);
    }

}
