@extends('cabinet/layouts/profile')
@php
$telegramLink = App\Http\Controllers\Telegram\Bots\NotificationTelegramBot::createStartChatLink(Auth::user()->id);
@endphp
@section('content-cabinet')
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-1"><i class='bx bxl-telegram me-1 text-primary fs-3'></i> Уведомления Telegram</h5>
  </div>
  <div class="card-body">
    @if(Auth::user()->telegram_notifications)

    <form method="POST" action="{{ route('unsubscribe-telegram') }}">
      @csrf
      <div>
        <i class='bx bx-link-alt' ></i>
          Telegram подключен к вашей учетной записи
          <p class="section-subtitle">Теперь вы будете получать уведомления через информационного бота</p>
        <button class="btn btn-secondary" type="submit">Отключить</button>
      </div>
    </form>

    @else
    <div class="d-flex flex-wrap ">
      <div class="col-auto py-2 px-4">
        {{ QrCode::generate($telegramLink)}}
      </div>
      <div class="col-sm-12 col-md-8 py-2 px-4">
        <div class="mb-3">Подключитесь к нашему Telegram боту и получайте уведомления об изменениях в расписании и быстрый доступ к просмотру своего расписания без входа в систему!</div>
        <a class="btn btn-primary" href="{{$telegramLink}}" target="_blank"> Подключить</a>
      </div>
    </div>

    @endif
  </div>
</div>

<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-1"><i class='bx bx-envelope me-1 text-primary fs-3'></i> Уведомление на почтовый адрес</h5>
  </div>
  <div class="card-body">
    @if(Auth::user()->mail_notifications)
    <form method="POST" action="{{ route('toggle-mail-notification') }}">
      @csrf
      <div>
        <i class='bx bx-link-alt' ></i>
          Уведомления на e-mail подключены к вашей учетной записи
          <p class="section-subtitle">Теперь вы будете получать уведомления на адрес электронной почты</p>
        <button class="btn btn-secondary" type="submit">Отключиться</button>
      </div>
    </form>
    @else
    <div>
      <div class="mb-3">Подключите уведомления на почтовый адрес, {{Auth::user()->email}} !</div>
      <a class="btn btn-primary" href="/in_dev"> Подключить</a>
    </div>
    @endif
  </div>
</div>
@endsection
