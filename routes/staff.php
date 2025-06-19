<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\JobVacancyController;
use App\Http\Controllers\admin\TemplatesController;
use App\Http\Controllers\admin\ApllicationController;
use App\Http\Controllers\admin\MediaController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\TalentPoolController;
use App\Http\Controllers\admin\ReportController;
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


Route::group(['prefix' => 'staff'], function () {
    Route::group(['middleware' => ['auth','guest','CheckUserRole']], function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
        Route::post('/dashboard-client-activity', [DashboardController::class, 'clientActivity'])->name('staff.dashboard.clientActivity');

        Route::get('/settings', [SettingController::class, 'showSetting'])->name('staff.showSetting');
        Route::post('/account-setting', [SettingController::class, 'accountSetting'])->name('staff.accountSetting');
        Route::post('/change-password', [SettingController::class, 'changePassword'])->name('staff.changePassword');
        Route::post('/business-hours-save', [SettingController::class, 'businessHoursSave'])->name('staff.businessHoursSave');

        /** JobVacancyController */
        Route::get('/vacancy-list', [JobVacancyController::class, 'index'])->name('staff.vacancyList');
        Route::get('/vacancy-add', [JobVacancyController::class, 'add'])->name('staff.vacancyAdd');
        Route::post('/region-get', [JobVacancyController::class, 'regionGet'])->name('staff.regionGet');
        Route::post('/category-get', [JobVacancyController::class, 'categoryidGet'])->name('staff.categoryidGet');
        Route::post('/vacancy-create', [JobVacancyController::class, 'create'])->name('staff.vacancyCreate');
        Route::get('/vacancy-edit/{id}', [JobVacancyController::class, 'edit'])->name('staff.vacancyEdit');
        Route::post('/vacancy-update', [JobVacancyController::class, 'update'])->name('staff.vacancyUpdate');
        Route::post('/vacancy-delete', [JobVacancyController::class, 'delete'])->name('staff.vacancyDelete');
        Route::post('/vacancy-update-status', [JobVacancyController::class, 'updateStatus'])->name('staff.vacancyUpdateStatus');
        Route::post('/pipeline-get', [JobVacancyController::class, 'pipelineGet'])->name('staff.pipelineGet');

        /** TemplatesController */
        Route::post('/template-save', [TemplatesController::class, 'saveVacancyTemplate'])->name('staff.saveVacancyTemplate');
        Route::get('/template-list', [TemplatesController::class, 'index'])->name('staff.templateList');
        Route::post('/template-update', [TemplatesController::class, 'update'])->name('staff.templateUpdate');
        Route::post('/template-delete', [TemplatesController::class, 'delete'])->name('staff.templateDelete');
        Route::post('/template-get', [TemplatesController::class, 'templateGet'])->name('staff.templateGet');

        /** MediaController */
        Route::get('/media-list', [MediaController::class, 'index'])->name('staff.mediaList');
        Route::post('/media-save', [MediaController::class, 'create'])->name('staff.mediaSave');
        Route::post('/media-edit', [MediaController::class, 'update'])->name('staff.mediaUpdate');
        Route::get('/media-download/{id?}', [MediaController::class, 'download'])->name('staff.mediaDownload');
        Route::post('/media-delete', [MediaController::class, 'delete'])->name('staff.mediaDelete');

        /** ApllicationController */
        Route::get('/job-applied/{id}', [ApllicationController::class, 'index'])->name('staff.jobApplied');

        /** EventController */
        Route::get('/event', [EventController::class, 'index'])->name('staff.eventList');
        Route::get('/pending-event', [EventController::class, 'pendingEventGet'])->name('staff.pendingEventGet');
        Route::get('/offer', [EventController::class, 'offerList'])->name('staff.offerList');

        /** TalentPoolController */
        Route::get('/telant-poot', [TalentPoolController::class, 'index'])->name('staff.telantPootList');
        Route::get('/telant-poot/{id?}', [TalentPoolController::class, 'talentPoolDetail'])->name('staff.telantPootDetail');

        /** ReportController */
        Route::get('/report-list', [ReportController::class, 'reportList'])->name('staff.reportList');
        Route::post('/report-data-get', [ReportController::class, 'reportDataGet'])->name('staff.reportDataGet');

        /** ChatModalController */
        Route::get('/chat-message', [ChatModalController::class, 'index'])->name('staff.indexList');

    });  


});