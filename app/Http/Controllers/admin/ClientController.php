<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\CustomFunction\CustomFunction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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

class ClientController extends Controller {

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

        $clientList = User::clientList();
        return view('admin.client.index')->with('clientList',$clientList);
    }

    public function add() {
        $recruiterList = User::recruiterListAll();
        return view('admin.client.add')->with('recruiterList',$recruiterList);

    }

    public function create(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            'jobtitle' => 'required',
            'company' => 'required|unique:users,company_name',
            'address' => 'required',
            'phone' => 'required',
            'policy_url' => 'required',
            'border_color' => 'required',
            'background_color' => 'required',
            'background_text_color' => 'required',
            'button_color' => 'required',
            'button_text_color' => 'required',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.unique' => 'The email address you have provided is already in use!',
            'password.required' => 'Please enter Password!',
            'password.min' => 'Password must be minimum 6 characters',
            'name.required' => 'Please enter Name!',
            'jobtitle.required' => 'Please enter job title!',
            'company.required' => 'Please enter company name!',
            'address.required' => 'Please enter Registered company address!',
            'phone.required' => 'Please enter Registered company number!',
            'policy_url.required' => 'Please enter Registered privacy policy(URL)!',
            'border_color.required' => 'Please enter your border color!',
            'background_color.required' => 'Please enter your background color!',
            'background_text_color.required' => 'Please enter your background text color!',
            'button_color.required' => 'Please enter your button color!',
            'button_text_color.required' => 'Please enter your button text color!',
        ]);

        $offer_status = null;
        if($request->offer_status == 'on'){
            $offer_status = '1';
        }else{
            $offer_status = '0';
        }

        $company_logo = $cover_image = null;
        if ($request->hasFile('company_logo_file')) {
            $file = $request->file('company_logo_file');
            $fileName = CustomFunction::fileUpload($file, $request->company_logo, '/client_profile');
            $request->merge(['company_logo_file' => $fileName]);
            $company_logo = $fileName;
        }else{
            $company_logo = $request->company_logo;
        }

        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = CustomFunction::fileUpload($file, $request->cover_image, '/client_profile');
            $cover_image = $fileName;
        }

        $email = CustomFunction::filter_input($request->email);
        $password = CustomFunction::filter_input($request->password);
        $name = CustomFunction::filter_input($request->name);
        $password_hash = Hash::make($password);

        $address = CustomFunction::filter_input($request->address);
        $phone = CustomFunction::filter_input($request->phone);
        $policy_url = CustomFunction::filter_input($request->policy_url);

        $event_time_slot_select = $request->event_time_slot_select;


        $is_found_email = User::where('email', $email)->get()->count();
        if ($is_found_email > 0) {
            return back()->with('error', 'The email address you have provided is already in use')->withInput($request->except('password'));
        }

        $video_name = null;

        if ($request->hasFile('video_file')) {

            $file = $request->file('video_file');

            $random_no = CustomFunction::random_string(3);

            $fileName = $file->getClientOriginalName();
            $folder = substr($fileName, 0, strpos($fileName, '.'));
            $string = str_replace(' ', '-', $folder);
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

            $video_name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();
            $folderName = '/client_profile/';

            $file->move('uploads' . $folderName, $video_name);
        }

        $random_no = CustomFunction::random_string(10);
        $key = site_title;
        $new_key = $random_no . '#' . $key;
        $new_ket_encode = base64_encode($new_key);
        $confirm_url = route('front.verify.email', $new_ket_encode);

        $company = CustomFunction::string_to_slug($request->company);
        $slug = CustomFunction::string_to_slug($company);

        $new_user = new User;
        $new_user->email = $email;
        $new_user->name = $name;
        $new_user->password = $password_hash;
        $new_user->company_name = $request->company;
        $new_user->job_title = $request->jobtitle;
        $new_user->status = '1';
        $new_user->email_confirm = '1';
        $new_user->role = 2;
        $new_user->email_key = null;
        $new_user->created_at = date('Y-m-d H:i:s');
        $new_user->company_credits = $request->credits;
        $new_user->client_slug = $slug;
        $new_user->address = $address;
        $new_user->phone = $phone;
        $new_user->policy_url = $policy_url;
        $new_user->company_credits = 0;
        $new_user->company_logo = $company_logo;
        $new_user->cover_image = $cover_image;
        $new_user->offer_status = $offer_status;
        $new_user->event_time_slot_select = $event_time_slot_select;

        $recruiter_arr = null;
        if($request->recruiter_select){
            $recruiter_arr = implode(',', $request->recruiter_select);
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

        if ($new_user->save()) {
            $client_detail = new ClientDetail;
            $client_detail->client_id = $new_user->id;
            $client_detail->about = $request->about;
            $client_detail->facebook_url = $request->facebook_url;
            $client_detail->linkedin_url = $request->linkedin_url;
            $client_detail->youtube_url = $request->youtube_url;
            $client_detail->instagram_url = $request->instagram_url;
            $client_detail->twitter_url = $request->twitter_url;
            $client_detail->video = $video_name;
            $client_detail->border_color = $request->border_color;
            $client_detail->background_color = $request->background_color;
            $client_detail->background_text_color = $request->background_text_color;
            $client_detail->button_color = $request->button_color;
            $client_detail->button_text_color = $request->button_text_color;

            $client_detail->save();

            $link = route('home.index');

            try {
                $emaildata = array(
                    'email' => $email,
                    'confirm_url' => $confirm_url,
                    'name' => $name,
                    'password' => $password,
                    'siteHeaderLogo' => $site_header_logo,
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

                if(isset($recruiter_arr) && !empty($recruiter_arr)){
                  $recruiter_assign = new RecruiterAssign;
                  $recruiter_assign->client_id = $new_user->id;
                  $recruiter_assign->client_assign_recruiter = $recruiter_arr;
                  $recruiter_assign->save();
                }

                $folderName = '/job_vacancy/'.$new_user->id;
                File::makeDirectory(url('uploads').$folderName, 0777, true, true);

            } catch (\Exception $ex) {
                $id = $new_user->id;
                $delete_user = User::find($id)->delete();
                $delete_user = ClientDetail::where('client_id','=',$id)->delete();
                $error_msg = $ex->getMessage();
                return back()->with('error', 'Detail not saved and mail not send, please try again');

            }

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.clientList';

            return redirect()->route($route_name)->with('success', 'Client added successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function edit($id) {

        $user_data = User::find($id);
        $recruiterList = User::recruiterListAll();
        $recruiter_assign = RecruiterAssign::getDataForCandidate($id);

        $client_detail = ClientDetail::getData($id);
        $client_assign_recruiter = null;
        if(isset($recruiter_assign) && !empty($recruiter_assign)){
            $client_assign_recruiter = $recruiter_assign->client_assign_recruiter;
        }
        return view('admin.client.edit')->with('user_data',$user_data)->with('recruiterList',$recruiterList)
                                        ->with('client_assign_recruiter',$client_assign_recruiter)->with('client_detail',$client_detail);
    }

    public function update(Request $request) {

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$request->id,
            'name' => 'required',
            'jobtitle' => 'required',
            'company' => 'required|unique:users,company_name,'.$request->id,
            'video_file' => 'mimes:mp4,ogx,oga,ogv,ogg,webm|max:10240',
            'border_color' => 'required',
            'background_color' => 'required',
            'background_text_color' => 'required',
            'button_color' => 'required',
            'button_text_color' => 'required',
                ], [
            'email.required' => 'Please enter Email Address!',
            'email.email' => 'Please enter valid Email Address!',
            'email.unique' => 'The email address you have provided is already in use!',
            'name.required' => 'Please enter Name!',
            'jobtitle.required' => 'Please enter job title!',
            'company.required' => 'Please enter company name!',
            'video_file.required' => 'File too Big, please select a file less than 10mb!',
            'border_color.required' => 'Please enter your border color!',
            'background_color.required' => 'Please enter your background color!',
            'background_text_color.required' => 'Please enter your background text color!',
            'button_color.required' => 'Please enter your button color!',
            'button_text_color.required' => 'Please enter your button text color!',
        ]);

        $offer_status = null;
        if($request->offer_status == 'on'){
            $offer_status = '1';
        }else{
            $offer_status = '0';
        }

        $company_logo = $cover_image = null;
        if ($request->hasFile('company_logo_file')) {
            $file = $request->file('company_logo_file');
            $fileName = CustomFunction::fileUpload($file, $request->company_logo, '/client_profile');
            $request->merge(['company_logo_file' => $fileName]);
            $company_logo = $fileName;
        }else{
            $company_logo = $request->company_logo;
        }

        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = CustomFunction::fileUpload($file, $request->cover_image, '/client_profile');
            $cover_image = $fileName;
        }else{
            $cover_image = $request->cover_image;
        }

        $email = CustomFunction::filter_input($request->email);
        $name = CustomFunction::filter_input($request->name);

        $address = CustomFunction::filter_input($request->address);
        $phone = CustomFunction::filter_input($request->phone);
        $policy_url = CustomFunction::filter_input($request->policy_url);

        $event_time_slot_select = $request->event_time_slot_select;

        if(isset($request->password) && !empty($request->password)){
            $password = CustomFunction::filter_input($request->password);
            $password_hash = Hash::make($password);
        }

        $company = CustomFunction::string_to_slug($request->company);
        $slug = CustomFunction::string_to_slug($company);

        $new_user = User::find($request->id);
        $new_user->email = $email;
        $new_user->name = $name;
        if(isset($request->password) && !empty($request->password)){
            $new_user->password = $password_hash;
        }
        $new_user->company_name = $request->company;
        $new_user->job_title = $request->jobtitle;
        $new_user->updated_at = date('Y-m-d H:i:s');
        $new_user->client_slug = $slug;
        $new_user->address = $address;
        $new_user->phone = $phone;
        $new_user->policy_url = $policy_url;
        $new_user->company_logo = $company_logo;
        $new_user->cover_image = $cover_image;
        $new_user->offer_status = $offer_status;
        $new_user->event_time_slot_select = $event_time_slot_select;

        $recruiter_arr = null;
        if($request->recruiter_select){
            $recruiter_arr = implode(',', $request->recruiter_select);
        }

        $recruiter_data = RecruiterAssign::where('client_id','=',$request->id)->first();

        if(isset($recruiter_data) && !empty($recruiter_data)){
            $recruiter_assign = RecruiterAssign::find($recruiter_data->id);
        }else{
            $recruiter_assign = new RecruiterAssign;
        }

        if(isset($recruiter_arr) && !empty($recruiter_arr)){
            $recruiter_assign->client_id = $request->id;
            $recruiter_assign->client_assign_recruiter = $recruiter_arr;
            $recruiter_assign->save();
        }

        $video_name = null;

        if ($request->hasFile('video_file')) {

            $file = $request->file('video_file');

            $random_no = CustomFunction::random_string(3);

            $fileName = $file->getClientOriginalName();
            $folder = substr($fileName, 0, strpos($fileName, '.'));
            $string = str_replace(' ', '-', $folder);
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

            $video_name = $string.'-'.$random_no . '.' . $file->getClientOriginalExtension();
            $folderName = '/client_profile/';


            $file->move('uploads' . $folderName, $video_name);

            if(isset($request->video) && !empty($request->video)){
                $old_video = $request->video;
                $old_file = url('uploads') . $folderName . '/' . $old_video;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
        }else{
            $video_name = $request->video;
        }

        $client_detail = ClientDetail::getData($request->id);
        if(empty($client_detail)){
            $client_detail = new ClientDetail;
        }

        $client_detail->client_id = $request->id;
        $client_detail->about = $request->about;
        $client_detail->facebook_url = $request->facebook_url;
        $client_detail->linkedin_url = $request->linkedin_url;
        $client_detail->youtube_url = $request->youtube_url;
        $client_detail->instagram_url = $request->instagram_url;
        $client_detail->twitter_url = $request->twitter_url;
        $client_detail->video = $video_name;
        $client_detail->border_color = $request->border_color;
        $client_detail->background_color = $request->background_color;
        $client_detail->background_text_color = $request->background_text_color;
        $client_detail->button_color = $request->button_color;
        $client_detail->button_text_color = $request->button_text_color;
        $client_detail->save();

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.clientList';
            return redirect()->route($route_name)->with('success', 'Client updated successfully.');
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

        JobVacancy::where('user_select','=',$request->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        User::where('created_user_id','=',$request->id)->update(['deleted_at' => date('Y-m-d H:i:s'),'status' => 0]);
        RecruiterAssign::where('client_id','=',$request->id)->delete();

        $new_user = User::find($request->id);
        $new_user->deleted_at = date('Y-m-d H:i:s');
        $new_user->status = 0;

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.clientList';

            return redirect()->route($route_name)->with('success', 'Client delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }


    public function membershipEdit($id) {

        $user_data = User::find($id);
        return view('admin.client.membership')->with('user_data',$user_data);
    }

    public function membershipUpdate(Request $request) {

        $request->validate([
            'sub_model' => 'required',
            'sub_created' => 'required',
            'sub_expires' => 'required',
            'sub_cost' => 'required',
            'sub_payment_terms' => 'required',
            'credits' => 'required',
            'credits_expire' => 'required',
                ], [
            'sub_model.required' => 'Please enter Subscription Model!',
            'sub_created.required' => 'Please enter Subscription Created!',
            'sub_expires.required' => 'Please enter Subscription Expires!',
            'sub_cost.required' => 'Please enter Subscription Cost!',
            'sub_payment_terms.required' => 'Please enter Payment Terms!',
            'credits.required' => 'Please enter Credits!',
            'credits_expire.required' => 'Please enter Credits Expire!',
        ]);

        $sub_model = CustomFunction::filter_input($request->sub_model);

        $sub_created = $request->sub_created;
        $startdate = date('Y-m-d', strtotime($sub_created));
        $sub_created_date = Carbon::createFromFormat('Y-m-d', $startdate)->format('Y-m-d');

        $sub_expires = CustomFunction::filter_input($request->sub_expires);
        $estartdate = date('Y-m-d', strtotime($sub_expires));
        $sub_expires_date = Carbon::createFromFormat('Y-m-d', $estartdate)->format('Y-m-d');

        $sub_cost = $request->sub_cost;
        $sub_payment_terms = CustomFunction::filter_input($request->sub_payment_terms);
        $credits = CustomFunction::filter_input($request->credits);

        $credits_expire = $request->credits_expire;
        $cstartdate = date('Y-m-d', strtotime($credits_expire));
        $credits_expire_date = Carbon::createFromFormat('Y-m-d', $cstartdate)->format('Y-m-d');

        $new_user = User::find($request->id);
        $new_user->sub_model = $sub_model;
        $new_user->sub_created = $sub_created_date;
        $new_user->sub_expires = $sub_expires_date;
        $new_user->sub_cost = $sub_cost;
        $new_user->sub_payment_terms = $sub_payment_terms;
        $new_user->company_credits = $credits;
        $new_user->credits_expire = $credits_expire_date;

        if ($new_user->save()) {
            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.clientList';
            return redirect()->route($route_name)->with('success', 'Client updated successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function addSubCompany(Request $request) {

        $client_data = User::clientJobVacancy();
        return view('admin.client.sub_client_company.add')->with('client_data',$client_data);

    }

    public function createSubCompany(Request $request) {

        $request->validate([
            'client_id' => 'required',
            'company_name' => 'required|unique:sub_company,company_name',
            'border_color' => 'required',
            'background_color' => 'required',
            'background_text_color' => 'required',
            'button_color' => 'required',
            'button_text_color' => 'required',

            'company_logo_file' => 'required|mimes:jpg,jpeg,png|max:500',
        ], [
            'client_id.required' => 'Please Select client!',
            'company_name.required' => 'Please enter company name!',
            'company_name.unique' => 'The company name is already in use!',
            'border_color.required' => 'Please enter your border color!',
            'background_color.required' => 'Please enter your background color!',
            'background_text_color.required' => 'Please enter your background text color!',
            'button_color.required' => 'Please enter your button color!',
            'button_text_color.required' => 'Please enter your button text color!',

            'company_logo_file.required' => 'Please select company logo!',
            'company_logo_file.mimes' => 'Company Logo allow only jpg and png file.',
            'company_logo_file.max' => 'Company Logo should be less than 500 KB.',

            'cover_image_file.required' => 'Please select cover image!',
            'cover_image_file.mimes' => 'Cover Image allow only jpg and png file.',
            'cover_image_file.max' => 'Cover Image should be less than 500 KB.',
        ]);

        $company_logo = $cover_image = null;
        if ($request->hasFile('company_logo_file')) {
            $fileName = null;
            $file = $request->file('company_logo_file');
            $fileName = CustomFunction::fileUpload($file, null, '/client_profile');
            $company_logo = $fileName;
        }

        if ($request->hasFile('cover_image_file')) {
            $fileName = null;
            $file = $request->file('cover_image_file');
            $fileName = CustomFunction::fileUpload($file, null, '/client_profile');
            $cover_image = $fileName;
        }

        $benefits_image_name = $video_name = null;

        if ($request->hasFile('video_file')) {
            $fileName = null;
            $file = $request->file('video_file');
            $fileName = CustomFunction::fileUpload($file, null, '/client_profile');
            $video_name = $fileName;
        }

        $sub_client_detail = new SubCompany;
        $sub_client_detail->client_id = $request->client_id;
        $sub_client_detail->company_name = $request->company_name;
        $sub_client_detail->benefits_image = $benefits_image_name;
        $sub_client_detail->about = $request->about;
        $sub_client_detail->facebook_url = $request->facebook_url;
        $sub_client_detail->linkedin_url = $request->linkedin_url;
        $sub_client_detail->youtube_url = $request->youtube_url;
        $sub_client_detail->instagram_url = $request->instagram_url;
        $sub_client_detail->twitter_url = $request->twitter_url;
        $sub_client_detail->video = $video_name;
        $sub_client_detail->border_color = $request->border_color;
        $sub_client_detail->background_color = $request->background_color;
        $sub_client_detail->background_text_color = $request->background_text_color;
        $sub_client_detail->button_color = $request->button_color;
        $sub_client_detail->button_text_color = $request->button_text_color;
        $sub_client_detail->cover_image = $cover_image;
        $sub_client_detail->company_logo = $company_logo;

        if($sub_client_detail->save()){

            $role_name = CustomFunction::role_name();
            $route_name = $role_name.'.editSubCompany';

            return redirect()->route($route_name,['id' => $request->client_id])->with('success', 'Sub Company added successfully.');

        }else {
            return back()->with('error', 'Please try again!');
        }

    }

    public function editSubCompany($id) {

        $sub_company_data = SubCompany::getSubCompany($id);
        $clientName = User::getUserName($id);
        $clientCompany = User::clientCompany($id);

        return view('admin.client.sub_client_company.index')->with('sub_company_data',$sub_company_data)->with('clientName',$clientName)->with('clientCompany',$clientCompany);
    }

    public function updateSubCompany(Request $request) {
        $id = $request->id;
        $request->validate([
            'client_id' => 'required',
            'company_name' => 'required|unique:sub_company,company_name,' .$id,
            'border_color' => 'required',
            'background_color' => 'required',
            'background_text_color' => 'required',
            'button_color' => 'required',
            'button_text_color' => 'required',

            'company_logo_file' => 'nullable|mimes:jpg,jpeg,png|max:500',
        ], [
            'client_id.required' => 'Please Select client!',
            'company_name.required' => 'Please enter company name!',
            'company_name.unique' => 'The company name is already in use!',
            'border_color.required' => 'Please enter your border color!',
            'background_color.required' => 'Please enter your background color!',
            'background_text_color.required' => 'Please enter your background text color!',
            'button_color.required' => 'Please enter your button color!',
            'button_text_color.required' => 'Please enter your button text color!',

            'company_logo_file.required' => 'Please select company logo!',
            'company_logo_file.mimes' => 'Company logo allow only jpg and png file.',
            'company_logo_file.max' => 'Company logo should be less than 500 KB.',

            'cover_image_file.required' => 'Please select cover image!',
            'cover_image_file.mimes' => 'Cover Image allow only jpg and png file.',
            'cover_image_file.max' => 'Cover Image should be less than 500 KB.',

        ]);

        $company_logo = $cover_image = null;
        if ($request->hasFile('company_logo_file')) {
            $fileName = null;
            $file = $request->file('company_logo_file');
            $fileName = CustomFunction::fileUpload($file, $request->company_logo, '/client_profile');
            $company_logo = $fileName;
        }else{
            $company_logo = $request->company_logo;
        }

        if ($request->hasFile('cover_image_file')) {
            $fileName = null;
            $file = $request->file('cover_image_file');
            $fileName = CustomFunction::fileUpload($file, $request->cover_image, '/client_profile');
            $cover_image = $fileName;
        }else{
            $cover_image = $request->cover_image;
        }

        $benefits_image_name = $video_name = null;

        if ($request->hasFile('video_file')) {
            $fileName = null;
            $file = $request->file('video_file');
            $fileName = CustomFunction::fileUpload($file, $request->video, '/client_profile');
            $video_name = $fileName;
        }else{
            $video_name = $request->video;
        }

        $sub_client_detail = SubCompany::find($id);
        $sub_client_detail->client_id = $request->client_id;
        $sub_client_detail->company_name = $request->company_name;
        $sub_client_detail->benefits_image = $benefits_image_name;
        $sub_client_detail->about = $request->about;
        $sub_client_detail->facebook_url = $request->facebook_url;
        $sub_client_detail->linkedin_url = $request->linkedin_url;
        $sub_client_detail->youtube_url = $request->youtube_url;
        $sub_client_detail->instagram_url = $request->instagram_url;
        $sub_client_detail->twitter_url = $request->twitter_url;
        $sub_client_detail->video = $video_name;
        $sub_client_detail->border_color = $request->border_color;
        $sub_client_detail->background_color = $request->background_color;
        $sub_client_detail->background_text_color = $request->background_text_color;
        $sub_client_detail->button_color = $request->button_color;
        $sub_client_detail->button_text_color = $request->button_text_color;
        $sub_client_detail->cover_image = $cover_image;
        $sub_client_detail->company_logo = $company_logo;

        if($sub_client_detail->save()){

            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.editSubCompany';

            return redirect()->route($route_name,['id' => $request->client_id])->with('success', 'Sub Company updated successfully.');

        }else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function editSubCompanyClient($id) {

        $data = SubCompany::find($id);
        $client_data = User::clientJobVacancy();

        return view('admin.client.sub_client_company.edit')->with('data',$data)->with('client_data',$client_data);
    }

    public function deleteSubCompany(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $sub_client_detail = SubCompany::find($request->id);
        $sub_client_detail->deleted_at = date('Y-m-d H:i:s');

        $JobVacancy = JobVacancy::where('sub_company','=',$request->id)->update(['sub_company' => null]);

        if ($sub_client_detail->save()) {
            $role_name = CustomFunction::role_name();

            $route_name = $role_name.'.clientList';

            return redirect()->route($route_name)->with('success', 'Sub Company delete successfully.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

}
