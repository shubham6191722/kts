<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\CustomFunction\CustomFunction;

use App\Models\MailTemplate;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\RecruiterCandidate;
use App\Models\SiteSetting;
use App\Models\SubCompany;

use Mail;

class UnsuccessFullMailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $job_id;
    protected $mail_template_id;
    protected $client_id;
    protected $job_reference;
    protected $created_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id,$job_id,$mail_template_id,$client_id,$job_reference,$created_id)
    {
        $this->user_id = $user_id;
        $this->job_id = $job_id;
        $this->mail_template_id = $mail_template_id;
        $this->client_id = $client_id;
        $this->job_reference = $job_reference;
        $this->created_id = $created_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $user_id = $this->user_id;
        $job_id = $this->job_id;
        $mail_template_id = $this->mail_template_id;
        $client_id = $this->client_id;
        $job_reference = $this->job_reference;
        $created_id = $this->created_id;

        $vacancy_data = JobVacancy::jobName($job_id);
        $user_data = User::find($user_id);
        // $company_data = User::clientCompany($client_id);
        // $company_full_data = User::clientData($client_id);
        $job_vacancy = JobVacancy::find($job_id);
        if($created_id == 1){
            if($job_vacancy->managed_by == 1){
                $siteSetting = SiteSetting::first();
                
                $site_title  = $site_header_logo = null;

                $site_header_logo = url('assets/frontend').'/img/logo.png';
                if (isset($siteSetting) && !empty($siteSetting)) {
                    $site_title = $siteSetting->site_title;
                    if (isset($siteSetting->site_talent_logo) && !empty($siteSetting->site_email_logo)) {
                        $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
                    }
                }

                $company_logo = $site_header_logo;
                $company_data = User::clientCompany($client_id);
            }else{
                if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                    $company_full_data = SubCompany::getSubCompanyData($job_vacancy->sub_company);
                    $company_data = SubCompany::getSubCompanyName($job_vacancy->sub_company);
                }else{
                    $company_full_data = User::clientData($client_id);
                    $company_data = User::clientCompany($client_id);
                }

                $company_logo = 0;
                if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                    $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
                }
            }
        }else{
            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                $company_full_data = SubCompany::getSubCompanyData($job_vacancy->sub_company);
                $company_data = SubCompany::getSubCompanyName($job_vacancy->sub_company);
            }else{
                $company_full_data = User::clientData($client_id);
                $company_data = User::clientCompany($client_id);
            }

            $company_logo = 0;
            if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
            }
        }

        $mail_template = MailTemplate::find($mail_template_id);

        // $company_logo = 0;
        // if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
        //     $company_logo = url('uploads') . '/client_profile/' . $company_full_data->company_logo;
        // }

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
                $userName= RecruiterCandidate::recruiterCandidateName($user_id);
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

            if($created_id == 1){
                $created_name = User::getUserName($client_id);
                $created_job_title = User::getUserJobTitle($client_id);
            }else{
                $created_name = User::getUserName($created_id);
                $created_job_title = User::getUserJobTitle($created_id);
            }

            $companyName = $company_data;
            $vacancyTitle = $vacancy_data;

            if(isset($job_reference) && !empty($job_reference)){
                $recruiter_id = RecruiterCandidate::getId($user_id);
                $nameOfEmail = User::getEmail($recruiter_id);
            }else{
                $nameOfEmail = $user_data->email;
            }

            Log::info("User id:- ".$user_id);
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


            $siteSetting = SiteSetting::first();

            $site_title  = $site_header_logo = null;

            $site_header_logo = url('assets/frontend').'/img/logo.png';
            if (isset($siteSetting) && !empty($siteSetting)) {
                $site_title = $siteSetting->site_title;
                if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                    $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
                }
            }

            $link = route('home.index');
            
            $data = [
                'siteTitle' => $site_title,
                'siteHeaderLogo' => $site_header_logo,
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
    
            } catch (Exception $exc) {

            }
        }

    }
}
