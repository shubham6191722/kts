<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\CandidateController;
use App\Http\Controllers\admin\JobVacancyController;
use App\Http\Controllers\admin\ClientController;
use App\Http\Controllers\admin\RecruiterController;
use App\Http\Controllers\admin\SkillController;
use App\Http\Controllers\admin\KeyWordController;
use App\Http\Controllers\admin\ApllicationController;
use App\Http\Controllers\admin\TemplatesController;
use App\Http\Controllers\admin\MediaController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\admin\TalentPoolController;
use App\Http\Controllers\admin\MailTemplateController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\JobAlertController;
use App\Http\Controllers\admin\ChatModalController;
use App\Http\Controllers\Controller;




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

/*adminside route*/
Route::group(['prefix' => 'rats-5768'], function () {

    Route::post('/submit-reset-password', [LoginController::class, 'submitResetPassword'])->name('admin.submitResetPassword');

    Route::get('/', [LoginController::class, 'getIndex'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'doLogin'])->name('admin.dologin');

    Route::get('/forget-password', [LoginController::class, 'showForgotPasswordForm'])->name('admin.showForgotPasswordForm');
    Route::post('/forget-password', [LoginController::class, 'sendForgotPasswordRequest'])->name('admin.sendForgotPasswordRequest');
    Route::get('/reset_password/{id}', [LoginController::class, 'resetPasswordRequest'])->name('admin.reset.password')->where('id', '[a-zA-Z0-9]+');

});


