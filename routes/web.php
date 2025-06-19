<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\ConfigController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\UserJobController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\OutlookCalendarController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\frontend\PendingEventController;

use App\Http\Controllers\frontend\DashboardController;
use App\Http\Controllers\frontend\ApplicationsController;
use App\Http\Controllers\frontend\OfferController;
use App\Http\Controllers\frontend\ClientJobController;
use App\Http\Controllers\frontend\ProfileController;
use App\Http\Controllers\admin\ChatModalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// define('site_img', 'uploads/site_setting/');
// define('img_upload_path', 'uploads/');
// define('file_path', url('uploads'));
// define('site_logo', 'https://laravel.thedevelopment.in/resource/uploads/');

// define('super_admin_role', '1');
// define('client_role', '2');
// define('staff_role', '3');
// define('recruiter_role', '4');
// define('candidate_role', '5');

// define('admin_assets', url('assets/backend'));
// define('front_assets', url('assets/frontend'));

Route::get('phpinfo', function () {
    phpinfo();
});
Route::get('/clearCache', [ConfigController::class, 'clearRoute'])->name('clearRoute');


// Route::get('/register', [LoginController::class, 'getRegister'])->name('getRegister');
Route::get('/verify_email/{key}', [LoginController::class, 'verifyEmail'])->name('front.verify.email');
Route::get('/logout', [LoginController::class, 'authLogoutAttempt'])->name('logout');


// Route::get('/login', [LoginController::class, 'clientLogin'])->name('client.clientLogin');
Route::post('/user-login', [LoginController::class, 'clientLoginCheck'])->name('client.clientLoginCheck');

Route::post('/forget-password', [LoginController::class, 'sendForgotPasswordRequest'])->name('home.sendForgotPasswordRequest');
Route::get('/reset_password/{id}', [LoginController::class, 'resetPasswordRequest'])->name('home.reset.password')->where('id', '[a-zA-Z0-9]+');
Route::post('/submit-reset-password', [LoginController::class, 'submitResetPassword'])->name('home.submitResetPassword');


Route::get('/', [UserController::class, 'getIndex'])->name('home.index');
Route::post('/candidate-register', [LoginController::class, 'candidateRegister'])->name('candidateRegister');
// Route::get('/candidate-login', [LoginController::class, 'candidateLogin'])->name('candidateLogin');
Route::post('/candidate-login', [LoginController::class, 'candidateLoginCheck'])->name('candidateLoginCheck');


Route::get('/job-detail/{id}', [UserJobController::class, 'getJobDetail'])->name('getJobDetail');
Route::post('/job-applied', [UserJobController::class, 'candidateJobApplied'])->name('candidateJobApplied');

Route::get('/jobs/{id?}', [ClientJobController::class, 'index'])->name('home.getClientJobDetail');

// Route::get('/talent-pool', [UserController::class, 'talentPool'])->name('home.talentPool');
// Route::get('/talent-pool/{id?}', [UserController::class, 'talentPoolDetail'])->name('home.talentPoolDetail');

Route::get('/job-list', [UserController::class, 'jobList'])->name('home.jobList');
Route::post('/job-list', [UserController::class, 'jobList'])->name('home.jobList.post');
Route::post('/job-list-data', [UserController::class, 'jobListData'])->name('home.jobListData');

Route::post('/job-search-letlong', [UserController::class, 'jobSearchLatLong'])->name('home.jobSearchLatLong');

Route::post('/r-category-get', [UserController::class, 'rCategoryidGet'])->name('rCategoryidGet');

Route::get('/terms-and-condition/{id?}', [UserController::class, 'termsCondition'])->name('home.termsCondition');
Route::get('/privacy-policy', [UserController::class, 'privacyPolicy'])->name('home.privacyPolicy');
Route::get('/gdpr', [UserController::class, 'getGDPR'])->name('home.getGDPR');

