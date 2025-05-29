 <!doctype html>
<html class="no-js" lang="en">
    <head>
        <title>Sagar Store</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="author" content="ThemeZaa">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
         <meta name="description" content=""> 
        <!-- favicon icon -->
        <!-- <link rel="shortcut icon" href="images/favicon.png"> -->
        <link rel="apple-touch-icon" href="{{asset('public/site/images/apple-touch-icon-57x57.png')}}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{asset('public/site/images/apple-touch-icon-72x72.png')}}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{asset('public/site/images/apple-touch-icon-114x114.png')}}">
        <!-- style sheets and font icons  -->
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/css/font-icons.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/css/theme-vendors.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/css/style.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/css/style-p.css')}}" />

        <link rel="stylesheet" type="text/css" href="css/responsive.css" />
        <!-- revolution slider -->
        <link rel='stylesheet' href="{{asset('public/site/revolution/revolution-addons/bubblemorph/css/revolution.addon.bubblemorph.css')}}" type='text/css' media='all' />
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/revolution/css/settings.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/revolution/css/layers.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('public/site/revolution/css/navigation.css')}}">
        
    </head>
    <body data-mobile-nav-style="classic">
 <!-- start header -->
        <header class="header-with-topbar">
            <div class="top-bar bg-extra-dark-gray d-none d-md-inline-block padding-35px-lr md-no-padding-lr">
                <div class="container-fluid nav-header-container">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="col-12 text-center text-sm-start col-sm-auto me-auto ps-lg-0">
                            <p class="text-medium m-0"><span class="font-weight-500 text-white">Offer: </span>Worldwide free shipping for all orders of $150</p>
                        </div>
                        <div class="col-auto d-none d-sm-block text-end px-lg-0 font-size-0">
                            <div class="top-bar-contact">
                                <span class="top-bar-contact-list border-none md-no-padding-right">
                                    <i class="feather icon-feather-phone-call icon-extra-small text-white"></i>+91 9876543210
                                </span>
                                <span class="top-bar-contact-list d-none d-lg-inline-block border-none pe-0">
                                    <i class="feather icon-feather-map-pin icon-extra-small text-white"></i>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start navigation -->
            <nav class="navbar navbar-expand-lg navbar-boxed navbar-light bg-white header-light top-space fixed-top header-reverse-scroll">
                <div class="container-fluid nav-header-container">
                    <div class="col-auto col-sm-6 col-lg-2 me-auto ps-lg-0">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{asset('public/site/images/sagar-logo.png')}}" data-at2x="{{asset('public/site/images/sagar-logo.png')}}" alt="" class="default-logo">
                            <!--<img src="images/sagar-logo.png" data-at2x="images/sagar-logo.png" alt="" class="alt-logo">-->
                            <!--<img src="images/sagar-logo.png" data-at2x="images/sagar-logo.png" class="mobile-logo" alt="">-->
                        </a>
                    </div>
                    <div class="col-auto col-lg-8 menu-order px-lg-0">
                        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                            <span class="navbar-toggler-line"></span>
                            <span class="navbar-toggler-line"></span>
                            <span class="navbar-toggler-line"></span>
                            <span class="navbar-toggler-line"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                            <ul class="navbar-nav alt-font">
                                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                                
                                <li class="nav-item dropdown megamenu">
                                    <a href="javascript:void(0);" class="nav-link">Women's Wear</a>
                                    <i class="fa fa-angle-down dropdown-toggle" data-bs-toggle="dropdown" aria-hidden="true"></i>
                                    <div class="menu-back-div dropdown-menu megamenu-content" role="menu">
                                        <div class="d-lg-flex justify-content-center">
                                            <ul class="d-lg-inline-block">
                                                <li class="dropdown-header">Women's Wear</li>
                                                <li><a href="{{url('/product-listing')}}">Women's Wear</a></li>
                                                <li><a href="{{url('/product-listing')}}">Evening Gown</a></li>
                                                <li><a href="{{url('/product-listing')}}">Skirt</a></li>
                                                <li><a href="{{url('/product-listing')}}">Crop Top</a></li>
                                                <li><a href="{{url('/product-listing')}}">Indo Western</a></li>
                                                <li><a href="{{url('/product-listing')}}">Saree</a></li>
                                                <li><a href="{{url('/product-listing')}}">Silk Saree</a></li>
                                                <li><a href="{{url('/product-listing')}}">Designer Saree</a></li>
                                                <li><a href="{{url('/product-listing')}}">Bridal Ghagra</a></li>
                                                <li><a href="{{url('/product-listing')}}">Bridal Saree</a></li>
                                                <li><a href="{{url('/product-listing')}}">Traditional Saree</a></li>
                                            </ul>
                                           
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item dropdown megamenu">
                                    <a href="javascript:void(0);" class="nav-link">Men's Wear</a>
                                    <i class="fa fa-angle-down dropdown-toggle" data-bs-toggle="dropdown" aria-hidden="true"></i>
                                    <div class="menu-back-div dropdown-menu megamenu-content" role="menu">
                                        <div class="d-lg-flex justify-content-center">
                                            <ul class="d-lg-inline-block">
                                                <li class="dropdown-header">Men's Wear</li>
                                                <li><a href="{{url('/product-listing')}}">Suit</a></li>
                                                <li><a href="{{url('/product-listing')}}">Indo Western</a></li>
                                                <li><a href="{{url('/product-listing')}}">Suit Blazer</a></li>
                                                <li><a href="{{url('/product-listing')}}">Jackets</a></li>
                                                <li><a href="{{url('/product-listing')}}">Kurta Pajama</a></li>
                                            </ul>
                                          
                                           
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item dropdown megamenu">
                                    <a href="javascript:void(0);" class="nav-link">Kid's Wear</a>
                                    <i class="fa fa-angle-down dropdown-toggle" data-bs-toggle="dropdown" aria-hidden="true"></i>
                                    <div class="menu-back-div dropdown-menu megamenu-content" role="menu">
                                        <div class="d-lg-flex justify-content-center">
                                            <ul class="d-lg-inline-block">
                                                <li class="dropdown-header">Boys</li>
                                                <li><a href="{{url('/product-listing')}}">Suit</a></li>
                                                <li><a href="{{url('/product-listing')}}">Blazers</a></li>
                                                <li><a href="{{url('/product-listing')}}">Indo Western</a></li>
                                            </ul>
                                            <ul class="d-lg-inline-block">
                                                <li class="dropdown-header">Girls</li>
                                                <li><a href="{{url('/product-listing')}}">Gown</a></li>
                                                <li><a href="{{url('/product-listing')}}">Crop Top</a></li>
                                                <li><a href="{{url('/product-listing')}}">Skirts</a></li>
                                                <li><a href="{{url('/product-listing')}}">Indo Western</a></li>
                                            </ul>
                                           
                                        </div>
                                    </div>
                                </li>
                              
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto col-lg-2 text-end pe-0 font-size-0">
                        <div class="header-search-icon search-form-wrapper">
                            <a href="javascript:void(0)" class="search-form-icon header-search-form"><i class="feather icon-feather-search"></i></a>
                            <!-- start search input --> 
                            <div class="form-wrapper">
                                <button title="Close" type="button" class="search-close alt-font">×</button>
                                <form id="search-form" role="search" method="get" class="search-form text-start" action="search-result.html">
                                    <div class="search-form-box">
                                        <span class="search-label alt-font text-small text-uppercase text-medium-gray">What are you looking for?</span>
                                        <input class="search-input alt-font" id="search-form-input5e219ef164995" placeholder="Enter your keywords..." name="s" value="" type="text" autocomplete="off">
                                        <button type="submit" class="search-button">
                                            <i class="feather icon-feather-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- end search input --> 
                        </div>
                        <div class="header-cart-icon dropdown">
                            <a href="javascript:void(0);"><i class="feather icon-feather-shopping-bag"></i><span class="cart-count alt-font bg-extra-dark-gray text-white">2</span></a>
                            <ul class="dropdown-menu cart-item-list">
                                <li class="cart-item align-items-center">
                                    <a href="javascript:void(0);" class="alt-font close">×</a>
                                    <div class="product-image">
                                        <a href="#"><img src="https://via.placeholder.com/150x191" class="cart-thumb" alt="" /></a>
                                    </div>
                                    <div class="product-detail alt-font">
                                        <a href="#">Beautiful Grey Tussar Silk Saree</a>
                                        <span class="item-ammount">&#8377;1999</span> 
                                    </div>
                                </li>
                                <li class="cart-item align-items-center">
                                    <a href="javascript:void(0);" class="alt-font close">×</a>
                                    <div class="product-image">
                                        <a href="#"><img src="https://via.placeholder.com/150x191" class="cart-thumb" alt="" /></a>
                                    </div>
                                    <div class="product-detail alt-font">
                                        <a href="#">Elegant Peach Semi Organza Printed Saree</a>
                                        <span class="item-ammount">	&#8377; 1999</span> 
                                    </div>
                                </li>
                                <li class="cart-item cart-total">
                                    <div class="alt-font margin-15px-bottom"><span class="w-50 d-inline-block text-medium text-uppercase">Subtotal:</span><span class="w-50 d-inline-block text-end text-medium font-weight-500">&#8377;3998</span></div>
                                    <a href="{{url('/cart')}}" class="btn btn-small btn-dark-gray">view cart</a>
                                    <a href="{{url('/checkout')}}" class="btn btn-small btn-neon-orange">checkout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>