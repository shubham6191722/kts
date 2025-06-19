<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OutlookCalendarController;


use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationsController;

use App\Models\JobEvent;
use App\Models\ScheduleTime;
use App\Models\OutlookEvent;
use App\Models\Token;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

use DateInterval;
use DateTime;
use DatePeriod;

class PendingEventController extends Controller
{

    // public function getEventTime(Request $request,$id) {
    //     if(isset($id) && !empty($id)){

    //         $slug = CustomFunction::base_decode_string($id);
            
    //         $event_data = JobEvent::getPendingEvent($slug);

    //         if(isset($event_data) && !empty($event_data)){

    //             $schedule_type = null;
    //             if($event_data->event_status == 1){
    //                 $schedule_type = 're-schedule';
    //             }
    //             $event_staff_select = $event_data->event_staff_select;
    //             $event_staff = [];
    //             if(isset($event_staff_select) && !empty($event_staff_select)){
    //                 $event_staff = explode(',', $event_staff_select);
    //             }else{
    //                 $event_staff[] = $event_data->client_id;
    //             }

    //             $user_event_time = [];
    //             $user_event = [];
    //             foreach($event_staff as $ekey => $event_value){
    //                 $check_data = ScheduleTime::findUserData($event_value);
    //                 if(isset($check_data->schedule_time) && !empty($check_data->schedule_time)){
    //                     $schedule_time = @json_decode($check_data->schedule_time,TRUE);
    //                     $schedule_count = count($schedule_time);
    //                     for($s = 0; $s < $schedule_count; $s++){
    //                         if(in_array($schedule_time[$s], $user_event)){
        
    //                         }else{
    //                             array_push($user_event,$schedule_time[$s]);        
    //                         }
    //                     }
    //                     array_push($user_event_time,$schedule_time);
    //                 }
                    
    //             }
        
    //             foreach($user_event_time as $ukey => $u_e_value){
    //                 $user_event = array_intersect($user_event,$u_e_value);
    //             }
        
    //             $result = $user_event;
        
    //             $current_date = date('Y-m-d',strtotime($event_data->event_date));
    //             $end_date = date("Y-m-d", strtotime("+14 day", strtotime($current_date)));
        
    //             $interval = new DateInterval('P1D');
                        
    //             $realEnd = new DateTime($end_date);
    //             $realEnd->add($interval);
            
    //             $period = new DatePeriod(new DateTime($current_date), $interval, $realEnd);
            
    //             // Use loop to store date into array
    //             $array = [];
    //             $format = 'Y-m-d';
    //             foreach($period as $date) {
    //                 $array[$date->format($format)] = $result;
    //             }
        
    //             $events_data = [];
    //             $events_arr = [];
        
    //             for ($i = 0; $i < count($event_staff); $i++) {
    //                 $user_id = $event_staff[$i];
                    
    //                 $viewData = OutlookCalendarController::loadViewData($user_id);
    //                 $graph = OutlookCalendarController::getGraph($user_id);
                    
    //                 if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){
        
    //                     $startDateTime = $current_date;
    //                     $endDateTime = $end_date;
                        
    //                     $viewData['dateRange'] = $startDateTime.' - '.$endDateTime;
        
    //                     $startDate = $startDateTime.'T00:00:30.919Z';
    //                     $endDate = $endDateTime.'T23:59:30.919Z';
                        
        
    //                     $queryParams = array(
    //                         // '$select' => 'subject,organizer,start,end',
    //                         'startDateTime' => $startDate,
    //                         'endDateTime' => $endDate,
    //                         '$orderby' => 'start/dateTime',
    //                         '$top' => 1000000000
    //                     );
        
    //                     // Append query parameters to the '/me/calendarView' url
    //                     $getEventsUrl = '/me/calendar/calendarView?'.http_build_query($queryParams);
                        
    //                     // Add the user's timezone to the Prefer header
    //                     $events = $graph->createRequest('GET', $getEventsUrl)->addHeaders(array('Prefer' => 'outlook.timezone="'.$viewData['userTimeZone'].'"'))->setReturnType(Model\Event::class)->execute();
                        
