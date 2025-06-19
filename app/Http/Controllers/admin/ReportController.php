<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Config;

use App\Models\User;
use App\Models\SiteSetting;
use App\Models\JobVacancy;
use App\Models\JobOffers;
use App\Models\JobApplied;
use App\Models\AdvertisementOption;
use App\Models\JobCategory;
use App\Models\JobEvent;
use App\Models\OfferLeavingReason;

use Hash;
use Mail;

class ReportController extends Controller {

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
    public function reportList(){

        if(Auth::check()){
            $clientList = null;
            $job_category = null;
            if(Auth::user()->role == 1){
                $id = Auth::user()->id;
                $clientList = User::clientList();
                $job_category = JobCategory::getAll();
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $job_category = JobCategory::getAll();
            }elseif(Auth::user()->role == 3){
                $id = Auth::user()->id;
            }elseif(Auth::user()->role == 4){
                $id = Auth::user()->id;
            }
            return view('admin.report.index')->with('clientList',$clientList)->with('job_category',$job_category)->with('id',$id);
        }else{
            return redirect()->route('home.index');
        }


    }
    
    public function reportDataGet(Request $request){

        $user_id = $request->u_id;
        $client_id = $request->c_id;
        $startdate = null;
        $enddate = null;
        if(isset($request->todate) && !empty($request->todate))
        {
            $dateData = explode(" To ",$request->todate);
            $s_date = $dateData[0];
            $e_date = $dateData[1];
            $startdate = Carbon::parse($s_date)->toDateTimeString();
            $enddate = Carbon::parse($e_date)->toDateTimeString();
        }

        // workBasePreference
        $office = JobApplied::reportDataGetOffice($user_id,$client_id,$startdate,$enddate);
        $remote = JobApplied::reportDataGetRemote($user_id,$client_id,$startdate,$enddate);
        $hybrid = JobApplied::reportDataGetHybrid($user_id,$client_id,$startdate,$enddate);

        $work_base_preference[0] = $office;
        $work_base_preference[1] = $remote;
        $work_base_preference[2] = $hybrid;

        // jobAdvertisementSource
        $advertisement_option = AdvertisementOption::where('client_id','=',$user_id)->where('deleted_at','=',null)->get();

        $advertisement_option_name = array();
        $advertisement_option_count = array();
        $advertisement_option_color = array();
        foreach($advertisement_option as $key => $value){
            $count = JobApplied::reportDataGetAdvertisementSource($user_id,$value->id,$startdate,$enddate);
            $color = CustomFunction::random_color();
            $advertisement_option_name = array_merge($advertisement_option_name, [$key => $value->option_name]);
            $advertisement_option_count = array_merge($advertisement_option_count, [$key => $count]);
            $advertisement_option_color = array_merge($advertisement_option_color, [$key => $color]);
        }
        $count = JobApplied::where('client_id','=',$user_id)->where('job_advertised','=',null);
        
        $query = JobApplied::query();
        
        $query = $query->where('client_id',$user_id)->where('job_advertised','=',null);
        if((isset($startdate) && !empty($startdate)) && (isset($enddate) && !empty($enddate)) )
        {
            $query = $query->whereBetween('created_at', [$startdate, $enddate]);
        }
        $count = $query->where('deleted_at','=',null)->count();

        array_push($advertisement_option_name, "No Advertisement Source");
        array_push($advertisement_option_count, $count);
        array_push($advertisement_option_color, "#000000");

        $live_vacancies = $jobs_filled = $jobs_on_hold = $jobs_cancelled = $offers_pending = $live_interviews =$candidates_waiting =$candidates_left = 0;

        $live_vacancies = JobVacancy::liveVacancyCount($user_id);
        $jobs_filled = JobVacancy::jobsFilledCount($user_id);
        $jobs_on_hold = JobVacancy::jobsonholdCount($user_id);
        $jobs_cancelled = JobVacancy::jobsCancelledCount($user_id);
        $offers_pending = JobOffers::offersPendingCount($user_id);

        $live_interviews_data = JobEvent::liveInterviewsCount($user_id);
        $live_interviews = count($live_interviews_data);

        $candidates_waiting_data = JobOffers::candidatesWaitingCount($user_id);
        $candidates_waiting = count($candidates_waiting_data);

        $candidates_left_data = OfferLeavingReason::candidatesLeftCount($user_id);
        $candidates_left = count($candidates_left_data);

        return response()->json(['work_base_preference' => $work_base_preference,'advertisement_option_name' => $advertisement_option_name,
                                 'advertisement_option_count' => $advertisement_option_count,'advertisement_option_color' => $advertisement_option_color,
                                 'live_vacancies' => $live_vacancies,'jobs_filled' => $jobs_filled,'jobs_on_hold' => $jobs_on_hold,
                                 'jobs_cancelled' => $jobs_cancelled,'offers_pending' => $offers_pending,'live_interviews' => $live_interviews,
                                 'candidates_waiting' => $candidates_waiting,'candidates_left' => $candidates_left,
                                 'code' => 1]);
    }

