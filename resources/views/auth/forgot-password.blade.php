    @extends('layouts/blankLayout')

    @php
      $title = 'Восстановление доступа к учетной записи';
      $description = 'Страница восстановления доступа к учетной записи';
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

              <h4 class="mb-2">Забыли пароль?</h4>
              <p class="mb-4">Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам ссылку для сброса пароля.</p>
              <x-auth-session-status class="mb-4" :status="session('status')" />
              <form id="formAuthentication" method="POST" class="mb-3" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required placeholder="Введите email-адрес" autofocus :value="old('email')">
                  <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger"/>
                </div>
                <button type="submit" class="btn btn-primary d-grid w-100">Отправить ссылку для восстановления</button>
              </form>

              <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                  <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                  Вернуться к авторизации
                </a>
              </div>
            </div>
          </div>
          <!-- /Forgot Password -->
        </div>
      </div>
    </div>
    @endsection
