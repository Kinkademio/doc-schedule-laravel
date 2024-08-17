<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SystemNotifications extends SimpleTablesModel
{
  protected $table = 'system_notifications';

  public static function getUserNotifications()
  {
    $notifications = SystemNotifications::where(function ($q) {
        $q->orWhere(function ($query) {
          $query->where('for', 3)
            ->where(['ids'=>Auth::user()->role->id]);
        })->orWhere(function ($query) {
            $query->where('for', 2)
              ->where(['ids'=>Auth::user()->id]);
          })->orWhere(function ($query) {
            $query->where('for', 1);
          });
      })
      ->where(['active' => true])
      ->where(function($q){
        $q->whereRaw("NOT read @> '" . Auth::user()->id . "'")
          ->orWhere(['read'=> null]);
      })

      ->get();

    return $notifications;
  }

  public function receiver(){
    $receiver = '';
    switch($this->for){
      case '1':
        $receiver = 'Все';
        break;
      case '2':
        $query = User::where(['id'=> $this->ids])->first();
        $receiver = $query->hrInfo->ФИО;
        break;

      case '3':
        $query = UserRoles::where(['id'=> $this->ids])->first();
        $receiver = $query->name;
        break;
    }
    return $receiver;
  }
}
