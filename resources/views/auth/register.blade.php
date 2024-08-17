    @extends('layouts/blankLayout')

    @php
      $title = 'Регистрация';
      $description = 'Страница регистрации пользователя в системе';
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
              <h4 class="mb-2">Регистрация</h4>
              <p class="mb-4">Создайте аккаунт и получите доступ к сервису</p>

              <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" type="email" :value="old('email')"  placeholder="Введите email-адрес"  required autocomplete="username">
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Пароль</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"  required autocomplete="new-password"/>
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
                </div>

                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Подтверждение пароля</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"  required autocomplete="new-password"/>
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
                </div>

                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                    <label class="form-check-label" for="terms-conditions">
                      Я соглашаюсь
                      <a href="/policy">с политикой конфиденциальности</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100" type="submit">
                  Зарегистрироваться
                </button>
              </form>

              <p class="text-center">
                <span>Уже есть аккаунт?</span>
                <a href="{{ route('login') }}">
                  <span>Выполните вход</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>
    @endsection
