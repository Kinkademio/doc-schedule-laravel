<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ScheduleProjectWorkDates extends ScheduleProjects
{
  protected $table = 'sch.ЗаписиВерсииРасписания';
  protected $primaryKey = 'Код';

  public static function addForcemajor($versionRecordId, $comment){
    return DB::select("SELECT * FROM sch.ЗаписиВерсииДобавитьКомментарий(:versionRecordId, :comment)", ['versionRecordId' => $versionRecordId, 'comment' => $comment]);
  }
}
