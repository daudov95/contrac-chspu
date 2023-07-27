<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Админ панель</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("assets/admin/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("assets/admin/css/adminlte.min.css") }}">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset("assets/admin/plugins/daterangepicker/daterangepicker.css") }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset("assets/admin/plugins/summernote/summernote-bs4.min.css") }}">

  {{-- Select2  --}}
  <link rel="stylesheet" href="{{ asset("assets/admin/plugins/select2/css/select2.min.css") }}">
  <link rel="stylesheet" href="{{ asset("assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset("assets/admin/img/AdminLTELogo.png") }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('lk.index') }}" class="nav-link">Главная</a>
      </li>
    </ul>
    

    <!-- Right navbar links -->
    {{-- <ul class="navbar-nav ml-auto"> --}}
      <!-- Navbar Search -->
        
    {{-- </ul> --}}
  </nav>
  <!-- /.navbar -->