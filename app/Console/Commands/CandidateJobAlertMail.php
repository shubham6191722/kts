<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use App\CustomFunction\CustomFunction;
use App\Jobs\CandidateMailNotificationInQueue;
use Carbon\Carbon;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\SiteSetting;
use App\Models\JobsAlert;

class CandidateJobAlertMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'candidatejobalertmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'candidate job alert mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_data = User::getCandidateFull();
        $date = Carbon::today();
        // $date = Carbon::yesterday();
        foreach($user_data as $key => $value){
            
            if($value->check_notification == 1){
                
                if($value->check_radius == 1){
                    $vacancy_data = JobVacancy::candidateNotificationRadius($value,$date);
                }else{
                    $vacancy_data = JobVacancy::candidateNotification($value,$date);
                }
            }
            if(isset($vacancy_data) && !empty($vacancy_data) && count($vacancy_data)){
                $email = $value->email;
                $user_id = $value->id;
                $name = $value->name;
                $lname = $value->lname;
                if(isset($name) && !empty($name)){
                    $userName = $name;
                }
                if((isset($lname) && !empty($lname)) && (isset($name) && !empty($name))){
                    $userName = $name.' '.$lname;
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

                $siteHeaderLogo = $site_header_logo;
                $statusJobData = view('vacancy_data_for_mail')->with('data', $vacancy_data)->with('siteHeaderLogo', $siteHeaderLogo)->render();
                
                $nameOfEmail = $email;
                $trimedDescription = $statusJobData;
    
                $siteSettingData = SiteSetting::where('site_title','=','candidateJobAlert')->first();
                $description = trim(CustomFunction::decode_input(str_replace(['"', "'"], "", $siteSettingData->site_notification_email)));
                $description = str_replace("{candidate-name}", $userName, $description);
    
                $trimedSubject = CustomFunction::decode_input($siteSettingData->site_favicon);
                $trimedSubject = str_replace("{candidate-name}", $userName, $trimedSubject);
    
                $data = [
                    'siteTitle' => $site_title,
                    'siteHeaderLogo' => $site_header_logo,
                    'email_subject' => $trimedSubject,
                    'emailDescription' => $trimedDescription,
                    'name_of_sent_email' => $nameOfEmail,
                    'userName' => $userName,
                    'user_id' => $user_id,
                    'description' => $description,
                ];
                $time = $key;
    
                $job_alert = JobsAlert::where('user_id','=',$user_id)->whereDate('date','=',$date)->get();
                
                // if(isset($job_alert) && !empty($job_alert) && count($job_alert)){
                    // return redirect()->route('home.index');
                // }else{
                    $job = (new CandidateMailNotificationInQueue($data))->delay(now()->addSeconds($time * 4));
                    app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                // }
            }
            
        }
        
        $mytime = Carbon::now();
        Log::info("Cron is working fine!".$mytime);
    }
}
