<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ScheduleProjects extends SimpleTablesModel
{
  protected $table = 'sch.ПроектыРасписания';

  public static function createProject($dateStart, $dateEnd){
    return DB::select("SELECT * FROM sch.ПроектыРасписанияSet(NULL, :dateStart, :dateEnd)", ['dateStart'=> $dateStart, 'dateEnd' => $dateEnd]);
  }
  public static function scheduleStatusApprove($projectCode, $versionCode){
    return DB::select("SELECT * FROM sch.Утвердить(:projectCode, :versionCode)", ['projectCode'=> $projectCode, 'versionCode' => $versionCode]);
  }
  public static function scheduleStatusForming($projectCode){
    return DB::select("SELECT * FROM sch.НаФормирование(:projectCode)", ['projectCode'=> $projectCode]);
  }
}
