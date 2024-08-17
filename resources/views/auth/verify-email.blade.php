@extends('layouts/blankLayout')

@php
  $title = 'Восстановление доступа к учетной записи';
  $description = 'Страница восстановления доступа к аккаунту сервиса';
@endphp

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Forgot Password -->
      <div class="card">
        <div class="card-body">

          <h4 class="mb-2">Спасибо за регистрацию!</h4>
          <p class="mb-4">Прежде чем начать, не могли бы вы подтвердить свой адрес электронной почты, нажав на ссылку, которую мы только что отправили вам по электронной почте? Если вы не получили письмо, мы с радостью отправим вам другое.</p>

          @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
              Новая ссылка для подтверждения была отправлена на адрес электронной почты, который вы указали при регистрации.
            </div>
          @endif

          <form method="POST" class="mb-3"action="{{ route('verification.send') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="Введите email-адрес" autofocus :value="old('email')">
              <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger"/>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Выслать повторно</button>
          </form>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline-primary d-grid w-100">
              Выйти
          </button>
        </form>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection

