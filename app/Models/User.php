<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\NewResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Views\UserDoctorView;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Получение информации о сотруднике
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hrInfo()
    {
       return $this->hasOne(UserDoctorView::class, 'Код', 'hr_id');
    }

  /**
   * Роль пользователя
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
    public function role(){
      return $this->hasOne(UserRoles::class, 'id', 'role_id');
    }

    public function workNorm(){
      return $this->hasOne(DoctorWorkNorm::class, 'КодДоктора', 'hr_id');
    }


    /**
     * Все пользовательские разрешения
    * @return array
    */
    public function extensions(){
      //Пользовательские расширения
      $resultUser = $this->from('user_extensions')->leftJoin('extensions', 'extensions.id', '=' ,'user_extensions.extension_id')
        ->where(['user_extensions.user_id' => $this->id])->get()->toArray();

      $resultExt = [];
      if(!empty($this->role)){
        //Расширения от роли пользователя
        $resultExt = $this->from('role_extensions')->leftJoin('extensions', 'extensions.id', '=' ,'role_extensions.extension_id')
          ->where(['role_extensions.role_id' => $this->role->id])->get()->toArray();
      }

      return array_merge($resultExt, $resultUser);
    }

  /**
   * Получение разрешений пользователя
   * @return mixed
   */
    public function personalExtensions()
    {
      return $this->extensions;
    }

  /**
   * Получение разрешений роли
   * @return mixed
   */
    private function roleExtensions(){
      return $this->role->extensions;
    }

}
