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

class OfflineResourceJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client_id;
    protected $candidate_id;
    protected $message_data;
    protected $client_company_name;
    protected $job_name;
    protected $candidate_name;
    protected $recruiter_name;
    protected $message_name;
    protected $job_id;
    protected $mail_send_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client_id,$candidate_id,$message_data,$client_company_name,$job_name,$candidate_name = null,$recruiter_name = null,$message_name = null,$job_id=null,$mail_send_id=null)
    {
        $this->client_id = $client_id;
        $this->candidate_id = $candidate_id;
        $this->message_data = $message_data;
        $this->client_company_name = $client_company_name;
        $this->job_name = $job_name;
        $this->candidate_name = $candidate_name;
        $this->recruiter_name = $recruiter_name;
        $this->message_name = $message_name;
        $this->job_id = $job_id;
        $this->mail_send_id = $mail_send_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client_id = $this->client_id;
        $candidate_id = $this->candidate_id;
        $message_data = $this->message_data;
        $client_company_name = $this->client_company_name;
        $job_name = $this->job_name;
        $candidate_name = $this->candidate_name;
        $recruiter_name = $this->recruiter_name;
        $message_name = $this->message_name;
        $job_id = $this->job_id;
        $mail_send_id = $this->mail_send_id;

        $siteSettingData = SiteSetting::where('site_title','=','offlineCandidate')->first();

        $siteSetting = SiteSetting::first();

        $site_title  = $site_header_logo = null;

        $site_header_logo = url('assets/frontend').'/img/logo.png';
        if (isset($siteSetting) && !empty($siteSetting)) {
            $site_title = $siteSetting->site_title;
            if (isset($siteSetting->site_email_logo) && !empty($siteSetting->site_email_logo)) {
                $site_header_logo = url('uploads') . '/site_setting/'.$siteSetting->site_email_logo;
            }
        }

        // $company_full_data = User::clientData($client_id);
        $job_vacancy = JobVacancy::find($job_id);
        if(isset($job_vacancy->sub_company) && !empty($job_vacancy->sub_company)){
            $company_full_data = SubCompany::getSubCompanyData($job_vacancy->sub_company);
        }else{
            $company_full_data = User::clientData($client_id);
        }
        

        $company_logo = null;
        if (isset($siteSetting) && !empty($siteSetting)) {
            $company_logo = url('uploads') . '/site_setting/'.$siteSetting->site_talent_logo;
        }

        $email = User::getEmail($mail_send_id);
        Log::info("User id:- ".$mail_send_id);
        Log::info("User chat admin Email:- ".$email);
        // $email = 'sunny.tzinfotech@gmail.com';
        $user_name = User::getUserName($candidate_id);

        $emailDescription = $message_data;
        
        $trimedSubject =  'You have received a new chat message';
        $new_message =  'New Message from '.$message_name;

        $link = route('home.index');
        
        $data = [
            'siteTitle' => $site_title,
            'siteHeaderLogo' => $site_header_logo,
            'email_subject' => $trimedSubject,
            'emailDescription' => $emailDescription,
            'company_logo' => $company_logo,
            'link' => $link,
            'client_company_name' => $client_company_name,
            'job_name' => $job_name,
            'candidate_name' => $candidate_name,
            'recruiter_name' => $recruiter_name,
            'new_message' => $new_message,
        ];

        try {
            Mail::send('admin.email_template.offline_candidate', $data, function ($message) use ($email, $data, $user_name) {
                $message->to($email, $user_name)->subject($data['email_subject']);
            });

            // Log::info('Mail send : '.$email);

        } catch (Exception $exc) {

        }
    }
}
