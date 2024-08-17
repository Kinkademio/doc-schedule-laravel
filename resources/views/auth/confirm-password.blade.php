@extends('layouts/blankLayout')

@php
  $title = 'Подтверждение пароля';
  $description = 'Страница подтверждения пароля';
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

          <h4 class="mb-2">Это безопасная область приложения.</h4>
          <p class="mb-4">Пожалуйста, подтвердите свой пароль, прежде чем продолжить.</p>
          <x-auth-session-status class="mb-4" :status="session('status')" />

          <form method="POST" class="mb-3" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-3">

              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Пароль</label>
                <div class="input-group input-group-merge">

                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="current-password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary d-grid w-100">Подтвердить</button>
          </form>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
