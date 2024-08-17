
@php
$title = 'Страница не найдена';
$description = 'Мы не нашли страницу, которую вы ищите :(';
@endphp

@extends('layouts/blankLayout')


@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">Страница не найдена</h2>
      <p class="mb-4 mx-2">Мы не смогли найти то, что вы искали</p>
      <a href="{{url('/cabinet')}}" class="btn btn-primary">Вернуться на главную</a>
      <div class="mt-3">
        <img src="{{asset('assets/img/illustrations/page-misc-error-light.png')}}" alt="page-misc-error-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
