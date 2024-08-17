<?php

namespace App\Models;

class DocModals extends SimpleTablesModel
{
  protected $table = 'hr.МодальностиДокторов';

  protected $primaryKey = ['КодДоктора', 'КодМодальности'];

  // Указываем, что ключ составной
  public $incrementing = false;
}
