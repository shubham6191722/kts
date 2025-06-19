<?php

namespace App\Http\Controllers\admin;

use Config;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\OutlookCalendarController;

use App\Models\JobEvent;
use App\Models\JobActivity;
use App\Models\JobVacancy;
use App\Models\JobOffers;
use App\Models\User;
use App\Models\RecruiterCandidate;
use App\Models\OfferAccept;
use App\Models\OfferLeavingReason;
use App\Models\OutlookEvent;
use App\Models\Token;


use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;


class EventController extends Controller {

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

            $user_id = Auth::user()->id;

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);
            $events_data = [];

            $outlook_calender_check = false;

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                // Get user's timezone
                $last_year = date("Y",strtotime("-1 year"));
                $start_year = date("Y",strtotime("+1 year"));

                // $timezone = TimeZones::getTzFromWindows($viewData['userTimeZone']);
                $startDateTime = $last_year.'-1-1';
                $endDateTime = $start_year.'-1-1';


                $viewData['dateRange'] = $startDateTime.' - '.$endDateTime;

                $startDate = $startDateTime;
                $endDate = $endDateTime;

                $queryParams = array(
                    'startDateTime' => $startDate,
                    'endDateTime' => $endDate,
                    '$orderby' => 'start/dateTime',
                    '$top' => 1000000000
                );

                // Append query parameters to the '/me/calendarView' url
                $getEventsUrl = '/me/calendar/calendarView?'.http_build_query($queryParams);

                // Add the user's timezone to the Prefer header
                $events = $graph->createRequest('GET', $getEventsUrl)->addHeaders(array('Prefer' => 'outlook.timezone="'.$viewData['userTimeZone'].'"'))->setReturnType(Model\Event::class)->execute();

                $events_arr = [];

                foreach($events as $e_value){
                    $json_encode = json_encode($e_value);
                    $json_decode = json_decode($json_encode);
                    $events_arr['title'] = $json_decode->subject;
                    $events_arr['startdate'] = $json_decode->start->dateTime;
                    $events_arr['enddate'] = $json_decode->end->dateTime;
                    array_push($events_data,$events_arr);
                }
                $outlook_calender_check = true;
            }
        }

        if(Auth::check()){
            $id = Auth::user()->id;
            if(Auth::user()->role == 1){
                $event = JobEvent::getAll();
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $event = JobEvent::eventClientGet($id);
            }elseif(Auth::user()->role == 3){
                $event_job = JobEvent::eventStaffGet($id);
                $event_select = JobEvent::eventOnlyStaffGet($id);
                $event = $event_job->concat($event_select)->shuffle();
            }elseif(Auth::user()->role == 4){
                $event = JobEvent::eventRecruiterGet($id);
            }else{
                $event = JobEvent::eventCandidateGet($id);
            }
            $event_data = @json_encode($event, true);
            $outlook_event_data = @json_encode($events_data, true);
            return view('admin.event.index')->with('event_data',$event_data)->with('event',$event)->with('outlook_event_data',$outlook_event_data)->with('outlook_calender_check',$outlook_calender_check);
        }else{
            return redirect()->route('home.index');
        }


    }

    public function pendingEventGet(Request $request){
        $q_job_vacancy = $q_managed_by = null;
        $q_user_id = 'all';
        $client = null;
        $search = null;

        if(!empty($request->all())){
            $q_user_id = $request->user_select;;
            $q_job_vacancy = $request->user_vacancy;
            $q_managed_by = $request->managed_by;
            $search = 1;
        }

        if(Auth::check()){
            $id = Auth::user()->id;
            if(Auth::user()->role == 1){
                $client = User::clientList();
                $vacancy_data = JobVacancy::getVacancyTitle($q_user_id);
                if(isset($search) && !empty($search)){
                    $event = JobEvent::pendingGetAllSearch($q_user_id,$q_job_vacancy);
                }else{
                    $event = JobEvent::pendingGetAll();
                }
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $vacancy_data = JobVacancy::getVacancyTitle($id);
                if(isset($search) && !empty($search)){
                    $event = JobEvent::pendingEventClientGetSearch($id,$q_job_vacancy);
                }else{
                    $event = JobEvent::pendingEventClientGet($id);
                }
            }elseif(Auth::user()->role == 3){
                if(isset($search) && !empty($search)){
                    $event_job = JobEvent::pendingEventStaffGetSearch($id,$q_job_vacancy);
                    $event_select = JobEvent::pendingEventOnlyStaffGet($id,$q_job_vacancy);
                    $event = $event_job->concat($event_select)->shuffle();
                }else{
                    $event_job = JobEvent::pendingEventStaffGet($id);
                    $event_select = JobEvent::pendingEventOnlyStaffGet($id);
                    $event = $event_job->concat($event_select)->shuffle();
                }
                $vacancy_data = JobVacancy::getVacancyTitle($id);
            }elseif(Auth::user()->role == 4){
                $event = JobEvent::pendingEventRecruiterGet($id);
            }else{
                $event = JobEvent::pendingEventCandidateGet($id);
            }

            return view('admin.pending_event.pending_event')->with('event',$event)->with('vacancy_data',$vacancy_data)->with('client',$client);

        }else{

            return redirect()->route('home.index');

        }


    }

    // public function confirmInterview(){

    //     if(Auth::check()){
    //         $id = Auth::user()->id;
    //         if(Auth::user()->role == 1){
    //             $event = JobEvent::confirmGetAll();
    //         }elseif(Auth::user()->role == 2){
    //             if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
    //                 $id = Auth::user()->created_user_id;
    //             }else{
    //                 $id = Auth::user()->id;
    //             }
    //             $event = JobEvent::confirmEventClientGet($id);
    //         }elseif(Auth::user()->role == 3){
    //             $event_job = JobEvent::confirmEventStaffGet($id);
    //             $event_select = JobEvent::confirmEventOnlyStaffGet($id);
    //             $event = $event_job->concat($event_select)->shuffle();
    //         }elseif(Auth::user()->role == 4){
    //             $event = JobEvent::pendingEventRecruiterGet($id);
    //         }else{
    //             $event = JobEvent::pendingEventCandidateGet($id);
    //         }
    //         return view('admin.pending_event.confirm_event')->with('event',$event);
    //     }else{
    //         return redirect()->route('home.index');
    //     }


    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addEvent(Request $request) {

        $event_time_slot = array();
        $event_date_slot = array();
        $event_time_data = null;
        $event_date_data = null;
        if(isset($request->event_time_slot) && !empty($request->event_time_slot)){

            $time_slot = @json_decode($request->event_time_slot, true);

            foreach($time_slot as $key => $value_time){
                $date = $start_time = $end_time = $full_time = null;

                $date = $value_time['v_date'];
                $start_time = $value_time['v_start_time'];
                $end_time = $value_time['v_end_time'];
                $full_time = $value_time['value'];

                $event_time_slot_arr = [
                    'date' => $date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'full_time' => $full_time,
                ];
                $event_time_slot[$date][] = $event_time_slot_arr;
                $event_date_slot[] = $date;
            }

            $event_time_data = @json_encode($event_time_slot, true);

            $event_date_slot_data = array_unique($event_date_slot);
            $event_date_data = @json_encode($event_date_slot_data, true);
        }

        $event_staff_select = null;
        if(isset($request->event_staff_select) && !empty($request->event_staff_select)){
            $event_staff_select = implode(',', $request->event_staff_select);
        }

        $interview_type = $request->interview_type;

        $video_link = null;
        if(isset($request->video_link) && !empty($request->video_link)){
            $video_link = $request->video_link;
        }

        $address_select = null;
        if(isset($request->address_select) && !empty($request->address_select)){
            $address_select = $request->address_select;
        }

        $random_string = CustomFunction::random_string(5);
        $slug = CustomFunction::base_encode_string($random_string);

        $event_title = '';
        if((isset($request->event_type) && !empty($request->event_type)) && (isset($request->user_id) && !empty($request->user_id))){
            $event_title_text = $request->event_type;
            $user_id_get = $request->user_id;

            if(isset($request->job_reference) && !empty($request->job_reference)){
                $userName = RecruiterCandidate::recruiterCandidateName($user_id_get);
                if(isset($userName) && !empty($userName)){
                    $event_title = $event_title_text.' - '.$userName;
                }
            }else{
                $userName = User::getUserName($user_id_get);
                if(isset($userName) && !empty($userName)){
                    $event_title = $event_title_text.' - '.$userName;
                }
            }

        }

        $event_type = $request->event_type;
        $event_description = $request->event_description;
        $event_date = $request->event_date;
        $applied_id = $request->applied_id;

        $vacancy_id = $request->vacancy_id;
        $client_id = $request->client_id;
        $user_id = $request->user_id;
        $job_reference = $request->job_reference;
        $r_c_id = $request->r_c_id;
        $created_user_id = Auth::user()->id;


        $startdate = date('Y-m-d', strtotime($event_date));
        $date = Carbon::createFromFormat('Y-m-d', $startdate)->format('Y-m-d');

        $job_event = new JobEvent;
        $job_event->applied_id = $applied_id;
        $job_event->event_title = $event_title;
        $job_event->event_staff_select = $event_staff_select;
        $job_event->event_type = $event_type;
        $job_event->event_description = $event_description;
        $job_event->event_date = $date;
        $job_event->client_id = $client_id;
        $job_event->vacancy_id = $vacancy_id;
        $job_event->created_user_id = $created_user_id;
        $job_event->interview_type = $interview_type;
        $job_event->video_link = $video_link;
        $job_event->address_select = $address_select;
        $job_event->event_slug = $slug;
        $job_event->random_string = $random_string;
        if($request->event_check_time_slot == 2){
            $job_event->event_status = 0;
        }else{
            $job_event->event_status = 1;
            $job_event->confirm_date = $date;
            $job_event->event_time = CustomFunction::get_time_forment_24($request->event_time);;
        }

        $job_event->time_slot = $event_time_data;
        $job_event->date_slot = $event_date_data;
        $job_event->check_time_slot = $request->event_check_time_slot;

        if(isset($request->job_reference) && !empty($request->job_reference)){
            $job_event->job_reference = $job_reference;
            $job_event->r_c_id = $user_id;
            $job_event->user_id = $r_c_id;
        }else{
            $job_event->user_id = $user_id;
            $job_event->job_reference = "0";
        }

        if ($job_event->save()) {

            NotificationsController::notificationNewEvent($job_event);

            $text = $event_type." Interview Created.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $job_event->user_id;
            $JobActivity->client_id = $job_event->client_id;
            $JobActivity->job_id = $job_event->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $job_event->applied_id;
            $JobActivity->r_c_id = $job_event->r_c_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            if($job_event->check_time_slot == 1){
                $data = $job_event;
                $event_staff_select = $job_event->event_staff_select;
                $user_data = [];
                if(isset($event_staff_select) && !empty($event_staff_select)){
                    $user_data = explode(',', $event_staff_select);
                }

                $outlookuser_id = null;
                for ($i = 0; $i < count($user_data); $i++) {
                    $get_user_data = Token::getUserData($user_data[$i]);

                    if(isset($get_user_data) && !empty($get_user_data)){
                        $outlookuser_id = $user_data[$i];
                        unset($user_data[$i]);
                        break;
                    }
                }

                $user_id = array();
                $user_id[] = $outlookuser_id;
                $candidate_id = $data->user_id;

                if(isset($user_id[0]) && !empty($user_id[0])){
                    OutlookCalendarController::updateEventNormal($data,$user_id,$candidate_id,$user_data);
                    OutlookCalendarController::createEventNormal($data,$user_data);
                }
            }

            $msg = 'Interview successfully created.';
            return response()->json(['msg' => $msg,'code' => 1]);
        } else {
            return response()->json(['code' => 0]);
        }


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editEvent(Request $request) {

        $event_staff_select = null;
        if(isset($request->event_staff_select) && !empty($request->event_staff_select)){
            $event_staff_select = implode(',', $request->event_staff_select);
        }

        $interview_type = $request->interview_type;

        $video_link = null;
        if(isset($request->video_link) && !empty($request->video_link)){
            $video_link = $request->video_link;
        }

        $address_select = null;
        if(isset($request->address_select) && !empty($request->address_select)){
            $address_select = $request->address_select;
        }

        $random_string = CustomFunction::random_string(5);
        $slug = CustomFunction::base_encode_string($random_string);


        $event_title = '';
        if((isset($request->event_type) && !empty($request->event_type)) && (isset($request->user_id) && !empty($request->user_id))){
            $event_title_text = $request->event_type;
            $user_id_get = $request->user_id;

            if(isset($request->job_reference) && !empty($request->job_reference)){
                $user_id_get = $request->r_c_id;
                $userName = RecruiterCandidate::recruiterCandidateName($user_id_get);
                if(isset($userName) && !empty($userName)){
                    $event_title = $event_title_text.' - '.$userName;
                }
            }else{
                $userName = User::getUserName($user_id_get);
                if(isset($userName) && !empty($userName)){
                    $event_title = $event_title_text.' - '.$userName;
                }
            }

        }

        $event_type = $request->event_type;
        $event_description = $request->event_description;
        $event_date = $request->event_date;
        $applied_id = $request->applied_id;
        $id = $request->id;

        $startdate = date('Y-m-d', strtotime($event_date));
        $date = Carbon::createFromFormat('Y-m-d', $startdate)->format('Y-m-d');
        $event_time = CustomFunction::get_time_forment_24($request->event_time);

        $created_user_id = Auth::user()->id;

        $check_event_data = JobEvent::where('id','=',$id)->first();
        $check_event_type = $check_event_data->event_type;
        $check_event_date = $check_event_data->event_date;
        $check_event_time = $check_event_data->event_time;

        $job_event = JobEvent::find($id);
        $job_event->applied_id = $applied_id;
        $job_event->event_title = $event_title;
        // $job_event->event_staff_select = $event_staff_select;
        $job_event->event_type = $event_type;
        $job_event->event_description = $event_description;
        // $job_event->event_date = $date;
        $job_event->interview_type = $interview_type;
        $job_event->video_link = $video_link;
        $job_event->address_select = $address_select;
        $job_event->created_user_id = $created_user_id;
        $job_event->event_slug = $slug;
        $job_event->random_string = $random_string;
        $check_time_slot = $job_event->check_time_slot;
        if($check_event_type != $event_type){
            if($check_time_slot == 1){
                $job_event->event_status = 1;
                $job_event->confirm_date = $date;
                $job_event->event_date = $date;
                $job_event->event_time = $event_time;
            }
        }
        if($check_event_date != $date){
            if($check_time_slot == 1){
                $job_event->event_status = 1;
                $job_event->event_date = $date;
                $job_event->confirm_date = $date;
                $job_event->event_time = $event_time;
            }
        }
        if($check_event_time != $event_time){
            if($check_time_slot == 1){
                $job_event->event_status = 1;
                $job_event->event_date = $date;
                $job_event->confirm_date = $date;
                $job_event->event_time = $event_time;
            }
        }

        if ($job_event->save()) {

            if($check_event_type != $event_type){
                if($check_time_slot == 1){
                    $outlook_event = OutlookEvent::where('event_id','=',$job_event->id)->where('deleted_at','=',null)->get();

                    if(isset($outlook_event) && !empty($outlook_event)){
                        foreach($outlook_event as $e_data){
                            $outlook_event_id = $e_data->outlook_event_id;
                            $e_id = $e_data->id;
                            $user_id = $e_data->user_id;
                            OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_id);
                        }
                    }
                }
            }

            if($check_event_date != $date){
                if($check_time_slot == 1){
                    $outlook_event = OutlookEvent::where('event_id','=',$job_event->id)->where('deleted_at','=',null)->get();

                    if(isset($outlook_event) && !empty($outlook_event)){
                        foreach($outlook_event as $e_data){
                            $outlook_event_id = $e_data->outlook_event_id;
                            $e_id = $e_data->id;
                            $user_id = $e_data->user_id;
                            OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_id);
                        }
                    }
                }
            }
            if($check_event_time != $event_time){
                if($check_time_slot == 1){
                    $outlook_event = OutlookEvent::where('event_id','=',$job_event->id)->where('deleted_at','=',null)->get();

                    if(isset($outlook_event) && !empty($outlook_event)){
                        foreach($outlook_event as $e_data){
                            $outlook_event_id = $e_data->outlook_event_id;
                            $e_id = $e_data->id;
                            $user_id = $e_data->user_id;
                            OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_id);
                        }
                    }
                }
            }

            NotificationsController::notificationUpdateEvent($job_event,$created_user_id);

            if(($check_event_time != $event_time) || ($check_event_date != $date) || ($check_event_type != $event_type)){
                if($job_event->check_time_slot == 1){
                    $data = $job_event;
                    $event_staff_select = $job_event->event_staff_select;
                    $user_data = [];
                    if(isset($event_staff_select) && !empty($event_staff_select)){
                        $user_data = explode(',', $event_staff_select);
                    }

                    $outlookuser_id = null;
                    for ($i = 0; $i < count($user_data); $i++) {
                        $get_user_data = Token::getUserData($user_data[$i]);

                        if(isset($get_user_data) && !empty($get_user_data)){
                            $outlookuser_id = $user_data[$i];
                            unset($user_data[$i]);
                            break;
                        }
                    }

                    $user_id = array();
                    $user_id[] = $outlookuser_id;
                    $candidate_id = $data->user_id;

                    if(isset($user_id[0]) && !empty($user_id[0])){
                        OutlookCalendarController::updateEventNormal($data,$user_id,$candidate_id,$user_data);
                        OutlookCalendarController::createEventNormal($data,$user_data);
                    }
                }
            }

            $text = $event_type." Interview Updated.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $job_event->user_id;
            $JobActivity->client_id = $job_event->client_id;
            $JobActivity->job_id = $job_event->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $job_event->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return back()->with('success', 'Interview successfully updated.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteEvent(Request $request) {

        $id = $request->id;
        $outlook_event = OutlookEvent::where('event_id','=',$id)->where('deleted_at','=',null)->get();

        foreach($outlook_event as $e_data){
            $outlook_event_id = $e_data->outlook_event_id;
            $e_id = $e_data->id;
            $user_id = $e_data->user_id;
            OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_id);
        }

        $job_event = JobEvent::find($id);
        $job_event->deleted_at = date('Y-m-d H:i:s');


        if ($job_event->save()) {

            $text = "Interview Deleted.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $job_event->user_id;
            $JobActivity->client_id = $job_event->client_id;
            $JobActivity->job_id = $job_event->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $job_event->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            $event_data = null;
            $event = JobEvent::getAll($id);
            $event_data = @json_encode($event, true);
            return response()->json(['event_data' => $event_data,'code' => 1]);

        } else {
            return response()->json(['code' => 0]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function offerList(Request $request) {

        $declined_reason = Config::get('dropdown.declined_reason');

        if(Auth::check()){
            $id = Auth::user()->id;
            if(Auth::user()->role == 1){
                $offer = JobOffers::getAll();
                return view('admin.offer.index')->with('offer',$offer)->with('declined_reason',$declined_reason);
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $offer = JobOffers::offerClientGet($id);
                return view('admin.offer.index')->with('offer',$offer)->with('declined_reason',$declined_reason);
            }elseif(Auth::user()->role == 3){
                $offer = JobOffers::offerStaffGet($id);
                return view('admin.offer.index')->with('offer',$offer)->with('declined_reason',$declined_reason);
            }elseif(Auth::user()->role == 4){
                $offer_data_panding = JobOffers::offerRecruiterCandidatePanding($id);
                $offer_data_accepted = JobOffers::offerRecruiterCandidateAccepted($id);
                $offer_data_declined = JobOffers::offerRecruiterCandidateDeclined($id);

                $offer_data_panding_count  = JobOffers::offerRecruiterCandidatePanding($id)->count();
                $offer_data_accepted_count = JobOffers::offerRecruiterCandidateAccepted($id)->count();
                $offer_data_declined_count = JobOffers::offerRecruiterCandidateDeclined($id)->count();
                return view('admin.offer.recruiter_offer.index')->with('offer_data_panding',$offer_data_panding)->with('offer_data_panding_count',$offer_data_panding_count)
                                                                ->with('offer_data_accepted',$offer_data_accepted)->with('offer_data_accepted_count',$offer_data_accepted_count)
                                                                ->with('offer_data_declined',$offer_data_declined)->with('offer_data_declined_count',$offer_data_declined_count);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function offerCreate(Request $request) {

        $data = $request->all();
        $modal_name = $request->modal_name;
        $startdate = date('Y-m-d', strtotime($data['suggested_date']));
        $date = Carbon::createFromFormat('Y-m-d', $startdate)->format('Y-m-d');

        $offer_letter = $offer_letter_old = null;
        if($data['offer_letter_file'] == 'undefined'){
            $offer_letter = null;
        }
        if ($request->hasFile('offer_letter_file')) {
            $file = $request->file('offer_letter_file');
            if(isset($data['offer_letter']) && !empty($data['offer_letter'])){
                $offer_letter_old = $data['offer_letter'];
            }
            $fileName = CustomFunction::offerFleUpload($file, $offer_letter_old, '/offer_letter',$data['user_id'],$data['vacancy_id']);
            $offer_letter = $fileName;
        }else{
            if(isset($data['offer_letter']) && !empty($data['offer_letter'])){
                $offer_letter = $data['offer_letter'];
            }else{
                $offer_letter = null;
            }
        }

        if(isset($data['offer_id']) && !empty($data['offer_id'])){
            if($data['offer_id'] == 'undefined'){
                $offer_data = new JobOffers;
            }else{
                $offer_data = JobOffers::find($data['offer_id']);
            }
        }else{
            $offer_data = new JobOffers;
        }

        $offer_data->applied_id =  $data['applied_id'];
        $offer_data->vacancy_id =  $data['vacancy_id'];
        $offer_data->client_id =  $data['client_id'];
        $offer_data->candidate_id =  $data['user_id'];
        $offer_data->offered_salary =  $data['offered_salary'];
        $offer_data->suggested_date =  $date;
        $offer_data->description =  $data['description'];
        $offer_data->job_reference =  $data['job_reference'];
        $offer_data->r_c_id =  $data['offer_r_c_id'];
        $offer_data->offer_letter =  $offer_letter;
        $offer_data->created_id =  Auth::user()->id;

        if ($offer_data->save()) {

            if(isset($data['offer_id']) && !empty($data['offer_id'])){
                $text = "Offer Updated.";
            }else{
                $text = "Offer Created.";
            }

            NotificationsController::notificationNewOffer($offer_data);

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();
            return response()->json(['msg' => $text,'modal_name'=> $modal_name ,'code' => 1]);

        } else {
            return response()->json(['code' => 0]);
        }
    }

    public function offerEdit(Request $request) {

        $data = $request->all();
        $startdate = date('Y-m-d', strtotime($request->offer_suggested_date));
        $date = Carbon::createFromFormat('Y-m-d', $startdate)->format('Y-m-d');

        $offer_letter = $offer_letter_old = null;
        if ($request->hasFile('offer_letter_file')) {
            $file = $request->file('offer_letter_file');
            if(isset($request->offer_letter) && !empty($request->offer_letter)){
                $offer_letter_old = $request->offer_letter;
            }
            $fileName = CustomFunction::offerFleUpload($file, $offer_letter_old, '/offer_letter',$request->user_id,$request->vacancy_id);
            $request->merge(['offer_letter_file' => $fileName]);
            $offer_letter = $fileName;
        }else{
            if(isset($request->offer_letter) && !empty($request->offer_letter)){
                $offer_letter = $request->offer_letter;
            }else{
                $offer_letter = null;
            }
        }

        $offer_data = JobOffers::find($request->id);

        $offer_data->applied_id =  $request->applied_id;
        $offer_data->vacancy_id =  $request->vacancy_id;
        $offer_data->client_id =  $request->client_id;
        $offer_data->candidate_id =  $request->user_id;
        $offer_data->offered_salary =  $request->offer_offered_salary;
        $offer_data->suggested_date =  $date;
        $offer_data->description =  $request->offer_description;
        $offer_data->offer_letter =  $offer_letter;
        $offer_data->created_id =  Auth::user()->id;

        if ($offer_data->save()) {

            $text = "Offer Updated.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return back()->with('success', $text);

        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function offerDelete(Request $request) {


        $id = $request->id;


        $job_event = JobOffers::find($id);
        $job_event->deleted_at = date('Y-m-d H:i:s');


        if ($job_event->save()) {

            $text = "Offer Deleted.";

            return back()->with('success', $text);

        } else {
            return back()->with('error', 'Please try again!');
        }
    }



    public function offerAccept(Request $request) {

        $value = $request->value;
        $offer_id = $request->offer_id;
        $user_id = $request->user_id;
        $r_c_id = $request->r_c_id;


        $offer_data = JobOffers::offerRecruiterCandidateGet($offer_id,$user_id,$r_c_id);
        $offer_data->offer_status = $value;
        $offer_data->declined_reason = null;

        if ($offer_data->save()) {
            $offer_accept = new OfferAccept;
            $offer_accept->offer_id = $offer_data->id;
            $offer_accept->applied_id = $offer_data->applied_id;
            $offer_accept->vacancy_id = $offer_data->vacancy_id;
            $offer_accept->client_id = $offer_data->client_id;
            $offer_accept->candidate_id = $offer_data->candidate_id;
            $offer_accept->job_reference = $offer_data->job_reference;
            $offer_accept->r_c_id = $offer_data->r_c_id;
            $offer_accept->save();

            $job_vacancy = JobVacancy::find($offer_data->vacancy_id);
            $job_vacancy->jobvacancystatus = 3;
            $job_vacancy->jobvacancystage = 5;
            $job_vacancy->save();

            NotificationsController::notificationNewOfferAccepted($offer_data);

            $text = "Offer accepted";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return response()->json(['msg'=> $text,'code' => 1]);
        } else {
            return response()->json(['code' => 0]);
        }
    }

    public function offerDeclin(Request $request) {

        $value = $request->value;
        $offer_id = $request->offer_id;
        $user_id = $request->user_id;
        $declined_reason = $request->declined_reason;
        $r_c_id = $request->r_c_id;

        $offer_data = JobOffers::offerRecruiterCandidateGet($offer_id,$user_id,$r_c_id);

        $offer_data->offer_status = $value;
        $offer_data->declined_reason = $declined_reason;
        $offer_data->r_c_id = $r_c_id;

        if ($offer_data->save()) {

            NotificationsController::notificationNewOfferDeclined($offer_data);

            $text = "Offer Decline.";

            $JobActivity = new JobActivity;

            $JobActivity->select_id = $offer_data->candidate_id;
            $JobActivity->client_id = $offer_data->client_id;
            $JobActivity->job_id = $offer_data->vacancy_id;
            $JobActivity->user_id = Auth::user()->id;
            $JobActivity->applied_id = $offer_data->applied_id;
            $JobActivity->text = $text;
            $JobActivity->save();

            return back()->with("success", "Your Offer Decline.");
        } else {
            return back()->with("error", "Please try again!");
        }
    }

    public function offerConfirmedLeavingReason(Request $request) {

        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'applied_id' => 'required',
            'vacancy_id' => 'required',
            'client_id' => 'required',
            'candidate_id' => 'required',
            'confirmed_start_date' => 'required',
            'confirmed_leave_date' => 'required',
            'reason_for_leaving' => 'required',
                ], [
            'offer_id.required' => 'Please try again!',
            'applied_id.required' => 'Please try again!',
            'vacancy_id.required' => 'Please try again!',
            'client_id.required' => 'Please try again!',
            'candidate_id.required' => 'Please try again!',
            'confirmed_start_date.required' => 'Please select Confirmed Start Date!',
            'confirmed_leave_date.required' => 'Please select Confirmed Leave Date!',
            'reason_for_leaving.required' => 'Please select Reason For Leaving!',
        ]);

        $modal_name = 'edit_offer_newdata_'.$request->offer_id;

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_modal', 'On')->with('modal_id', $request->offer_id)->with('modal_name', $modal_name)->with('error_msg', $validator->errors()->first());
        }

        $offer_id = $request->offer_id;
        $applied_id = $request->applied_id;
        $vacancy_id = $request->vacancy_id;
        $client_id = $request->client_id;
        $candidate_id = $request->candidate_id;
        $job_reference = $request->job_reference;
        $r_c_id = $request->r_c_id;

        $confirmed_start_date = $request->confirmed_start_date;
        $confirmed_leave_date = $request->confirmed_leave_date;
        $reason_for_leaving = $request->reason_for_leaving;

        $c_s_d = date('Y-m-d', strtotime($confirmed_start_date));
        $c_s_date = Carbon::createFromFormat('Y-m-d', $c_s_d)->format('Y-m-d');

        $c_l_d = date('Y-m-d', strtotime($confirmed_leave_date));
        $c_l_date = Carbon::createFromFormat('Y-m-d', $c_l_d)->format('Y-m-d');

        $diff_in_days = CustomFunction::week_between_two_dates($c_s_date,$c_l_date);

        $offer_leaving_reason_data = OfferLeavingReason::findData($offer_id,$applied_id,$vacancy_id,$client_id,$candidate_id,$job_reference,$r_c_id);

        if(isset($offer_leaving_reason_data) && !empty($offer_leaving_reason_data)){
            $offer_leaving_reason_save = OfferLeavingReason::find($offer_leaving_reason_data->id);
            $message_save = "Data updated successfully.";
        }else{
            $offer_leaving_reason_save = new OfferLeavingReason;
            $message_save = "Data added successfully.";
        }

        $offer_leaving_reason_save->offer_id = $offer_id;
        $offer_leaving_reason_save->applied_id = $applied_id;
        $offer_leaving_reason_save->vacancy_id = $vacancy_id;
        $offer_leaving_reason_save->client_id = $client_id;
        $offer_leaving_reason_save->candidate_id = $candidate_id;
        $offer_leaving_reason_save->job_reference = $job_reference;
        $offer_leaving_reason_save->r_c_id = $r_c_id;
        $offer_leaving_reason_save->confirmed_start_date = $c_s_date;
        $offer_leaving_reason_save->confirmed_leave_date = $c_l_date;
        $offer_leaving_reason_save->reason_for_leaving = $reason_for_leaving;
        $offer_leaving_reason_save->week_count = $diff_in_days;
        $offer_leaving_reason_save->save();

        if ($offer_leaving_reason_save->save()) {
            return back()->with("success", $message_save);
        } else {
            return back()->withInput()->with('open_modal', 'On')->with('modal_id', $request->offer_id)->with('modal_name', $modal_name)->with('error_msg', 'Please try again!')->with("error", "Please try again!");
        }
    }

    public function offerStatusChange(Request $request) {
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'applied_id' => 'required',
            'vacancy_id' => 'required',
            'client_id' => 'required',
            'candidate_id' => 'required',
                ], [
            'offer_id.required' => 'Please try again!',
            'applied_id.required' => 'Please try again!',
            'vacancy_id.required' => 'Please try again!',
            'client_id.required' => 'Please try again!',
            'candidate_id.required' => 'Please try again!',
        ]);

        $modal_name = 'edit_offer_res_'.$request->offer_id;

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_modal', 'On')->with('modal_id', $request->offer_id)->with('modal_name', $modal_name)->with('error_msg', $validator->errors()->first());
        }

        $declined_reason = $request->declined_reason;
        $offer_id = $request->offer_id;
        $applied_id = $request->applied_id;
        $vacancy_id = $request->vacancy_id;
        $client_id = $request->client_id;
        $candidate_id = $request->candidate_id;
        $job_reference = $request->job_reference;
        $r_c_id = $request->r_c_id;
        $offer_status = $request->offer_status;

        $offer_leaving_reason_data = OfferAccept::findData($offer_id,$applied_id,$vacancy_id,$client_id,$candidate_id,$job_reference,$r_c_id);

        if(isset($offer_leaving_reason_data) && !empty($offer_leaving_reason_data)){
            $offer_leaving_reason_save = OfferAccept::find($offer_leaving_reason_data->id);
            $message_save = "Data updated successfully.";
        }else{
            $offer_leaving_reason_save = new OfferAccept;
            $message_save = "Data updated successfully.";
        }

        $offer_save = JobOffers::find($offer_id);
        $offer_save->offer_status = $offer_status;
        $offer_save->declined_reason = $declined_reason;
        $offer_save->updated_at = date('Y-m-d H:i:s');
        $offer_save->save();

        $offer_leaving_reason_save->offer_id = $offer_id;
        $offer_leaving_reason_save->applied_id = $applied_id;
        $offer_leaving_reason_save->vacancy_id = $vacancy_id;
        $offer_leaving_reason_save->client_id = $client_id;
        $offer_leaving_reason_save->candidate_id = $candidate_id;
        $offer_leaving_reason_save->job_reference = $job_reference;
        $offer_leaving_reason_save->r_c_id = $r_c_id;
        $offer_leaving_reason_save->offer_status = $offer_status;

        if ($offer_leaving_reason_save->save()) {
            return back()->with("success", $message_save);
        } else {
            return back()->withInput()->with('open_modal', 'On')->with('modal_id', $request->offer_id)->with('modal_name', $modal_name)->with('error_msg', 'Please try again!')->with("error", "Please try again!");
        }
    }



    public function outLookDateTime(Request $request) {

        $date = date('Y-m-d',strtotime($request->date));
        $id = $request->id;
        $gap = $request->time_distance;

        $full_array = CustomFunction::isGetSystemTimeAndDate($date,$id,$gap);
        $full_date_array = $full_array['date'];;

        $full_date_data = $full_array['full_array'];

        $current_date = $full_array['start_date'];
        $end_date = $full_array['end_date'];

        $events_data = [];

        for ($i = 0; $i < count($id); $i++) {
            $user_id = $id[$i];

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                $startDateTime = $current_date;
                $endDateTime = $end_date;

                $viewData['dateRange'] = $startDateTime.' - '.$endDateTime;

                $startDate = $startDateTime.'T00:00:30.919Z';
                $endDate = $endDateTime.'T23:59:30.919Z';


                $queryParams = array(
                    // '$select' => 'subject,organizer,start,end',
                    'startDateTime' => $startDate,
                    'endDateTime' => $endDate,
                    '$orderby' => 'start/dateTime',
                    '$top' => 1000000000
                );

                // Append query parameters to the '/me/calendarView' url
                $getEventsUrl = '/me/calendar/calendarView?'.http_build_query($queryParams);

                // Add the user's timezone to the Prefer header
                $events = $graph->createRequest('GET', $getEventsUrl)->addHeaders(array('Prefer' => 'outlook.timezone="'.$viewData['userTimeZone'].'"'))->setReturnType(Model\Event::class)->execute();

                if(isset($events) && !empty($events)){
                    foreach($events as $e_value){
                        $json_encode = json_encode($e_value);
                        $json_decode = json_decode($json_encode);
                        $events_arr['name'] = $json_decode->organizer->emailAddress->name;
                        $events_arr['title'] = $json_decode->subject;

                        $event_date = date('Y-m-d', strtotime($json_decode->start->dateTime));
                        $events_arr['date'] = $event_date;

                        $startdate = date('H:i', strtotime($json_decode->start->dateTime));
                        $enddate = date('H:i', strtotime($json_decode->end->dateTime));

                        $events_arr['startdate'] = $startdate;
                        $events_arr['enddate'] = $enddate;

                        $events_arr['checkstartdate'] = str_replace(':', '', $startdate);
                        $events_arr['checkenddate'] = str_replace(':', '', $enddate);

                        array_push($events_data,$events_arr);

                    }

                }
            }
        }

        $outlook_date_data = [];

        foreach($events_data as $key => $outlook_value){
            if (array_key_exists($outlook_value['date'],$full_date_data))
            {
                $needle = $full_date_data[$outlook_value['date']];
                $min = $outlook_value['checkstartdate'];
                $max = $outlook_value['checkenddate'];

                foreach($needle as $Nkey => $n_value){

                    if($n_value['check_start_time'] >= $min && $n_value['check_end_time'] <= $max){
                        $outlook_date_data[$outlook_value['date']][$Nkey] = $n_value;
                    }
                    if($n_value['check_end_time'] >= $min && $n_value['check_start_time'] <= $max){
                        $outlook_date_data[$outlook_value['date']][$Nkey] = $n_value;
                    }
                }
            }
        }

        foreach($outlook_date_data as $Okey => $O_value){
            foreach($O_value as $ODkey => $val){
                unset($full_date_data[$Okey][$ODkey]);
            }
        }

        $event_data = @json_encode($full_date_data, true);

        return response()->json(['code' => 1, 'event_data' => $full_date_data, 'date' => $full_date_array]);

    }


}