    //                     if(isset($events) && !empty($events)){
    //                         foreach($events as $e_value){
    //                             $json_encode = json_encode($e_value);
    //                             $json_decode = json_decode($json_encode);
    //                             $events_arr['name'] = $json_decode->organizer->emailAddress->name;
    //                             $events_arr['title'] = $json_decode->subject;
        
    //                             $event_date = date('Y-m-d', strtotime($json_decode->start->dateTime));
    //                             $events_arr['date'] = $event_date;
                                
    //                             $start_time = floor(date('H.i', strtotime($json_decode->start->dateTime)));
    //                             $start_time_int = (string)$start_time;
    //                             if($start_time_int < 10){
    //                                 $start_time_int = '0'.$start_time_int;
    //                             }
    //                             $start_time_full = $start_time_int.':00';
    //                             $events_arr['startdate'] = $start_time_full;
        
    //                             $end_time = ceil(date('H.i', strtotime($json_decode->end->dateTime)));
    //                             $end_time_int = (string)$end_time;
    //                             if($end_time_int < 10){
    //                                 $end_time_int = '0'.$end_time_int;
    //                             }
    //                             $end_time_full = $end_time_int.':00';
    //                             $events_arr['enddate'] = $end_time_full;
                                
    //                             array_push($events_data,$events_arr);
        
    //                         }
        
    //                     }
    //                 }
        
    //             }
        
    //             foreach($events_data as $key => $outlook_value){
        
    //                 $needle = $array[$outlook_value['date']];
    //                 $min = $outlook_value['startdate'];
    //                 $max = $outlook_value['enddate'];
                   
    //                 $result  = array_filter($needle, function($v) use($min, $max) {
    //                     return $v >= $min && $v < $max;
    //                 });
        
    //                 foreach($result as $unkey => $outlook_key){
    //                     unset($array[$outlook_value['date']][$unkey]);
    //                 }
                    
    //             }
        
    //             $date_array = $array;
                
    //             $date_disabled = [];
    //             foreach($date_array as $dKey => $d_value){
    //                 if(isset($d_value) && !empty($d_value)){
                        
    //                 }else{
    //                     array_push($date_disabled,$dKey);
    //                 }
                    
    //             }

    //             $today = date('Y-m-d');

    //             if ($today < $current_date){
    //                 $current_date = $current_date;
    //             }else{
    //                 $current_date = $today;
    //             }

    //             $date_disabled_value = @json_encode($date_disabled,TRUE);
    //             $time_value = @json_encode($array,TRUE);

    //             return view('frontend.after_login.dashboard.schedule_event_time')->with("date_disabled_value",$date_disabled_value)->with("time_value",$time_value)
    //                                                                              ->with("current_date",$current_date)->with("end_date",$end_date)
    //                                                                              ->with("event_data",$event_data)->with("schedule_type",$schedule_type);
    //         }else{
    //             $role_name = CustomFunction::role_name();
    //             $route_name = $role_name.'.dashboard';
    //             return redirect()->route($route_name)->with("error", "Please try again!"); 
    //         }
            

    //     }else{
    //         return redirect()->route('home.index');
    //     }
        

    // }

