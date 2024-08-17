<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Doctors extends SimpleTablesModel
{
  public $timestamps = false;
  protected $primaryKey ='Код';
  protected $table = 'hr.Доктора';

  public static function setDoctor($id, $fio = null, $tabNumber = null, $stavka = null, $isActive = null, $idOsnMod  = null, $dopMods  = null){

    return DB::select("SELECT * FROM hr.Доктораset(:id, :fio, :tabNumber, :stavka, :isActive, :idOsnMod, :dopMods)",
      ['id' => $id, 'fio'=> $fio, 'tabNumber' => $tabNumber, 'stavka' => $stavka, 'isActive' => $isActive, 'idOsnMod' => $idOsnMod, 'dopMods'=>$dopMods] );
  }
}

