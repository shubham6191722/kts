<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\RecruiterAssign;
use App\Models\ClientDetail;
use App\Models\SubCompany;
use App\Models\JobVacancy;
use App\Models\ScheduleTime;

use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;
use File;

class SubClientController extends Controller {

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

        $id = Auth::user()->id;
        $clientList = User::clientListForClient($id);
        return view('admin.subclient.index')->with('clientList',$clientList)->with('id',$id);
    }

    public function add() {
        return view('admin.subclient.add');

    }

    public function create(Request $request) {

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.unique' => 'The email address you have provided is already in use!',
            'password.required' => 'Please enter Password!',
            'password.min' => 'Password must be minimum 6 characters',
            'name.required' => 'Please enter Name!',
        ]);

        $email = CustomFunction::filter_input($request->email);
        $password = CustomFunction::filter_input($request->password);
        $name = CustomFunction::filter_input($request->name);
        $password_hash = Hash::make($password);

        $new_user = new User;
        $new_user->email = $email;
        $new_user->name = $name;
        $new_user->password = $password_hash;
        $new_user->status = '1';
        $new_user->email_confirm = '1';
        $new_user->role = 2;
        $new_user->email_key = null;
        $new_user->created_at = date('Y-m-d H:i:s');
        $new_user->created_user_id = $request->created_user_id;

        $siteSetting = SiteSetting::first();

        $site_title  = $site_header_logo = null;

        $company_logo = 0;
        $site_header_logo = url('assets/frontend').'/img/logo.png';
        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
            }
        }

        $company_full_data = User::clientData($request->created_user_id);

        if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
            $site_header_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
        }

        if ($new_user->save()) {
            $link = route('home.index');

            try {
                $emaildata = array(
                    'email' => $email,
                    'name' => $name,
                    'password' => $password,
                    'siteHeaderLogo' => $site_header_logo,
                    'company_logo' => $company_logo,
                    'siteTitle' => $site_title,
                    'link' => $link
                );
                $mail_sub = 'Welcome '.$name;
                Log::info("User id:- ".$new_user->id);
                Log::info("User Email:- ".$email);
                // $email = "sunny.tzinfotech@gmail.com";
                $mail_send = Mail::send('frontend.email_template.client_registration', $emaildata, function ($message) use ($email) {
                    $message->to($email)->subject('Welcome Re:Source ATS');
                });

                $start_time = "10:00";
                $end_time = "18:00";
                $data_for_time = '["10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00"]';

                $schedule_time = new ScheduleTime;
                $schedule_time->user_id = $new_user->id;
                $schedule_time->start_time = $start_time;
                $schedule_time->end_time = $end_time;
                $schedule_time->schedule_time = $data_for_time;
                $schedule_time->time_distance = 0;
                $schedule_time->save();

            } catch (\Exception $ex) {
                $id = $new_user->id;
                $delete_user = User::find($id)->delete();
                $delete_user = ClientDetail::where('client_id','=',$id)->delete();
                $error_msg = $ex->getMessage();
                return back()->with('error', 'Detail not saved and mail not send, please try again');
            }

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.clientList';

            return redirect()->route($route_name)->with('success', 'Sub Main Client added successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function edit($id) {

        $user_data = User::find($id);
        return view('admin.subclient.edit')->with('user_data',$user_data);
    }

    public function update(Request $request) {

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$request->id,
            'name' => 'required',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.unique' => 'The email address you have provided is already in use!',
        ]);

        $email = CustomFunction::filter_input($request->email);
        $name = CustomFunction::filter_input($request->name);

        if(isset($request->password) && !empty($request->password)){
            $password = CustomFunction::filter_input($request->password);
            $password_hash = Hash::make($password);
        }

        $new_user = new User;
        $new_user->email = $email;
        $new_user->name = $name;

        if(isset($request->password) && !empty($request->password)){
            $new_user->password = $password_hash;
        }
        $new_user->updated_at = date('Y-m-d H:i:s');

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.clientList';
            return redirect()->route($route_name)->with('success', 'Sub Main Client updated successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $new_user = User::find($request->id);
        $new_user->deleted_at = date('Y-m-d H:i:s');
        $new_user->status = 0;

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.clientList';

            return redirect()->route($route_name)->with('success', 'Sub Main Client delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
