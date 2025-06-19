<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Mail;
use Hash;
use App\Models\User;
use App\Models\SiteSetting;

class LoginController extends Controller {

    public function __construct() {
    
    }

    public function getIndex() {
        if(Auth::check()){
            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.dashboard';
            return redirect()->route($route_name);
        }
        return view('admin.auth.login');
    }

    public function doLogin(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'password.required' => 'Please enter Password!',
        ]);
        

        // create our user data for the authentication
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        );

        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::attempt($userdata, $remember_me) && Auth::user()->role == '1' && Auth::user()->status == '1') {
            Auth::user()->update(['last_login_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('rats-5768.dashboard');
        }elseif (Auth::attempt($userdata, $remember_me) && Auth::user()->role == '2' && Auth::user()->status == '1') {
            Auth::user()->update(['last_login_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('client.dashboard');
        }elseif (Auth::attempt($userdata, $remember_me) && Auth::user()->role == '2' && Auth::user()->status == '1') {
            Auth::user()->update(['last_login_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('staff.dashboard');
        }elseif (Auth::attempt($userdata, $remember_me) && Auth::user()->role == '2' && Auth::user()->status == '1') {
            Auth::user()->update(['last_login_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('recruiter.dashboard');
        } else {
            return back()->with('error', 'Email or Password is wrong!')->withInput($request->except('password'));
        }
    }

    public function showForgotPasswordForm() {
        return view('admin.auth.forgot-password');
    }

    public function sendForgotPasswordRequest(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.exists' => 'Email Address is not Found!'
        ]);

        

        $user = User::where('email', $request->email)->first();
        $email = $user->email;
        $random_no = $user->pass_reset_token = CustomFunction::random_string(25);

        $siteSetting = SiteSetting::first();

        $site_title  = $site_header_logo = null;

        $site_header_logo = url('assets/frontend').'/img/logo.png';
        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
            }
        }

        $pass_reset_link = url('reset-password/' . $user->pass_reset_token);
        

        $pass_reset_link = route('admin.reset.password', $random_no);

        $data_customer = array(
            'pass_reset_link' => $pass_reset_link,
            'user_data' => $user,
            'siteHeaderLogo' => $site_header_logo,
            'siteTitle' => $site_title
        );

        try {
            Log::info("User id:- ".$user->id);
            Log::info("User Email:- ".$email);
            // $email = 'sunny.tzinfotech@gmail.com';
            Mail::send('admin.email_template.forgot_password_email', $data_customer, function ($message) use ($user,$email) {
                $message->to($email)->subject('We received a password reset request');
            });

            if ($user->update()) {
                return redirect()->route('admin.login')->with("success", "Password Reset requested send successfully! Check your email.");
            } else {
                return back()->with('error', 'Something went wrong !!!');
            }

        } catch (Exception $exc) {
            return back()->with('error', 'Password not Reset, please try again!');
        }

        
    }

    public function resetPasswordRequest($token) {
        if (User::where('pass_reset_token', $token)->count()) {
            return view('admin.auth.reset_password', compact('token'));
        }
        return redirect()->route('admin.login')->with("error", "Your Reset Password Token has been expired!");
    }

    public function submitResetPassword(Request $request) {
        

        $request->validate([
            'new_password' => 'required|min:6|required_with:renew_password|same:renew_password',
            'renew_password' => 'required',
            'token' => 'required',
                ], [
            'new_password.required' => 'Please enter New Password',
            'new_password.min' => 'New Password must be minimum 6 characters',
            'renew_password.required' => 'Please enter Conform Password',
            'new_password.same' => 'New Password and Conform Password must be same',
            'token.required' => 'Your Request token not found',
        ]);
        

        $user = User::where('pass_reset_token', $request->token)->first();
        $user->password = Hash::make($request->new_password);
        $user->pass_reset_token = null;

        if ($user->update()) {
            return redirect()->route('admin.login')->with("success", "Your password has been reset successfully.");
        } else {
            return back()->with('error', 'Password not change, please try again.');
        }
    }

}
