<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	@vite('resources/scss/parts/admin.scss')
	<title>Панель администрирования</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	@yield('styles')

</head>
<body>


    @include('admin.parts.header')

    @include('admin.parts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">
                @yield('page_title')
              </h1>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->

      
      
      <section class="content">
        <div class="container-fluid">

          @yield('content')
          

          {{-- content --}}


          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
  


  @include('admin.parts.footer')


  @yield('scripts')


	{{-- @vite('resources/js/app.js') --}}
</body>

