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
		<link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">

		<!-- Pe7 CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin/assets/plugins/icons/themify/themify.css') }}">

		{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
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
			/* .dt-search{
				float: right;
			}
			.dt-length{
				display: none;
			}
			#exapmle_info{
				display: none;
			}
			.dt-info{
				display: none;
			}
			.paging_full_numbers{
				display: none;
			}
			.dt-scroll-headInner > table > thead {
			display: none;
			}
			/* Use the attribute selector to target the label with the 'for' attribute set to 'dt-search-0' */
			/* label[for="dt-search-0"] {
				position: absolute;
				margin-left: -55px;
				padding-top: 8px;
			} */ */

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
            <div class="header">
                @include('admin.includes.header') 

            </div>
			<!-- /Header -->

            <!-- Sidebar -->
			<div class="sidebar" id="sidebar">

                @include('admin.includes.sidebarleft') 

            </div>

            <!-- /Sidebar -->

            <!-- Page Wrapper -->
			<div class="page-wrapper">
                @yield('content')
            </div>

             <!-- /Page Wrapper -->

        </div>

        @include('admin.includes.footer') 
@yield('footer_js')