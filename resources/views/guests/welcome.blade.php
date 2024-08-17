@extends('layouts/blankLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="p-5">
            <!-- Hero: Start -->
            <div class="section-py landing-hero position-relative mb-4">
                <div class="container">
                    <div class="hero-text-box text-center">

                    </div>
                </div>
            </div>
            <!-- Hero: End -->

            <div class="mb-4 d-flex flex-wrap align-items-center justify-content-between">
                <div class="col-sm-12 col-lg-6">
                    <img class="h-100 w-100" src="assets/img/illustrations/Illustration_ (8).svg">
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="d-flex flex-column">
                        <h1 class="text-primary hero-title display-5 fw-bold"> Автоматизированное составление графика работы
                            рентгенологов</h1>
                        <h2 class="hero-sub-title h6 mb-4 pb-1 fs-5">
                            Наш сервис использует передовые алгоритмы и нейронную сеть для оптимизации и составления
                            графиков работы врачей-рентгенологов.
                        </h2>
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <a href="{{ route('login') }}" class="btn btn-primary m-2">Вход</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary m-2">Регистрация</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Useful features: Start -->
            <div class="mb-4">
                <h3 class="text-center mb-2"><span class="section-title">Преимущества нашего решения</h3>
                <p class="text-center mb-md-5 pb-3">Автоматизируйте составление графика работы врачей-рентгенологов и
                    освободите свое время для более важных задач.</p>
                <div class="features-icon-wrapper row gx-0 gy-4 g-sm-5">
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/laptop.png"
                                alt="laptop charging" />
                        </div>
                        <h5 class="mb-3">Хорошее качество кода и гибкий алгоритм составления расписания</h5>
                        <p class="features-icon-description">
                            Мы используем хорошо знакомую всем разработчикам схему разделения данных приложения <b>MVC</b>
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/rocket.png"
                                alt="transition up" />
                        </div>
                        <h5 class="mb-3">Популярный и простой стек<br>использование нейронной сети</h5>
                        <p class="features-icon-description">
                            Сервис реализован с помощью <b>Laravel</b> и <b>Bootstrap 5</b> и <b>Python</b>
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/paper.png"
                                alt="edit" />
                        </div>
                        <h5 class="mb-3">Уведомления в Telegram</h5>
                        <p class="features-icon-description">
                            Наше решение взаимодействует с мессенджером Telegram, для оперативного информирования ваших
                            сотрудников
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/check.png"
                                alt="3d select solid" />
                        </div>
                        <h5 class="mb-3">Простое монтирование</h5>
                        <p class="features-icon-description">
                            Проект содержит конфигурационные файлы <b>webpack, vite, docker</b>
                        </p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/user.png"
                                alt="lifebelt" />
                        </div>
                        <h5 class="mb-3">Простой UI/UX дизайн</h5>
                        <p class="features-icon-description">Взаимодействие с сервисом простое и не требует особых навыков и
                            знаний</p>
                    </div>
                    <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                        <div class="text-center mb-3">
                            <img src="assets/img/icons/keyboard.png"
                                alt="google docs" />
                        </div>
                        <h5 class="mb-3">Весь процесс задокументирован</h5>
                        <p class="features-icon-description">Мы подготовили подробную документацию от предметной области до
                            внутреннего устройства проекта</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Useful features: End -->

        <!-- Our great team: Start -->

        <div class="mb-4">
          <h3 class="text-center mb-1"><span class="section-title">Наша команда</span></h3>
            <p class="text-center mb-md-5 pb-3">Познакомьтесь с нашей командой разработчиков, мы рады разработать вам
                стабильное эффективное решение</p>
            <div class="row">
                <div class="col-sm-6 col-lg-3 ">
                    <div class="card">
                        <div class="bg-label-primary position-relative d-flex justify-content-center p-1 pb-0">
                            <img class="w-100"  src="assets/img/avatars/Ekaterina.png" style="object-fit: cover; height: 350px;"/>
                        </div>
                        <div class="card-body border border-label-primary border-top-0 text-center">
                            <h5 class="card-title mb-1">Гусева Екатерина Александровна</h5>
                            <p class="text-muted mb-0">Fullstack разработчик <br> UX/UI дизайнер <br> DevOps инженер</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 ">
                    <div class="card">
                        <div class="bg-label-success position-relative d-flex justify-content-center p-1 pb-0">
                            <img class="w-100" src="assets/img/avatars/Sam.png" style="object-fit: cover;  height: 350px;"/>
                        </div>
                        <div class="card-body border border-label-success border-top-0 text-center">
                            <h5 class="card-title mb-1">Левченко Семен Александрович</h5>
                            <p class="text-muted mb-0">Fullstack разработчик <br> Mobile разработчик</p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-lg-3 ">
                    <div class="card">
                        <div class="bg-label-danger position-relative d-flex justify-content-center p-1 pb-0">
                            <img class="w-100" src="assets/img/avatars/Elena.png" style="object-fit: cover; height: 350px;"/>
                        </div>
                        <div class="card-body border border-label-danger border-top-0 text-center">
                            <h5 class="card-title mb-1">Абарникова Елена Борисовна</h5>
                            <p class="text-muted mb-0">Аналитик <br> Data Science специалист</p>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-lg-3 ">
                    <div class="card">
                        <div class="bg-label-info position-relative d-flex justify-content-center p-1 pb-0">
                            <img class="w-100" src="assets/img/avatars/no-avatar.svg" style="object-fit: cover; height: 350px;"/>
                        </div>
                        <div class="card-body border border-label-info  border-top-0 text-center">
                            <h5 class="card-title mb-1">Жбанов Валерий Александрович</h5>
                            <p class="text-muted mb-0">Backend-разработчик <br> Инженер по оптимизации и искусственному интеллекту <br> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our great team: End -->

        <!-- FAQ: Start -->

            <div class="container">
                <h3 class="text-center mb-1">Часто задаваемые <span class="section-title">вопросы</span></h3>
                <p class="text-center mb-5 pb-3">Просмотрите эти часто задаваемые вопросы и найдите на них ответы</p>
                <div class="row gy-5">
                    <div class="col-lg-5">
                        <div class="text-center">
                          <img class="h-100 w-100" src="assets/img/illustrations/Illustration_ (11).svg">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion" id="accordionExample">
                            <div class="card accordion-item active">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                      Где я могу найти сопроводительную документацию?
                                    </button>
                                </h2>

                                <div id="accordionOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Всю сопроводительную документацию вы можете найти по ссылке ниже.
                                      <br>
                                        <a href="https://decode.knastu.ru/wiki/books/soprovoditelnaia-dokumentaciia">Сопроводительная документация</a>
                                      <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionTwo" aria-expanded="false"
                                        aria-controls="accordionTwo">
                                        Где я могу найти техническую документацию?
                                    </button>
                                </h2>
                                <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Всю техническую документацию вы можете найти по ссылке ниже.
                                      <br>
                                        <a href="https://decode.knastu.ru/wiki/books/texniceskaia-dokumentaciia">Техническая документация</a>
                                      <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFive" aria-expanded="false"
                                        aria-controls="accordionFive">
                                        Как с нами связаться?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       Мы команда DECODE Predators, вы можете обратиться в чат, созданный модераторами LCT2024, или написать командиру команды в Telegram <a href="https://t.me/KinkaMay">@KinkaMay</a>, мы обязательно вам ответим.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- FAQ: End -->

        <!-- Footer: Start -->
        <footer class="landing-footer bg-body footer-text">
            <div class="footer-bottom py-3">
                <div
                    class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
                    <div class="mb-2 mb-md-0">
                        <span class="footer-text">©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            DECODE Predators
                        </span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer: End -->
    </div>
    </div>

@endsection
