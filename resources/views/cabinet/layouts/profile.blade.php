@extends('layouts/contentNavbarLayout')

@section('title', 'Личный кабинет сотрудника')

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
  @yield('cabinet-vendor-script')
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
  @yield('cabinet-page-script')
@endsection

@section('content')
<div class="row">
  <!-- User Sidebar -->
  <div class="col-xl-4 col-lg-4 col-md-4 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            <img class="img-fluid rounded my-4" src="/assets/img/avatars/no-avatar.svg" height="200" width="200" alt="User avatar">
            <div class="user-info text-center">
              <h4 class="mb-2">{{Auth::user()->hrInfo->ФИО}}</h4>
            </div>
          </div>
        </div>
        <h5 class="pb-2 border-bottom mb-4"></h5>
        <div class="info-container">
          <ul class="list-unstyled">

            <li class="mb-3">
              <span class="fw-medium me-2">Ставка:</span>
              @if(!empty(Auth::user()->hrInfo->Ставка ))
                <span>{{Auth::user()->hrInfo->Ставка }}</span>
              @else
                <span>нет</span>
              @endif
            </li>

            <li class="mb-3">
              <span class="fw-medium me-2">Модальность:</span>
              @if(!empty(Auth::user()->hrInfo->Модальности ))
                @foreach(Auth::user()->hrInfo->Модальности as $modal)
                  @if($modal['Основная'])
                    <span>{{$modal['Модальность']['Название']}}</span><br>
                  @endif
                @endforeach
              @else
                <span>нет</span>
              @endif
            </li>

            <li class="mb-3">
              <span class="fw-medium me-2">Дополнительные модальности:</span>
              @if(!empty(Auth::user()->hrInfo->Модальности ))
                @foreach(Auth::user()->hrInfo->Модальности as $modal)
                  @if(!$modal['Основная'])
                    <br><span>{{$modal['Модальность']['Название']}}</span>
                  @endif
                @endforeach
              @else
                <span>нет</span>
              @endif
            </li>

            <li class="pb-2 border-bottom mb-4"></li>

            <li class="mb-3">
              <span class="fw-medium me-2">Email:</span>
              <span>{{Auth::user()->email}}</span>
            </li>
            <li class="mb-3">
              <span class="fw-medium me-2">Роль:</span>
              <span class="badge bg-label-success">{{Auth::user()->role->name}}</span>
            </li>
            <li class="mb-3">
              <span class="fw-medium me-2">Номер телефона:</span>
              <span>+7 999 865 41 12</span>
            </li>

            <li class="mb-3">
              <span class="fw-medium me-2">Рабочий номер:</span>
              <span>254-807</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- /User Card -->
  </div>
  <!--/ User Sidebar -->

  @php
  $currentRouteName = Route::currentRouteName();
  @endphp


  <!-- User Content -->
  <div class="col-xl-8 col-lg-8 col-md-8 order-0 order-md-1">
    <div class="card mb-2">
      <div class="card-body p-2">
        <!-- User Pills -->
        <ul class="nav nav-pills flex-column flex-md-row">
          <li class="nav-item"><a class="nav-link {{str_contains($currentRouteName, 'profile-account') && strpos($currentRouteName, 'profile-account') === 0 ? 'active' : ''}}" href="/profile"><i class="bx bx-user me-1"></i>Персональные данные</a></li>
          <li class="nav-item"><a class="nav-link {{str_contains($currentRouteName, 'profile-security') && strpos($currentRouteName, 'profile-security') === 0 ? 'active' : ''}}" href="/profile/security"><i class="bx bx-lock-alt me-1"></i>Защита аккаунта</a></li>
          <li class="nav-item"><a class="nav-link {{str_contains($currentRouteName, 'profile-notifications') && strpos($currentRouteName, 'profile-notifications') === 0 ? 'active' : ''}}" href="/profile/notifications"><i class="bx bx-bell me-1"></i>Уведомления</a></li>
        </ul>
      </div>
    </div>

    <!--/ User Pills -->
    @yield('content-cabinet')
  </div>
  <!--/ User Content -->
</div>
</div>
@endsection
