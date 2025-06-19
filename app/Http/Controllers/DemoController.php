<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\JobEvent;
use App\Models\Token;
use App\Models\OutlookEvent;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use App\TimeZones\TimeZones;

use DateInterval;
use DateTime;
use DatePeriod;

class DemoController extends Controller
{

    public function syncCalendar()
    {
        $get_organizer = OutlookEvent::getOrganizer();

        if(isset($get_organizer) && !empty($get_organizer)){
            foreach($get_organizer as $key => $g_value){
                
                $user_id = $g_value->user_id;
                $outlook_event_id = $g_value->event_id;
                $viewData = OutlookCalendarController::loadViewData($user_id);
                $graph = OutlookCalendarController::getGraph($user_id);

                if((isset($viewData) && !empty($viewData)) && (isset($graph) && !empty($graph))){

                    // Get Outlook id
                    $outlook_id = $g_value->outlook_event_id;

                    // Append query parameters to the '/me/calendarView' url
                    $getEventsUrl = '/me/calendar/events/'.$outlook_id;
                    
                    // Add the user's timezone to the Prefer header
                    $events = $graph->createRequest('GET', $getEventsUrl)->addHeaders(array('Prefer' => 'outlook.timezone="'.$viewData['userTimeZone'].'"'))->setReturnType(Model\Event::class)->execute();

                    $json_encode = json_encode($events);
                    $json_decode = json_decode($json_encode);
                    
                    $content = $json_decode->body->content;
                    $outlookEvent = JobEvent::find($outlook_event_id);
                    $outlookEvent->event_description = $content;
                    $outlookEvent->save();

                }
            }
        }
        
    }

}
