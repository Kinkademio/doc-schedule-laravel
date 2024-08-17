<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

;

use App\Models\Views\PreferredDoctorsSchedule;
use App\Models\Views\PreferredDoctorsScheduleView;
use App\Models\WorkScheduleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctors;

class ProfileController extends CabinetBaseController
{
  /**
   * Профиль пользователя сайта
   */
  public function getUserProfile()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    $userData = Auth::user()->hrInfo;

    $workScheduleTypes = WorkScheduleTypes::get();
    foreach ($workScheduleTypes as $type) {
      $seconds1 = strtotime($type['ВремяНачала']);
      $seconds2 = strtotime($type['Продолжительность']);
      $seconds3 = strtotime($type['Перерыв']);
      $totalSeconds = $seconds1 + $seconds2 + $seconds3;
      $result = date('H:i:s', $totalSeconds);
      $type['ВремяОкончания'] = $result;
    }

    // Получаем текущий год и месяц
    $currentYear = date('Y');
    $currentMonth = date('m');

    // Увеличиваем месяц на 1
    $nextMonth = $currentMonth + 1;
    // Если следующий месяц - январь, то увеличиваем год на 1
    if ($nextMonth > 12) {
      $nextMonth = 1;
      $nextYear = $currentYear + 1;
    } else {
      $nextYear = $currentYear;
    }

    // Получаем начало следующего месяца
    $startNextMonth = date('Y-m-d', mktime(0, 0, 0, $nextMonth, 1, $nextYear));
    // Получаем конец следующего месяца
    $endNextMonth = date('Y-m-d', mktime(0, 0, 0, $nextMonth + 1 , 0, $nextYear));


    $preferSchedule = PreferredDoctorsScheduleView::where(['КодДоктора' => Auth::user()->hr_id])->whereBetween( 'Дата', [$startNextMonth, $endNextMonth])->get();

    foreach ($preferSchedule as $one) {
      $one['Дата'] = $one['Дата'] . 'T' . $one->ТипРабочейСмены['ВремяНачала'];

      // Разделяем исходную дату и время
      list($date, $time) = explode('T', $one['Дата']);
      // Разделяем время, которое нужно добавить
      list($addHours, $addMinutes, $addSeconds) = explode(':',  $one->ТипРабочейСмены['Продолжительность']);
      list($addHours2, $addMinutes2, $addSeconds2) = explode(':',  $one->ТипРабочейСмены['Перерыв']);

      // Преобразуем время в секунды
      $addSeconds = $addHours * 3600 + $addMinutes * 60 + $addSeconds;
      $addSeconds2 = $addHours2 * 3600 + $addMinutes2 * 60 + $addSeconds2;

      // Преобразуем исходное время в секунды
      list($hours, $minutes, $seconds) = explode(':', $time);
      $originalSeconds = $hours * 3600 + $minutes * 60 + $seconds;
      // Складываем секунды
      $totalSeconds = $originalSeconds + $addSeconds + $addSeconds2;
      // Преобразуем секунды в часы, минуты и секунды
      $newHours = floor($totalSeconds / 3600);
      $newMinutes = floor(($totalSeconds % 3600) / 60);
      $newSeconds = $totalSeconds % 60;
      // Форматируем новое время
      $newTime = sprintf('%02d:%02d:%02d', $newHours, $newMinutes, $newSeconds);
      // Объединяем новую дату и время
      $newDateTime = $date . 'T' . $newTime;

      $one['ДатаОкончания'] = $newDateTime;
    }

    return $this->createPageView(
      'cabinet.profile-account',
      ['hrInfo' => $userData,
        'workScheduleTypes' => $workScheduleTypes,
        'preferSchedule' => $preferSchedule
      ],
      'Профиль пользователя',
      'Профиль пользователя сервиса. На данной странице вы можете управлять своём персональной информацией и управлять уведомлениями в Telegram'
    );
  }

  /**
   * Страница защиты аккаунта
   */
  public function getUserSecurity()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    return $this->createPageView(
      'cabinet.profile-security',
      [],
      'Защита аккаунта',
      'Профиль пользователя сервиса. На данной странице вы можете управлять своём персональной информацией и управлять уведомлениями в Telegram'
    );
  }

  /**
   * Страница настройки уведомлений
   */
  public function getUserNotifications()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    return $this->createPageView(
      'cabinet.profile-notifications',
      [],
      'Настройка уведомлений',
      'Профиль пользователя сервиса. На данной странице вы можете управлять своём персональной информацией и управлять уведомлениями в Telegram'
    );
  }

  /**
   * Отписка от телеграма
   */
  public function unsubscribeTelegram()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!isset(Auth::user()->id)) return false;
    $user = Auth::user();
    $user->telegram_notifications = false;
    $user->save();
    return redirect()->back();
  }

  public function toggleMailNotifications()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!isset(Auth::user()->id)) return false;
    $userId = Auth::user()->id;
    $userData = User::where(['id' => $userId])->get()[0];
    $userData->mail_notifications = !$userData->mail_notifications;
    $userData->save();
    return true;
  }


  public function savePreferDocSchedule(Request $request){

    $events = $request->events;

    if(!$events || count($events) == 0) response()->json(['success'=>false, 'message'=>'Ошибка: Не верно переданы параметры'], 400);

    $firstEventTimestamp = strtotime($events[0]['start']);
    $month = date('m', $firstEventTimestamp);
    $year = date('Y', $firstEventTimestamp);
    $starMonth = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
    $endMonth = date('Y-m-d', mktime(0, 0, 0, $month + 1 , 0, $year));
    //Удаляем все события за месяц
    PreferredDoctorsSchedule::where(['КодДоктора' => Auth::user()->hr_id])->whereBetween( 'Дата', [$starMonth, $endMonth])->delete();

    //Заносим новые события в базу
    foreach ($events as $event){
      if($event['title'] !== 'Рабочий день'){
        continue;
      }
      $newScheduleDate = new PreferredDoctorsSchedule;
      $newScheduleDate->КодДоктора = Auth::user()->hr_id;
      $newScheduleDate->Дата = $event['start'];
      $newScheduleDate->КодТипаРабочейСмены = $event['description']['Код'];
      $newScheduleDate->save();
    }

    return response()->json(['success'=>true, 'message'=>'Данные успешно сохранены']);
  }

}
