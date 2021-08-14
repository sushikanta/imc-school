<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fav Icon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('theme-school') }}/css/bootstrap.min.css">
    <link href="{{ asset('theme-school') }}/css/all.css" rel="stylesheet">
    <link href="{{ asset('theme-school') }}/css/owl.carousel.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="{{ asset('theme-school') }}/css/switcher.css"> -->
    <link rel="stylesheet" href="{{ asset('theme-school') }}/rs-plugin/css/settings.css">
    <!-- Jquery Fancybox CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme-school') }}/css/jquery.fancybox.min.css" media="screen" />
    <link href="{{ asset('theme-school') }}/css/animate.css" rel="stylesheet">
    <link href="{{ asset('theme-school') }}/css/style.css" rel="stylesheet"  id="colors">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset(mix('theme-school/css/main.css'))}}" />
    <title>Integrated Manipur Academy</title>
</head>
<body class="theme-school">

<!--Header Start-->
<div class="header-wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-12 navbar-light" style="display: flex">
                <div class="logo" style="    display: flex; align-items: center;"> <a href="{{route('home')}}"><img alt="" class="logo-default" src="{{ asset('theme-school') }}/images/001/logo.png"></a></div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="navigation-wrap" id="filters">
                    <nav class="navbar navbar-expand-lg navbar-light"> <a class="navbar-brand" href="#">Menu</a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <button class="close-toggler" type="button" data-toggle="offcanvas"> <span><i class="fas fa-times-circle" aria-hidden="true"></i></span> </button>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item"> <a class="nav-link {!! request()->is('/') ? 'active' : ''  !!}" href="{{route('home')}}">Home {!! request()->is('/') ? '<span class="sr-only">(current)</span></a>' : ''  !!}</a> </li>
                                <li class="nav-item"><a class="nav-link {!! request()->is('about-us') ? 'active' : ''  !!}" href="{{route('aboutus')}}">About</a></li>
                                <li class="nav-item"><a class="nav-link {!! request()->is('register') ? 'active' : ''  !!}" href="{{route('register')}}">Registration {!! request()->is('register') ? '<span class="sr-only">(current)</span></a>' : ''  !!}</a></li>
                                <li class="nav-item"><a class="nav-link {!! request()->is('contact-us') ? 'active' : ''  !!}" href="{{route('contact')}}">Contact Us</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="header_info">
                    <div class="search"></div>
                    <div class="loginwrp"><a href="{{route('admin.login')}}">Admin Login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Header End-->

@yield('content')

<!-- Footer Start -->
<div class="footer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="footer_logo"><img alt="" class="footer-default" src="{{ asset('theme-school') }}/images/001/logo.png"></div>
                <p>
                    We are more than just a school, We provide our students with a safe learning environment
                    that helps them grow as unique personalities. We know that each child is different and
                    hence a one size fits all teaching method would never do.
                    We employ several innovative teaching techniques that impart knowledge and
                    instill strong values into the child to become responsible future citizens of the world.
                </p>
            </div>
            <div class="col-lg-2 col-md-3">
                <h3>Quick links</h3>
                <ul class="footer-links">
                    <li> <a href="{{route('home')}}">Home</a></li>
                    <li> <a href="{{route('aboutus')}}">About</a></li>
                    <li> <a href="{{route('register')}}">Enroll</a></li>
                    {{--<li> <a href="teachers.html">Teachers</a></li>--}}
                    <li> <a href="{{route('contact')}}">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4">
                <h3>Opening Hours</h3>
                <ul class="unorderList hourswrp">
                    <li>Monday <span>09:00 - 06:00</span></li>
                    <li>Tuesday <span>09:00 - 06:00</span></li>
                    <li>Wednesday <span>09:00 - 06:00</span></li>
                    <li>Thursday <span>09:00 - 06:00</span></li>
                    <li>Friday <span>09:00 - 06:00</span></li>
                    <li>Saturday <span>09:00 - 06:00</span></li>
                    <li>Sunday <span>Closed</span></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4" style="padding: 0">
                <div class="footer_info">
                    <h3>Get in Touch</h3>
                    <ul class="footer-adress">
                        <li class="footer_address"> <i class="fas fa-map-signs"></i> <span>Malom, Airport Road, Imphal</span> </li>
                        <li class="footer_email"> <i class="fas fa-envelope" aria-hidden="true"></i> <span> <a href="mailto:info@integratedmanipuracademy.com">
                                    info@integratedmanipuracademy.com
                                </a></span> </li>
                        <li class="footer_phone"> <i class="fas fa-phone-alt"></i> <span><a href="tel:7704282433"> +91 - 9362 113 179</a></span> </li>
                    </ul>
                    <div class="social-icons footer_icon">
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!--Copyright Start-->
<div class="footer-bottom text-center" style="background-color: #16191f">
    <div class="container">
        <div class="copyright-text" style="color: white">Copyright © Integrated Manipur Academy {{ date("Y") }}. All Rights Reserved</div>
    </div>
</div>
<!--Copyright End-->

<!-- Js -->
<script src="{{ asset('theme-school') }}/js/jquery.min.js"></script>
<script src="{{ asset('theme-school') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('theme-school') }}/js/popper.min.js"></script>
<script src="{{ asset('theme-school') }}/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="{{ asset('theme-school') }}/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- Jquery Fancybox -->
<script src="{{ asset('theme-school') }}/js/jquery.fancybox.min.js"></script>
<!-- Animate js -->
<script src="{{ asset('theme-school') }}/js/animate.js"></script>
<script>
    new WOW().init();
</script>
<!-- WOW file -->
<script src="{{ asset('theme-school') }}/js/wow.js"></script>
<!-- general script file -->
<script src="{{ asset('theme-school') }}/js/owl.carousel.js"></script>
<script src="{{ asset('theme-school') }}/js/script.js"></script>

@yield('scripts')
</body>
</html>