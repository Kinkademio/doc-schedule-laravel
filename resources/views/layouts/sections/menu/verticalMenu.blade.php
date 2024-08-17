<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand my-3">
    <a href="#" class="app-brand-link">
      <span class="app-brand-logo me-2">
        <img src="/assets/img/logo/logo.png" height="60" width="60">
      </span>
      <span class="app-brand-text menu-text">ЦЕНТР<br> ДИАГНОСТИКИ И <br> ТЕЛЕМЕДИЦИНЫ</span>
    </a>

    <a href="#" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @php
      $currentRouteName = Route::currentRouteName();
    @endphp

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Персональное пространство</span>
    </li>

    <li class="menu-item {{str_contains($currentRouteName, 'cabinet') && strpos($currentRouteName, 'cabinet') === 0 ? 'active' : ''}}">
      <a href="/cabinet" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div class="text-truncate">Мое расписание</div>
      </a>
    </li>

    <li class="menu-item {{str_contains($currentRouteName, 'my-statistic') && strpos($currentRouteName, 'my-statistic') === 0 ? 'active' : ''}}">
      <a href="/my-statistic" class="menu-link">
        <i class="menu-icon tf-icons bx bx-line-chart"></i>
        <div class="text-truncate">Моя статистика</div>
      </a>
    </li>
    <li class="menu-item {{str_contains($currentRouteName, 'profile') && strpos($currentRouteName, 'profile') === 0 ? 'active' : ''}}">
      <a href="/profile" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div class="text-truncate">Профиль</div>
      </a>
    </li>
    @if(App\Http\Controllers\Auth\User::userHasExtension('schedule.create', ['read' => true]) || App\Http\Controllers\Auth\User::userHasExtension('edit.statistics', ['read' => true]))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Рабочее пространство</span>
    </li>
    @endif
    @if(App\Http\Controllers\Auth\User::userHasExtension('schedule.create', ['read' => true]) )
    <li class="menu-item {{str_contains($currentRouteName, 'schedule-create') ? 'active' : ''}}">
      <a href="/schedule" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar-plus"></i>
        <div class="text-truncate">Формирование <br> расписания</div>
      </a>
    </li>
    @endif

    @if(App\Http\Controllers\Auth\User::userHasExtension('edit.statistics', ['read' => true]))
    <li class="menu-item {{str_contains($currentRouteName, 'statistics') && strpos($currentRouteName, 'statistics') === 0 ? 'active' : ''}}">
      <a href="/statistics" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
        <div class="text-truncate">Графики точности <br> прогнозирования <br> по модальностям</div>
      </a>
    </li>
    @endif

    @if(App\Http\Controllers\Auth\User::userHasExtension('edit.statistics', ['read' => true]))
    <li class="menu-item {{str_contains($currentRouteName, 'forecasts') && strpos($currentRouteName, 'forecasts') === 0 ? 'active' : ''}}">
      <a href="/forecasts" class="menu-link">
        <i class="menu-icon tf-icons bx bx-objects-vertical-center"></i>
        <div class="text-truncate">Прогнозы <br> исследований </div>
      </a>
    </li>
    @endif

    @if(App\Http\Controllers\Auth\User::userHasExtension('users', ['read' => true]) || App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read' => true]))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Администрирование</span>
    </li>
    @endif
    @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read' => true]) || App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read' => true]))
    <li class="menu-item {{ str_contains($currentRouteName, 'data-edit') ? 'active' : '' }}">
      <a href="/admin/edit" class="menu-link">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div class="text-truncate">Управление <br>данными</div>
      </a>
    </li>
    @endif
    @if(App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read' => true]))
    <li class="menu-item {{ str_contains($currentRouteName, 'notification-data-') ? 'active' : '' }}">
      <a href="/admin/system_notifications" class="menu-link">
        <i class="menu-icon tf-icons bx bx-chat"></i>
        <div class="text-truncate">Системные<br>уведомления</div>
      </a>
    </li>
    @endif

  </ul>

</aside>
