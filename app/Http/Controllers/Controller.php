<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{

  use AuthorizesRequests, ValidatesRequests;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      if(Auth::user()){
        User::init(Auth::user());
      }
      return $next($request);
    });
  }


  public function createPageView($view, $data = [], $pageTitle = '', $pageDescription = '')
  {

    $pageData = [
      'title' => $pageTitle,
      'description' => $pageDescription,
      ''
    ];
    return view($view, $data, $pageData);
  }
}
