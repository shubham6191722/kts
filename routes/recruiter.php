<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\JobVacancyController;
use App\Http\Controllers\admin\RecruiterCandidateController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\ChatModalController;
use App\Http\Controllers\frontend\PendingEventController;
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


Route::group(['prefix' => 'recruiter'], function () {
    Route::group(['middleware' => ['auth','guest','CheckUserRole']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('recruiter.dashboard');

        Route::get('/settings', [SettingController::class, 'showSetting'])->name('recruiter.showSetting');
        Route::post('/account-setting', [SettingController::class, 'accountSetting'])->name('recruiter.accountSetting');
        Route::post('/change-password', [SettingController::class, 'changePassword'])->name('recruiter.changePassword');

        /** JobVacancyController */
        Route::get('/vacancy-list', [JobVacancyController::class, 'index'])->name('recruiter.vacancyList');
        Route::get('/vacancy-list/{id?}', [JobVacancyController::class, 'recruiterViewVacancy'])->name('recruiter.recruiterViewVacancy');
        Route::get('/vacancy-download/{id?}', [JobVacancyController::class, 'recruiterDownloadVacancy'])->name('recruiter.recruiterDownloadVacancy');

        /** RecruiterCandidateController */
        Route::get('/recruiter-candidate-list', [RecruiterCandidateController::class, 'index'])->name('recruiter.recruiterCandidateList');
        Route::get('/recruiter-candidate-add', [RecruiterCandidateController::class, 'add'])->name('recruiter.recruiterCandidateAdd');
        Route::post('/recruiter-candidate-create', [RecruiterCandidateController::class, 'create'])->name('recruiter.recruiterCandidateCreate');
        Route::get('/recruiter-candidate-edit/{id?}', [RecruiterCandidateController::class, 'edit'])->name('recruiter.recruiterCandidateEdit');
        Route::post('/recruiter-candidate-update', [RecruiterCandidateController::class, 'update'])->name('recruiter.recruiterCandidateUpdate');
        Route::post('/recruiter-candidate-delete', [RecruiterCandidateController::class, 'delete'])->name('recruiter.recruiterCandidateDelete');
        Route::get('/recruiter-candidate-download/{id?}', [RecruiterCandidateController::class, 'recruiterDownloadCV'])->name('recruiter.recruiterDownloadCV');

        /** EventController */
        Route::get('/event', [EventController::class, 'index'])->name('recruiter.eventList');
        Route::get('/offer', [EventController::class, 'offerList'])->name('recruiter.offerList');
        Route::post('/offer-accept', [EventController::class, 'offerAccept'])->name('recruiter.offerAccept');
        Route::post('/offer-declin', [EventController::class, 'offerDeclin'])->name('recruiter.offerDeclin');

        /** ChatModalController */
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('recruiter.indexList');

        /** PendingEventController */
        Route::get('/event-time/{id?}', [PendingEventController::class, 'getEventTime'])->name('recruiter.getEventTime');
        Route::post('/event-time-reject', [PendingEventController::class, 'getEventTimeReject'])->name('recruiter.getEventTimeReject');
        Route::post('/event-time-schedule', [PendingEventController::class, 'saveScheduleEventTime'])->name('recruiter.saveScheduleEventTime');

    });  


});