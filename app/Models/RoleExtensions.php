<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleExtensions extends SimpleTablesModel
{
  protected $table = 'role_extensions';
  protected $primaryKey = 'role_id';

  public function extension(){
    return $this->hasOne(Extensions::class, 'id', 'extension_id');
  }

}
