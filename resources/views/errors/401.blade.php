
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
      <h2 class="mb-2 mx-2">У вас не хватает прав</h2>
      <p class="mb-4 mx-2">Для посещения данной страницы вам необходимы особенные права. Пожалуйста, обратитесь к администратору</p>
      <a href="{{url('/cabinet')}}" class="btn btn-primary">Вернуться на главную</a>
      <div class="mt-3">
        <img src="{{asset('assets/img/illustrations/girl-doing-yoga-light.png')}}" alt="girl-doing-yoga-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
