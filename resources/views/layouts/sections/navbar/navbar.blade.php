@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<style>
  @media (min-width: 767.98px) {
  #notifications-dropdown{
    min-width: 450px;
  }
  }
</style>
<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>
      @endif
      <h5 class="fs-5 d-none d-sm-block m-0 my-2" style="width:inherit">{{$title}}</h5>
      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">

        <!--Notifications-->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
            <a class="btn btn-sm btn-light position-relative" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class="bx bx-bell bx-sm"></i>
              @if($systemNotifications && count($systemNotifications) > 0)
              <div class="position-absolute top-0 end-0">
                <span class="badge bg-danger rounded-pill badge-notifications">{{count($systemNotifications)}}</span>
              </div>
              @endif
            </a>
            <ul id="notifications-dropdown"  class="dropdown-menu dropdown-menu-end py-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h5 class="text-body mb-0 me-auto">Уведомления</h5>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container ps">

                <ul class="list-group list-group-flush">
                @if($systemNotifications && count($systemNotifications) > 0)
                  @foreach ($systemNotifications as $notification)


                  <li class="list-group-item list-group-item-action dropdown-notifications-item p-4">
                    <form method="POST" class="notification-read-FORM" action="/admin/system_notifications/read">
                      @csrf
                      <input style="display: none" name="id" value="{{$notification->id}}">
                    <h6 class="mb-4">
                      {{$notification->title}}
                    </h6>
                    <div>
                      <div class="d-flex mb-4">
                        <div class="flex-grow-1" class="mb-4">
                        <p class="mb-0">{!! $notification->text !!}</p>
                      </div>
                      </div>
                      <div class="d-flex justify-content-end">
                        <button class="btn btn-sm btn-primary" type="submit" >Отметить как прочитанное</button>
                      </div>
                    </div>
                    </form>
                  </li>
                  @endforeach
                  @else
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Пусто</h6>
                        <p class="mb-0">У вас пока нет уведомлений</p>
                      </div>
                    </div>
                  </li>
                  @endif
                </ul>

            </ul>
          </li>
        <!--/Notifications-->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar">
                <img src="{{ asset('assets/img/avatars/no-avatar.svg') }}" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0 m-0">
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar">
                        <img src="{{ asset('assets/img/avatars/no-avatar.svg') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block">{{Auth::user()->hrInfo->ФИО}}</span>
                      <small class="text-muted">{{Auth::user()->hrInfo->ФИО}}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider m-0"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{route('profile-account')}}">
                  <i class="bx bx-user me-2"></i>
                  <span class="align-middle">Профиль</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider m-0"></div>
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                  <i class='bx bx-power-off me-2'></i>
                    <span class="align-middle">Выход</span>
                  </button>
                </form>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <script>
    $('.notification-read-FORM').on('submit', (event) => {
      let form = event.target;
      event.preventDefault(); // Предотвращаем стандартную отправку формы

      const formData = new FormData(form);

      fetch(form.action, {
        method: form.method,
        body: formData
      })
        .then(response => {
          // Обработка ответа сервера (например, проверка на успех)
          if (!response.ok) {
            throw new Error('Ошибка отправки формы');
          }
          return response.text(); // Или response.json() если сервер возвращает JSON
        })
        .then(data => {
          // Действия после успешной отправки формы, например:
          console.log('Данные успешно отправлены:', data);

          // Перезагрузка страницы
          location.reload();
        })
        .catch(error => {
          console.error('Ошибка:', error);
          // Обработка ошибки, например, отображение сообщения пользователю
        });
    });
  </script>
  <!-- / Navbar -->
