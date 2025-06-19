<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mail;
use Session;
use App\Models\SiteSetting;
use App\Models\JobVacancy;
use App\Models\JobApplied;
use App\Models\AdvertisementOption;
use App\Models\ClientDetail;
use App\Models\SubCompany;


class UserJobController extends BaseController {

    public function __construct() {

    }

    /**
     *
     * @return type
     */

    public function getJobDetail(Request $request,$id)
    {

        if($id){
            $job_data = JobVacancy::jobVacancyFind($id);

            if(isset($job_data) && !empty($job_data)){
                $job_applied_val = 1;

                $optionList = AdvertisementOption::list($job_data->user_select);
                $optionListCount = AdvertisementOption::list($job_data->user_select)->count();

                if(isset($job_data->sub_company) && !empty($job_data->sub_company)){
                    $client_detail = SubCompany::getSubCompanyData($job_data->sub_company);
                }else{
                    $client_detail = ClientDetail::getData($job_data->user_select);
                }

                if(Auth::check()){
                    $user_id = Auth::user()->id;
                    $job_applied = JobApplied::checkAppliedJob($job_data->id,$user_id);
                    if(isset($job_applied) && !empty($job_applied)){
                        $job_applied_val = 0;
                    }
                }
                return view('frontend.job.joblisting')->with('job_data',$job_data)->with('id',$id)->with('job_applied_val',$job_applied_val)->with('optionList',$optionList)
                                                      ->with('optionListCount',$optionListCount)->with('client_detail',$client_detail);
            }
            return redirect()->route('home.index');
        }
        return redirect()->route('home.index');

    }

    public function candidateJobApplied(Request $request)
    {
        if(Auth::check()){

            $validator = Validator::make($request->all(), [
                'cv_file' => 'required|mimes:pdf,docx,doc',
                'notice_period' => 'required',
                'salary_expectations' => 'required',
                'work_base_preferences' => 'required',
                'j_town' => 'required',
                'g-recaptcha-response' => 'required|recaptchav3:jobapplied,0.5'
                    ], [
                'cv_file.mimes' => 'CV allow only pdf,docx,doc file.',
                'cv_file.required' => 'Please select CV.',
                'cv_file.max' => 'CV should be less than 3 mb.',
                'notice_period.required' => 'Please select notice period!',
                'salary_expectations.required' => 'Please enter salary expectations!',
                'work_base_preferences.required' => 'Please enter work base preferences!',
                'j_town.required' => 'Please enter town!',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('open_application_job', 'On')->with('error_msg', $validator->errors()->first());
            }

            $job_id = $request->job_id;
            $folderName = '/job_applied/'.$job_id;

            if ($request->hasFile('cv_file')) {
                $file = $request->file('cv_file');
                $fileName = CustomFunction::fileUpload($file, null, $folderName);
                $cv_file = $fileName;
            }

            // $work_in_the_uk_do_you_hold = $request->work_in_the_uk_do_you_hold;
            // $require_visa_sponsorship = $request->require_visa_sponsorship;
            // $visa_expire_date = null;
            // if(isset($request->visa_expire_date) && !empty($request->visa_expire_date)){
            //     $visa_expire_date = date('Y-m-d',strtotime($request->visa_expire_date));
            // }
            // $british_passport = $request->british_passport;

            // if($british_passport == 1){
            //     if($require_visa_sponsorship == 1){
            //         return back()->with('error', 'Oh no. An error has occurred. Please check you have completed all the fields!');
            //     }
            // }

            $job_applied = new JobApplied;
            $job_applied->notice_period = $request->notice_period;
            $job_applied->salary_expectations = $request->salary_expectations;
            $job_applied->work_base_preferences = $request->work_base_preferences;
            $job_applied->job_id = $request->job_id;
            $job_applied->client_id = $request->client_id;
            $job_applied->user_id = $request->user_id;
            $job_applied->managed_by = $request->managed_by;
            $job_applied->cv_file = $cv_file;
            $job_applied->job_status = 1;
            $job_applied->job_stage = 1;
            $job_applied->job_workflow_id = $request->job_workflow_id;
            $job_applied->thumbs_status = 0;
            $job_applied->j_town = $request->j_town;
            // $job_applied->british_passport = $british_passport;
            // $job_applied->work_in_the_uk_do_you_hold = $work_in_the_uk_do_you_hold;
            // $job_applied->visa_expire_date = $visa_expire_date;
            // $job_applied->require_visa_sponsorship = $require_visa_sponsorship;
            if(isset($request->job_advertised) && !empty($request->job_advertised)){
                $job_applied->job_advertised = $request->job_advertised;
            }

            if ($job_applied->save()) {
                NotificationsController::notificationNewApplication($request->job_id,$request->user_id);
                return back()->with('success', 'Your job application sent successfully.');
            } else {
                return back()->with('error', 'Oh no. An error has occurred. Please check you have completed all the fields!');
            }
        }else{
            return back()->with('error', 'Oh no. An error has occurred. Please please try again!');;
        }

    }

}
