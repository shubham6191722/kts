<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;
use Illuminate\Support\Facades\Auth;

use App\Models\Token;
use App\Models\SiteAddress;
use App\Models\OutlookEvent;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\RecruiterCandidate;
use App\Models\SubCompany;

class OutlookCalendarController extends Controller
{
    public function calendar()
    {
        if(Auth::check()){

            $user_id = Auth::user()->id;

            $viewData = $this->loadViewData($user_id);
            $graph = $this->getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                // Get user's timezone
                $last_year = date("Y",strtotime("-1 year"));
                $start_year = date("Y",strtotime("+1 year"));

                $timezone = TimeZones::getTzFromWindows($viewData['userTimeZone']);
                $startDateTime = $last_year.'-1-1';
                $endDateTime = $start_year.'-1-1';


                $viewData['dateRange'] = $startDateTime.' - '.$endDateTime;

                $startDate = $startDateTime;
                $endDate = $endDateTime;

                $queryParams = array(
                    // '$select' => 'subject,organizer,start,end',
                    'startDateTime' => $startDate,
                    'endDateTime' => $endDate,
                    '$orderby' => 'start/dateTime',
                    'isAllDay' => true,
                    '$top' => 1000000000
                );

                // Append query parameters to the '/me/calendarView' url
                $getEventsUrl = '/me/calendar/events?'.http_build_query($queryParams);
                // $getEventsUrl = '/me/calendars/events';

                // Add the user's timezone to the Prefer header
                $events = $graph->createRequest('GET', $getEventsUrl)->addHeaders(array('Prefer' => 'outlook.timezone="'.$viewData['userTimeZone'].'"'))->setReturnType(Model\Event::class)->execute();

                $viewData['events'] = $events;
                return view('calendar', $viewData);

            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }
    }

    public function getNewEventForm()
    {
        $user_id = Auth::user()->id;

        $viewData = OutlookCalendarController::loadViewData($user_id);

        return view('newevent', $viewData);
    }

    public function createNewEvent(Request $request)
    {
        // Validate required fields
        $request->validate([
            'eventSubject' => 'nullable|string',
            'eventAttendees' => 'nullable|string',
            'eventStart' => 'required|date',
            'eventBody' => 'nullable|string'
        ]);


        $user_data = $request->user_id;
        foreach($user_data as $user_id){

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);
            // Attendees from form are a semi-colon delimited list of
            // email addresses
            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){
                $attendeeAddresses = explode(';', $request->eventAttendees);

                // The Attendee object in Graph is complex, so build the structure
                $attendees = [];
                foreach($attendeeAddresses as $attendeeAddress)
                {
                    array_push($attendees, [
                        // Add the email address in the emailAddress property
                        'emailAddress' => [
                        'address' => $attendeeAddress
                        ],
                        // Set the attendee type to required
                        'type' => 'required'
                    ]);
                }

                // Build the event
                $newEvent = [
                    'subject' => $request->eventSubject,
                    'attendees' => $attendees,
                    'start' => [
                        'dateTime' => $request->eventStart,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'end' => [
                        'dateTime' => $request->eventStart,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'body' => [
                        'content' => $request->eventBody,
                        'contentType' => 'text'
                    ]
                ];

                // POST /me/events
                $response = $graph->createRequest('POST', '/me/events')->attachBody($newEvent)->setReturnType(Model\Event::class)->execute();
            }
        }

        return redirect('/outlook-calendar');
    }

    public static function createEvent($data,$user_id_get)
    {

        $start_dateTime = $end_dateTime = $subject = $body = $address_select = $interview_type = null;

        foreach($user_id_get as $user_id){

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                $confirm_time = date("h:i",strtotime($data->confirm_time." -1 minutes"));

                $start_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                $end_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->confirm_time));
                // $end_dateTime = $data->confirm_date.'T'.date('h:i', strtotime($confirm_time));
                $event_type = $data->event_type;
                $vacancy_data = JobVacancy::jobGet($data->vacancy_id);
                $vacancy_title = $vacancy_data->jobtitle;

