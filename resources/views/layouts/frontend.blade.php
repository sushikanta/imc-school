<!DOCTYPE HTML>
<!-- BEGIN html -->
<html lang = "en">
<!-- BEGIN head -->
<head>
    <title>RealtynInfra.com @yield('title')</title>

    <!-- Meta Tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <meta property="og:url"           content="{{ Request::url() }}" />
    <meta property="og:type"          content="post" />
    <meta property="og:title"         content="@yield('og_title')" />
    <meta property="og:description"   content="@yield('og_description')" />
    <meta property="og:image"         content="@yield('og_image')" />

    <meta name="google-site-verification" content="u3dl8u6YBl-kgLymcAKAen1_PVAuQi2VNrkA0wVgGZ8" />


    <meta name="Language" content="English" />
    <meta name="Revisit-After" content="7 Days" />
    <meta name="distribution" content="LOCAL" />
    <meta name="Robots" content="INDEX, FOLLOW" />
    <meta name="page-topic" content="RealtynInfra">
    <META name="YahooSeeker" content="INDEX, FOLLOW">
    <META name="msnbot" content="INDEX, FOLLOW">
    <meta name="googlebot" content="index,follow"/>
    <meta name="Rating" content="General"/>
    <META name="allow-search" content="yes">
    <META name="expires" content="never">
    <meta name="author" content="RealtynInfra" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend') }}/images/new/favicon.png" type="image/x-icon" />

    <!-- Stylesheets -->
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700+Open+Sans:400,700" />
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/reset.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/owl.carousel.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/animate.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/main-stylesheet.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/ot-lightbox.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/shortcodes.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/responsive.min.css?v=21.21" />
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/custom.css?v=1.2.1" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--[if lte IE 8]>
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/ie-ancient.min.css" />
    <![endif]-->

    <style>

        /* Custom CSS colors and fonts */
        /* Main body font size, font, color / default: 16px, Arial, #5e5e5e */
        /*body {
            font-size: 16px;
            font-family: Arial, sans-serif;
            color: #5e5e5e;
        }*/
    </style>

    <!-- Demo Only -->
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend') }}/css/_ot-demo.min.css" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179035897-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-179035897-1');
    </script>
    <!-- END head -->
</head>

<!-- BEGIN body -->
<!-- <body> -->
<body class="ot-menu-will-follow">