    public function timeToHire(Request $request){

        $client_id = $request->client_id;

        $job_vacancy = JobVacancy::reportJobTitle($client_id);
    
        return response()->json(['job_vacancy' => $job_vacancy,'code' => 1]);

    }
    
    public function reportTimeToHireAction(Request $request){

        $u_id = $request->u_id;
        $todate = $request->todate;
        $j_id = $request->j_id;
        $j_c_id = $request->j_c_id;
        
        $startdate = null;
        $enddate = null;
        if(isset($request->todate) && !empty($request->todate))
        {
            $dateData = explode(" To ",$request->todate);
            $s_date = $dateData[0];
            $e_date = $dateData[1];
            $startdate = Carbon::parse($s_date)->toDateTimeString();
            $enddate = Carbon::parse($e_date)->toDateTimeString();
        }

        $timeToHireAll = JobVacancy::timeToHireAll($u_id,$j_id,$j_c_id,$startdate,$enddate);

        $data = null;
        if(isset($timeToHireAll) && !empty($timeToHireAll) && count($timeToHireAll)){
            if($timeToHireAll['totle_day'] > 0){
                $timeToHireData = $timeToHireAll['result'];
                $timeToHireCount = $timeToHireAll['totle_day'];
                $data = view('admin.report.report_data')->with('timeToHireCount', $timeToHireCount)->with('timeToHireData', $timeToHireData)->render();
            }else{
                $data = null;
            }
        }

        return response()->json(['data' => $data,'code' => 1]);

    }


    public function reportPrintAction(Request $request,$id){

        if(isset($id) && !empty($id)){
            $user_id = $id;

            $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
            $jobvacancystage = Config::get('dropdown.jobvacancystage');
            $reasonforleaving = Config::get('dropdown.reason_for_leaving');

            $live_vacancies = $jobs_filled = $jobs_on_hold = $jobs_cancelled = $offers_pending = $live_interviews =$candidates_waiting =$candidates_left = 0;

            if($request->action == 'live_vacancies'){
                $live_vacancies = JobVacancy::liveVacancyData($user_id);
                return view('admin.print_report.view.live_vacancies')->with('live_vacancies',$live_vacancies)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)->with('user_id',$user_id);
            }

            if($request->action == 'live_interviews'){
                $live_interviews = JobEvent::liveInterviewsCount($user_id);
                return view('admin.print_report.view.live_interviews')->with('live_interviews',$live_interviews)->with('user_id',$user_id);
            }
            
            if($request->action == 'offers_pending'){
                $offers_pending = JobOffers::offersPendingData($user_id);
                return view('admin.print_report.view.offers_pending')->with('offers_pending',$offers_pending)->with('user_id',$user_id);
            }

            if($request->action == 'jobs_filled'){
                $jobs_filled = JobVacancy::jobsFilledData($user_id);
                return view('admin.print_report.view.jobs_filled')->with('jobs_filled',$jobs_filled)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)->with('user_id',$user_id);
            }

            if($request->action == 'candidates_waiting'){
                $candidates_waiting = JobOffers::candidatesWaitingCount($user_id);
                return view('admin.print_report.view.candidates_waiting')->with('candidates_waiting',$candidates_waiting)->with('user_id',$user_id);
            }