                if($data->job_reference  == 1){
                    $candidate_name = RecruiterCandidate::recruiterCandidateName($data->r_c_id);
                }else{
                    $candidate_name = User::getUserName($data->user_id);
                }

                if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                    $company_full_data = SubCompany::getSubCompanyData($vacancy_data->sub_company);
                }else{
                    $company_full_data = User::clientData($vacancy_data->user_select);
                }

                $company_name = $company_full_data->company_name;

                $subject = $event_type." | ".$vacancy_title." | ".$candidate_name." | ".$company_name;
                $body = $data->event_description;

                $address_select = SiteAddress::addressGet($data->address_select);
                $interview_type = $data->interview_type;

                // The Attendee object in Graph is complex, so build the structure
                $attendees = [
                    [
                        // Add the email address in the emailAddress property
                        'emailAddress' => ['address' => ''],
                        // Set the attendee type to required
                        'type' => 'required'
                    ]
                ];


                // Build the event
                $newEvent = [
                    'subject' => $subject,
                    'attendees' => $attendees,
                    'start' => [
                        'dateTime' => $start_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'end' => [
                        'dateTime' => $end_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'body' => [
                        'content' => $body,
                        'contentType' => 'text'
                    ]
                ];
                $response = $graph->createRequest('POST', '/me/events')->attachBody($newEvent)->setReturnType(Model\Event::class)->execute();

                $json_encode = json_encode($response);
                $json_decode = json_decode($json_encode);

                $outlook_event = new OutlookEvent;
                $outlook_event->outlook_event_id = $json_decode->id;
                $outlook_event->event_id = $data->id;
                $outlook_event->user_id = $user_id;
                $outlook_event->full_data = $json_encode;
                $outlook_event->check_organizer = 0;
                $outlook_event->save();
            }
        }

        return true;

    }

    public static function createEventNormal($data,$user_id_get)
    {

        $start_dateTime = $end_dateTime = $subject = $body = $address_select = $interview_type = null;

        foreach($user_id_get as $user_id){

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                $confirm_time = date("h:i",strtotime($data->confirm_time." -1 minutes"));

                $start_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                $end_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                // $end_dateTime = $data->confirm_date.'T'.date('h:i', strtotime($confirm_time));
                $event_type = $data->event_type;
                $vacancy_data = JobVacancy::jobGet($data->vacancy_id);
                $vacancy_title = $vacancy_data->jobtitle;

                if($data->job_reference  == 1){
                    $candidate_name = RecruiterCandidate::recruiterCandidateName($data->r_c_id);
                }else{
                    $candidate_name = User::getUserName($data->user_id);
                }

                if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                    $company_full_data = SubCompany::getSubCompanyData($vacancy_data->sub_company);
                }else{
                    $company_full_data = User::clientData($vacancy_data->user_select);
                }

                $company_name = $company_full_data->company_name;

                $subject = $event_type." | ".$vacancy_title." | ".$candidate_name." | ".$company_name;
                $body = $data->event_description;

                $address_select = SiteAddress::addressGet($data->address_select);
                $interview_type = $data->interview_type;

                // The Attendee object in Graph is complex, so build the structure
                $attendees = [
                    [
                        // Add the email address in the emailAddress property
                        'emailAddress' => ['address' => ''],
                        // Set the attendee type to required
                        'type' => 'required'
                    ]
                ];


                // Build the event
                $newEvent = [
                    'subject' => $subject,
                    'attendees' => $attendees,
                    'start' => [
                        'dateTime' => $start_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'end' => [
                        'dateTime' => $end_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'body' => [
                        'content' => $body,
                        'contentType' => 'text'
                    ]
                ];
                $response = $graph->createRequest('POST', '/me/events')->attachBody($newEvent)->setReturnType(Model\Event::class)->execute();

                $json_encode = json_encode($response);
                $json_decode = json_decode($json_encode);

                $outlook_event = new OutlookEvent;
                $outlook_event->outlook_event_id = $json_decode->id;
                $outlook_event->event_id = $data->id;
                $outlook_event->user_id = $user_id;
                $outlook_event->full_data = $json_encode;
                $outlook_event->check_organizer = 0;
                $outlook_event->save();
            }
        }

        return true;

    }

    public static function updateEvent($data,$user_id_get,$candidate_id,$user_data)
    {

        $start_dateTime = $end_dateTime = $subject = $body = $address_select = $interview_type = null;

        foreach($user_id_get as $user_id){

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                $confirm_time = date("h:i",strtotime($data->confirm_time." -1 minutes"));

                $start_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                $end_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->confirm_time));
                // $end_dateTime = $data->confirm_date.'T'.date('h:i', strtotime($confirm_time));
                $event_type = $data->event_type;
                $vacancy_data = JobVacancy::jobGet($data->vacancy_id);
                $vacancy_title = $vacancy_data->jobtitle;

                if($data->job_reference  == 1){
                    $candidate_name = RecruiterCandidate::recruiterCandidateName($data->r_c_id);
                }else{
                    $candidate_name = User::getUserName($data->user_id);
                }

                if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                    $company_full_data = SubCompany::getSubCompanyData($vacancy_data->sub_company);
                }else{
                    $company_full_data = User::clientData($vacancy_data->user_select);
                }

                $company_name = $company_full_data->company_name;

                $subject = $event_type." | ".$vacancy_title." | ".$candidate_name." | ".$company_name;
                $body = $data->event_description;

                $address_select = SiteAddress::addressGet($data->address_select);
                $interview_type = $data->interview_type;

                // The Attendee object in Graph is complex, so build the structure
                $attendees = [];
                foreach($user_data as $attendeeAddress)
                {
                    $candidate_email = User::getEmail($attendeeAddress);

                    array_push($attendees, [
                        // Add the email address in the emailAddress property
                        'emailAddress' => [
                        'address' => $candidate_email
                        ],
                        // Set the attendee type to required
                        'type' => 'required'
                    ]);
                }


                $candidate_email = User::getEmail($candidate_id);
                array_push($attendees, [
                    // Add the email address in the emailAddress property
                    'emailAddress' => [
                        'address' => $candidate_email
                    ],
                    // Set the attendee type to required
                    'type' => 'required'
                ]);

                // Build the event
                $newEvent = [
                    'subject' => $subject,
                    'attendees' => $attendees,
                    'start' => [
                        'dateTime' => $start_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'end' => [
                        'dateTime' => $end_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'body' => [
                        'content' => $body,
                        'contentType' => 'text'
                    ]
                ];
                $response = $graph->createRequest('POST', '/me/events')->attachBody($newEvent)->setReturnType(Model\Event::class)->execute();

                $json_encode = json_encode($response);
                $json_decode = json_decode($json_encode);

                $outlook_event = new OutlookEvent;
                $outlook_event->outlook_event_id = $json_decode->id;
                $outlook_event->event_id = $data->id;
                $outlook_event->user_id = $user_id;
                $outlook_event->full_data = $json_encode;
                $outlook_event->check_organizer = 1;
                $outlook_event->save();
            }
        }

        return true;

    }

    public static function updateEventNormal($data,$user_id_get,$candidate_id,$user_data)
    {

        $start_dateTime = $end_dateTime = $subject = $body = $address_select = $interview_type = null;

        foreach($user_id_get as $user_id){

            $viewData = OutlookCalendarController::loadViewData($user_id);
            $graph = OutlookCalendarController::getGraph($user_id);

            if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                $confirm_time = date("h:i",strtotime($data->confirm_time." -1 minutes"));

                $start_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                $end_dateTime = $data->confirm_date.'T'.date('H:i', strtotime($data->event_time));
                // $end_dateTime = $data->confirm_date.'T'.date('h:i', strtotime($confirm_time));
                $event_type = $data->event_type;
                $vacancy_data = JobVacancy::jobGet($data->vacancy_id);
                $vacancy_title = $vacancy_data->jobtitle;

                if($data->job_reference  == 1){
                    $candidate_name = RecruiterCandidate::recruiterCandidateName($data->r_c_id);
                }else{
                    $candidate_name = User::getUserName($data->user_id);
                }

                if(isset($vacancy_data->sub_company) && !empty($vacancy_data->sub_company)){
                    $company_full_data = SubCompany::getSubCompanyData($vacancy_data->sub_company);
                }else{
                    $company_full_data = User::clientData($vacancy_data->user_select);
                }

                $company_name = $company_full_data->company_name;

                $subject = $event_type." | ".$vacancy_title." | ".$candidate_name." | ".$company_name;
                $body = $data->event_description;

                $address_select = SiteAddress::addressGet($data->address_select);
                $interview_type = $data->interview_type;

                // The Attendee object in Graph is complex, so build the structure
                $attendees = [];
                foreach($user_data as $attendeeAddress)
                {
                    $candidate_email = User::getEmail($attendeeAddress);

                    array_push($attendees, [
                        // Add the email address in the emailAddress property
                        'emailAddress' => [
                        'address' => $candidate_email
                        ],
                        // Set the attendee type to required
                        'type' => 'required'
                    ]);
                }


                $candidate_email = User::getEmail($candidate_id);
                array_push($attendees, [
                    // Add the email address in the emailAddress property
                    'emailAddress' => [
                        'address' => $candidate_email
                    ],
                    // Set the attendee type to required
                    'type' => 'required'
                ]);

                // Build the event
                $newEvent = [
                    'subject' => $subject,
                    'attendees' => $attendees,
                    'start' => [
                        'dateTime' => $start_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'end' => [
                        'dateTime' => $end_dateTime,
                        'timeZone' => $viewData['userTimeZone']
                    ],
                    'body' => [
                        'content' => $body,
                        'contentType' => 'text'
                    ]
                ];
                $response = $graph->createRequest('POST', '/me/events')->attachBody($newEvent)->setReturnType(Model\Event::class)->execute();

                $json_encode = json_encode($response);
                $json_decode = json_decode($json_encode);

                $outlook_event = new OutlookEvent;
                $outlook_event->outlook_event_id = $json_decode->id;
                $outlook_event->event_id = $data->id;
                $outlook_event->user_id = $user_id;
                $outlook_event->full_data = $json_encode;
                $outlook_event->check_organizer = 1;
                $outlook_event->save();
            }
        }

        return true;

    }

    public static function deleteEvent($outlook_event_id,$id,$user_id)
    {
        $viewData = OutlookCalendarController::loadViewData($user_id);
        $graph = OutlookCalendarController::getGraph($user_id);

        if((isset($graph) && !empty($graph)) && (isset($viewData) && !empty($viewData))){
            $response = $graph->createRequest('DELETE', '/me/events/'.$outlook_event_id)->setReturnType(Model\Event::class)->execute();

            $outlook_event = OutlookEvent::find($id);
            if(isset($outlook_event) && !empty($outlook_event)){
                $outlook_event->deleted_at = date('Y-m-d H:i:s');
                $outlook_event->save();
            }
        }

        return true;

    }

    public static function loadViewData($user_id)
    {
        $viewData = [];

        // Check for flash errors
        if (session('error')) {
            $viewData['error'] = session('error');
            $viewData['errorDetail'] = session('errorDetail');
        }

        // $user_id = Auth::user()->id;
        $sessionData = Token::where('user_id','=',$user_id)->first();

        // Check for logged on user
        if(isset($sessionData) && !empty($sessionData)){
            if ($sessionData->userTimeZone)
            {
                $viewData['userName'] = $sessionData->userName;
                $viewData['userEmail'] = $sessionData->userEmail;
                $viewData['userTimeZone'] = $sessionData->userTimeZone;
            }
        }

        return $viewData;
    }

    public static function getGraph($user_id): Graph
    {
        // Get the access token from the cache
        // $user_id = Auth::user()->id;
        // $user_id = Auth::user()->id;
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken($user_id);

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }
}