<!-- BEGIN .boxed -->
<div class="boxed">

    <!-- BEGIN .header -->
    <div class="header">

        <!-- BEGIN .wrapper -->
        <div class="wrapper">

            {{-- <nav class="header-top">
                 <div class="header-top-socials">
                     <a href="#" class="ot-color-hover-facebook"><i class="fa fa-facebook"></i><span>43</span></a>
                     <a href="#" class="ot-color-hover-twitter"><i class="fa fa-twitter"></i></a>
                     <a href="#" class="ot-color-hover-google-plus"><i class="fa fa-google-plus"></i><span>12</span></a>
                     <a href="#" class="ot-color-hover-pinterest"><i class="fa fa-pinterest-p"></i><span>65</span></a>
                 </div>
                 <ul>
                     <li><a href="javascript:void(0)"><span>Homepage</span></a>
                         <ul class="sub-menu">
                             <li><a href="index2.html">Homepage style 2</a></li>
                             <li><a href="index3.html">Homepage style 3</a></li>
                         </ul>
                     </li>
                     <li><a href="javascript:void(0)">Blog</a></li>
                     <li><a href="#"><span>Sub-menu</span></a>
                         <ul class="sub-menu">
                             <li><a href="#">Sub-menu link #1</a>
                             <li><a href="#"><span>Sub-menu link #2</span></a>
                                 <ul class="sub-menu">
                                     <li><a href="#">Sub-sub-menu link #1</a></li>
                                     <li><a href="#">Sub-sub-menu link #2</a></li>
                                     <li><a href="#">Sub-sub-menu link #3</a></li>
                                 </ul>
                             </li>
                             <li><a href="#">Sub-menu link #3</a>
                         </ul>
                     </li>
                     <li><a href="photo-gallery.html">Photo gallery</a></li>
                     <li><a href="http://themeforest.net/item/composs-elegant-blog-magazine-news-html-template/14726262?ref=orange-themes" target="_blank">Buy Composs</a></li>
                 </ul>
             </nav>--}}

            <div class="header-content">

                <div class="header-content-logo">
                    <a href="{{ route('home') }}"><img style="max-height: 70px" src="{{ asset('frontend') }}/images/new/logo_3.png" data-ot-retina="{{ asset('frontend') }}/images/logo@2x.png" alt="" /></a>
                </div>

                <div class="header-content-o">
                  {{--  <a href="#" target="_blank"><img src="{{ asset('frontend') }}/images/o1.jpg" alt="" /></a>--}}
                </div>

            </div>

            <div class="main-menu-placeholder wrapper">
                <nav id="main-menu">
                    <ul>

                        <li><a href="{{ route('home') }}">Home</a></li>

                            <?php
                                if(@$menu_categories){
                                   foreach ($menu_categories as $menu) {
                                       ?>
                                        <li><a href="{{ route('category.posts.slug', $menu->slug) }}">{{$menu->title}}</a></li>
                                        <?php
                                   }
                                }
                                ?>
                       {{-- <li><a href="{{route('contact')}}">Contact Us</a></li>--}}
                    </ul>
                    {{-- <form action="javascript:void(0)" method="get">
                         <input type="text" value="" placeholder="Search" />
                         <button type="submit"><i class="fa fa-search"></i></button>
                     </form>--}}
                </nav>
            </div>

            <!-- END .wrapper -->
        </div>

        <!-- END .header -->
    </div>


    <!-- BEGIN .content -->
    <div class="content">

        <!-- BEGIN .wrapper -->
        @yield('content')

        <!-- BEGIN .content -->
    </div>


    <!-- BEGIN #footer -->
    <footer id="footer">

        <!-- BEGIN .wrapper -->
        <div class="wrapper"  style="border-top: 1px solid #ececec;
    padding-top: 30px;">
            {{--
                        <ul>
                            <li><a href="category.html">Timeam delicatissimi</a></li>
                            <li><a href="category.html">Viderer salutatus eiusmel ea</a></li>
                            <li><a href="category.html">Mei debet quaeque et</a></li>
                            <li><a href="category.html">Ne his adhuc meliore</a></li>
                            <li><a href="category.html">Scaevola postulant essent</a></li>
                            <li><a href="category.html">Summo vivendum</a></li>
                        </ul>--}}

            <div class="footer-widgets lets-do-4">

                <div class="widget-split item">
                    <div class="widget">
                        <div>
                            <p><a href="javascript:void(0)"><img src="{{ asset('frontend') }}/images/new/logo_3.png" alt="" /></a></p>

                            <p>Find the latest real estate news, views and updates from all top sources for the Indian Realty industry.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="widget-split item">
                    <div class="widget">
                        <h3>Popular categories</h3>
                        <ul class="menu">
                            <?php
                            if(@$menu_categories){
                            foreach ($menu_categories as $menu) {
                            ?>
                                <li><a href="{{ route('category.posts.slug', $menu->slug) }}">{{$menu->title}}</a></li>
                            <?php
                            }
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="widget-split item">
                    <div class="widget">
                        <h3>Popular Post</h3>
                        <div class="widget-content ot-w-article-list">
                            <?php
                                if(@$popular_posts){
                                    foreach ($popular_posts as $post){

                                    if(is_array($post->img_src)){
                                        $img_src = @$post->img_src['thumbs']['100W_SQUARECROP']['path'];
                                    }else{
                                        $img_src =  asset('storage/'.$post->img_src);
                                    }

                                        ?>
                                <div class="item">
                                    <div class="item-header">
                                        <a href="{{route('post.details.slug', $post->slug)}}" class="img-read-later-button rm-btn-small">Read More</a>
                                        <a href="{{route('post.details.slug', $post->slug)}}"><img class="border-light" src="{{$img_src}}" alt="" /></a>
                                    </div>
                                    <div class="item-content">
                                        <h4><a href="{{route('post.details.slug', $post->slug)}}">{{$post->title}}</a></h4>
                                        <span class="item-meta">
												<span class="item-meta-item"><i class="material-icons">access_time</i>{{ \App\Classes\Utility::convertTimeToUSERzone($post->published_at, 'F d, Y')}}</span>
											</span>
                                    </div>
                                </div>
                                    <?php
                                    }
                                }

                            ?>


                        </div>
                    </div>
                </div>
                <div class="widget-split item">
                    <div class="widget">
                        <h3>Site Links</h3>
                        <ul class="menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            {{--<li><a href="javascript:void(0)">About Us</a></li>
                            <li><a href="javascript:void(0)">Terms</a></li>--}}
                        </ul>
                    </div>
                </div>


            </div>

            <div class="footer-copyright" style=" border-top: 1px solid #ececec;">
                <p>&copy; <a href="{{ url('') }}" target="_blank">RealtynInfra.com</a> {{ date('Y') }}. All rights reserved.</p>
            </div>

            <!-- END .wrapper -->
        </div>

        <!-- END #footer -->
    </footer>

    {{--<div class="ot-follow-share">--}}
    {{--<a href="#" class="ot-color-facebook" data-h-title="Facebook"><i class="fa fa-facebook"></i></a>--}}
    {{--<a href="#" class="ot-color-twitter" data-h-title="Twitter"><i class="fa fa-twitter"></i></a>--}}
    {{--<a href="#" class="ot-color-google-plus" data-h-title="Google+"><i class="fa fa-google-plus"></i></a>--}}
    {{--<a href="#" class="ot-color-rss" data-h-title="RSS Feed"><i class="fa fa-rss"></i></a>--}}
    {{--</div>--}}

    <div class="ot-responsive-menu-header">
        <a href="#" class="ot-responsive-menu-header-burger"><i class="material-icons">menu</i></a>
        <a href="javascript:void(0)" class="ot-responsive-menu-header-logo"><img style="max-height: 70px" src="{{ asset('frontend') }}/images/new/logo_3.png" alt="" /></a>
    </div>

    <!-- END .boxed -->
