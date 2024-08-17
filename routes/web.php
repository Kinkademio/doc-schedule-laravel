<?php


use App\Http\Controllers\Cabinet\CabinetEdit;
use App\Http\Controllers\Cabinet\Notifications;
use App\Http\Controllers\Cabinet\ScheduleProcess;
use App\Http\Controllers\Telegram\SchedulePage;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Guests\GuestsController;

use App\Http\Controllers\Cabinet\CabinetController;
use App\Http\Controllers\Cabinet\ProfileController;
use App\Http\Controllers\Cabinet\StatisticsController;
use App\Http\Controllers\Auth\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * REGION PUBLIC
 */
Route::get('/in_dev', [GuestsController::class, 'getInDevelopmentPage'])->name('in_dev');
Route::get('/recruit', [GuestsController::class, 'getRecruitPage'])->name('recruit');
Route::get('/', [GuestsController::class, 'getWelcomeLending'])->name('welcome');
Route::get('policy', [GuestsController::class, 'getUserAgreement'])->name('policy');
Route::get('/telegram/web/schedule', [SchedulePage::class, 'viewSchedulePage'])->name('telegram-schedule');
Route::get('/telegram/web/schedule/get/{telegram_id}', [SchedulePage::class, 'viewUserSchedule'])->name('telegram-schedule-get');

/**
 * REGION CLOSED
 */
Route::middleware('auth')->group(callback: function () {

    //Главная страница
    Route::get('/cabinet', [CabinetController::class, 'getUserCabinet'])->name('cabinet');
    Route::post('/cabinet/addForceMajor', [CabinetController::class, 'addForceMajor'])->name('cabinet-add-forcemajor');

    Route::get('/my-statistic', [StatisticsController::class, 'getDocStatistics'])->name('my-statistic');
    //Формирование расписания
    Route::get('/schedule/getDaysStatistic/{scheduleVersion}',[ScheduleProcess::class, 'getDaysScheduleStatistic']);
    Route::get('/schedule/getWeeksStatistic/{scheduleVersion}',[ScheduleProcess::class, 'getWeeksScheduleStatistic']);

    Route::get('/schedule/{date}/{version}', [ScheduleProcess::class, 'scheduleCreatePage'])->name('schedule-create-d-v');
    Route::get('/schedule/{date}', [ScheduleProcess::class, 'scheduleCreatePage'])->name('schedule-create-d');
    Route::get('/schedule', [ScheduleProcess::class, 'scheduleCreatePage'])->name('schedule-create');

    Route::post('/schedule/create-project', [ScheduleProcess::class, 'createNewScheduleProject']);
    Route::post('/schedule/project-approve', [ScheduleProcess::class, 'approveProject']);
    Route::post('/schedule/project-forming', [ScheduleProcess::class, 'scheduleStatusForming']);



    Route::post('/forming/schedule/add-work-day', [ScheduleProcess::class, 'addWorkDayToVersion']);
    Route::post('/forming/schedule/delete-work-day', [ScheduleProcess::class, 'deleteWorkDayFromVersion']);
    Route::post('/forming/schedule/edit-work-day', [ScheduleProcess::class, 'editWorkDayToVersion']);

    Route::get('/download/schedule/{version}', [ScheduleProcess::class, 'downloadExcel']);

    Route::post('/schedule/generate-new-version', [ScheduleProcess::class, 'generateNewVersion']);

  Route::get('/forecasts', [CabinetEdit::class, 'workWithForecasts'])->name('forecasts');
  Route::get('/forecasts/get/{date}', [CabinetEdit::class, 'getForecastTable'])->name('forecasts-get-table');

    //Профиль пользователя
    Route::prefix('profile')->group(function(){
      Route::get('/', [ProfileController::class, 'getUserProfile'])->name('profile-account');
      Route::post('/save/prefer_schedule', [ProfileController::class, 'savePreferDocSchedule'])->name('save-prefer-schedule');
      Route::get('/security', [ProfileController::class, 'getUserSecurity'])->name('profile-security');
      Route::post('/resetPassword', [PasswordController::class, 'update'])->name('cabinet-password-reset');
      Route::get('/notifications', [ProfileController::class, 'getUserNotifications'])->name('profile-notifications');
      Route::post('/unsubscribeTelegram', [ProfileController::class, 'unsubscribeTelegram'])->name('unsubscribe-telegram');
      Route::post('/toggleMailNotifications', [ProfileController::class, 'toggleMailNotifications'])->name('toggle-mail-notification');
    });

    Route::prefix('admin')->group(function(){
      Route::get('/system_notifications', [Notifications::class, 'workWithNotificationsPage'])->name('notification-data-view-notification');
      Route::post('/system_notifications/create', [Notifications::class, 'createEditNotification'])->name('notification-data-create-notification');
      Route::post('/system_notifications/read', [Notifications::class, 'markSystemMessageAsRead'])->name('notification-data-read-notification');
      Route::get('/system_notifications/notification-table-data',[Notifications::class, 'getNotificationDataTable'])->name('notification-data-get-notification-table-data');
      Route::get('/system_notifications/delete/{id}', [Notifications::class, 'deleteSystemNotification'])->name('notification-data-delete-notification');


      Route::post('/month_constants/edit', [CabinetEdit::class, 'editScheduleConstants'])->name('month_constants-edit');

      Route::get('/edit', [CabinetEdit::class, 'workWithEditPage'])->name('data-edit');

      //Пользователи
      Route::get('/account', [CabinetEdit::class, 'workWithUsersPage'])->name('data-edit-account');
      Route::get('/hr', [CabinetEdit::class, 'workWithHrPage'])->name('data-edit-hr');
      Route::post('/hr/create', [CabinetEdit::class, 'createEditHr'])->name('hr-data-create-hr');
      Route::get('/hr/delete/{id}', [CabinetEdit::class, 'deleteHr'])->name('hr-data-delete-hr');
      Route::get('/access', [CabinetEdit::class, 'workWithAccessPage'])->name('data-edit-access');

      //Справочники
      Route::get('/modals', [CabinetEdit::class, 'workWithModalsPage'])->name('data-edit-modals');
      Route::get('/research', [CabinetEdit::class, 'workWithResearchPage'])->name('data-edit-research');
      Route::get('/schedule', [CabinetEdit::class, 'workWithSchedulePage'])->name('data-edit-schedule');
      Route::get('/vacation', [CabinetEdit::class, 'workWithVacationPage'])->name('data-edit-vacation');
      Route::get('/month_constants', [CabinetEdit::class, 'workWithMonthConstants'])->name('data-edit-month_constants');
    });

    Route::prefix('statistics')->group(function(){
      Route::get('/', [StatisticsController::class, 'getModalsStatistics'])->name('statistics-modals');
      //Route::get('/statistics-alldocs', [StatisticsController::class, 'getAllDocsStatistics'])->name('statistics-alldocs');
    });


});

require_once __DIR__.'/auth.php';
