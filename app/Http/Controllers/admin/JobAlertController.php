<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\CustomFunction\CustomFunction;

use App\Models\JobEvent;
use App\Models\SiteSetting;


class JobAlertController extends Controller {

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
            if(Auth::user()->role == 1){
                $siteSettingData = SiteSetting::where('site_title','=','candidateJobAlert')->first();
                $siteSetting = null;
                if(isset($siteSettingData) && !empty($siteSettingData)){
                    $siteSetting = $siteSettingData;
                }
                return view('admin.job_alert.index')->with('siteSetting',$siteSetting);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request) {

        $request->validate([
            'site_favicon' => 'required|max:255',
            'site_notification_email' => 'required',
                ], [
            'site_favicon.required' => 'Please enter email subject.',
            'site_favicon.max' => 'Email subject allow 255 later.',
            'site_notification_email.max' => 'Please enter email Description.',
        ]);
        
        $site_favicon = CustomFunction::filter_input($request->site_favicon);
        $email_description = CustomFunction::remove_html_tags($request->site_notification_email, array('script','iframe','small','span','br'));
        $email_description = CustomFunction::filter_input($email_description);

        if(isset($request->id) && !empty($request->id)){
            $siteSettingData = SiteSetting::find($request->id);
            $msg = 'candidate mail template successfully added.';
        }else{
            $siteSettingData = New SiteSetting;
            $msg = 'candidate mail template successfully updated.';
        }

        $siteSettingData->site_favicon = $site_favicon;
        $siteSettingData->site_notification_email = $email_description;
        $siteSettingData->site_title = 'candidateJobAlert';
        $siteSettingData->save();
        return back()->with('success', $msg);
    }

