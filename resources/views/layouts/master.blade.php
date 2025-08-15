@php
    $dir = app()->getLocale() == 'ar' ? 'rtl' : 'ltr';
    $align = app()->getLocale() == 'ar' ? 'right' : 'left';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $dir }}">

<head>

	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('page-title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets-v1/assets/img/favicon.png')}}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets-v1/assets/img/apple-touch-icon.png')}}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    @if(app()->getLocale() == 'ar')
    <!-- Bootstrap CSS -->
	   <link rel="stylesheet" href="{{asset('assets-v1/assets/css/bootstrap.rtl.min.css')}}">
    @else
       <link rel="stylesheet" href="{{asset('assets-v1/assets/css/bootstrap.min.css')}}">
    @endif

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/daterangepicker/daterangepicker.css')}}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/bootstrap-datetimepicker.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/fontawesome/css/all.min.css')}}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/simplebar/simplebar.min.css')}}">

	<!-- Iconsax CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/iconsax.css')}}">
    <link rel="stylesheet" href="{{ asset('assets-v1/assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/select2/css/select2.min.css')}}">

    @yield('style')

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/style.css')}}">

    <style>
        body, html, .main-wrapper, .form-control, .btn, .table, .modal, h1, h2, h3, h4, h5, h6, p, span, a, label {
            font-family: 'Cairo', sans-serif !important;
			font-size: 15px;
        }
    </style>

</head>

  @if(app()->getLocale() == 'ar')
    <!-- Bootstrap CSS -->
	  <body class="layout-mode-rtl">
    @else
       <body >
    @endif


	<!-- Begin Wrapper -->
	<div class="main-wrapper">		

		<!-- Topbar Start -->
		  @include('parts.topbar')
		<!-- Topbar End -->

		<!-- Sidenav Menu Start -->
		  @include('parts.sidenav')
		<!-- Sidenav Menu End -->

		<!-- ========================
			Start Page Content
		========================= -->

		<div class="page-wrapper">	

			<!-- Start Content -->
			<div class="content">

				<!-- Page Header -->
			       <!-- @include('parts.page_header') -->
				<!-- End Page Header -->
                    @if (Route::is(['dashboard']))
                  
                    @endif
                    
                    @yield('content')
			

			</div>
			<!-- End Content -->

			<!-- Start Footer -->
			  @include('parts.footer')
			<!-- End Footer -->

		</div>

		<!-- ========================
			End Page Content
		========================= -->
		  @yield('modals')
	</div>
	<!-- End Wrapper -->

	<!-- jQuery -->
	<script src="{{asset('assets-v1/assets/js/jquery-3.7.1.min.js')}}"></script>

	<!-- Simplebar JS -->
	<script src="{{asset('assets-v1/assets/plugins/simplebar/simplebar.min.js')}}"></script>

	<!-- Feather Icon JS -->
	<script src="{{asset('assets-v1/assets/js/feather.min.js')}}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('assets-v1/assets/js/bootstrap.bundle.min.js')}}"></script> 
	
	<!-- Daterangepikcer JS -->
	<script src="{{asset('assets-v1/assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets-v1/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets-v1/assets/js/moment.js')}}"></script>
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets-v1/assets/js/bootstrap-datetimepicker.min.js')}}"></script>

	<!-- Chart JS -->
	<script src="{{asset('assets-v1/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
	<script src="{{asset('assets-v1/assets/plugins/apexchart/chart-data.js')}}"></script>


    <script src="{{ asset('assets-v1/assets/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets-v1/assets/js/dataTables.bootstrap5.min.js') }}"></script>


    <script src="{{asset('assets-v1/assets/plugins/select2/js/select2.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{asset('assets-v1/assets/js/script.js')}}"></script>
     @stack('scripts')

</body>

</html>
