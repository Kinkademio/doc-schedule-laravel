<?php

namespace App\Http\Controllers\Cabinet;
use App\Http\Controllers\Auth\User as UserData;
use App\Http\Controllers\Controller;
use App\Models\SystemNotifications;
use App\Models\SystemNotificationsTypes;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Views\UserDoctorView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Notifications extends CabinetBaseController{


  public function workWithNotificationsPage(){

    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    //только для Админов или для пользователей с расширением
    if(!UserData::userHasExtension('notifications', ['read' => true])) return $this->createPageView('errors.401', [], 'Не хватает прав!', 'У вас не хватает прав для посещения данной страницы');

    return $this->createPageView('cabinet.notifications', [
      'systemNotificationTypes'=> SystemNotificationsTypes::get(),
      'notificationUsers' => User::get(),
      'notificationRoles' => UserRoles::get(),
      'allNotificationsForDataTable' => SystemNotifications::where(['active'=>true])->get()

    ], 'Управление уведомлениями', 'Страница просмотра и управления уведомлениями сервиса составления расписания врачей рентгенологов');
  }

  public function getAllSystemNotifications(){

      if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

      return  SystemNotifications::getUserNotifications();
  }

  public function deleteSystemNotification($id){

    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    $notification = SystemNotifications::where(['id' => $id])->first();
    $notification->active = false;
    $notification->save();
  }

  public function createEditNotification(Request $request){

    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');

    if($request->input('id')){
      $notification = SystemNotifications::where(['id'=> $request->input('id')])->first();
    }else{
      $notification = new SystemNotifications();
    }
    $for = $request->input('for');
    $notification->for = $for;
    switch($for){
      case '2':
        $notification->ids = intval($request->input('ids_person'));
        break;
      case '3':
        $notification->ids = intval($request->input('ids_role'));
        break;
    }
    $notification->title = $request->input('title');
    $notification->text = $request->input('text');
    $notification->active = true;
    $notification->save();

    return response()->json(['id'=>$notification->id]);
  }

  public function markSystemMessageAsRead(Request $request){

    if (Auth::user()->role['id'] == 5) return redirect()->intended('/recruit');


    $id = $request->input('id');
    $notification = SystemNotifications::where(['id' => $id])->first();
    if(empty($notification->read)){
      $notification->read = [Auth::user()->id];
    }else{
      $read = array_merge(json_decode($notification->read), [Auth::user()->id]);
      $notification->read = array_unique($read);
    }
    $notification->save();
  }

}