    public function getEventTime(Request $request,$id) {
        if(isset($id) && !empty($id)){

            $slug = CustomFunction::base_decode_string($id);
            
            $event_data = JobEvent::getPendingEvent($slug);

            $today = date('Y-m-d');
            $yesterday = date('Y-m-d',strtotime('-1 day'));
            $strtotime = strtotime('-10 day');
            $formDay = date("Y-m-d",$strtotime);

            $current_date = date('Y-m-d',strtotime($formDay));
            $end_date = date("Y-m-d", strtotime($yesterday));
    
            $interval = new DateInterval('P1D');
                    
            $realEnd = new DateTime($end_date);
            $realEnd->add($interval);
        
            $period = new DatePeriod(new DateTime($current_date), $interval, $realEnd);
        
            // Use loop to store date into array
            $old_date_array = [];
            $format = 'Y-m-d';
            foreach($period as $date) {
                $old_date_array[] = $date->format($format);
            }

            if(isset($event_data) && !empty($event_data)){

                $schedule_type = null;
                if($event_data->event_status == 1){
                    $schedule_type = 're-schedule';
                }
                $event_staff_select = $event_data->event_staff_select;
                $event_staff = [];
                if(isset($event_staff_select) && !empty($event_staff_select)){
                    $event_staff = explode(',', $event_staff_select);
                }else{
                    $event_staff[] = $event_data->client_id;
                }
                
                $get_date_slot = @json_decode($event_data->date_slot, true);
                $date_slot = [];
                foreach($get_date_slot as $DateKey => $date_value){
                    if (in_array($date_value,$old_date_array))
                    {
                    }else{
                        $date_slot[] = $date_value;
                    }
                }

                $get_time_slot = @json_decode($event_data->time_slot, true);
                $time_slot = [];
                foreach($get_time_slot as $DateTimeKey => $time_value){
                    if (in_array($DateTimeKey,$old_date_array))
                    {
                    }else{
                        $time_slot[$DateTimeKey] = $time_value;
                    }
                }

                $firstKey = array_key_first($date_slot);
                $endKey = array_key_last($date_slot);


                $current_date = date('Y-m-d',strtotime($date_slot[$firstKey]));
                $end_date = date("Y-m-d", strtotime($date_slot[$endKey]));

                $interval = new DateInterval('P1D');
                        
                $realEnd = new DateTime($end_date);
                $realEnd->add($interval);
            
                $period = new DatePeriod(new DateTime($current_date), $interval, $realEnd);
            
                // Use loop to store date into array
                $array = [];
                $format = 'Y-m-d';

                $array = $time_slot;
        
                $events_data = [];
                $events_arr = [];
        
                for ($i = 0; $i < count($event_staff); $i++) {
                    $user_id = $event_staff[$i];
                    
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
                    if (array_key_exists($outlook_value['date'],$array))
                    {
                        $needle = $array[$outlook_value['date']];
                        $min = $outlook_value['startdate'];
                        $max = $outlook_value['enddate'];

                        foreach($needle  as $nkey => $need_value){
                            if($need_value['start_time'] >= $min && $need_value['start_time'] <= $max){
                                $outlook_date_data[$outlook_value['date']][$nkey] = $need_value;
                            }
                            if($need_value['end_time'] >= $min && $need_value['end_time'] <= $max){
                                $outlook_date_data[$outlook_value['date']][$nkey] = $need_value;
                            }
                        }
                    }
                }

                $full_date_data = $array;

                foreach($outlook_date_data as $Okey => $O_value){
                    foreach($O_value as $ODkey => $val){
                        unset($full_date_data[$Okey][$ODkey]);
                    }
                }


                $full_array = CustomFunction::isDateGetFullMonth($current_date);
                $date_get_avalble = array_keys($full_date_data);

                $arr_1_final = array_diff($full_array, $date_get_avalble);
                $disabled_date = [];
                foreach($arr_1_final as $des_value){
                    array_push($disabled_date,$des_value);
                }

                $get_time_value = [];
                foreach($full_date_data as $DateKey => $date_value){
                    if(isset($date_value) && !empty($date_value)){
                        $get_time_value[$DateKey] = $date_value;
                    }else{
                        array_push($disabled_date,$DateKey);
                    }
                }

                ksort($get_time_value);
                $firstKey = array_key_first($get_time_value);
                $current_date = date('Y-m-d',strtotime($firstKey));

                $date_disabled_value = @json_encode($disabled_date,TRUE);
                $time_value = @json_encode($full_date_data,TRUE);

                return view('frontend.after_login.dashboard.schedule_event_time')->with("date_disabled_value",$date_disabled_value)->with("time_value",$time_value)
                                                                                 ->with("current_date",$current_date)->with("end_date",$end_date)
                                                                                 ->with("event_data",$event_data)->with("schedule_type",$schedule_type);
            }else{
                $role_name = CustomFunction::role_name();
                $route_name = $role_name.'.dashboard';
                return redirect()->route($route_name)->with("error", "Please try again!"); 
            }
            

        }else{
            return redirect()->route('home.index');
        }
        

    }

