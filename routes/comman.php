<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ApllicationController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\frontend\ApplicationsController as FrontendApplicationsController;
use App\Http\Controllers\admin\MailTemplateController;
use App\Http\Controllers\admin\TalentPoolController;
use App\Http\Controllers\admin\BenefitPackageController;
use App\Http\Controllers\admin\ChatModalController;
use App\Http\Controllers\admin\CandidateController;
use App\Http\Controllers\admin\JobVacancyController;
use App\Http\Controllers\Controller;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\frontend\PendingEventController;




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

/*Comman route*/

    Route::group(['middleware' => ['auth']], function () {

        /** ApllicationController */
        Route::post('/job-status-data-get', [ApllicationController::class, 'statusJobDataGet'])->name('comman.jobApplied');
        Route::post('/job-status-stage-chage', [ApllicationController::class, 'chageStateSattus'])->name('comman.chageStateSattus');
        Route::post('/job-count', [ApllicationController::class, 'chageCount'])->name('comman.chageCount');
        Route::post('/job-data-get', [ApllicationController::class, 'jobDataGet'])->name('comman.jobDataGet');
        Route::post('/job-name-search', [ApllicationController::class, 'jobNameSearch'])->name('comman.jobNameSearch');
        Route::get('/file-download/{id?}', [ApllicationController::class, 'fileDownload'])->name('comman.fileDownload');
        Route::post('/unsuccessful-user-mail-send', [ApllicationController::class, 'unsuccessfulMailSend'])->name('comman.unsuccessfulMailSend');
        Route::post('/thumbs-status-change', [ApllicationController::class, 'thumbsStatusChange'])->name('comman.thumbsStatusChange');
        Route::post('/note-submit', [ApllicationController::class, 'noteSubmit'])->name('comman.noteSubmit');
        Route::post('/note-get', [ApllicationController::class, 'noteGet'])->name('comman.noteGet');

        /** EventController */
        Route::post('/add-event', [EventController::class, 'addEvent'])->name('comman.addEvent');
        Route::post('/edit-event', [EventController::class, 'editEvent'])->name('comman.editEvent');
        Route::post('/delete-event', [EventController::class, 'deleteEvent'])->name('comman.deleteEvent');
        Route::post('/event-cancel', [PendingEventController::class, 'getEventTimeReject'])->name('comman.getEventTimeReject');

        Route::post('/offer-create', [EventController::class, 'offerCreate'])->name('comman.offerCreate');
        Route::post('/offer-edit', [EventController::class, 'offerEdit'])->name('comman.offerEdit');
        Route::post('/offer-delete', [EventController::class, 'offerDelete'])->name('comman.offerDelete');
        Route::post('/offer-confirmed-leaving-reason', [EventController::class, 'offerConfirmedLeavingReason'])->name('comman.offerConfirmedLeavingReason');
        Route::post('/offer-status-change', [EventController::class, 'offerStatusChange'])->name('comman.offerStatusChange');

        /** Chat Message */
        Route::post('/message-get', [FrontendApplicationsController::class, 'saveUserChat'])->name('comman.saveUserChat');
        // Route::post('/message-send', [FrontendApplicationsController::class, 'saveUserMessageData'])->name('comman.saveUserMessageData');

        /** MailTemplateController */
        Route::post('/mail-send', [MailTemplateController::class, 'candidateMailSend'])->name('comman.candidateMailSend');
        Route::post('/mail-preview', [MailTemplateController::class, 'candidateMailPreview'])->name('comman.candidateMailPreview');

        /** TalentPoolController */
        Route::get('/telant-poot-file-download/{id?}', [TalentPoolController::class, 'fileDownload'])->name('comman.candidateFileDownload');
        Route::post('/telant-poot-search', [TalentPoolController::class, 'talentSearch'])->name('comman.talentSearch');


        /** NotificationsController */
        Route::post('/chage-notification', [NotificationsController::class, 'changeNotoficationStatus'])->name('comman.changeNotoficationStatus');
        Route::post('/marl-all-read-status', [NotificationsController::class, 'markAllReadStatus'])->name('comman.markAllReadStatus');
        Route::post('/view-notification', [NotificationsController::class, 'viewNotification'])->name('comman.viewNotification');

        Route::post('/benefit-package-data-get', [BenefitPackageController::class, 'benefitPackageDataGet'])->name('comman.benefitPackageDataGet');

        /** ChatModalController */
        Route::post('/chat-message-get', [ChatModalController::class, 'chatModal'])->name('comman.chatModal');
        Route::post('/chat-message-send', [ChatModalController::class, 'sendChat'])->name('comman.sendChat');
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('comman.indexList');
        Route::post('/chat-user-message-all-data', [ChatModalController::class, 'userMessageAllData'])->name('comman.userMessageAllData');
        Route::post('/chat-user-message-search', [ChatModalController::class, 'userMessageAllDataSearch'])->name('comman.userMessageAllDataSearch');
        Route::post('/view-chat-count', [ChatModalController::class, 'viewChatCount'])->name('comman.viewChatCount');
        Route::post('/view-message', [ChatModalController::class, 'viewMessage'])->name('comman.viewMessage');

        Route::post('/job-skill-get', [CandidateController::class, 'jobSkillGet'])->name('comman.jobSkillGet');

        Route::post('/check-login-status', [NotificationsController::class, 'checkLoginStatus'])->name('comman.checkLoginStatus');

        Route::post('/outlook-date-time', [EventController::class, 'outLookDateTime'])->name('comman.outLookDateTime');
        Route::post('/get-user-vacancy', [JobVacancyController::class, 'getUserVacancy'])->name('comman.getUserVacancy');

    });


/*Comman route*/
