<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SimpleTablesModel extends Model{
  public $timestamps = false;

  public function type(){
    return $this->hasOne(SystemNotificationsTypes::class, 'id', 'for');
  }

}
