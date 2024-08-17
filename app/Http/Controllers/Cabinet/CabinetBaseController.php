<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\SystemNotifications;

class CabinetBaseController extends Controller
{
  public function createPageView($view, $data = [], $pageTitle = '', $pageDescription = ''){

    $systemNotifications = SystemNotifications::getUserNotifications();
    $cabinetData = [
      'systemNotifications' => $systemNotifications,
    ];
    return parent::createPageView($view, array_merge($data, $cabinetData), $pageTitle, $pageDescription);
  }


}
