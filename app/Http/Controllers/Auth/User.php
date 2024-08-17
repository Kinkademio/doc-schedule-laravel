<?php

namespace App\Http\Controllers\Auth;

class User
{
  protected static $userData;
  protected static $userRole;
  protected static $userExtensions;

  public static function init($user){
    self::$userData = $user;
    self::$userRole = $user->role;
    self::$userExtensions = $user->extensions();
  }

  /**
   * Проверка на наличие роли
   * @param $slugs
   * @return bool
   */
  public static function userHasRole($slugs){
    if(empty(self::$userRole)) return false;
    return  in_array(self::$userRole->slug, $slugs);
  }

  /**
   * Проверка на наличие расширения
   * @param $slug
   * @param $modifiers
   * @param $user_id
   * @return bool
   */
  public static function userHasExtension($slug, $modifiers = []){

    if(!self::$userExtensions) return false;

    $found = [];
    foreach(self::$userExtensions as $extension){
      if($extension['slug'] === $slug){
        $found[] = $extension;
      }
    }
    if(count($found) == 0) return false;
    $result = true;
    foreach ($found as $one){
      foreach($modifiers as $key => $value) {
        $result &= $one[$key] == $value;
      }
    }

    return $result;

  }
}
