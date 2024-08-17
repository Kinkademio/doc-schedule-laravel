<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Auth\User as UserData;
use App\Models\ScheduleProjectGenerations;
use App\Models\ScheduleProjects;
use App\Models\ScheduleProjectStatus;
use App\Models\ScheduleProjectVersions;
use App\Models\ScheduleProjectWorkDates;
use App\Models\Views\ProjectStatisticByDay;
use App\Models\Views\ProjectStatisticByWeek;
use App\Models\Views\ScheduleGenerationErrors;
use App\Models\Views\ScheduleProjectDocScheduleView;
use App\Models\WorkScheduleTypes;
use finfo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GRequest;
use Illuminate\Http\Request;

class ScheduleProcess extends CabinetBaseController
{
  public function scheduleCreatePage($date = null, $versionId = null)
  {

    if (!UserData::userHasExtension('schedule.create', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    $projectStatuses = ScheduleProjectStatus::get();
    $tmpStatuses = [];
    foreach ($projectStatuses as $project) {
      $tmpStatuses[$project->Код] = $project;
    }
    $projectStatuses = $tmpStatuses;

    //Получаем дату
    if (!$date) {
      $date = now()->format('Y-m');
    }

    //Получаем проекты расписания по этой дате их может и не быть
    $project = ScheduleProjects::where(['ДатаНачала' => $date . '-01'])->first();

    //Получаем версии проектов расписания
    $versions = $project ? ScheduleProjectVersions::where(['КодПроектаРасписания' => $project['Код']])->get() : [];
    $currentVersion = null;
    if (!$versionId) {
      if ($project) {
        if ($project['КодВерсииТекущей']) {
          $versionId = $project['КодВерсииТекущей'];
        } elseif (count($versions) > 0) {
          $versionId = $versions[0]->Код;
        }
      }
    }
    if ($versionId) {
      $currentVersion = ScheduleProjectVersions::where(['Код' => $versionId])->first();
    }

    $versionData = $versionId ? ScheduleProjectDocScheduleView::where(['КодВерсииПроектаРасписания' => $versionId, 'Диапазон' => $date . '-01'])->get() : [];
    $versionErrorsData = $versionId ? ScheduleGenerationErrors::where(['КодВерсииПроектаРасписания' => $versionId])->get() : [];


    $workScheduleTypes = WorkScheduleTypes::get();
    foreach ($workScheduleTypes as $type) {
      $seconds1 = strtotime($type['ВремяНачала']);
      $seconds2 = strtotime($type['Продолжительность']);
      $seconds3 = strtotime($type['Перерыв']);
      $totalSeconds = $seconds1 + $seconds2 + $seconds3;
      $result = date('H:i:s', $totalSeconds);
      $type['ВремяОкончания'] = $result;
    }


    return $this->createPageView('cabinet.schedule-create', [
      'date' => $date,
      'scheduleProject' => $project,
      'scheduleStatuses' => $projectStatuses,
      'scheduleVersions' => $versions,
      'currentVersionId' => $versionId,
      'scheduleVersionData' => $versionData,
      'scheduleCurrentVersion' => $currentVersion,
      'scheduleVersionErrors' => $versionErrorsData,
      'workScheduleTypes' => $workScheduleTypes,
    ],
      'Формирование графика работы', 'Страница формирования графика работы врачей рентгенологов');
  }


  public function getDaysScheduleStatistic($scheduleVersion){
    $result = ProjectStatisticByDay::where(['КодВерсииПроектаРасписания' => $scheduleVersion])->get();
    return response()->json($result);
  }

  public function getWeeksScheduleStatistic($scheduleVersion){
    $result = ProjectStatisticByWeek::where(['КодВерсииПроектаРасписания' => $scheduleVersion])->get();
    return response()->json($result);
  }


  public function createNewScheduleProject(Request $request)
  {
    $date = $request->projectDate;

    //Проверяем есть ли на эту дату проект если нет то создаем
    $project = ScheduleProjects::where(['ДатаНачала' => $date . '-01'])->first();
    if (empty($project)) {
      // Получаем количество дней в месяце
      $daysInMonth = date('t', strtotime($date));
      // Выводим каждый день месяца
      $startDate = $date . '-01';
      $endDate = $date . '-' . $daysInMonth;

      //Создаем проект
      $result = ScheduleProjects::createProject($startDate, $endDate);
      $generation = ScheduleProjectVersions::generateScheduleForVersion($result[0]->Код);

      $generationResult = ScheduleProjectGenerations::where(['Код' => $generation[0]->Код])->first();
      while (!$generationResult->Выполнено) {
        sleep(1);
        $generationResult = ScheduleProjectGenerations::where(['Код' => $generation[0]->Код])->first();
      }

    }
    return response()->json();
  }

  public function downloadExcel($version)
  {
    ob_start();
    $client = new Client();
    $request = new GRequest('GET', 'http://192.168.0.150:50032/report?КодВерсииПроектаРасписания='.$version);
    $res = $client->sendAsync($request)->wait();

    $name = "График работы врачей версия №" . $version . '.xlsx';
    // Установка заголовков для скачивания файла
    header('Content-Type: ' . $res->getHeaderLine('Content-Type'));
    header("Content-Disposition: attachment; filename=" . $name);
    header('Content-Length: ' . $res->getHeaderLine('Content-Length'));
    ob_end_clean();
    // Вывод содержимого файла в браузер
    echo $res->getBody();
    die();
  }

  public function generateNewVersion(Request $request)
  {

    $generation = ScheduleProjectVersions::generateScheduleForVersion($request->code);
    $generationResult = ScheduleProjectGenerations::where(['Код' => $generation[0]->Код])->first();
    while (!$generationResult->Выполнено) {
      sleep(1);
      $generationResult = ScheduleProjectGenerations::where(['Код' => $generation[0]->Код])->first();
    }
    return response()->json();
  }

  public function approveProject(Request $request)
  {
    ScheduleProjects::scheduleStatusApprove($request->projectCode, $request->versionCode);
    return response()->json();
  }

  public function scheduleStatusForming(Request $request)
  {
    ScheduleProjects::scheduleStatusForming($request->projectCode);
    return response()->json();
  }


  public function addWorkDayToVersion(Request $request)
  {
    $newDate = new ScheduleProjectWorkDates();
    $newDate->КодВерсииПроектаРасписания = $request->schVersion;
    $newDate->КодДоктора = $request->docId;
    $newDate->Дата = $request->date;
    $newDate->КодТипаРабочейСмены = $request->eventCode;
    $newDate->save();
    return response()->json();
  }

  public function deleteWorkDayFromVersion(Request $request){
    $workDay = ScheduleProjectWorkDates::where(['КодВерсииПроектаРасписания' => $request->schVersion, 'КодДоктора' =>$request->docId,  'Дата'=>$request->date, 'КодТипаРабочейСмены'=> $request->eventCode])->delete();
    return response()->json();
  }

  public function editWorkDayToVersion(Request $request){
    $workDay = ScheduleProjectWorkDates::where(['КодВерсииПроектаРасписания' => $request->schVersion, 'КодДоктора' =>$request->docId,  'Дата'=>$request->date, 'КодТипаРабочейСмены'=> $request->eventCode])->first();
    $workDay->КодТипаРабочейСмены = $request->newEventCode;
    $workDay->save();
    return response()->json();
  }


}
