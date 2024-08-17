<?php

namespace App\Models\Views;

use App\Models\SimpleTablesModel;

class PreferredDoctorsSchedule extends SimpleTablesModel
{
  protected $table = 'hr.РабочиеСменыДокторов';

  protected $primaryKey = ['КодДоктора', 'Дата', 'КодТипаРабочейСмены'];

  // Указываем, что ключ составной
  public $incrementing = false;

  // Указываем типы данных для составных ключей
  protected $casts = [
    'КодДоктора' => 'integer',
    'Дата' => 'date',
    'КодТипаРабочейСмены' => 'integer',
  ];

}
