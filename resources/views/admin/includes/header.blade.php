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
			<a href="javascript:void(0);" id="toggle_btn">
				<i class="fas fa-bars"></i>
			</a>
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
			<a class="mobile_btn" id="mobile_btn">
				<i class="fas fa-bars"></i>
			</a>
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
				
				<!-- Notifications -->
				<li class="nav-item dropdown">
					<!-- <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<i data-feather="bell"></i> <span class="badge rounded-pill">5</span>
					</a>
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header">
							<span class="notification-title">Notifications</span>
							<a href="javascript:void(0)" class="clear-noti"> Clear All</a>
						</div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="activities.html">
										<div class="media d-flex">
											<span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="" src="{{asset('public/assets/img/profiles/avatar-02.jpg')}}">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Brian Johnson</span> paid the invoice <span class="noti-title">#DF65485</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="activities.html">
										<div class="media d-flex">
											<span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="" src="{{asset('public/assets/img/profiles/avatar-03.jpg')}}">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Marie Canales</span> has accepted your estimate <span class="noti-title">#GTR458789</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="activities.html">
										<div class="media d-flex">
											<div class="avatar avatar-sm">
												<span class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>
											</div>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">New user registered</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="activities.html">
										<div class="media d-flex">
											<span class="avatar avatar-sm">
												<img class="avatar-img rounded-circle" alt="" src="{{asset('public/assets/img/profiles/avatar-04.jpg')}}">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Barbara Moore</span> declined the invoice <span class="noti-title">#RDW026896</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="activities.html">
										<div class="media d-flex">
											<div class="avatar avatar-sm">
												<span class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
											</div>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">You have received a new message</span></p>
												<p class="noti-time"><span class="notification-time">2 days ago</span></p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer">
							<a href="activities.html">View all Notifications</a>
						</div>
					</div> -->
				</li>
				<!-- /Notifications -->
				
				<!-- User Menu -->
				<li class="nav-item dropdown has-arrow main-drop">
					<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						<span class="user-img">
							<!-- <img src="{{asset('public/assets/img/profiles/avatar-01.jpg')}}" alt=""> -->
							<span class="status online"></span>
						</span>
						<span>{{Auth::user()->name}}</span>
					</a>
					<div class="dropdown-menu">
						<!-- <a class="dropdown-item" href="{{route('profile.edit')}}"><i data-feather="user" class="me-1"></i> Profile</a> -->
						<a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="log-out" class="me-1"></i> Logout</a>
					</div>
				</li>
				<!-- /User Menu -->
				
			</ul>
			<!-- /Header Menu -->
			
		
		<!-- /Header-->
		