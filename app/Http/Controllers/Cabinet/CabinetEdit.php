<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\DocModals;
use App\Models\Extensions;
use App\Models\MonthConstants;
use App\Models\MonthConstantsGroups;
use App\Models\User;
use App\Models\Modals;
use App\Models\Views\ForecastsStats;
use App\Models\Views\RefBookResearchTypesView;
use App\Models\UserRoles;
use App\Models\WorkSchedule;
use App\Models\VacationTypes;
use App\Models\Views\UserDoctorView;
use App\Http\Controllers\Auth\User as UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Doctors;
use Illuminate\Support\Facades\DB;

class CabinetEdit extends CabinetBaseController
{
  public function workWithEditPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.hr', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    return $this->createPageView('cabinet.edit', [],
      'Управление данными', 'Страница управления данными');
  }


  //Пользователи
  public function workWithUsersPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.users', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $users = User::get();
    return $this->createPageView('cabinet.edit.users', ['allUsers' => $users],
      'Управление аккаунтами', 'Страница администрирования аккаунтов пользователей');
  }

  public function workWithHrPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.hr', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allDocs = UserDoctorView::where(['Активно'=>true])->get();
    $modals = Modals::get();

    return $this->createPageView('cabinet.edit.hr', ['allDocs' => $allDocs, 'modals' => $modals],
      'Управление кадровым составом', 'Страница управления кадровыми данными');
  }

  public function createEditHr(Request $request){

      if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

      if(!empty($request->id)){

            $doctor = Doctors::setDoctor(
              $request->id,
              $request->fio,
              $request->tab_number,
              $request->stavka,
              true,
              null,
              null);

        DocModals::where(['КодДоктора' => $doctor[0]->Код])->delete();

        $new1  = new DocModals;
        $new1->КодДоктора = $doctor[0]->Код;
        $new1->КодМодальности = $request->main_modal;
        $new1->Основная = true;
        $new1->Активно = true;
        $new1->save();

        foreach ($request->dop_modals as $modal){
          $new  = new DocModals;
          $new->КодДоктора = $doctor[0]->Код;
          $new->КодМодальности = $modal;
          $new->Основная = false;
          $new->Активно = true;
          $new->save();
        }


      }else{
        $doctor = Doctors::setDoctor(
          null,
          $request->fio,
          $request->tab_number,
          $request->stavka,
          true,
          null,
          null);

        $new1  = new DocModals;
        $new1->КодДоктора = $doctor[0]->Код;
        $new1->КодМодальности = $request->main_modal;
        $new1->Основная = true;
        $new1->Активно = true;
        $new1->save();

        foreach ($request->dop_modals as $modal){
          $new  = new DocModals;
          $new->КодДоктора = $doctor[0]->Код;
          $new->КодМодальности = $modal;
          $new->Основная = false;
          $new->Активно = true;
          $new->save();
        }
      }
  }

    public function deleteHr($id){

        if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

        $doctor = Doctors::setDoctor($id, null, null, null, false);
    }

  public function workWithAccessPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.roles', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allExtensions = Extensions::get();
    $allRoles = UserRoles::get();
    return $this->createPageView('cabinet.edit.access', ['allExtensions' => $allExtensions, 'allRoles' => $allRoles],
      'Управление правами пользователей', 'Страница управления правами пользователей');
  }


  //Справочники
  public function workWithModalsPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allModals = Modals::get();
    return $this->createPageView('cabinet.edit.modals', ['allModals' => $allModals],
      'Справочник модальностей', 'Страница управления справочной информацией');
  }

  public function workWithResearchPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allResearchTypes = RefBookResearchTypesView::get();
    return $this->createPageView('cabinet.edit.refbook', ['allResearchTypes' => $allResearchTypes],
      'Справочник нормативов исследований', 'Страница управления справочной информацией');
  }

  public function workWithSchedulePage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');


    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allScheduleTypes = WorkSchedule::get();
    return $this->createPageView('cabinet.edit.schedule', ['allScheduleTypes' => $allScheduleTypes],
      'Справочник типов графиков работы врачей', 'Страница управления справочной информацией');
  }

  public function workWithVacationPage()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');
    $allVacationTypes = VacationTypes::get();
    return $this->createPageView('cabinet.edit.vacation', ['allVacationTypes' => $allVacationTypes],
      'Справочник видов освобождения', 'Страница управления справочной информацией');
  }

  public function workWithMonthConstants()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    $constantsGroups = MonthConstantsGroups::get();
    $constants = MonthConstants::get();
    $result = [];

    foreach ($constantsGroups as $group) {
      $result[$group['Код']]['Название'] = $group['Название'];
    }


    foreach ($constants as $one) {
      $result[$one['КодГруппы']]['Значение'][] = $one;
    }

    return $this->createPageView('cabinet.edit.month_constants', ['monthConstantsGroups' => $result],
      'Справочник норм рабочей деятельности', 'Страница управления нормами рабочей деятельности');
  }


  public function workWithForecasts()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if (!UserData::userHasExtension('edit.refbook', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    $forecastsData = ForecastsStats::orderBy('Дата', 'ASC')->get();
    //Очень плохо сейчас будет, закройте глазки все кому дорог этот код
    $result = [];

    $resultForGraphByModals = [];
    foreach ($forecastsData as $one) {
      $date = Carbon::parse($one['Дата']);
      $weekNumber = $date->weekOfYear;
      $modals = [];
      foreach ($one['Значения'] as $modal) {
        $modals[$modal['Тип']['Код']]['Информация'] = $modal['Тип'];
        $modals[$modal['Тип']['Код']]['Значение'] = $modal['Значение'];
        $resultForGraphByModals['Данные'][$modal['Тип']['Код']]['Название'] = $modal['Тип']['Название'] . ' ' . $date->year;
        $resultForGraphByModals['Данные'][$modal['Тип']['Код']]['Значения'][] = $modal['Значение'];
      }
      $resultForGraphByModals['НомераНедель'][] = $weekNumber;
      $result[] = [
        'Дата' => $one['Дата'],
        'НомерНедели' => $weekNumber,
        'Год' => $date->year,
        'Модальности' => $modals
      ];
    }

    return $this->createPageView('cabinet.edit.forecast', ['forecastsData' => $result, 'resultForGraphByModals' => $resultForGraphByModals],
      'Прогнозы исследований', 'Справочник прогнозов исследований по модальностям');
  }

  public function editScheduleConstants(Request $request){

    $constantId = $request->id;
    $constantNewValue = $request->value;

    $modernValue = strpos($constantNewValue, ":") ? json_encode($constantNewValue) : $constantNewValue;

    MonthConstants::where(['Код' => $constantId])->update(['Значение' => $modernValue]);
    return redirect()->back();
  }

}