            if($request->action == 'jobs_on_hold'){
                $jobs_on_hold = JobVacancy::jobsonholdData($user_id);
                return view('admin.print_report.view.jobs_on_hold')->with('jobs_on_hold',$jobs_on_hold)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)->with('user_id',$user_id);
            }
            
            if($request->action == 'jobs_cancelled'){
                $jobs_cancelled = JobVacancy::jobsCancelledData($user_id);
                return view('admin.print_report.view.jobs_cancelled')->with('jobs_cancelled',$jobs_cancelled)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage)->with('user_id',$user_id);
            }
            
            if($request->action == 'candidates_left'){
                $candidates_left = OfferLeavingReason::candidatesLeftCount($user_id);
                return view('admin.print_report.view.candidates_left')->with('candidates_left',$candidates_left)->with('reasonforleaving',$reasonforleaving)->with('user_id',$user_id);
            }

            if($request->action == ''){

                $live_vacancies = JobVacancy::liveVacancyCount($user_id);
                $jobs_filled = JobVacancy::jobsFilledCount($user_id);
                $jobs_on_hold = JobVacancy::jobsonholdCount($user_id);
                $jobs_cancelled = JobVacancy::jobsCancelledCount($user_id);
                $offers_pending = JobOffers::offersPendingCount($user_id);
        
                $live_interviews_data = JobEvent::liveInterviewsCount($user_id);
                $live_interviews = count($live_interviews_data);
        
                $candidates_waiting_data = JobOffers::candidatesWaitingCount($user_id);
                $candidates_waiting = count($candidates_waiting_data);
        
                $candidates_left_data = OfferLeavingReason::candidatesLeftCount($user_id);
                $candidates_left = count($candidates_left_data);

                return view('admin.print_report.index')->with('live_vacancies',$live_vacancies)->with('jobs_filled',$jobs_filled)
                                                       ->with('jobs_on_hold',$jobs_on_hold)->with('jobs_cancelled',$jobs_cancelled)
                                                       ->with('offers_pending',$offers_pending)->with('live_interviews',$live_interviews)
                                                       ->with('candidates_waiting',$candidates_waiting)->with('candidates_left',$candidates_left);
            }
        }
        return redirect()->route('home.index');

        
    }

    public function reportPrintActionPrint(Request $request,$id){

        if(isset($id) && !empty($id)){
            $user_id = $id;

            $jobvacancystatus = Config::get('dropdown.jobvacancystatus');
            $jobvacancystage = Config::get('dropdown.jobvacancystage');
            $reasonforleaving = Config::get('dropdown.reason_for_leaving');

            $live_vacancies = $jobs_filled = $jobs_on_hold = $jobs_cancelled = $offers_pending = $live_interviews =$candidates_waiting =$candidates_left = 0;

            if($request->action == 'live_vacancies'){
                $live_vacancies = JobVacancy::liveVacancyData($user_id);
                return view('admin.print_report.live_vacancies')->with('live_vacancies',$live_vacancies)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage);
            }

            if($request->action == 'live_interviews'){
                $live_interviews = JobEvent::liveInterviewsCount($user_id);
                return view('admin.print_report.live_interviews')->with('live_interviews',$live_interviews);
            }
            
            if($request->action == 'offers_pending'){
                $offers_pending = JobOffers::offersPendingData($user_id);
                return view('admin.print_report.offers_pending')->with('offers_pending',$offers_pending);
            }

            if($request->action == 'jobs_filled'){
                $jobs_filled = JobVacancy::jobsFilledData($user_id);
                return view('admin.print_report.jobs_filled')->with('jobs_filled',$jobs_filled)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage);
            }

            if($request->action == 'candidates_waiting'){
                $candidates_waiting = JobOffers::candidatesWaitingCount($user_id);
                return view('admin.print_report.candidates_waiting')->with('candidates_waiting',$candidates_waiting);
            }

            if($request->action == 'jobs_on_hold'){
                $jobs_on_hold = JobVacancy::jobsonholdData($user_id);
                return view('admin.print_report.jobs_on_hold')->with('jobs_on_hold',$jobs_on_hold)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage);
            }
            
            if($request->action == 'jobs_cancelled'){
                $jobs_cancelled = JobVacancy::jobsCancelledData($user_id);
                return view('admin.print_report.jobs_cancelled')->with('jobs_cancelled',$jobs_cancelled)->with('jobvacancystatus',$jobvacancystatus)->with('jobvacancystage',$jobvacancystage);
            }
            
            if($request->action == 'candidates_left'){
                $candidates_left = OfferLeavingReason::candidatesLeftCount($user_id);
                return view('admin.print_report.candidates_left')->with('candidates_left',$candidates_left)->with('reasonforleaving',$reasonforleaving);
            }

            if($request->action == ''){

                $live_vacancies = JobVacancy::liveVacancyCount($user_id);
                $jobs_filled = JobVacancy::jobsFilledCount($user_id);
                $jobs_on_hold = JobVacancy::jobsonholdCount($user_id);
                $jobs_cancelled = JobVacancy::jobsCancelledCount($user_id);
                $offers_pending = JobOffers::offersPendingCount($user_id);
        
                $live_interviews_data = JobEvent::liveInterviewsCount($user_id);
                $live_interviews = count($live_interviews_data);
        
                $candidates_waiting_data = JobOffers::candidatesWaitingCount($user_id);
                $candidates_waiting = count($candidates_waiting_data);
        
                $candidates_left_data = OfferLeavingReason::candidatesLeftCount($user_id);
                $candidates_left = count($candidates_left_data);

                return view('admin.print_report.index')->with('live_vacancies',$live_vacancies)->with('jobs_filled',$jobs_filled)
                                                       ->with('jobs_on_hold',$jobs_on_hold)->with('jobs_cancelled',$jobs_cancelled)
                                                       ->with('offers_pending',$offers_pending)->with('live_interviews',$live_interviews)
                                                       ->with('candidates_waiting',$candidates_waiting)->with('candidates_left',$candidates_left);
            }
        }
        return redirect()->route('home.index');

        
    }

}
