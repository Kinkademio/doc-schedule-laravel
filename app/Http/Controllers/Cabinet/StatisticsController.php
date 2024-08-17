<?php
namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Auth\User as UserData;
use App\Models\Views\RequestStatistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends CabinetBaseController
{
  public function getDocStatistics()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    $statisticsMod = DB::select('select *
                                  from sch.НагрузкаДокторов1 нагДок
                                          where нагДок.КодДоктора = :id', ['id' => Auth::user()->hr_id]);

    return $this->createPageView(
      'statistics.statistics-doc',
      ['statistics' => $statisticsMod],
      'Статистика пользователя',
      'Статистика пользователя сервиса. На данной странице вы можете увидеть статистику своего профиля'
    );
  }

  public function getModalsStatistics()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if(!UserData::userHasExtension('edit.statistics', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

      $statisticsMod = DB::select('select тип.Название, стат.Исследования
                                    from nn.СтатистикаОбращенийДляСтаты стат
                                            inner join med.ТипыИсследований тип on стат.КодТипаИсследования = тип.Код');

    return $this->createPageView(
      'statistics.statistics-modals',
      ['statisticsMod' => $statisticsMod],
      'Статистика оценки модальности',
      'Статистика отделения. На данной странице вы можете увидеть статистику своего отделения'
    );
  }

  public function getAllDocsStatistics()
  {
    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if(!UserData::userHasExtension('edit.statistics', ['read' => true]))
      return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    return $this->createPageView(
      'statistics.statistics-alldocs',
      [],
      'Статистика по всем врачам',
      'Статистика всех врачей. На данной странице вы можете увидеть статистику всех врачей референс-центра'
    );
  }
}
