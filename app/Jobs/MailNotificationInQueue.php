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

use App\Models\User;
use App\Models\JobVacancy;
use App\Models\NotificationsMailTemplate;
use App\Models\SiteSetting;
use App\Models\SubCompany;

use Mail;

class MailNotificationInQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $job_id;
    protected $email;
    protected $notifications_type;
    protected $candidate_id;
    protected $event_type;
    protected $link;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $job_id, $email,$notifications_type,$candidate_id = null,$event_type = null,$link = null)
    {
        $this->user_id = $user_id;
        $this->job_id = $job_id;
        $this->email = $email;
        $this->notifications_type = $notifications_type;
        $this->candidate_id = $candidate_id;
        $this->event_type = $event_type;
        $this->link = $link;

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
        $email = $this->email;
        Log::info("User id:- ".$user_id);
        Log::info("User Email:- ".$email);
        // $email = 'sunny.tzinfotech@gmail.com';
        $notifications_type = $this->notifications_type;
        $candidate_id = $this->candidate_id;
        $event_type = $this->event_type;
        $link = $this->link;

        if ((isset($user_id) && !empty($user_id)) && (isset($job_id) && !empty($job_id)) && (isset($email) && !empty($email))) {

            $user_data = User::find($user_id);
            $candidate_data = User::find($candidate_id);
            $job_vacancy = JobVacancy::find($job_id);

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


            $user_name = '';
            if(isset($user_data['name']) && !empty($user_data['name'])){
                $user_name = $user_data['name'];
            }
            if(isset($user_data['lname']) && !empty($user_data['lname'])){
                $user_name = $user_name." ".$user_data['lname'];
            }

            $candidate_name = '';
            if(isset($candidate_data) && !empty($candidate_data)){

                if(isset($candidate_data->name) && !empty($candidate_data->name)){
                    $candidate_name = $candidate_data->name;
                }

                if(isset($candidate_data->lname) && !empty($candidate_data->lname)){
                    $candidate_name = $candidate_name." ".$candidate_data->lname;
                }
            }

            // $client_name = User::getUserName($job_vacancy->user_select);
            // $company_name = User::clientCompany($job_vacancy->user_select);

            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                // $client_name = SubCompany::getSubUserName($job_vacancy->user_select);
                $client_name = User::getUserName($job_vacancy->user_select);
            }else{
                $client_name = User::getUserName($job_vacancy->user_select);
            }

            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                $company_name = SubCompany::getSubCompanyName($job_vacancy->sub_company);
            }else{
                $company_name = User::clientCompany($job_vacancy->user_select);
            }

            $job_title = JobVacancy::jobName($job_vacancy->id);

            $mail_data = NotificationsMailTemplate::where('role','=',$user_data->role)->where('notifications_type','=',$notifications_type)->first();

            if(($user_data->role == 2) && ($user_data->created_user_id)){
                $client_name = User::getUserName($user_data->id);
            }

            $trimedDescription = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $mail_data->email_description)));
            $emailDescription = str_replace("{client-name}", $client_name, $trimedDescription);
            $emailDescription = str_replace("{staff-name}", $user_name, $emailDescription);
            $emailDescription = str_replace("{recruiter-name}", $user_name, $emailDescription);
            $emailDescription = str_replace("{candidate-name}", $candidate_name, $emailDescription);

            $emailDescription = str_replace("{vacancy-title}", $job_title, $emailDescription);
            $emailDescription = str_replace("{company-name}", $company_name, $emailDescription);

            $emailDescription = str_replace("{event-type}", $event_type, $emailDescription);


            $emailDescription = str_replace("{admin-name}", $admin_name, $emailDescription);
            $emailDescription = str_replace("{admin-company}", $admin_company, $emailDescription);

            $trimedSubject = CustomFunction::decode_input($mail_data->email_subject);
            $trimedSubject = str_replace("{client-name}", $client_name, $trimedSubject);
            $trimedSubject = str_replace("{staff-name}", $user_name, $trimedSubject);
            $trimedSubject = str_replace("{recruiter-name}", $user_name, $trimedSubject);
            $trimedSubject = str_replace("{candidate-name}", $candidate_name, $trimedSubject);
            $trimedSubject = str_replace("{vacancy-title}", $job_title, $trimedSubject);
            $trimedSubject = str_replace("{company-name}", $company_name, $trimedSubject);
            $trimedSubject = str_replace("{event-type}", $event_type, $trimedSubject);

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

            // $company_full_data = User::clientData($job_vacancy->user_select);
            $company_logo = null;
            if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
                $company_full_data = SubCompany::getSubCompanyData($job_vacancy->sub_company);
            }else{
                $company_full_data = User::clientData($job_vacancy->user_select);
            }

            if(isset($company_full_data->company_logo) && !empty($company_full_data->company_logo)){
                $company_logo = url('uploads') . '/client_profile/'.$company_full_data->company_logo;
            }

            $link = route('home.index');

            $data = [
                'siteTitle' => $site_title,
                'siteHeaderLogo' => $site_header_logo,
                'email_subject' => $trimedSubject,
                'emailDescription' => $emailDescription,
                'name_of_sent_email' => $email,
                'company_logo' => $company_logo,
                'link' => $link,
            ];

            try {
                Mail::send('admin.email_template.notification_mail_template', $data, function ($message) use ($email, $data, $user_name) {
                    $message->to($email, $user_name)->subject($data['email_subject']);
                });

            } catch (Exception $exc) {

            }

        }
    }

}
