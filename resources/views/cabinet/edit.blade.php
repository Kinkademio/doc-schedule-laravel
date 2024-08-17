@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('content')

  @if(App\Http\Controllers\Auth\User::userHasExtension('edit.userdata', ['read'=>true]))
  <h4>Пользователи</h4>
  @if(App\Http\Controllers\Auth\User::userHasExtension('edit.users', ['read'=>true]))
  <div class="d-flex flex-wrap mb-4">
    <a class="col-12 col-md-4 p-2" href="/admin/account" title="Аккаунты">
    <div class="card btn btn-light h-100 w-100">
      <div class="card-body">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <i class='bx bxs-user-account text-primary' style="font-size: 5rem"></i>
          <span class="text-muted">Аккаунты</span>
        </div>
      </div>
    </div>
    </a>
    @endif

    @if(App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read'=>true]))
    <a class="col-12 col-md-4 p-2"  href="/admin/hr" title="Кадровые данные">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bxs-briefcase-alt text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Кадровые данные</span>
          </div>
        </div>
      </div>
    </a>
    @endif

    @if(App\Http\Controllers\Auth\User::userHasExtension('edit.roles', ['read'=>true]))
    <a class="col-12 col-md-4 p-2" href="/admin/access" title="Права и роли">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bxs-lock-alt text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Права и роли</span>
          </div>
        </div>
      </div>
    </a>
  </div>
  @endif
  @endif

  @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true]))
  <h4>Справочники</h4>
  <div class="d-flex flex-wrap mb-4">
    <a class="col-12 col-md-4 p-2" href="/admin/modals" title="Модальности">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bx-shape-square text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Справочник модальностей</span>
          </div>
        </div>
      </div>
    </a>

    <a class="col-12 col-md-4 p-2"  href="/admin/research" title="Типы исследований">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bxs-vial text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Справочник нормативов исследований</span>
          </div>
        </div>
      </div>
    </a>

    <a class="col-12 col-md-4 p-2" href="/admin/schedule" title="Права и роли">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bx-calendar text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Справочник видов графиков работы врачей</span>
          </div>
        </div>
      </div>
    </a>

    <a class="col-12 col-md-4 p-2" href="/admin/vacation" title="Справочник видов отсутствия на рабочем месте">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bxs-plane-alt text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Справочник видов отсутствия на рабочем месте</span>
          </div>
        </div>
      </div>
    </a>

    <a class="col-12 col-md-4 p-2" href="/admin/month_constants" title="Справочник норм рабочей деятельности">
      <div class="card btn btn-light h-100 w-100">
        <div class="card-body">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <i class='bx bx-calculator text-primary' style="font-size: 5rem"></i>
            <span class="text-muted">Справочник норм рабочей деятельности</span>
          </div>
        </div>
      </div>
    </a>

  </div>
  @endif
@endsection
