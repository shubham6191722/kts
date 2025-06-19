<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;
use App\Models\SiteSetting;
use App\Models\UserDetail;
use Carbon\Carbon;


class LoginController extends BaseController {

    public function __construct() {

    }

    /** Candidate Register */
    public function candidateRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'c_email' => 'required|email|unique:users,email',
            // 'cv_file' => 'required|mimes:pdf,docx,doc',
            'c_password' => 'required|min:6',
            'c_username' => 'required',
            'c_lastname' => 'required',
            // 'c_town' => 'required',
            'c_number' => 'required',
                ], [
            'c_email.required' => 'Please enter Email Address!',
            'c_email.email' => 'Please enter valid Email Address!',
            'c_email.unique' => 'This Email address is already registered!',
            'c_password.required' => 'Please enter Password!',
            'c_password.min' => 'Password must be minimum 6 characters',
            'c_username.required' => 'Please enter name!',
            'c_town.required' => 'Please enter town!',
            'c_number.required' => 'Please enter phone number!',
            'cv_file.mimes' => 'CV allow only pdf file.',
            'cv_file.required' => 'Please select CV.',
            'cv_file.max' => 'CV should be less than 3 mb.',
        ]);


        if ($validator->fails()) {
            $modal_name = 'register';
            return back()->withErrors($validator)->withInput()->with('open_application', 'On')->with('modal_name', $modal_name)->with('error_msg', $validator->errors()->first());
            // return response()->json(['msg' => $validator->errors()->first(),'modal_name' => $modal_name, 'code' => 0]);
        }

        $email = CustomFunction::filter_input($request->c_email);
        $password = CustomFunction::filter_input($request->c_password);
        $name = CustomFunction::filter_input($request->c_username);
        $lname = CustomFunction::filter_input($request->c_lastname);
        $password_hash = Hash::make($password);


        $is_found_email = User::where('email', $email)->get()->count();
        if ($is_found_email > 0) {
            $modal_name = 'register';
            return back()->withInput()->with('open_application', 'On')->with('modal_name', $modal_name)->with('error_msg', 'This Email address is already registered');
            // return response()->json(['msg' => 'This Email address is already registered','modal_name' => $modal_name, 'code' => 0]);
        }

        $talent_pool = "0";
        if(isset($request->talent_pool) && !empty($request->talent_pool)){
            $talent_pool = $request->talent_pool;
        }

        $random_no = CustomFunction::random_string(10);
        $key = site_title;
        $new_key = $random_no . '#' . $key;
        $new_ket_encode = base64_encode($new_key);

        $new_user = new User;
        $new_user->email = $email;
        $new_user->name = $name;
        $new_user->lname = $lname;
        $new_user->password = $password_hash;
        $new_user->phone = $request->c_number;
        // $new_user->town = $request->c_town;
        $new_user->status = '1';
        $new_user->email_confirm = '1';
        $new_user->role = 5;
        $new_user->created_at = date('Y-m-d H:i:s');
        $new_user->client_slug = $random_no;
        $new_user->talent_pool_status = $talent_pool;
        $new_user->c_code = $request->c_code;
        $new_user->country_code = $request->country_code;

        $siteSetting = SiteSetting::first();

        $site_title  = $site_header_logo = null;

        $site_header_logo = url('assets/frontend').'/img/logo.png';
        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
            }
        }

        $sector = null;
        if($request->sector){
            $sector = $request->sector;
        }

        $salary = null;
        if($request->salary){
            $salary = $request->salary;
        }

        $key_skills = null;
        if($request->skillsrequired){
            $key_skills = implode(',', $request->skillsrequired);
        }

        $location = null;
        if($request->c_loction){
            $location = $request->c_loction;
        }

        $workbasepreference = null;
        if($request->workbasepreference){
            $workbasepreference = implode(',', $request->workbasepreference);
        }

        $noticeperiod = null;
        if($request->noticeperiod){
            $noticeperiod = $request->noticeperiod;
        }

        if ($new_user->save()) {
            // try {
            //     $emaildata = array(
            //         'email' => $email,
            //         'confirm_url' => $confirm_url,
            //         'name' => $name.' '.$lname,
            //         'siteHeaderLogo' => $site_header_logo,
            //         'siteTitle' => $site_title
            //     );

            //     Mail::send('frontend.email_template.registration', $emaildata, function ($message) use ($email) {
            //         $message->to($email)->subject('Verify your Email');
            //     });

            // } catch (\Exception $ex) {
            //     $id = $new_user->id;
            //     $delete_user = User::find($id)->delete();
            //     $error_msg = $ex->getMessage();
            //     return back()->with('error', 'Registration not done, please try again');

            // }

            $user_id = $new_user->id;
            $folderName = '/candidate/';
            $folderPath = $new_user->id;

            $cv = null;
            if ($request->hasFile('cv_file')) {
                $file = $request->file('cv_file');
                $old_file = null;
                if($request->old_cv_file){
                    $old_file = $request->old_cv_file;
                }
                $fileName = CustomFunction::cvUpload($file, $old_file, $folderName,$folderPath);
                $cv = $fileName['name'];
            }

            $check_data = UserDetail::where('user_id','=',$user_id)->where('deleted_at', "=", null)->first();

            if(isset($check_data) && !empty($check_data)){
                $user_detail = UserDetail::find($check_data->id);
            }else{
                $user_detail = new UserDetail;
            }

            $user_detail->user_id = $user_id;
            $user_detail->salary = $salary;
            $user_detail->location = $location;
            $user_detail->key_skills = $key_skills;
            $user_detail->cv = $cv;
            $user_detail->sector = $sector;
            $user_detail->workbasepreference = $workbasepreference;
            $user_detail->noticeperiod = $noticeperiod;

            $user_detail->save();


            $auth = Auth::attempt(
            [
                'email' => $new_user->email,
                'password' => $password,
                'role' => $new_user->role
            ]);

            if (!$auth) {
                $modal_name = 'register';
                return back()->withInput()->with('open_application', 'On')->with('modal_name', $modal_name)->with('error_msg', 'Incorrect Email address or password');
                // return response()->json(['msg' => 'Incorrect Email address or password','modal_name' => $modal_name, 'code' => 0]);
            }
            
            $job_id = $request->job_id;
            if(isset($job_id) && !empty($job_id)){
                Session::put('modalOpen', 'yes');
            }
            return back()->with('success', 'You have been successfully registered.');
            // return response()->json(['msg' => 'You have been successfully registered.', 'code' => 1]);
        } else {
            $modal_name = 'register';
            return back()->withInput()->with('open_application', 'On')->with('modal_name', $modal_name)->with('error_msg', 'Registration not done, please try again');
            // return response()->json(['msg' => 'Registration not done, please try again','modal_name' => $modal_name, 'code' => 0]);
        }
    }

    /** logout User */
    public function authLogoutAttempt(Request $request) {

        if(Auth::check()){
            $current_time = Carbon::now();
            $time = $current_time->toDateTimeString();
            $user = User::find(Auth::user()->id);
            $user->check_status = null;
            $user->save();
        }

        Auth::logout(); // logout user
        Session::flush();
        return redirect()->route('home.index')->with("success", "logout successfully.");

    }

    /** Candidate login */
    public function candidateLoginCheck(Request $request)
    {
        $request->validate([
            'c_email' => 'required',
            'c_password' => 'required',
                ], [
            'c_email.required' => 'Invaild request, please try again.',
            'c_password.required' => 'Invaild request, please try again.',
        ]);

        $email = CustomFunction::filter_input($request->c_email);
        $password = CustomFunction::filter_input($request->c_password);

        $is_found_email = User::select('status', 'email_confirm')->where('email', $email)->get()->toArray();
        if (!empty($is_found_email)) {

            $status = $is_found_email[0]['status'];
            $email_confirm = $is_found_email[0]['email_confirm'];

            if ($status == '0') {
                return back()->with('error_msg', 'Your Account is disabled, please contact admin for more information')->with('open_application', 'On')->with('modal_name', 'login');
            }

            $user = User::where('email', $email)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return back()->with('error_msg', 'Incorrect Email address or Password')->with('open_application', 'On')->with('modal_name', 'login');
            }

            // attempt to do the login
            $auth = Auth::attempt(
            [
                'email' => $email,
                'password' => $password,
                'role' => $user->role
            ]);

            if (!$auth) {
                return back()->with('error_msg', 'Incorrect Email address or password')->with('open_application', 'On')->with('modal_name', 'login');
            }

            $role_name = CustomFunction::role_name();
            if(isset($role_name) && !empty($role_name)){

                if($role_name == 'candidate'){
                    if(isset($request->job_id) && !empty($request->job_id)){
                        return back()->with('success', 'Login Success!')->with('open_application', 'On')->with('modal_name', 'applyjob');
                    }
                    return back()->with('success', 'Login Success!');
                }else{
                    $route_name = $role_name.'.dashboard';
                    return redirect()->route($route_name);
                }
            }else{
                return back()->with('error_msg', 'Incorrect Email address or password')->with('open_application', 'On')->with('modal_name', 'login');
            }

        } else {
            return back()->with('error_msg', 'Incorrect Email address or password')->with('open_application', 'On')->with('modal_name', 'login');
        }
    }

    public function sendForgotPasswordRequest(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'g-recaptcha-response' => 'required|recaptchav3:forgotpassword,0.5'
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.exists' => 'Email Address is not Found!'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('open_application', 'On')->with('modal_name', 'forgot_password')->with('error_msg', $validator->errors()->first());
        }


        $siteSetting = SiteSetting::first();

        $site_title  = $site_header_logo = null;

        $site_header_logo = url('assets/frontend').'/img/logo.png';
        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
            }
        }

        $user = User::where('email', $request->email)->first();
        $email = $user->email;
        $random_no = $user->pass_reset_token = CustomFunction::random_string(25);

        $pass_reset_link = route('home.reset.password', $random_no);

        $data_customer = array(
            'pass_reset_link' => $pass_reset_link,
            'user_data' => $user,
            'siteHeaderLogo' => $site_header_logo,
            'siteTitle' => $site_title
        );

        try {
            Log::info("User id:- ".$user->id);
            Log::info("User Email:- ".$email);
            // $email = "sunny.tzinfotech@gmail.com";
            Mail::send('admin.email_template.forgot_password_email', $data_customer, function ($message) use ($user,$email) {
                $message->to($email)->subject('We received a password reset request');
            });

            if ($user->update()) {
                return back()->with('open_application', 'On')->with('modal_name', 'forgot_password')->with('success', 'Password Reset requested send successfully! Check your email.');
            } else {
                return back()->with('open_application', 'On')->with('modal_name', 'forgot_password')->with('error_msg', 'Something went wrong !!!');
            }

        } catch (Exception $exc) {
            return back()->with('open_application', 'On')->with('modal_name', 'forgot_password')->with('error_msg', 'Password not Reset, please try again!');
        }


    }

    public function resetPasswordRequest($token) {
        if (User::where('pass_reset_token', $token)->count()) {
            return view('frontend.client.reset_password', compact('token'));
        }
        return redirect()->route('home.index')->with("error", "Your Reset Password Token has been expired!");
    }

    public function submitResetPassword(Request $request) {


        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6|required_with:renew_password|same:renew_password',
            'renew_password' => 'required',
            'token' => 'required',
            'g-recaptcha-response' => 'required|recaptchav3:resetpassword,0.5'
                ], [
            'new_password.required' => 'Please enter New Password',
            'new_password.min' => 'New Password must be minimum 6 characters',
            'renew_password.required' => 'Please enter Conform Password',
            'new_password.same' => 'New Password and Conform Password must be same',
            'token.required' => 'Your Request token not found',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $user = User::where('pass_reset_token', $request->token)->first();
        $user->password = Hash::make($request->new_password);
        $user->pass_reset_token = null;

        if ($user->update()) {
            return redirect()->route('home.index')->with('open_application', 'On')->with('modal_name', 'login')->with("success_msg", "Your password has been reset successfully.");;
        } else {
            return back()->with('error', 'Password not change, please try again.');
        }
    }
}
