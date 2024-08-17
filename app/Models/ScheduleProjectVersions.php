<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ScheduleProjectVersions extends SimpleTablesModel
{
    protected $table = 'sch.ВерсииПроектовРасписания';
    protected $primaryKey = 'Код';

  public static function generateScheduleForVersion($projectCode){
    return DB::select("SELECT * FROM sch.СоздатьЗапросНаГенерацию(:projectCode)", ['projectCode'=> $projectCode]);
  }

}
