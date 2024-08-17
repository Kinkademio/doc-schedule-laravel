@extends('cabinet/layouts/profile')

@section('content-cabinet')
<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-1"><i class='bx bxs-lock me-1 text-primary fs-3'></i> Изменение пароля</h5>
  </div>
  <div class="card-body">
        <form class="mb-3" method="POST" action="{{ route('cabinet-password-reset') }}">
          @csrf
          <div class="alert alert-warning" role="alert">
            <h6 class="alert-heading mb-1">Пароль должен соответствовать следующим требованиям:</h6>
            <ul class="m-0">
              <li>Минимальная длина 8 символов</li>
            </ul>
          </div>
          <div class="mb-3 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
            <label class="form-label" for="current_password">Текущий пароль</label>
            <div class="input-group input-group-merge has-validation">
              <input class="form-control" type="password" id="current_password" name="current_password" placeholder="············">
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div><div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>

          <div class="mb-3 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
            <label class="form-label" for="new_password">Новый пароль</label>
            <div class="input-group input-group-merge has-validation">
              <input class="form-control" type="password" id="new_password" name="new_password" placeholder="············">
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div><div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>

          <div class="mb-3 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
            <label class="form-label" for="new_password_confirmation">Подтверждение пароля</label>
            <div class="input-group input-group-merge has-validation">
              <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="············">
              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div><div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
          </div>
          @if (session('message'))
            <h5 class="alert alert-success mb-2">{{ session('message') }}</h5>
          @endif
          @if ($errors->any())
            <ul class="alert alert-danger mb-2">
              @foreach ($errors->all() as $error)
                <li class="text-danger" style="margin-left:20px">{{ $error }}</li>
              @endforeach
            </ul>
          @endif
          <div>
            <button type="submit" class="btn btn-primary me-2">Изменить пароль</button>
          </div>
      </form>
      </div>
</div>

@endsection
