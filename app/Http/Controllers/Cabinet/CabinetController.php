<?php

namespace App\Http\Controllers\Cabinet;

use App\Models\Doctors;
use App\Models\ScheduleProjects;
use App\Models\ScheduleProjectVersions;
use App\Models\ScheduleProjectWorkDates;
use App\Models\SystemNotifications;
use App\Models\Views\PreferredDoctorsScheduleView;
use App\Models\Views\ScheduleProjectDocScheduleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends CabinetBaseController
{
  /**
   * Профиль пользователя сайта
   */
  public function getUserCabinet(){

    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    $userData = Auth::user()->hrInfo;

    $docSchedule = ScheduleProjectDocScheduleView::where(['КодДоктора' => Auth::user()->hr_id, 'Утверждено' => true])->get();
    $resultScheduleStruct = [];
    foreach ($docSchedule as $schedule){
        foreach ($schedule['СменыНаМесяц'] as $one){
          if($one['Смена'] !== null){
            $resultScheduleStruct[] = [
              "КодДоктора" => $schedule['КодДоктора'],
              "Дата" => $one['Дата'],
              "КодТипаРабочейСмены" =>$one['Смена']['Код'],
              "ТипРабочейСмены" => $one['Смена'],
              "Комментарий" => $one['Запись']['Комментарий']
            ];
          }
        }
    }


    foreach ($resultScheduleStruct as &$one) {
      $startTime = strtotime($one['ТипРабочейСмены']['ВремяНачала']);
      $one['Дата'] = $one['Дата'] . 'T' . date("H:i:s", $startTime);


      // Разделяем исходную дату и время
      list($date, $time) = explode('T', $one['Дата']);
      // Разделяем время, которое нужно добавить
      list($addHours, $addMinutes, $addSeconds) = explode(':',  $one['ТипРабочейСмены']['Продолжительность']);
      list($addHours2, $addMinutes2, $addSeconds2) = explode(':',  $one['ТипРабочейСмены']['Перерыв']);

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
      'cabinet.cabinet',
      ['hrInfo' => $userData,
        'workShift' => $resultScheduleStruct ],
      'Кабинет сотрудника',
      'Главная страница кабинета сотрудника.'
    );
  }

  public function addForceMajor(Request $request){
    $date = $request->dataEvent;
    $text = $request->text;
    $doctor = $request->hrId;

    //Получаем дату для которой была создана версия
    $dateVersion = substr($date, 0, 7);
    $docSchedule = ScheduleProjects::where(['КодСтатуса' => 2, 'ДатаНачала' => $dateVersion . "-01"])->first();
    $version = ScheduleProjectVersions::where(['КодПроектаРасписания' => $docSchedule->Код, 'Утверждено' => true])->first();
    $scheduleRecord = ScheduleProjectWorkDates::where(['КодВерсииПроектаРасписания'=> $version->Код, 'КодДоктора' => $doctor, 'Дата'=> $date])->first();
    ScheduleProjectWorkDates::addForcemajor($scheduleRecord->Код ,$text);

    return redirect()->back();
  }
}
