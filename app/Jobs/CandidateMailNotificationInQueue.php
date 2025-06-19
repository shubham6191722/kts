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
use Carbon\Carbon;

use App\Models\JobsAlert;

use Mail;

class CandidateMailNotificationInQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $site_title = $data['siteTitle'];
        $site_header_logo = $data['siteHeaderLogo'];
        $trimedSubject = $data['email_subject'];
        $emailDescription = $data['emailDescription'];
        $email = $data['name_of_sent_email'];
        // $email = 'sunny.tzinfotech@gmail.com';
        $userName = $data['userName'];
        $user_id = $data['user_id'];
        $description = $data['description'];

        $data = [
            'siteTitle' => $site_title,
            'siteHeaderLogo' => $site_header_logo,
            'email_subject' => $trimedSubject,
            'emailDescription' => $emailDescription,
            'name_of_sent_email' => $email,
            'userName' => $userName,
            'description' => $description,
        ];

        try {
                
            Mail::send('admin.email_template.candidate_notification_template', $data, function ($message) use ($email, $data, $userName) {
                $message->to($email, $userName)->subject($data['email_subject']);
            });    
            $date = Carbon::today();
            $job_alert_save = new JobsAlert;
            $job_alert_save->user_id = $user_id;
            $job_alert_save->date = $date;
            $job_alert_save->email = $email;
            $job_alert_save->save();

        } catch (Exception $exc) {

        }
    }
}

