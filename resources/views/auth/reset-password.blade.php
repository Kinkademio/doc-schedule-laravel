@extends('layouts/blankLayout')

@php
  $title = 'Изменение пароля';
  $description = 'Страница изменения пароля аккаунта сервиса';
@endphp


@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <h4 class="mb-2">Изменение пароля</h4>
          <p class="mb-4">Придумайте новый надежный пароль</p>

          <form  class="mb-3" method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3" style="display: none">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" type="email" :value="old('email', $request->email)"  placeholder="Введите email-адрес"  required autocomplete="username">
              <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Новый пароль</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autofocus required autocomplete="new-password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Подтверждение пароля</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="new-password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
              </div>
            </div>

            <button class="btn btn-primary d-grid w-100" type="submit">
              Изменить пароль
            </button>
          </form>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection
