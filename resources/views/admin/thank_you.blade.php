<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>ERP</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{ asset('public/admin/assets/img/favicon.png') }}">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{asset('public/admin/assets/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{asset('public/admin/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/admin/assets/plugins/fontawesome/css/all.min.css')}}">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{asset('public/admin/assets/plugins/select2/css/select2.min.css')}}">

        <!-- Datatables CSS -->
		<link rel="stylesheet" href="{{asset('public/admin/assets/plugins/datatables/datatables.min.css')}}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{asset('public/admin/assets/css/style.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
		<style>
			#set_order_model h3{
				font-size: 18px;
			}

			#set_order_model .btn{
				padding: 0 8px !important;
			}

			#select_one_record h3{
				font-size: 22px;
			}
		</style>
        
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	
		<!-- Main Wrapper -->
		<div class="main-wrapper">

			<!-- Header -->
            <div class="header" >
               <!--Header -->

			<!-- Logo -->
			<div class="header-left">
				<a href="{{ url('/') }}" class="logo">
					<img src="{{asset('public/admin/assets/img/logo.png')}}" alt="Logo">
				</a>
				<a href="{{ url('/') }}" class="logo logo-small">
					<img src="{{asset('public/admin/assets/img/logo.png')}}" alt="Logo" width="30" height="30">
				</a>
			</div>

			<!-- /Logo -->
			
			<!-- Sidebar Toggle -->
			
			<!-- /Sidebar Toggle -->
			
			<!-- Search -->
			<!-- <div class="top-nav-search">
				<form>
					<input type="text" class="form-control" placeholder="Search here">
					<button class="btn" type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div> -->
			<!-- /Search -->
			
			<!-- Mobile Menu Toggle -->
			
			<!-- /Mobile Menu Toggle -->
			
			<!-- Header Menu -->
			<ul class="nav nav-tabs user-menu">
				<!-- Flag -->
				<!-- <li class="nav-item dropdown has-arrow flag-nav">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
						<img src="{{asset('public/assets/img/flags/us.png')}}" alt="" height="20"> <span>English</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="{{asset('public/assets/img/flags/us.png')}}" alt="" height="16"> English
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="{{asset('public/assets/img/flags/fr.png')}}" alt="" height="16"> French
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="{{asset('public/assets/img/flags/es.png')}}" alt="" height="16"> Spanish
						</a>
						<a href="javascript:void(0);" class="dropdown-item">
							<img src="{{asset('public/assets/img/flags/de.png')}}" alt="" height="16"> German
						</a>
					</div>
				</li> -->
				<!-- /Flag -->
				
				
				
			</ul>
			<!-- /Header Menu -->
			
		
		<!-- /Header-->
		

            </div>
			<!-- /Header -->

            

            <!-- /Sidebar -->

            <!-- Page Wrapper -->
			<div class="page-wrapper">
                <div class="row">
						<div class="col-sm-12">
							<h3 style="
    margin-top: 50px;
   
">{{$message}}</h3>
						</div>			
					</div>
            </div>

             <!-- /Page Wrapper -->

        </div>

        @include('admin.includes.footer') 
@yield('footer_js')