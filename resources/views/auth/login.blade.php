@extends('layouts/blankLayout')

@php
  $title = 'Вход';
  $description = 'Страница входа в систему';
@endphp

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <h4 class="mb-2">Вход в систему</h4>
          <p class="mb-4">Для доступа к сервису необходимо авторизоваться в системе</p>
          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Введите email-адрес">
              <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Пароль</label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                   Забыли пароль?
                </a>
                @endif

              </div>
              <div class="input-group input-group-merge">
                <input required type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <span class="form-check-label">Запомнить меня</span>
              </div>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Вход</button>
            </div>
          </form>

          <p class="text-center">
            <span>У вас еще нет учетной записи?</span>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Создать аккаунт</a>
            @endif
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
