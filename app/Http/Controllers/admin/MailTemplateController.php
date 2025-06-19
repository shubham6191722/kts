<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\CustomFunction\CustomFunction;
use Config;
use Mail;

use App\Models\MailTemplate;
use App\Models\Media;
use App\Models\User;
use App\Models\JobActivity;
use App\Models\JobVacancy;
use App\Models\NotificationsMailTemplate;
use App\Models\RecruiterCandidate;
use App\Models\SubCompany;
use App\Models\SiteSetting;

class MailTemplateController extends Controller {

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

        if(Auth::check()){
            
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }

            if(Auth::user()->role == 1){
                $id = Auth::user()->id;
                $mail_template = MailTemplate::getAll($id);
                $check_sub_company = true;
            }else{
                $mail_template = MailTemplate::getClientDataAll($id);
                $check_sub_company = false;
                $cub_company_data = SubCompany::getSubCompany($id);
                if(isset($cub_company_data) && !empty($cub_company_data) && count($cub_company_data)){
                    $check_sub_company = true;
                }
            }
            return view('admin.mail_template.index')->with('mail_template',$mail_template)->with('check_sub_company',$check_sub_company);
        }else{
            return redirect()->route('home.index');
        }
       
    }
    
    public function add() {

        if(Auth::check()){
            if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                $id = Auth::user()->created_user_id;
            }else{
                $id = Auth::user()->id;
            }
            $media_image = Media::getImage($id);
            $sub_company = null;
            $sub_company = SubCompany::getSubCompany($id);
            return view('admin.mail_template.add')->with('id',$id)->with('media_image',$media_image)->with('sub_company',$sub_company);
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function create(Request $request){

        if(Auth::check()){
            $request->validate([
                'template_title' => 'required|max:255',
                'email_subject' => 'nullable|max:255',
                    ], [
                'template_title.required' => 'Please enter template title.',
                'template_title.max' => 'Template title allow 255 later.',
                'template_title.unique' => 'Template Title is already exists.',
                'email_subject.max' => 'Email subject allow 255 later.',
            ]);

            $template_title = CustomFunction::filter_input($request->template_title);
            $email_subject = CustomFunction::filter_input($request->email_subject);
            $email_description = CustomFunction::remove_html_tags($request->email_description, array('script','iframe','small','span','br'));
            $email_description = CustomFunction::filter_input($email_description);
            $client_id = $request->client_id;
            $sub_company = $request->sub_company;

            $user_id = Auth::user()->id;
            $folderName = 'job_vacancy/';
            $folderPath = $request->client_id;
            $folderPath = '';

            $cover_image = null;
            if($request->logo_manager == 'media'){
                $cover_image = $request->logo_file_file_value;
            }else{
                if ($request->hasFile('logo_file')) {
                    $file = $request->file('logo_file');
                    $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                    $cover_image = $fileName['name'];

                    $file_name = $fileName['name'];
                    $file_type = $fileName['extension'];

                    $media = new Media;
                    $media->user_id = $user_id;
                    $media->file_name = $file_name;
                    $media->file_type = $file_type;
                    $media->save();
                }
            }

            $mail_template = new MailTemplate;
            $mail_template->template_title = $template_title;
            $mail_template->email_subject = $email_subject;
            $mail_template->email_description = $email_description;
            $mail_template->client_id = $client_id;
            $mail_template->created_at = date('Y-m-d H:i:s');
            $mail_template->cover_image = $cover_image;
            $mail_template->sub_company = $sub_company;

            if ($mail_template->save()) {
                
                $role_name = CustomFunction::role_name();
    
                $route_name = $role_name.'.emailTemplateList';
                return redirect()->route($route_name)->with('success', 'Template added successfully.');

            } else {
                return back()->with('error', 'Something went wrong !!!');
            }
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function edit($id) {

        if(Auth::check()){
            if($id){
                $mail_template = MailTemplate::find($id);
                $media_image = Media::getImage($id);
                
                $sub_company = null;
                if(isset(Auth::user()->created_user_id) && !empty(Auth::user()->created_user_id)){
                    $u_id = Auth::user()->created_user_id;
                }else{
                    $u_id = Auth::user()->id;
                }
                $sub_company = SubCompany::getSubCompany($u_id);

                return view('admin.mail_template.edit')->with('mail_template',$mail_template)->with('id',$id)->with('media_image',$media_image)->with('sub_company',$sub_company);
            }else{
                $role_name = CustomFunction::role_name();
    
                $route_name = $role_name.'.emailTemplateList';
                return redirect()->route($route_name);
            }
            
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function update(Request $request){

        if(Auth::check()){
            $request->validate([
                'id' => 'required',
                'template_title' => 'required|max:255',
                'email_subject' => 'nullable|max:255',
                    ], [
                'id.required' => 'Something went wrong!!',
                'template_title.required' => 'Please enter template title.',
                'template_title.max' => 'Template title allow 255 later.',
                'template_title.unique' => 'Template Title is already exists.',
                'email_subject.max' => 'Email subject allow 255 later.',
            ]);

            $template_title = CustomFunction::filter_input($request->template_title);
            $email_subject = CustomFunction::filter_input($request->email_subject);
        
            $email_description = CustomFunction::remove_html_tags($request->email_description, array('script','iframe','small','span','br'));
            $email_description = CustomFunction::filter_input($email_description);
            $sub_company = $request->sub_company;

            $user_id = Auth::user()->id;
            $folderName = 'job_vacancy/';
            $folderPath = $user_id;
            $folderPath = '';

            $cover_image = null;
            if(isset($request->logo_manager) && !empty($request->logo_manager)){
                if($request->logo_manager == 'media'){
                    if(isset($request->specification_file_value) && !empty($request->specification_file_value)){
                        $cover_image = $request->logo_file_file_value;
                    }else{
                        $cover_image = $request->cover_image;
                    }
                    
                }elseif($request->logo_manager == 'select'){
                    if ($request->hasFile('logo_file')) {
                        $file = $request->file('logo_file');
                        $fileName = CustomFunction::mediaUpload($file, null, $folderName,$folderPath);
                        $cover_image = $fileName['name'];
        
                        $file_name = $fileName['name'];
                        $file_type = $fileName['extension'];
        
                        $media = new Media;
                        $media->user_id = $user_id;
                        $media->file_name = $file_name;
                        $media->file_type = $file_type;
                        $media->save();
                    }else{
                        if(isset($request->job_specification) && !empty($request->job_specification)){
                            $cover_image = $request->cover_image;
                        }
                    }
                }
            }

            $mail_template = MailTemplate::find($request->id);
            $mail_template->template_title = $template_title;
            $mail_template->email_subject = $email_subject;
            $mail_template->email_description = $email_description;
            $mail_template->updated_at = date('Y-m-d H:i:s');
            $mail_template->cover_image = $cover_image;
            $mail_template->sub_company = $sub_company;

            if ($mail_template->save()) {
                
                $role_name = CustomFunction::role_name();
    
                $route_name = $role_name.'.emailTemplateList';
                return redirect()->route($route_name)->with('success', 'Template updated successfully.');

            } else {
                return back()->with('error', 'Something went wrong !!!');
            }
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function delete(Request $request) {

        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $mail_template = MailTemplate::find($request->id);
        $mail_template->deleted_at = date('Y-m-d H:i:s');

        if ($mail_template->save()) {
            return back()->with('success', 'Mail Template has been deleted.');
        } else {
            return back()->with('error', 'Please try again!');
        }
    }

    public function mailNotification() {

        if(Auth::check()){
            $mail_noti_template = NotificationsMailTemplate::getAll();
            $job_application = NotificationsMailTemplate::jobApplication();
            $job_events = NotificationsMailTemplate::jobEvents();
            $job_offers = NotificationsMailTemplate::jobOffers();
            return view('admin.mail_template.mail_notification')->with('mail_noti_template',$mail_noti_template)->with('job_application',$job_application)
                                                                ->with('job_events',$job_events)->with('job_offers',$job_offers);
        }else{
            return redirect()->route('home.index');
        } 
    }

    public function mailNotificationUpdate(Request $request){

        if(Auth::check()){
            $request->validate([
                'id' => 'required',
                'email_subject' => 'nullable|max:255',
                    ], [
                'id.required' => 'Something went wrong!!',
                'email_subject.max' => 'Email subject allow 255 later.',
            ]);

            $template_title = CustomFunction::filter_input($request->template_title);
            $email_subject = CustomFunction::filter_input($request->email_subject);
        
            $email_description = CustomFunction::remove_html_tags($request->email_description, array('script','iframe','small','span','br'));
            $email_description = CustomFunction::filter_input($email_description);

            $user_id = Auth::user()->id;

            $mail_template = NotificationsMailTemplate::find($request->id);
            $mail_template->email_subject = $email_subject;
            $mail_template->email_description = $email_description;
            $mail_template->updated_at = date('Y-m-d H:i:s');

            if ($mail_template->save()) {
                
                return back()->with('success', 'Template updated successfully.');

            } else {
                return back()->with('error', 'Something went wrong !!!');
            }
        }else{
            return redirect()->route('home.index');
        }
       
    }

    public function candidateMailSend(Request $request) {

        
        $request->validate([
            'mail_template' => 'required',
                ], [
            'mail_template.required' => 'Please try again!',
        ]);

        $job_reference = $request->job_reference;

        $mail_template = MailTemplate::find($request->mail_template);
        if(isset($job_reference) && !empty($job_reference)){
            $getId = RecruiterCandidate::getId($request->user_id);
            $user_data = User::find($getId);
        }else{
            $user_data = User::find($request->user_id);
        }

        if(isset($mail_template->sub_company) && !empty($mail_template->sub_company)){
            $company_full_data = SubCompany::getSubCompanyData($mail_template->sub_company);
            $company_data = SubCompany::getSubCompanyName($mail_template->sub_company);
        }else{
            $company_full_data = User::clientData($request->client_id);
            $company_data = User::clientCompany($request->client_id);
        }

        $vacancy_data = JobVacancy::jobName($request->vacancy_id);
        $job_reference = $request->job_reference;

        if($request->created_id == 1){
            $created_name = User::getUserName($request->client_id);
            $created_job_title = User::getUserJobTitle($request->client_id);
        }else{
            $created_name = User::getUserName($request->created_id);
            $created_job_title = User::getUserJobTitle($request->created_id);
        }

        $job_vacancy = JobVacancy::find($request->vacancy_id);

        if((isset($job_vacancy->managed_by) && !empty($job_vacancy->managed_by)) && ($job_vacancy->managed_by == 1)){
            $company_logo = 0;
            
            if(Auth::user()->role == 1){
                $siteSetting = SiteSetting::first();

                if (isset($siteSetting) && !empty($siteSetting)) {
                    $company_logo = url('uploads') . '/site_setting/'.$siteSetting->site_talent_logo;
                }
            }else{
                if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                    $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
                }
            }
            
        }else{
            $company_logo = 0;
            if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
            }
        }

        if ((isset($mail_template->email_subject) && !empty($mail_template->email_subject)) && (isset($user_data) && !empty($user_data))) {

            $admin_data = User::find(1);
            $admin_name = $admin_company = null;
            if(isset($admin_data) && !empty($admin_data)){
                if(isset($admin_data->name) && !empty($admin_data->name)){
                    $admin_name = $admin_data->name;
                }
                if(isset($admin_data->company_name) && !empty($admin_data->company_name)){
                    $admin_company = $admin_data->company_name;
                }
            }

            if(isset($job_reference) && !empty($job_reference)){
                $userName= RecruiterCandidate::recruiterCandidateName($request->user_id);
            }else{
                if(isset($user_data->name) && !empty($user_data->name)){
                    $name = $user_data->name;
                }
                if(isset($user_data->lname) && !empty($user_data->lname)){
                    $lname = $user_data->lname;
                }
                if(isset($name) && !empty($name)){
                    $userName = $name;
                }
                if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                    $userName = $name.' '.$lname;
                }
            }

            $companyName = $company_data;
            $vacancyTitle = $vacancy_data;

            if(isset($job_reference) && !empty($job_reference)){
                $recruiter_id = RecruiterCandidate::getId($request->user_id);
                $nameOfEmail = User::getEmail($recruiter_id);
            }else{
                $nameOfEmail = $user_data->email;
            }
            Log::info("User id:- ".$request->user_id);
            Log::info("User Email:- ".$nameOfEmail);
            // $nameOfEmail = 'sunny.tzinfotech@gmail.com';

            $trimedDescription = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $mail_template->email_description)));
            $emailDescription = str_replace("{candidate-name}", $userName, $trimedDescription);
            $emailDescription = str_replace("{company-name}", $companyName, $emailDescription);
            $emailDescription = str_replace("{vacancy-title}", $vacancyTitle, $emailDescription);

            $emailDescription = str_replace("{user-name}", $created_name, $emailDescription);
            $emailDescription = str_replace("{user-job-title}", $created_job_title, $emailDescription);
            
            $emailDescription = str_replace("{admin-name}", $admin_name, $emailDescription);
            $emailDescription = str_replace("{admin-company}", $admin_company, $emailDescription);

            $trimedSubject = CustomFunction::decode_input($mail_template->email_subject);
            $trimedSubject = str_replace("{candidate-name}", $userName, $trimedSubject);
            $trimedSubject = str_replace("{company-name}", $companyName, $trimedSubject);
            $trimedSubject = str_replace("{vacancy-title}", $vacancyTitle, $trimedSubject);

            $trimedSubject = str_replace("{user-name}", $created_name, $trimedSubject);
            $trimedSubject = str_replace("{user-job-title}", $created_job_title, $trimedSubject);
            
            $trimedSubject = str_replace("{admin-name}", $admin_name, $trimedSubject);
            $trimedSubject = str_replace("{admin-company}", $admin_company, $trimedSubject);

            $link = route('home.index');
            
            $data = [
                'siteTitle' => site_title,
                'siteHeaderLogo' => site_email_logo,
                'email_subject' => $trimedSubject,
                'emailDescription' => $emailDescription,
                'name_of_sent_email' => $nameOfEmail,
                'company_logo' => $company_logo,
                'link' => $link,
            ];

            try {
                Mail::send('admin.email_template.job_applied_mail_template', $data, function ($message) use ($nameOfEmail, $data, $userName) {
                    $message->to($nameOfEmail, $userName)->subject($data['email_subject']);
                });

                $text = "Mail Send.";

                $JobActivity = new JobActivity;

                $JobActivity->select_id = $request->user_id;
                $JobActivity->client_id = $request->client_id;
                $JobActivity->job_id = $request->vacancy_id;
                $JobActivity->user_id = Auth::user()->id;
                $JobActivity->applied_id = $request->applied_id;
                $JobActivity->text = $text;
                $JobActivity->description = $emailDescription;
                $JobActivity->mail_template = $mail_template->id;
                $JobActivity->save();
                $text = 'Mail sent successfully';
                return response()->json(['msg' => $text,'code' => 1]);
    
            } catch (Exception $exc) {
                return response()->json(['msg' => "please try again!",'code' => 0]);
            }
        }
    }

    public function candidateMailPreview(Request $request) {

        
        $request->validate([
            'mail_template' => 'required',
                ], [
            'mail_template.required' => 'Please try again!',
        ]);
        

        $job_reference = $request->job_reference;

        $mail_template = MailTemplate::find($request->mail_template);
        if(isset($job_reference) && !empty($job_reference)){
            $getId = RecruiterCandidate::getId($request->user_id);
            $user_data = User::find($getId);
        }else{
            $user_data = User::find($request->user_id);
        }

        if(isset($mail_template->sub_company) && !empty($mail_template->sub_company)){
            $company_full_data = SubCompany::getSubCompanyData($mail_template->sub_company);
            $company_data = SubCompany::getSubCompanyName($mail_template->sub_company);
        }else{
            $company_full_data = User::clientData($request->client_id);
            $company_data = User::clientCompany($request->client_id);
        }

        $vacancy_data = JobVacancy::jobName($request->vacancy_id);

        if($request->created_id == 1){
            $created_name = User::getUserName($request->client_id);
            $created_job_title = User::getUserJobTitle($request->client_id);
        }else{
            $created_name = User::getUserName($request->created_id);
            $created_job_title = User::getUserJobTitle($request->created_id);
        }
        
        $job_vacancy = JobVacancy::find($request->vacancy_id);

        if((isset($job_vacancy->managed_by) && !empty($job_vacancy->managed_by)) && ($job_vacancy->managed_by == 1)){
            $company_logo = 0;
            
            if(Auth::user()->role == 1){
                $siteSetting = SiteSetting::first();

                if (isset($siteSetting) && !empty($siteSetting)) {
                    $company_logo = url('uploads') . '/site_setting/'.$siteSetting->site_talent_logo;
                }
            }else{
                if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                    $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
                }
            }
            
        }else{
            $company_logo = 0;
            if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
            }
        }

        if ((isset($mail_template->email_subject) && !empty($mail_template->email_subject))) {

            $admin_data = User::find(1);
            $admin_name = $admin_company = null;
            if(isset($admin_data) && !empty($admin_data)){
                if(isset($admin_data->name) && !empty($admin_data->name)){
                    $admin_name = $admin_data->name;
                }
                if(isset($admin_data->company_name) && !empty($admin_data->company_name)){
                    $admin_company = $admin_data->company_name;
                }
            }

            if(isset($job_reference) && !empty($job_reference)){
                $userName= RecruiterCandidate::recruiterCandidateName($request->user_id);;
            }else{
                if(isset($user_data->name) && !empty($user_data->name)){
                    $name = $user_data->name;
                }
                if(isset($user_data->lname) && !empty($user_data->lname)){
                    $lname = $user_data->lname;
                }
                if(isset($name) && !empty($name)){
                    $userName = $name;
                }
                if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                    $userName = $name.' '.$lname;
                }
            }



            $companyName = $company_data;
            $vacancyTitle = $vacancy_data;

            $nameOfEmail = $user_data->email;

            $trimedDescription = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $mail_template->email_description)));
            $emailDescription = str_replace("{candidate-name}", $userName, $trimedDescription);
            $emailDescription = str_replace("{company-name}", $companyName, $emailDescription);
            $emailDescription = str_replace("{vacancy-title}", $vacancyTitle, $emailDescription);
            
            $emailDescription = str_replace("{user-name}", $created_name, $emailDescription);
            $emailDescription = str_replace("{user-job-title}", $created_job_title, $emailDescription);

            $emailDescription = str_replace("{admin-name}", $admin_name, $emailDescription);
            $emailDescription = str_replace("{admin-company}", $admin_company, $emailDescription);

            $trimedSubject = CustomFunction::decode_input($mail_template->email_subject);
            $trimedSubject = str_replace("{candidate-name}", $userName, $trimedSubject);
            $trimedSubject = str_replace("{company-name}", $companyName, $trimedSubject);
            $trimedSubject = str_replace("{vacancy-title}", $vacancyTitle, $trimedSubject);

            $trimedSubject = str_replace("{user-name}", $created_name, $trimedSubject);
            $trimedSubject = str_replace("{user-job-title}", $created_job_title, $trimedSubject);

            $trimedSubject = str_replace("{admin-name}", $admin_name, $trimedSubject);
            $trimedSubject = str_replace("{admin-company}", $admin_company, $trimedSubject);

            $link = route('home.index');

            $data = [
                'siteTitle' => site_title,
                'siteHeaderLogo' => site_email_logo,
                'email_subject' => $trimedSubject,
                'emailDescription' => $emailDescription,
                'name_of_sent_email' => $nameOfEmail,
                'company_logo' => $company_logo,
                'link' => $link,
            ];

            $statusJobData = view('admin.email_template.mail_preview')->with('data', $data)->render();
            return response()->json(['msg' => $statusJobData,'code' => 1]);
        }
    }

}
