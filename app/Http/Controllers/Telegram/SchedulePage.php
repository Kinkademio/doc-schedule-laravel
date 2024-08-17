<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\Views\PreferredDoctorsScheduleView;
use App\Models\Views\ScheduleProjectDocScheduleView;
use App\Models\Views\UserDoctorView;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SchedulePage extends Controller
{


  public function viewSchedulePage(){
    return view('telegram.schedule_layout', []);
  }

  public function viewUserSchedule($telegram_id){

    if ($telegram_id == null || !is_numeric($telegram_id)){
      return response()->json(['preferSchedule' =>[]]);
    }

    $user = User::where(['telegram_id' => $telegram_id])->first();

    if (!$user){
      return response()->json(['preferSchedule' =>[]]);
    }


    $docSchedule = ScheduleProjectDocScheduleView::where(['КодДоктора' => $user->hr_id, 'Утверждено' => true])->get();

    $resultScheduleStruct = [];
    foreach ($docSchedule as $schedule){
      foreach ($schedule['СменыНаМесяц'] as $one){
        if($one['Смена'] !==null){
          $resultScheduleStruct[] = [
            "КодДоктора" => $schedule['КодДоктора'],
            "Дата" => $one['Дата'],
            "КодТипаРабочейСмены" =>$one['Смена']['Код'],
            "ТипРабочейСмены" => $one['Смена'],
          ];
        }
      }
    }

    $preferSchedule = $resultScheduleStruct;
    foreach ($preferSchedule as $one) {
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
    return response()->json(['preferSchedule' => $preferSchedule]);
  }
}
