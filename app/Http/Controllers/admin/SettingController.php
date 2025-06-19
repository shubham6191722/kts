<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\CustomFunction\CustomFunction;
use App\Models\SiteSetting;
use App\Models\ClientDetail;
use App\Models\User;
use App\Models\ScheduleTime;

class SettingController extends Controller {

    public function showSetting() {
        $siteSetting = SiteSetting::first();
        if ($siteSetting == null) {
            $siteSetting = new SiteSetting();
        }
        return view('admin.setting.index')->with('siteSetting', $siteSetting);
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|required_with:confirm_password|same:confirm_password|min:6',
            'confirm_password' => 'required',
                ], [
            'current_password.required' => 'Please enter Current Password',
            'new_password.required' => 'Please enter New Password',
            'new_password.min' => 'New Password must be minimum 6 characters',
            'new_password.same' => 'New Password and Confirm Password must be same',
            'confirm_password.required' => 'Please Re-enter New Password',
        ]);

        if (Hash::check($request->current_password, Auth::user()->password)) {
            Auth::user()->password = Hash::make($request->new_password);
            if (Auth::user()->save()) {
                return redirect()->back()->with("success", "Password changed successfully");
            }
            return back()->with('error', 'Password was not changed, please try again.');
        } else {
            return back()->with('error', 'Your current password is incorrect the password was not changed!');
        }
    }

    public function accountSetting(Request $request) {
        $request->validate([
            'fname' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,
                ], [
            'fname.required' => 'Please enter your Firstname!',
            'email.required' => 'Please enter your Email Address!'
        ]);

        Auth::user()->name = $request->fname;
        Auth::user()->email = $request->email;
        Auth::user()->phone = $request->phone;
        if(Auth::user()->role == 1){
            Auth::user()->company_name = $request->company_name;
        }

        if (Auth::user()->save()) {
            return redirect()->back()->with("success", "Your account has been updated");
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

    public function siteSetting(Request $request) {

        $request->validate([
            'site_title' => 'required',
            'site_notification_email' => 'required|email',
            'site_favicon_file' => 'nullable|mimes:jpg,jpeg,png|max:500',
            'site_header_logo_file' => 'nullable|mimes:jpg,jpeg,png|max:500',
                ], [
            'site_title.required' => 'Please enter Site Title!',
            'site_notification_email.required' => 'Please enter Notification Email!',
            'site_notification_email.email' => 'Notification Email enter in valide format!',
            'site_favicon_file.mimes' => 'Site Favicon allow only jpg and png file.',
            'site_favicon_file.max' => 'Site Favicon should be less than 500 KB.',
            'site_header_logo_file.mimes' => 'Site Header Logo allow only jpg and png file.',
            'site_header_logo_file.max' => 'Site Header Logo should be less than 500 KB.',
        ]);

        if ($request->hasFile('site_favicon_file')) {
            $file = $request->file('site_favicon_file');
            $fileName = CustomFunction::fileUpload($file, $request->site_favicon, '/site_setting/');
            $request->merge(['site_favicon' => $fileName]);
        }

        if ($request->hasFile('site_header_logo_file')) {
            $file = $request->file('site_header_logo_file');
            $fileName = CustomFunction::fileUpload($file, $request->site_header_logo, '/site_setting/');
            $request->merge(['site_header_logo' => $fileName]);
        }

        if ($request->hasFile('user_user_manual')) {
            $file = $request->file('user_user_manual');
            $fileName = CustomFunction::fileUpload($file, $request->user_manual, '/site_setting/');
            $request->merge(['user_manual' => $fileName]);
        }

        if ($request->hasFile('site_email_file')) {
            $file = $request->file('site_email_file');
            $fileName = CustomFunction::fileUpload($file, $request->user_manual, '/site_setting/');
            $request->merge(['site_email_logo' => $fileName]);
        }

        if ($request->hasFile('site_talent_file')) {
            $file = $request->file('site_talent_file');
            $fileName = CustomFunction::fileUpload($file, $request->user_manual, '/site_setting/');
            $request->merge(['site_talent_logo' => $fileName]);
        }

        $input = $request->all();
        unset($input['_token']);
        unset($input['site_header_logo_file']);
        unset($input['site_favicon_file']);
        unset($input['user_user_manual']);
        unset($input['site_talent_file']);
        if (SiteSetting::where('id','1')->update($input)) {
            return redirect()->back()->with("success", "Site Setting has been updated")->withInput($request->except('_token'));
        }
        return back()->with('error', 'Something went wrong, please try again!')->withInput($request->except('_token'));
    }

    public function footerSave(Request $request) {

        $logo = null;
        if ($request->hasFile('site_footer_logo_file')) {
            $file = $request->file('site_footer_logo_file');
            $fileName = CustomFunction::fileUpload($file, $request->site_favicon, '/site_setting/');
            $logo = $fileName;
        }else{
            if(isset($request->site_footer_logo) && !empty($request->site_footer_logo)){
                $logo = CustomFunction::filter_input($request->site_footer_logo);
            }
        }
        $footer_address = null;
        if(isset($request->footer_address) && !empty($request->footer_address)){
            $footer_address = $request->footer_address;
        }

        $footer_copy_text = null;
        if(isset($request->footer_copy_text) && !empty($request->footer_copy_text)){
            $footer_copy_text = CustomFunction::filter_input($request->footer_copy_text);
        }

        $site_setting = SiteSetting::find(1);
        $site_setting->footer_address = $footer_address;
        $site_setting->footer_copy_text = $footer_copy_text;
        $site_setting->site_footer_logo = $logo;

        if ($site_setting->save()) {
            return back()->with("success", "Site Setting has been updated")->withInput($request->except('_token'));
        }
        return back()->with('error', 'Something went wrong, please try again!')->withInput($request->except('_token'));
    }

    public function socialLink(Request $request) {

        $input = $request->all();
        $request->validate([
            'facebook_link' => 'required',
            'lnstagram_link' => 'required',
            'twitter_link' => 'required',
        ]);

        unset($input['_token']);
        if (SiteSetting::where('id','1')->update($input)) {
            return redirect()->back()->with("success", "Site Setting has been updated")->withInput($request->except('_token'));
        }
        return back()->with('error', 'Something went wrong, please try again!')->withInput($request->except('_token'));
    }

    public function clientProfile(Request $request) {

        $request->validate([
            'company_logo_file' => 'nullable|mimes:jpg,jpeg,png|max:500',
            'cover_image_file' => 'nullable|mimes:jpg,jpeg,png|max:500',
                ], [
            'company_logo_file.mimes' => 'Company Logo allow only jpg and png file.',
            'company_logo_file.max' => 'Company Logo should be less than 500 KB.',
            'cover_image_file.mimes' => 'Cover Image allow only jpg and png file.',
            'cover_image_file.max' => 'Cover Image should be less than 500 KB.',
        ]);

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

        $user_data = User::find($request->id);
        $user_data->company_logo = $company_logo;
        $user_data->cover_image = $cover_image;

        if ($user_data->save()) {
            return redirect()->back()->with("success", "Site Setting has been updated")->withInput($request->except('_token'));
        }
        return back()->with('error', 'Something went wrong, please try again!')->withInput($request->except('_token'));
    }

    public function clientJobDetailSetting(Request $request) {

        $request->validate([
            'id' => 'required',
            'border_color' => 'required',
            'background_color' => 'required',
            'background_text_color' => 'required',
            'button_color' => 'required',
            'button_text_color' => 'required',
                ], [
            'id.required' => 'Please reload and try again!',
            'border_color.required' => 'Please enter your border color!',
            'background_color.required' => 'Please enter your background color!',
            'background_text_color.required' => 'Please enter your background text color!',
            'button_color.required' => 'Please enter your button color!',
            'button_text_color.required' => 'Please enter your button text color!',
        ]);

        $client_detail = ClientDetail::getData($request->id);
        if(empty($client_detail)){
            $client_detail = new ClientDetail;
        }

        $client_detail->client_id = $request->id;
        $client_detail->border_color = $request->border_color;
        $client_detail->background_color = $request->background_color;
        $client_detail->background_text_color = $request->background_text_color;
        $client_detail->button_color = $request->button_color;
        $client_detail->button_text_color = $request->button_text_color;
        $client_detail->save();


        if ($client_detail->save()) {
            return redirect()->back()->with("success", "Job Detail Setting successfully updated")->withInput($request->except('_token'));
        }
        return back()->with('error', 'Something went wrong, please try again!')->withInput($request->except('_token'));
    }

    public function businessHoursSave(Request $request) {

        $request->validate([
            'id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            // 'time_distance' => 'required',
                ], [
            'id.required' => 'Please reload and try again!',
            'start_time.required' => 'Please select start time!',
            'end_time.required' => 'Please select end time!',
            // 'time_distance.required' => 'Please select time distance!',
        ]);

        $time_data_value = [];
        $time_data = ["01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00"];
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $time_distance = $request->time_distance;
        $id = $request->id;
        foreach($time_data as $key => $outlook_value){

            $needle = $time_data;
            $min = $start_time;
            $max = $end_time;

            $result  = array_filter($needle, function($v) use($min, $max) {
                return $v >= $min && $v <= $max;
            });
        }


        $count = count($result);
        foreach($result as $unkey => $outlook_key){
            array_push($time_data_value,$outlook_key);
        }

        unset($time_data_value[$count-1]);
        $data_for_time = @json_encode($time_data_value,TRUE);

        $check_data = ScheduleTime::findUserData($id);

        if(isset($check_data) && !empty($check_data)){
            $schedule_time = ScheduleTime::find($check_data->id);
        }else{
            $schedule_time = new ScheduleTime;
        }

        $schedule_time->user_id = $id;
        $schedule_time->start_time = $start_time;
        $schedule_time->end_time = $end_time;
        $schedule_time->schedule_time = $data_for_time;
        $schedule_time->time_distance = $time_distance;

        if ($schedule_time->save()) {
            return redirect()->back()->with("success", "Business Hours successfully updated");
        }
        return back()->with('error', 'Something went wrong, please try again!');
    }

}
