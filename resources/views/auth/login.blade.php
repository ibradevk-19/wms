@php
    $dir = app()->getLocale() == 'ar' ? 'rtl' : 'ltr';
    $align = app()->getLocale() == 'ar' ? 'right' : 'left';
@endphp


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>تسجيل الدخول | النظام المحوسب</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Misk is a Sales, Invoices & Accounts Admin for Accountant">
	<meta name="keywords" content=" Sales, Invoices & Accounts">
	<meta name="author" content="Dreams Technologies">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets-v1/assets/img/favicon.png')}}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets-v1/assets/img/apple-touch-icon.png')}}">
    
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/bootstrap.rtl.min.css')}}">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/plugins/tabler-icons/tabler-icons.min.css')}}">

	<!-- Iconsax CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/iconsax.css')}}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{asset('assets-v1/assets/css/style.css')}}">

</head>

<body class="bg-white">

	<!-- Begin Wrapper -->
	<div class="main-wrapper auth-bg">

		<!-- Start Content -->
		<div class="container-fuild">
			<div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">

				<!-- start row -->
				<div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap ">
					<div class="col-lg-4 mx-auto">
						<form method="POST" action="{{route('login')}}" class="d-flex justify-content-center align-items-center">
                            @csrf
							<div class="d-flex flex-column justify-content-lg-center p-4 p-lg-0 pb-0 flex-fill">
								
								<div class="card border-0 p-lg-3 shadow-lg">
									<div class="card-body">
										<div class=" mx-auto mb-5 text-center" style="height: 200px;">
											<img src="{{asset('assets-v1/assets/img/logo.png')}}"   class="img-fluid" alt="Logo">
										</div>
										<div class="text-center mb-3">
											<h5 class="mb-2"> تسجيل الدخول </h5>
											<p class="mb-0">من فضلك ادخل بيانات الدخول الى لوحة التحكم الخاصة بالنظام</p>
										</div>
										<div class="mb-3">
											<label class="form-label">البريد الالكتروني </label>
											<div class="input-group">
												<span class="input-group-text border-end-0">
													<i class="isax isax-sms-notification"></i>
												</span>
												<input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="{{ __('Enter Email Address') }} ">
											</div>
										</div>
										<div class="mb-3">
											<label class="form-label">كلمة المرور</label>
											<div class="pass-group input-group">
												<span class="input-group-text border-end-0">
													<i class="isax isax-lock"></i>
												</span>
												<input type="password" name="password" class="pass-inputs form-control border-start-0 ps-0" placeholder="****************">
											</div>
										</div>
										<div class="d-flex align-items-center justify-content-between mb-3">
											
										</div>
										<div class="mb-1">
											<button type="submit" class="btn bg-primary-gradient text-white w-100">تسجيل الدخول</button>
										</div>
									</div><!-- end card body -->
								</div><!-- end card -->
							</div>
						</form>
					</div><!-- end col -->
				</div>
				<!-- end row -->

			</div>
		</div>
		<!-- End Content -->

	</div>
	<!-- End Wrapper -->

	<!-- jQuery -->
	<script src="{{asset('assets-v1/assets/js/jquery-3.7.1.min.js')}}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('assets-v1/assets/js/bootstrap.bundle.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{asset('assets-v1/assets/js/script.js')}}"></script>

</body>

</html>