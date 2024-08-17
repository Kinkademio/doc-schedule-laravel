<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;

class GuestsController extends Controller
{

  public function getWelcomeLending()
  {
    return $this->createPageView(
      'guests.welcome',
      [],
      'Сервис составления расписания',
      'Сервис для автоматического составления расписания созданный командой DECODE Predators в рамках Хакатона Мера Москвы 2024'
    );
  }

  public function getUserAgreement()
  {
    return $this->createPageView(
      'guests.agreement',
      [],
      'Пользовательское соглашение',
      'Страница демонстрирующая пользовательское соглашение'
    );
  }

  public function getInDevelopmentPage(){
    return view('errors.in_dev');
  }

    public function getRecruitPage(){
        return view('errors.recruit');
    }
}
