<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{-- <link rel="stylesheet" href="{{ asset("assets/css/nice-select2.css") }}"> --}}
	{{-- <link rel="stylesheet" href="{{ asset("assets/css/style.min.css") }}"> --}}
	@vite('resources/scss/app.scss')
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<title>ЧГПУ - Контракт</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('styles')

</head>
<body>

    @yield('header')

    @yield('content')

    @yield('footer')

    @yield('menu')


    @yield('scripts')

	{{-- <script src="{{ asset("assets/js/nice-select2.js") }}"></script> --}}
	{{-- <script src="{{ asset("assets/js/app.js") }}"></script> --}}
	@vite('resources/js/app.js')
</body>