Route::group(['prefix' => 'candidate'], function () {
    Route::group(['middleware' => ['auth','guest','CheckUserRole']], function () {

        /** DashboardController */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('candidate.dashboard');

        /** ApplicationsController */
        Route::get('/applications', [ApplicationsController::class, 'index'])->name('candidate.applications');
        Route::get('/applications-archive', [ApplicationsController::class, 'archiveData'])->name('candidate.archiveData');
        Route::get('/applications/{id?}', [ApplicationsController::class, 'applicationGet'])->name('candidate.applicationGet');
        Route::post('/candidate-archive', [ApplicationsController::class, 'archiveCandidate'])->name('candidate.archiveCandidate');
        Route::post('/application-data', [ApplicationsController::class, 'applicationData'])->name('candidate.applicationData');
        Route::post('/application-archive-data', [ApplicationsController::class, 'applicationArchiveData'])->name('candidate.applicationArchiveData');

        /** offerController */
        Route::get('/offer', [OfferController::class, 'index'])->name('candidate.offerGet');
        Route::post('/offer-accept', [OfferController::class, 'offerAccept'])->name('candidate.offerAccept');
        Route::post('/offer-declin', [OfferController::class, 'offerDeclin'])->name('candidate.offerDeclin');

        /** ProfileController */
        Route::get('/settings', [ProfileController::class, 'index'])->name('candidate.profileSetting');
        Route::get('/job-alert-setting', [ProfileController::class, 'jobAlertSetting'])->name('candidate.jobAlertSetting');
        Route::post('/category-get', [ProfileController::class, 'categoryidGet'])->name('candidate.categoryidGet');
        Route::post('/account-setting', [ProfileController::class, 'accountSetting'])->name('candidate.accountSetting');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('candidate.changePassword');
        Route::post('/job-alert', [ProfileController::class, 'jobAlert'])->name('candidate.jobAlert');
        Route::post('/delete-candidate-profile', [ProfileController::class, 'deleteCandidateProfile'])->name('candidate.deleteCandidateProfile');

        /** ChatModalController */
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('candidate.indexList');

        /** PendingEventController */
        Route::get('/event-time/{id?}', [PendingEventController::class, 'getEventTime'])->name('candidate.getEventTime');
        Route::post('/event-time-reject', [PendingEventController::class, 'getEventTimeReject'])->name('candidate.getEventTimeReject');
        Route::post('/event-time-schedule', [PendingEventController::class, 'saveScheduleEventTime'])->name('candidate.saveScheduleEventTime');

    });
});

Route::get('/candidate-mail-view', [ConfigController::class, 'candidateMailView'])->name('candidateMailView');

Route::post('/send-otp', [ConfigController::class, 'sendOTP'])->name('sendOTP');
Route::post('/verify-otp', [ConfigController::class, 'verifyOTP'])->name('verifyOTP');

Route::post('/login-send-otp', [ConfigController::class, 'loginSendOTP'])->name('loginSendOTP');
Route::post('/login-verify-otp', [ConfigController::class, 'loginVerifyOTP'])->name('loginVerifyOTP');

Route::get('/outlook-signin', [TokenController::class, 'signin'])->name('outlook.signin');
Route::get('/outlook-callback', [TokenController::class, 'callback'])->name('outlook.callback');
Route::get('/outlook-tokens-update', [TokenController::class, 'tokensUpdate'])->name('outlook.tokensUpdate');
Route::post('/outlook-signout', [TokenController::class, 'signOut'])->name('outlook.signOut');

Route::get('/outlook-calendar', [OutlookCalendarController::class, 'calendar'])->name('outlook.calendar');
Route::get('/outlook-calendar/new', [OutlookCalendarController::class, 'getNewEventForm'])->name('outlook.getNewEventForm');
Route::post('/outlook-calendar/new', [OutlookCalendarController::class, 'createNewEvent'])->name('outlook.createNewEvent');

// Route::get('/update-event-normal', [UserController::class, 'updateEventNormal'])->name('home.updateEventNormal');
Route::get('/sync-calendar', [DemoController::class, 'syncCalendar'])->name('home.syncCalendar');

Route::get('/demo-mail-send', [UserController::class, 'mailDemoFunction'])->name('home.mailDemoFunction');
