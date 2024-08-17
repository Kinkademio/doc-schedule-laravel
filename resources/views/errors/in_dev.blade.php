
@extends('layouts/blankLayout')

@php
  $title = 'В разработке';
  $description = 'К сожалению данная страница пока в разработке';
@endphp

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">В разработке</h2>
      <p class="mb-4 mx-2">Данный функционал еще не реализован</p>
      <a href="{{url('/cabinet')}}" class="btn btn-primary">Вернуться на главную</a>
      <div class="mt-3">
        <img src="{{asset('assets/img/illustrations/girl-doing-yoga-light.png')}}" alt="girl-doing-yoga-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
