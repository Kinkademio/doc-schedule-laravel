<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserExtensions extends SimpleTablesModel
{
  protected $table = 'public.user_extensions';

  public function extension(){
    return $this->hasOne(Extensions::class, 'id', 'extension_id');
  }
}