Route::group(['prefix' => 'rats-5768'], function () {
    Route::group(['middleware' => ['auth','guest','CheckUserRole']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('rats-5768.dashboard');

        Route::get('/settings', [SettingController::class, 'showSetting'])->name('rats-5768.showSetting');
        Route::post('/account-setting', [SettingController::class, 'accountSetting'])->name('rats-5768.accountSetting');
        Route::post('/change-password', [SettingController::class, 'changePassword'])->name('rats-5768.changePassword');
        Route::post('/site-setting', [SettingController::class, 'siteSetting'])->name('rats-5768.site.setting');
        Route::post('/social-setting', [SettingController::class, 'socialLink'])->name('rats-5768.social.setting');
        Route::post('/footer-save', [SettingController::class, 'footerSave'])->name('rats-5768.footerSave');
        Route::post('/client-profile', [SettingController::class, 'clientProfile'])->name('rats-5768.clientProfile');
        Route::post('/business-hours-save', [SettingController::class, 'businessHoursSave'])->name('rats-5768.businessHoursSave');

        /** CandidateController */
        Route::get('/candidate-list', [CandidateController::class, 'index'])->name('rats-5768.candidateList');
        Route::post('/candidate-status', [CandidateController::class, 'statusUpdate'])->name('rats-5768.candidateStatusUpdate');
        Route::post('/candidate-delete', [CandidateController::class, 'delete'])->name('rats-5768.candidateDelete');
        Route::get('/candidate-edit/{id}', [CandidateController::class, 'edit'])->name('rats-5768.candidateEdit');
        Route::post('/candidate-update', [CandidateController::class, 'update'])->name('rats-5768.candidateUpdate');

        /** ClientController */
        Route::get('/client-list', [ClientController::class, 'index'])->name('rats-5768.clientList');
        Route::get('/client-add', [ClientController::class, 'add'])->name('rats-5768.clientAdd');
        Route::post('/client-create', [ClientController::class, 'create'])->name('rats-5768.clientCreate');
        Route::get('/client-edit/{id}', [ClientController::class, 'edit'])->name('rats-5768.clientEdit');
        Route::post('/client-update', [ClientController::class, 'update'])->name('rats-5768.clientUpdate');
        Route::post('/client-delete', [ClientController::class, 'delete'])->name('rats-5768.clientDelete');
        Route::post('/staff-status', [StaffController::class, 'statusUpdate'])->name('rats-5768.statusUpdate');
        Route::get('/client-membership-edit/{id}', [ClientController::class, 'membershipEdit'])->name('rats-5768.membershipEdit');
        Route::post('/client-membership-update', [ClientController::class, 'membershipUpdate'])->name('rats-5768.membershipUpdate');
        
        Route::get('/add-sub-company', [ClientController::class, 'addSubCompany'])->name('rats-5768.addSubCompany');
        Route::post('/create-sub-company', [ClientController::class, 'createSubCompany'])->name('rats-5768.createSubCompany');
        Route::get('/edit-sub-company/{id}', [ClientController::class, 'editSubCompany'])->name('rats-5768.editSubCompany');
        Route::get('/sub-company-edit/{id}', [ClientController::class, 'editSubCompanyClient'])->name('rats-5768.editSubCompanyClient');
        Route::post('/update-sub-company', [ClientController::class, 'updateSubCompany'])->name('rats-5768.updateSubCompany');
        Route::post('/delete-sub-company', [ClientController::class, 'deleteSubCompany'])->name('rats-5768.deleteSubCompany');


        /** RecruiterController */
        Route::get('/recruiter-list', [RecruiterController::class, 'index'])->name('rats-5768.recruiterList');
        Route::get('/recruiter-add', [RecruiterController::class, 'add'])->name('rats-5768.recruiterAdd');
        Route::post('/recruiter-create', [RecruiterController::class, 'create'])->name('rats-5768.recruiterCreate');
        Route::get('/recruiter-edit/{id}', [RecruiterController::class, 'edit'])->name('rats-5768.recruiterEdit');
        Route::post('/recruiter-update', [RecruiterController::class, 'update'])->name('rats-5768.recruiterUpdate');
        Route::post('/recruiter-delete', [RecruiterController::class, 'delete'])->name('rats-5768.recruiterDelete');

        /** SkillController */
        Route::get('/skill-list', [SkillController::class, 'index'])->name('rats-5768.skillList');
        Route::post('/skill-create', [SkillController::class, 'create'])->name('rats-5768.skillCreate');
        Route::post('/skill-update', [SkillController::class, 'update'])->name('rats-5768.skillUpdate');
        Route::post('/skill-delete', [SkillController::class, 'delete'])->name('rats-5768.skillDelete');

        /** KeyWordController */
        Route::get('/key-word-list', [KeyWordController::class, 'index'])->name('rats-5768.keyWordList');
        Route::post('/key-word-create', [KeyWordController::class, 'create'])->name('rats-5768.keyWordCreate');
        Route::post('/key-word-update', [KeyWordController::class, 'update'])->name('rats-5768.keyWordUpdate');
        Route::post('/key-word-delete', [KeyWordController::class, 'delete'])->name('rats-5768.keyWordDelete');


        /** JobVacancyController */
        Route::get('/vacancy-list', [JobVacancyController::class, 'index'])->name('rats-5768.vacancyList');
        Route::get('/vacancy-add', [JobVacancyController::class, 'add'])->name('rats-5768.vacancyAdd');
        Route::post('/region-get', [JobVacancyController::class, 'regionGet'])->name('rats-5768.regionGet');
        Route::post('/category-get', [JobVacancyController::class, 'categoryidGet'])->name('rats-5768.categoryidGet');
        Route::post('/vacancy-create', [JobVacancyController::class, 'create'])->name('rats-5768.vacancyCreate');
        Route::get('/vacancy-edit/{id}', [JobVacancyController::class, 'edit'])->name('rats-5768.vacancyEdit');
        Route::post('/vacancy-update', [JobVacancyController::class, 'update'])->name('rats-5768.vacancyUpdate');
        Route::post('/vacancy-delete', [JobVacancyController::class, 'delete'])->name('rats-5768.vacancyDelete');
        Route::post('/vacancy-update-status', [JobVacancyController::class, 'updateStatus'])->name('rats-5768.vacancyUpdateStatus');
        Route::post('/pipeline-get', [JobVacancyController::class, 'pipelineGet'])->name('rats-5768.pipelineGet');
        Route::post('/get-sub-company', [JobVacancyController::class, 'subCompanyGet'])->name('rats-5768.subCompanyGet');

        /** TemplatesController */
        Route::post('/template-save', [TemplatesController::class, 'saveVacancyTemplate'])->name('rats-5768.saveVacancyTemplate');
        Route::get('/template-list', [TemplatesController::class, 'index'])->name('rats-5768.templateList');
        Route::post('/template-update', [TemplatesController::class, 'update'])->name('rats-5768.templateUpdate');
        Route::post('/template-delete', [TemplatesController::class, 'delete'])->name('rats-5768.templateDelete');
        Route::post('/template-get', [TemplatesController::class, 'templateGet'])->name('rats-5768.templateGet');

        /** MediaController */
        Route::get('/media-list', [MediaController::class, 'index'])->name('rats-5768.mediaList');
        Route::post('/media-save', [MediaController::class, 'create'])->name('rats-5768.mediaSave');
        Route::post('/media-edit', [MediaController::class, 'update'])->name('rats-5768.mediaUpdate');
        Route::get('/media-download/{id?}', [MediaController::class, 'download'])->name('rats-5768.mediaDownload');
        Route::post('/media-delete', [MediaController::class, 'delete'])->name('rats-5768.mediaDelete');

        /** MailTemplateController */
        Route::get('/mail-template-get', [MailTemplateController::class, 'index'])->name('rats-5768.emailTemplateList');
        Route::get('/mail-template-add', [MailTemplateController::class, 'add'])->name('rats-5768.emailTemplateAdd');
        Route::post('/mail-template-create', [MailTemplateController::class, 'create'])->name('rats-5768.emailTemplateCreate');
        Route::get('/mail-template-edit/{id?}', [MailTemplateController::class, 'edit'])->name('rats-5768.emailTemplateEdit');
        Route::post('/mail-template-update', [MailTemplateController::class, 'update'])->name('rats-5768.emailTemplateUpdate');
        Route::post('/mail-template-delete', [MailTemplateController::class, 'delete'])->name('rats-5768.emailTemplateDelete');

        Route::get('/mail-notification', [MailTemplateController::class, 'mailNotification'])->name('rats-5768.mailNotification');
        Route::post('/mail-notification-update', [MailTemplateController::class, 'mailNotificationUpdate'])->name('rats-5768.mailNotificationUpdate');

        /** ApllicationController */
        Route::get('/job-applied/{id}', [ApllicationController::class, 'index'])->name('rats-5768.jobApplied');
        
        /** EventController */
        Route::get('/event', [EventController::class, 'index'])->name('rats-5768.eventList');
        Route::get('/pending-event', [EventController::class, 'pendingEventGet'])->name('rats-5768.pendingEventGet');
        Route::get('/offer', [EventController::class, 'offerList'])->name('rats-5768.offerList');
        
        /** TalentPoolController */
        Route::get('/telant-poot', [TalentPoolController::class, 'index'])->name('rats-5768.telantPootList');
        Route::get('/telant-poot/{id?}', [TalentPoolController::class, 'talentPoolDetail'])->name('rats-5768.telantPootDetail');

        /** ReportController */
        Route::get('/report-list', [ReportController::class, 'reportList'])->name('rats-5768.reportList');
        Route::post('/report-data-get', [ReportController::class, 'reportDataGet'])->name('rats-5768.reportDataGet');
        Route::post('/report-time-to-hire', [ReportController::class, 'timeToHire'])->name('rats-5768.timeToHire');
        Route::post('/report-time-to-hire-get', [ReportController::class, 'reportTimeToHireAction'])->name('rats-5768.reportTimeToHireAction');
        Route::get('/report-print/{id?}', [ReportController::class, 'reportPrintAction'])->name('rats-5768.reportPrintAction');
        Route::get('/report-print-data/{id?}', [ReportController::class, 'reportPrintActionPrint'])->name('rats-5768.reportPrintActionPrint');
        
        /** JobAlertController */
        Route::get('/job-alert', [JobAlertController::class, 'index'])->name('rats-5768.jobAlertList');
        Route::post('/job-alert-create', [JobAlertController::class, 'create'])->name('rats-5768.jobAlertCreate');
        Route::get('/terms-and-condition', [JobAlertController::class, 'termsCondition'])->name('rats-5768.termsConditionList');
        Route::post('/terms-and-condition-create', [JobAlertController::class, 'termsConditionCreate'])->name('rats-5768.termsConditionCreate');
        Route::get('/offline-candidate', [JobAlertController::class, 'offlineCandidate'])->name('rats-5768.offlineCandidate');
        Route::post('/offline-candidate-save', [JobAlertController::class, 'offlineCandidateSave'])->name('rats-5768.offlineCandidateSave');

        Route::get('/privacy-policy', [JobAlertController::class, 'privacyPolicy'])->name('rats-5768.privacyPolicy');
        Route::post('/privacy-policy-create', [JobAlertController::class, 'privacyPolicyCreate'])->name('rats-5768.privacyPolicyCreate');
        
        Route::get('/gdpr', [JobAlertController::class, 'getGDPR'])->name('rats-5768.getGDPR');
        Route::post('/gdpr-create', [JobAlertController::class, 'getGDPRCreate'])->name('rats-5768.getGDPRCreate');

        /** ChatModalController */
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('rats-5768.indexList');

        
    });


});
/*adminside route*/
