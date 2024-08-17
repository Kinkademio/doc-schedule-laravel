
@extends('layouts/blankLayout')

@php
    $title = 'Нет прав';
    $description = 'У вас нет прав для просмотра страницы';
@endphp

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
    <!-- Error -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">Вам еще не выдали роль</h2>
            <p class="mb-4 mx-2">Для посещения данной страницы вам необходима новая роль. <br>Ее выдадут после подтверждения вашей личности в отделе кадров.  <br>Пожалуйста, обратитесь в отдел кадров.</p>
            <a href="{{url('/')}}" class="btn btn-primary">Вернуться на лендинг</a>
            <div class="mt-3">
                <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" alt="girl-doing-yoga-light" width="500" class="img-fluid">
            </div>
        </div>
    </div>
    <!-- /Error -->
@endsection