    public function saveScheduleEventTime(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'event_status' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
                ], [
            'id.required' => 'Please reload and try again!',
            'event_status.required' => 'Please reload and try again!',
            'event_date.required' => 'Please select date!',
            'event_time.required' => 'Please select time!',
        ]);

        $random_string = CustomFunction::random_string(5);
        $slug = CustomFunction::base_encode_string($random_string);

        $role_name = CustomFunction::role_name();
        $route_name = $role_name.'.dashboard';

        if ($validator->fails()) {
            return redirect()->route($route_name)->with("error", "Please try again!");
        }

        
        $id = $request->id;
        $event_status = $request->event_status;
        $event_date = $request->event_date;
        $event_time = $request->event_time;
        $event_end_time = $request->event_end_time;

        $event_schedule_type = null;
        if(isset($request->schedule_type) && !empty($request->schedule_type)){
            $event_schedule_type = $request->schedule_type; 
        }
        
        $event_data = JobEvent::find($id);
        $event_data->event_status = $event_status;
        $event_data->confirm_date = $event_date;
        $event_data->event_time = $event_time;
        $event_data->confirm_time = $event_end_time;
        $event_data->event_slug = $slug;
        $event_data->random_string = $random_string;

        if($event_data->save()){

            $msg = 'Interview Scheduled!';
            if(isset($event_schedule_type) && !empty($event_schedule_type)){
                $msg = 'Interview Re-Scheduled!';
                $outlook_event = OutlookEvent::where('event_id','=',$event_data->id)->where('deleted_at','=',null)->get();

                if(isset($outlook_event) && !empty($outlook_event)){
                    foreach($outlook_event as $e_data){
                        $outlook_event_id = $e_data->outlook_event_id;
                        $e_id = $e_data->id;
                        $user_data_id = $e_data->user_id;
                        OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_data_id);
                    }
                }
            }

            NotificationsController::notificationScheduleEventTime($event_data);

            $data = $event_data;
            $event_staff_select = $event_data->event_staff_select;
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
            
            $check_outlookuser = '';

            $user_id[] = $outlookuser_id;
            $candidate_id = $data->user_id;

            if(isset($user_id[0]) && !empty($user_id[0])){
                OutlookCalendarController::updateEvent($data,$user_id,$candidate_id,$user_data);
                OutlookCalendarController::createEvent($data,$user_data);
            }
            

            return redirect()->route($route_name)->with("success", $msg);
        }else{
            return redirect()->route($route_name)->with("error", "Please try again!");    
        }
    }

    public function getEventTimeReject(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'event_status' => 'required',
                ], [
            'id.required' => 'Please reload and try again!',
            'event_status.required' => 'Please reload and try again!',
        ]);


        if ($validator->fails()) {
            // return back()->with("error", $validator->errors()->first());
            return response()->json(['msg' => $validator->errors()->first(), 'code' => 0]);
        }

        $id = $request->id;
        $event_status = $request->event_status;
        $event_type = $request->event_type;

        $event_data = JobEvent::find($id);
        $event_data->event_status = $event_status;
        // $event_data->event_slug = null;
        // $event_data->random_string = null;

        $role_name = CustomFunction::role_name();
        $route_name = $role_name.'.dashboard';

        if(isset($event_type) && !empty($event_type)){
            $msg = 'Interview canceled';
        }else{
            $msg = 'Interview rejected!';
        }

        if($event_data->save()){

            if(isset($event_type) && !empty($event_type)){
                
                NotificationsController::notificationCancelEventTime($event_data);

                $outlook_event = OutlookEvent::where('event_id','=',$event_data->id)->where('deleted_at','=',null)->get();

                if(isset($outlook_event) && !empty($outlook_event)){
                    foreach($outlook_event as $e_data){
                        $outlook_event_id = $e_data->outlook_event_id;
                        $e_id = $e_data->id;
                        $user_id = $e_data->user_id;
                        OutlookCalendarController::deleteEvent($outlook_event_id,$e_id,$user_id);
                    }
                }

            }else{
                NotificationsController::notificationRejectEventTime($event_data);
            }

            // return redirect()->route($route_name)->with("success", $msg);
            return response()->json(['msg' => $msg,'code' => 1]);
        }else{
            return response()->json(['code' => 0]);
            // return redirect()->route($route_name)->with("error", "Please try again!");    
        }

    }

}
