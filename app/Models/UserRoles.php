<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends SimpleTablesModel
{
  protected $table = 'public.user_roles';
    protected $primaryKey = 'id';

  public function extensions(){
    return $this->hasMany(RoleExtensions::class, 'role_id', 'id');
  }
}