</div>

<div class="ot-responsive-menu-content-c-header">
    <a href="#" class="ot-responsive-menu-header-burger"><i class="material-icons">menu</i></a>
</div>
{{--<div class="ot-responsive-menu-content">
    <div class="ot-responsive-menu-content-inner has-search">
        <form action="http://composs.orange-themes.net/html/javascript:void(0)" method="get">
            <input type="text" value="" placeholder="Search" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <ul id="responsive-menu-holder"></ul>
    </div>
</div>--}}
<div class="ot-responsive-menu-background"></div>

<!-- Scripts -->
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/jquery-latest.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/theia-sticky-sidebar.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/modernizr.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/owl.carousel.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/shortcode-scripts.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/theme-scripts.min.js"></script>
<script type="text/javascript" src="{{ asset('frontend') }}/jscript/ot-lightbox.min.js"></script>
<script>
    // jQuery('.main-slider-owl').owlCarousel({
    // 	margin: 20,
    // 	responsiveClass: true,
    // 	items: 1,
    // 	nav: true,
    // 	dots: false,
    // 	loop: true,
    // 	autoplay: true,
    // 	autoplayTimeout: 5000,
    // 	autoplayHoverPause: true,
    // 	animateOut: 'slideOutDown',
    // 	animateIn: 'slideInDown'
    // });
    jQuery('.main-slider-owl').owlCarousel({
        margin: 20,
        responsiveClass: true,
        nav: true,
        dots: false,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            }
        }
    });
</script>



<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d2b183f07f9ac0012ebd8e9&product=inline-share-buttons' async='async'></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3&appId=847648628594113&autoLogAppEvents=1"></script>

<!-- END body -->
</body>
<!-- END html -->
</html>