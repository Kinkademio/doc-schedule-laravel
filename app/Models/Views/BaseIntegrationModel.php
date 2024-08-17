<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class BaseIntegrationModel extends Model
{
  protected static function boot()
  {
      parent::boot();

      static::retrieved(function ($model) {
          foreach ($model->attributes as $key => $value) {
             //Проверяем поле на Json
              $newValue = json_decode($value, true);
              if(!empty($newValue)){
                $model->$key = $newValue;
              }
          }
      });
  }

}