    public function termsCondition(){

        if(Auth::check()){
            if(Auth::user()->role == 1){
                $siteSettingData = SiteSetting::where('site_title','=','termsCondition')->first();
                $siteSetting = null;
                if(isset($siteSettingData) && !empty($siteSettingData)){
                    $siteSetting = $siteSettingData;
                }
                return view('admin.job_alert.terms_condition')->with('siteSetting',$siteSetting);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function termsConditionCreate(Request $request) {

        $request->validate([
            'site_favicon' => 'required|max:255',
            'site_notification_email' => 'required',
                ], [
            'site_favicon.required' => 'Please enter Title.',
            'site_favicon.max' => 'Email subject allow 255 later.',
            'site_notification_email.max' => 'Please enter Description.',
            'site_notification_email.required' => 'Please enter Description.',
        ]);
        
        $site_favicon = CustomFunction::filter_input($request->site_favicon);
        $email_description = $request->site_notification_email;
        $email_description = CustomFunction::filter_input($email_description);

        if(isset($request->id) && !empty($request->id)){
            $siteSettingData = SiteSetting::find($request->id);
            $msg = 'Terms and Condition template successfully added.';
        }else{
            $siteSettingData = New SiteSetting;
            $msg = 'Terms and Condition template successfully updated.';
        }

        $siteSettingData->site_favicon = $site_favicon;
        $siteSettingData->site_notification_email = $email_description;
        $siteSettingData->site_title = 'termsCondition';
        $siteSettingData->save();
        return back()->with('success', $msg);
    }
    
    public function offlineCandidate(){

        if(Auth::check()){
            if(Auth::user()->role == 1){
                $siteSettingData = SiteSetting::where('site_title','=','offlineCandidate')->first();
                $siteSetting = null;
                if(isset($siteSettingData) && !empty($siteSettingData)){
                    $siteSetting = $siteSettingData;
                }
                return view('admin.job_alert.offline_candidate')->with('siteSetting',$siteSetting);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function offlineCandidateSave(Request $request) {

        $request->validate([
            'site_favicon' => 'required|max:255',
            'site_notification_email' => 'required',
                ], [
            'site_favicon.required' => 'Please enter Title.',
            'site_favicon.max' => 'Email subject allow 255 later.',
            'site_notification_email.max' => 'Please enter Description.',
            'site_notification_email.required' => 'Please enter Description.',
        ]);
        
        $site_favicon = CustomFunction::filter_input($request->site_favicon);
        $email_description = CustomFunction::remove_html_tags($request->site_notification_email, array('script','iframe','small','span','br'));
        $email_description = CustomFunction::filter_input($email_description);

        if(isset($request->id) && !empty($request->id)){
            $siteSettingData = SiteSetting::find($request->id);
            $msg = 'Offline Candidate template successfully added.';
        }else{
            $siteSettingData = New SiteSetting;
            $msg = 'Offline Candidate template successfully updated.';
        }

        $siteSettingData->site_favicon = $site_favicon;
        $siteSettingData->site_notification_email = $email_description;
        $siteSettingData->site_title = 'offlineCandidate';
        $siteSettingData->save();
        return back()->with('success', $msg);
    }


    public function privacyPolicy(){

        if(Auth::check()){
            if(Auth::user()->role == 1){
                $siteSettingData = SiteSetting::where('site_title','=','privacyPolicy')->first();
                $siteSetting = null;
                if(isset($siteSettingData) && !empty($siteSettingData)){
                    $siteSetting = $siteSettingData;
                }
                return view('admin.job_alert.privacy_policy')->with('siteSetting',$siteSetting);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function privacyPolicyCreate(Request $request) {

        $request->validate([
            'site_favicon' => 'required|max:255',
            'site_notification_email' => 'required',
                ], [
            'site_favicon.required' => 'Please enter Title.',
            'site_favicon.max' => 'Email subject allow 255 later.',
            'site_notification_email.max' => 'Please enter Description.',
            'site_notification_email.required' => 'Please enter Description.',
        ]);
        
        $site_favicon = CustomFunction::filter_input($request->site_favicon);
        $email_description = $request->site_notification_email;
        $email_description = CustomFunction::filter_input($email_description);

        if(isset($request->id) && !empty($request->id)){
            $siteSettingData = SiteSetting::find($request->id);
            $msg = 'Privacy Policy template successfully added.';
        }else{
            $siteSettingData = New SiteSetting;
            $msg = 'Privacy Policy template successfully updated.';
        }

        $siteSettingData->site_favicon = $site_favicon;
        $siteSettingData->site_notification_email = $email_description;
        $siteSettingData->site_title = 'privacyPolicy';
        $siteSettingData->save();
        return back()->with('success', $msg);
    }

    public function getGDPR(){

        if(Auth::check()){
            if(Auth::user()->role == 1){
                $siteSettingData = SiteSetting::where('site_title','=','gdpr')->first();
                $siteSetting = null;
                if(isset($siteSettingData) && !empty($siteSettingData)){
                    $siteSetting = $siteSettingData;
                }
                return view('admin.job_alert.gdpr')->with('siteSetting',$siteSetting);
            }else{
                return redirect()->route('home.index');
            }
        }else{
            return redirect()->route('home.index');
        }

    }

    public function getGDPRCreate(Request $request) {

        $request->validate([
            'site_favicon' => 'required|max:255',
            'site_notification_email' => 'required',
                ], [
            'site_favicon.required' => 'Please enter Title.',
            'site_favicon.max' => 'Email subject allow 255 later.',
            'site_notification_email.max' => 'Please enter Description.',
            'site_notification_email.required' => 'Please enter Description.',
        ]);
        
        $site_favicon = CustomFunction::filter_input($request->site_favicon);
        $email_description = $request->site_notification_email;
        $email_description = CustomFunction::filter_input($email_description);

        if(isset($request->id) && !empty($request->id)){
            $siteSettingData = SiteSetting::find($request->id);
            $msg = 'GDPR template successfully added.';
        }else{
            $siteSettingData = New SiteSetting;
            $msg = 'GDPR template successfully updated.';
        }

        $siteSettingData->site_favicon = $site_favicon;
        $siteSettingData->site_notification_email = $email_description;
        $siteSettingData->site_title = 'gdpr';
        $siteSettingData->save();
        return back()->with('success', $msg);
    }

}
