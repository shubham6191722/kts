<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\CustomFunction\CustomFunction;
use Carbon\Carbon;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use App\Models\JobVacancy;
use App\Models\JobsAlert;
use App\Jobs\CandidateMailNotificationInQueue;
use App\Models\SiteSetting;

use Twilio\Rest\Client;

class ConfigController extends BaseController {

    public function __construct() {

    }

    /**
     *
     * @return type
     */
    public function clearRoute(Request $request)
    {
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        return redirect()->route('home.index');
    }

    public function candidateMailView(Request $request)
    {
        $user_data = User::getCandidateFull();
        $date = Carbon::today();
        foreach($user_data as $key => $value){

            if($value->check_notification == 1){

                if($value->check_radius == 1){
                    $vacancy_data = JobVacancy::candidateNotificationRadius($value,$date);
                }else{
                    $vacancy_data = JobVacancy::candidateNotification($value,$date);
                }
            }
            if(isset($vacancy_data) && !empty($vacancy_data) && count($vacancy_data)){
                $email = $value->email;
                $user_id = $value->id;
                $name = $value->name;
                $lname = $value->lname;
                if(isset($name) && !empty($name)){
                    $userName = $name;
                }
                if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                    $userName = $name.' '.$lname;
                }
                
                $siteSetting = SiteSetting::first();

                $siteHeaderLogo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
                $statusJobData = view('vacancy_data_for_mail')->with('data', $vacancy_data)->with('siteHeaderLogo', $siteHeaderLogo)->render();

                $nameOfEmail = $email;
                // $nameOfEmail = "sunny.tzinfotech@gmail.com";
                $trimedDescription = $statusJobData;

                $siteSettingData = SiteSetting::where('site_title','=','candidateJobAlert')->first();
                $description = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_notification_email)));
                $description = str_replace("{candidate-name}", $userName, $description);

                $trimedSubject = CustomFunction::decode_input($siteSettingData->site_favicon);
                $trimedSubject = str_replace("{candidate-name}", $userName, $trimedSubject);

                $data = [
                    'siteTitle' => site_title,
                    'siteHeaderLogo' => $siteHeaderLogo,
                    'email_subject' => $trimedSubject,
                    'emailDescription' => $trimedDescription,
                    'name_of_sent_email' => $nameOfEmail,
                    'userName' => $userName,
                    'user_id' => $user_id,
                    'description' => $description,
                ];
                $time = $key;

                $job_alert = JobsAlert::where('user_id','=',$user_id)->whereDate('date','=',$date)->get();

                // if(isset($job_alert) && !empty($job_alert) && count($job_alert)){
                    // return redirect()->route('home.index');
                // }else{
                    $job = (new CandidateMailNotificationInQueue($data))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                // }
            }

        }
        return true;
    }

    public function sendOTP(Request $request)
    {
        $number= $request->number;
        $otp_send= $request->otp_send;
        $hide_submit_otp= $request->hide_submit_otp;
        $show_submit_otp= $request->show_submit_otp;
        $otp= $request->otp;
        $field_name= $request->field_name;
        $modal_name= $request->modal_name;
        $CountryData= $request->CountryData;

        $full_number = '+'.$CountryData.''.$number;

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        
        $twilio = new Client($twilio_sid, $token);
        
        $twilio_data = $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($full_number, "sms",["statusCallback" => "http://postb.in/1234abcd"]);
        
        $sid = $twilio_data->sid;
        $serviceSid = $twilio_data->serviceSid;
        $accountSid = $twilio_data->accountSid;
        
        return response()->json(['number' => $number,'otp_send' => $otp_send,'hide_submit_otp' => $hide_submit_otp,'show_submit_otp' => $show_submit_otp,'otp' => $otp,'field_name' => $field_name,'modal_name' => $modal_name,
                                 'sid' => $sid, 'serviceSid' => $serviceSid, 'accountSid' => $accountSid, 'code' => 1]);

    }

    public function verifyOTP(Request $request)
    {
        $number= $request->number;
        $modal_name= $request->modal_name;
        $otp_send= $request->otp_send;
        $value= $request->value;
        $CountryData= $request->CountryData;

        $full_number = '+'.$CountryData.''.$number;

        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        
        $twilio = new Client($twilio_sid, $token);
        
        $verification = $twilio->verify->v2->services($twilio_verify_sid)->verificationChecks->create(['to' => $full_number,'code' => $value]);

        if ($verification->valid)
        {
            return response()->json(['number' => $number,'modal_name' => $modal_name,'otp_send' => $otp_send,'code' => 1]);
        }
        return response()->json(['code' => 0,'modal_name' => $modal_name]);


    }

    public function loginSendOTP(Request $request)
    {

        $c_email= $request->c_email;
        $c_password= $request->c_password;
        $hide_submit_otp= $request->hide_submit_otp;
        $show_submit_otp= $request->show_submit_otp;
        $otp= $request->otp;
        $modal_name= $request->modal_name;

        $is_found_email = User::select('status', 'email_confirm')->where('email', $c_email)->get()->toArray();

        if (!empty($is_found_email)) {

            $status = $is_found_email[0]['status'];
            if ($status == '0') {
                return response()->json(['msg' => 'Your Account is disabled, please contact admin for more information','modal_name'=>$modal_name,'code' => 0]);
            }

            $user = User::where('email', $c_email)->first();
            if (!$user || !Hash::check($c_password, $user->password)) {
                return response()->json(['msg' => 'Incorrect Email address or Password','modal_name'=>$modal_name,'code' => 0]);
            }

            $full_number = '+'.$user->c_code.''.$user->phone;

            if($user->role == 5){

                // $token = getenv("TWILIO_AUTH_TOKEN");
                // $twilio_sid = getenv("TWILIO_SID");
                // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                
                // $twilio = new Client($twilio_sid, $token);
                
                // $twilio_data = $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($full_number, "sms",["statusCallback" => "http://postb.in/1234abcd"]);
                
                // $sid = $twilio_data->sid;
                // $serviceSid = $twilio_data->serviceSid;
                // $accountSid = $twilio_data->accountSid;
                
                // return response()->json(['hide_submit_otp' => $hide_submit_otp,'show_submit_otp' => $show_submit_otp,'otp' => $otp,'modal_name' => $modal_name,
                //                      'sid' => $sid, 'serviceSid' => $serviceSid, 'accountSid' => $accountSid, 'code' => 1]);

                $auth = Auth::attempt(
                [
                    'email' => $c_email,
                    'password' => $c_password,
                    'role' => $user->role
                ]);

                if (!$auth) {
                    return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
                }

                $job_id = $request->job_id;
                if(isset($job_id) && !empty($job_id)){
                    Session::put('modalOpen', 'yes');
                }

                return response()->json(['modal_name' => $modal_name,'code' => 1]);

            }else{

                $auth = Auth::attempt(
                [
                    'email' => $c_email,
                    'password' => $c_password,
                    'role' => $user->role
                ]);

                if (!$auth) {
                    return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
                }

                $role_name = CustomFunction::role_name();
                if(isset($role_name) && !empty($role_name)){

                    if($role_name != 'candidate'){
                        $route_name = $role_name.'.dashboard';
                        $url = route($route_name);
                        return response()->json(['url' => $url,'code' => 2]);
                    }
                }else{
                    return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
                }
            }

        }else{
            return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
        }

    }

    public function loginVerifyOTP(Request $request)
    {
        $c_email= $request->c_email;
        $c_password= $request->c_password;
        $hide_submit_otp= $request->hide_submit_otp;
        $show_submit_otp= $request->show_submit_otp;
        $otp= $request->otp;
        $modal_name= $request->modal_name;
        $otp_value= $request->otp_value;
        $job_id= $request->job_id;

        $is_found_email = User::select('status', 'email_confirm')->where('email', $c_email)->get()->toArray();

        if (!empty($is_found_email)) {

            $status = $is_found_email[0]['status'];
            if ($status == '0') {
                return response()->json(['msg' => 'Your Account is disabled, please contact admin for more information','modal_name'=>$modal_name,'code' => 0]);
            }

            $user = User::where('email', $c_email)->first();
            if (!$user || !Hash::check($c_password, $user->password)) {
                return response()->json(['msg' => 'Incorrect Email address or Password','modal_name'=>$modal_name,'code' => 0]);
            }

            $full_number = '+'.$user->c_code.''.$user->phone;

            if($user->role == 5){

                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

                $twilio = new Client($twilio_sid, $token);

                $verification = $twilio->verify->v2->services($twilio_verify_sid)->verificationChecks->create(['to' => $full_number,'code' => $otp_value]);

                if ($verification->valid)
                {

                    if(isset($job_id) && !empty($job_id)){
                        Session::put('modalOpen', 'yes');
                    }

                    $auth = Auth::attempt(
                    [
                        'email' => $c_email,
                        'password' => $c_password,
                        'role' => $user->role
                    ]);

                    if (!$auth) {
                        return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
                    }

                    return response()->json(['modal_name' => $modal_name,'code' => 1]);
                }
                return response()->json(['code' => 0,'modal_name' => $modal_name]);

            }

        }else{
            return response()->json(['msg' => 'Incorrect Email address or password','modal_name'=>$modal_name,'code' => 0]);
        }


    }

}
