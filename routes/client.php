<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\CandidateController;
use App\Http\Controllers\admin\JobVacancyController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\admin\RecruiterController;
use App\Http\Controllers\admin\JobWorkFlowController;
use App\Http\Controllers\admin\ApllicationController;
use App\Http\Controllers\admin\TemplatesController;
use App\Http\Controllers\admin\MediaController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\SiteAddressController;
use App\Http\Controllers\admin\MailTemplateController;
use App\Http\Controllers\admin\TalentPoolController;
use App\Http\Controllers\admin\AdvertisementOptionController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\BenefitPackageController;
use App\Http\Controllers\admin\ChatModalController;
use App\Http\Controllers\admin\SubClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OutlookCalendarController;




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


Route::group(['prefix' => 'client'], function () {
    Route::group(['middleware' => ['auth','guest','CheckUserRole']], function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('client.dashboard');
        Route::post('/dashboard-client-activity', [DashboardController::class, 'clientActivity'])->name('client.dashboard.clientActivity');

        Route::get('/settings', [SettingController::class, 'showSetting'])->name('client.showSetting');
        Route::post('/account-setting', [SettingController::class, 'accountSetting'])->name('client.accountSetting');
        Route::post('/change-password', [SettingController::class, 'changePassword'])->name('client.changePassword');
        Route::post('/site-setting', [SettingController::class, 'siteSetting'])->name('client.site.setting');
        Route::post('/social-setting', [SettingController::class, 'socialLink'])->name('client.social.setting');
        Route::post('/client-vacancyEditprofile', [SettingController::class, 'clientProfile'])->name('client.clientProfile');
        Route::post('/client-job-detail-setting', [SettingController::class, 'clientJobDetailSetting'])->name('client.clientJobDetailSetting');
        Route::post('/business-hours-save', [SettingController::class, 'businessHoursSave'])->name('client.businessHoursSave');

        /** CandidateController */
        Route::get('/candidate-list', [CandidateController::class, 'index'])->name('client.candidateList');

        /** SubClientController */
        Route::get('/client-list', [SubClientController::class, 'index'])->name('client.clientList');
        Route::get('/client-add', [SubClientController::class, 'add'])->name('client.clientAdd');
        Route::post('/client-create', [SubClientController::class, 'create'])->name('client.clientCreate');
        Route::get('/client-edit/{id}', [SubClientController::class, 'edit'])->name('client.clientEdit');
        Route::post('/client-update', [SubClientController::class, 'update'])->name('client.clientUpdate');
        Route::post('/client-delete', [SubClientController::class, 'delete'])->name('client.clientDelete');
        Route::post('/client-status', [StaffController::class, 'statusUpdate'])->name('client.subClientStatusUpdate');

        /** StaffController */
        Route::get('/staff-list', [StaffController::class, 'index'])->name('client.staffList');
        Route::get('/staff-add', [StaffController::class, 'add'])->name('client.staffAdd');
        Route::post('/staff-create', [StaffController::class, 'create'])->name('client.staffCreate');
        Route::get('/staff-edit/{id}', [StaffController::class, 'edit'])->name('client.staffEdit');
        Route::post('/staff-update', [StaffController::class, 'update'])->name('client.staffUpdate');
        Route::post('/staff-delete', [StaffController::class, 'delete'])->name('client.staffDelete');
        Route::post('/staff-status', [StaffController::class, 'statusUpdate'])->name('client.statusUpdate');

        /** RecruiterController */
        Route::get('/recruiter-list', [RecruiterController::class, 'index'])->name('client.recruiterList');
        // Route::get('/recruiter-add', [RecruiterController::class, 'add'])->name('client.recruiterAdd');
        // Route::post('/recruiter-create', [RecruiterController::class, 'create'])->name('client.recruiterCreate');
        // Route::get('/recruiter-edit/{id}', [RecruiterController::class, 'edit'])->name('client.recruiterEdit');
        // Route::post('/recruiter-update', [RecruiterController::class, 'update'])->name('client.recruiterUpdate');
        // Route::post('/recruiter-delete', [RecruiterController::class, 'delete'])->name('client.recruiterDelete');
        
        
        /** JobVacancyController */
        Route::get('/vacancy-list', [JobVacancyController::class, 'index'])->name('client.vacancyList');
        Route::get('/vacancy-add', [JobVacancyController::class, 'add'])->name('client.vacancyAdd');
        Route::post('/region-get', [JobVacancyController::class, 'regionGet'])->name('client.regionGet');
        Route::post('/category-get', [JobVacancyController::class, 'categoryidGet'])->name('client.categoryidGet');
        Route::post('/vacancy-create', [JobVacancyController::class, 'create'])->name('client.vacancyCreate');
        Route::get('/vacancy-edit/{id}', [JobVacancyController::class, 'edit'])->name('client.vacancyEdit');
        Route::post('/vacancy-update', [JobVacancyController::class, 'update'])->name('client.vacancyUpdate');
        Route::post('/vacancy-delete', [JobVacancyController::class, 'delete'])->name('client.vacancyDelete');
        Route::post('/vacancy-update-status', [JobVacancyController::class, 'updateStatus'])->name('client.vacancyUpdateStatus');
        Route::post('/pipeline-get', [JobVacancyController::class, 'pipelineGet'])->name('client.pipelineGet');

        /** TemplatesController */
        Route::post('/template-save', [TemplatesController::class, 'saveVacancyTemplate'])->name('client.saveVacancyTemplate');
        Route::get('/template-list', [TemplatesController::class, 'index'])->name('client.templateList');
        Route::post('/template-update', [TemplatesController::class, 'update'])->name('client.templateUpdate');
        Route::post('/template-delete', [TemplatesController::class, 'delete'])->name('client.templateDelete');
        Route::post('/template-get', [TemplatesController::class, 'templateGet'])->name('client.templateGet');

        /** MediaController */
        Route::get('/media-list', [MediaController::class, 'index'])->name('client.mediaList');
        Route::post('/media-save', [MediaController::class, 'create'])->name('client.mediaSave');
        Route::post('/media-edit', [MediaController::class, 'update'])->name('client.mediaUpdate');
        Route::get('/media-download/{id?}', [MediaController::class, 'download'])->name('client.mediaDownload');
        Route::post('/media-delete', [MediaController::class, 'delete'])->name('client.mediaDelete');

        /** JobStatusController */
        Route::get('/job-workflow-list', [JobWorkFlowController::class, 'index'])->name('client.jobWorkFlowList');
        Route::post('/job-workflow-add', [JobWorkFlowController::class, 'create'])->name('client.jobWorkFlowAdd');
        Route::post('/job-workflow-update', [JobWorkFlowController::class, 'update'])->name('client.jobWorkFlowUpdate');
        Route::post('/job-workflow-delete', [JobWorkFlowController::class, 'delete'])->name('client.jobWorkFlowDelete');
        Route::get('/job-workflow-stage/{id}', [JobWorkFlowController::class, 'jobWorkFlowStage'])->name('client.jobWorkFlowStage');
        Route::post('/job-workflow-stage-create', [JobWorkFlowController::class, 'jobWorkFlowStageCreate'])->name('client.jobWorkFlowStageCreate');
        Route::post('/job-workflow-stage-update', [JobWorkFlowController::class, 'jobWorkFlowStageUpdate'])->name('client.jobWorkFlowStageUpdate');
        Route::post('/job-workflow-stage-delete', [JobWorkFlowController::class, 'jobWorkFlowStageDelete'])->name('client.jobWorkFlowStageDelete');

        /** ApllicationController */
        Route::get('/job-applied/{id}', [ApllicationController::class, 'index'])->name('client.jobApplied');

        /** EventController */
        Route::get('/event', [EventController::class, 'index'])->name('client.eventList');
        Route::get('/pending-event', [EventController::class, 'pendingEventGet'])->name('client.pendingEventGet');
        Route::get('/offer', [EventController::class, 'offerList'])->name('client.offerList');

        /** ApllicationController */
        Route::get('/address-get', [SiteAddressController::class, 'index'])->name('client.siteAddress');
        Route::post('/address-save', [SiteAddressController::class, 'create'])->name('client.siteAddressCreate');
        Route::post('/address-update', [SiteAddressController::class, 'update'])->name('client.siteAddressUpdate');
        
        /** MailTemplateController */
        Route::get('/mail-template-get', [MailTemplateController::class, 'index'])->name('client.emailTemplateList');
        Route::get('/mail-template-add', [MailTemplateController::class, 'add'])->name('client.emailTemplateAdd');
        Route::post('/mail-template-create', [MailTemplateController::class, 'create'])->name('client.emailTemplateCreate');
        Route::get('/mail-template-edit/{id?}', [MailTemplateController::class, 'edit'])->name('client.emailTemplateEdit');
        Route::post('/mail-template-update', [MailTemplateController::class, 'update'])->name('client.emailTemplateUpdate');
        Route::post('/mail-template-delete', [MailTemplateController::class, 'delete'])->name('client.emailTemplateDelete');

        /** TalentPoolController */
        Route::get('/telant-poot', [TalentPoolController::class, 'index'])->name('client.telantPootList');
        Route::get('/telant-poot/{id?}', [TalentPoolController::class, 'talentPoolDetail'])->name('client.telantPootDetail');

        /** AdvertisementOptionController */
        Route::get('/advertisement-option-list', [AdvertisementOptionController::class, 'index'])->name('client.advertisementOptionList');
        Route::post('/advertisement-option-create', [AdvertisementOptionController::class, 'create'])->name('client.advertisementOptionCreate');
        Route::post('/advertisement-option-update', [AdvertisementOptionController::class, 'update'])->name('client.advertisementOptionUpdate');
        Route::post('/advertisement-option-delete', [AdvertisementOptionController::class, 'delete'])->name('client.advertisementOptionDelete');

        /** ReportController */
        Route::get('/report-list', [ReportController::class, 'reportList'])->name('client.reportList');
        Route::post('/report-data-get', [ReportController::class, 'reportDataGet'])->name('client.reportDataGet');
        Route::post('/report-time-to-hire', [ReportController::class, 'timeToHire'])->name('client.timeToHire');
        Route::post('/report-time-to-hire-get', [ReportController::class, 'reportTimeToHireAction'])->name('client.reportTimeToHireAction');
        Route::get('/report-print/{id?}', [ReportController::class, 'reportPrintAction'])->name('client.reportPrintAction');
        Route::get('/report-print-data/{id?}', [ReportController::class, 'reportPrintActionPrint'])->name('client.reportPrintActionPrint');
        
        /** BenefitPackageController */
        Route::get('/benefit-package-list', [BenefitPackageController::class, 'index'])->name('client.benefitPackageList');
        Route::get('/benefit-package-add', [BenefitPackageController::class, 'add'])->name('client.benefitPackageAdd');
        Route::post('/benefit-package-save', [BenefitPackageController::class, 'save'])->name('client.benefitPackageSave');
        Route::get('/benefit-package-edit/{id}', [BenefitPackageController::class, 'edit'])->name('client.benefitPackageEdit');
        Route::post('/benefit-package-update', [BenefitPackageController::class, 'update'])->name('client.benefitPackageUpdate');
        Route::post('/benefit-package-delete', [BenefitPackageController::class, 'delete'])->name('client.benefitPackageDelete');

        /** ChatModalController */
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('client.indexList');

    });  


});

Route::get('/outlook-calendar-controller', [OutlookCalendarController::class, 'calendar'])->name('client.calendar');