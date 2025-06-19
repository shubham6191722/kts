<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\RecruiterAssign;

use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;

class RecruiterController extends Controller {

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
            $id = Auth::user()->id;
            if(Auth::user()->role == 1){
                $recruiterList = User::recruiterListAll();
                return view('admin.recruiter.index')->with('recruiterList',$recruiterList);
            }elseif(Auth::user()->role == 2){
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $id = Auth::user()->created_user_id;
                }else{
                    $id = Auth::user()->id;
                }
                $recruiter_data = RecruiterAssign::getDataForCandidate($id);
                $recruiterList = null;
                if(isset($recruiter_data) && !empty($recruiter_data)){
                    $k = explode(",",$recruiter_data->client_assign_recruiter);
                    $recruiterList = User::whereIn('id', $k)->where('role', "=", 4)->where('deleted_at', "=", null)->orderBy('id', 'desc')->get();
                }
                return view('admin.recruiter.clientindex')->with('recruiterList',$recruiterList);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }


    }

    public function add() {

        return view('admin.recruiter.add');

    }

    public function create(Request $request) {

        if(Auth::check()){
            $id = Auth::user()->id;

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

            $company_name = CustomFunction::filter_input($request->company_name);
            $job_title = CustomFunction::filter_input($request->job_title);
            $recruitment_specialism = CustomFunction::filter_input($request->recruitment_specialism);


            $is_found_email = User::where('email', $email)->get()->count();
            if ($is_found_email > 0) {
                return back()->with('error', 'The email address you have provided is already in use')->withInput($request->except('password'));
            }


            $random_no = CustomFunction::random_string(10);
            $key = site_title;
            $new_key = $random_no . '#' . $key;
            $new_ket_encode = base64_encode($new_key);
            $confirm_url = route('front.verify.email', $new_ket_encode);

            $new_user = new User;
            $new_user->email = $email;
            $new_user->name = $name;
            $new_user->password = $password_hash;
            $new_user->status = '1';
            $new_user->email_confirm = '1';
            $new_user->role = 4;
            $new_user->email_key = null;
            $new_user->created_user_id = $id;
            $new_user->company_name = $company_name;
            $new_user->job_title = $job_title;
            $new_user->recruitment_specialism = $recruitment_specialism;
            $new_user->created_at = date('Y-m-d H:i:s');

            $siteSetting = SiteSetting::first();

            $site_title  = $site_header_logo = null;

            $site_header_logo = url('assets/frontend').'/img/logo.png';
            if (isset($siteSetting) && !empty($siteSetting)) {
                $site_title = $siteSetting->site_title;
                if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                    $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
                }
            }

            if ($new_user->save()) {
                
                $link = route('home.index');

                try {
                    $emaildata = array(
                        'email' => $email,
                        'confirm_url' => $confirm_url,
                        'name' => $name,
                        'password' => $password,
                        'siteHeaderLogo' => $site_header_logo,
                        'siteTitle' => $site_title,
                        'link' => $link,
                    );
                    Log::info("User id:- ".$new_user->id);
                    Log::info("User Email:- ".$email);
                    // $email = "sunny.tzinfotech@gmail.com";

                    Mail::send('frontend.email_template.client_registration', $emaildata, function ($message) use ($email) {
                        $message->to($email)->subject('Welcome Re:Source ATS');
                    });

                    $role_name = CustomFunction::role_name();

                    $route_name = $role_name.'.recruiterList';

                    return redirect()->route($route_name)->with('success', 'Recruiter added successfully.');

                } catch (\Exception $ex) {
                    $id = $new_user->id;
                    $delete_user = User::find($id)->delete();
                    $error_msg = $ex->getMessage();
                    return back()->with('error', 'Detail not saved and mail not send, please try again');

                }


            } else {
                return back()->with('error', 'Please try again!');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function edit($id) {

        $user_data = User::find($id);

        return view('admin.recruiter.edit')->with('user_data',$user_data);
    }

    public function update(Request $request) {

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$request->id,
            'name' => 'required',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.unique' => 'The email address you have provided is already in use!',
            'name.required' => 'Please enter Name!',
        ]);

        $email = CustomFunction::filter_input($request->email);
        $name = CustomFunction::filter_input($request->name);

        $company_name = CustomFunction::filter_input($request->company_name);
        $job_title = CustomFunction::filter_input($request->job_title);
        $recruitment_specialism = CustomFunction::filter_input($request->recruitment_specialism);


        if(isset($request->password) && !empty($request->password)){
            $password = CustomFunction::filter_input($request->password);
            $password_hash = Hash::make($password);
        }

        $new_user = User::find($request->id);
        $new_user->email = $email;
        $new_user->name = $name;
        $new_user->company_name = $company_name;
        $new_user->job_title = $job_title;
        $new_user->recruitment_specialism = $recruitment_specialism;
        if(isset($request->password) && !empty($request->password)){
            $new_user->password = $password_hash;
        }
        $new_user->updated_at = date('Y-m-d H:i:s');

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.recruiterList';
            return redirect()->route($route_name)->with('success', 'Recruiter updated successfully.');
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

            $route_name = $role_name.'.recruiterList';

            return redirect()->route($route_name)->with('success', 'Recruiter delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
