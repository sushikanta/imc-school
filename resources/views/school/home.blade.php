@extends('site-pharma.default_layout')
@section('content')
<!-- Section: home -->
<section id="home">
    <div class="container-fluid p-0">

        <!-- Slider Revolution Start -->
        <div class="rev_slider_wrapper">
            <div class="rev_slider" data-version="5.0">
                <ul>

                    <!-- SLIDE 1 -->
                    <li data-index="rs-3" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default"
                        data-thumb="{{ asset('theme-pharma') }}/images/001/bg1.jpg" data-rotate="0" data-saveperformance="off" data-title="Slide 3" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('theme-pharma') }}/images/001/bg1.jpg"  alt=""  data-bgposition="center 20%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme text-uppercase text-white font-raleway bg-theme-colored-transparent pr-20 pl-20"
                             id="rs-3-layer-1"

                             data-x="['center']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['-95']"
                             data-fontsize="['64']"
                             data-lineheight="['72']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:600;">BEST PRODUCTS
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme text-uppercase text-white font-raleway bg-theme-colored-transparent pr-10 pl-10"
                             id="rs-3-layer-2"

                             data-x="['center']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['-25']"
                             data-fontsize="['32']"
                             data-lineheight="['54']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:600;">Your Health Care Needs at Best Prices
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme text-white text-center"
                             id="rs-3-layer-3"

                             data-x="['center']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['30']"
                             data-fontsize="['14','16',20']"
                             data-lineheight="['25']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:0px; font-weight:400;">Every day we bring hope to the world's<br> hardest places as a sign of God's unconditional love.
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme"
                             id="rs-3-layer-4"

                             data-x="['center']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['95']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;"
                             data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:1px;"><a class="btn btn-colored btn-lg btn-flat btn-theme-colored pl-20 pr-20" href="#">Contact Us</a>
                        </div>
                    </li>

                    <!-- SLIDE 2 -->
                    <li data-index="rs-2" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default"
                        data-easeout="default" data-masterspeed="default"
                        data-thumb="{{ asset('theme-pharma') }}/images/001/bg2.jpg" data-rotate="0" data-saveperformance="off" data-title="Slide 2" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('theme-pharma') }}/images/001/bg2.jpg"  alt=""  data-bgposition="center 30%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme text-uppercase text-white font-raleway"
                             id="rs-2-layer-1"

                             data-x="['left']"
                             data-hoffset="['30']"
                             data-y="['middle']"
                             data-voffset="['-110']"
                             data-fontsize="['110']"
                             data-lineheight="['120']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:700;">Offshore Delivery
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme text-uppercase text-white font-raleway bg-theme-colored-transparent pl-20 pr-20"
                             id="rs-2-layer-2"

                             data-x="['left']"
                             data-hoffset="['35']"
                             data-y="['middle']"
                             data-voffset="['-25']"
                             data-fontsize="['35']"
                             data-lineheight="['54']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:600; border-radius: 30px;">Get prescribed medicines home delivered!
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme text-white"
                             id="rs-2-layer-3"

                             data-x="['left']"
                             data-hoffset="['35']"
                             data-y="['middle']"
                             data-voffset="['30']"
                             data-fontsize="['14','16',20']"
                             data-lineheight="['25']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:0px; font-weight:400;">Just enter your name, phone number, email address and upload your prescription below.
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme"
                             id="rs-2-layer-4"

                             data-x="['left']"
                             data-hoffset="['35']"
                             data-y="['middle']"
                             data-voffset="['95']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;"
                             data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:1px;"><a class="btn btn-colored btn-lg btn-theme-colored pl-20 pr-20" href="#">Contact Us</a>
                        </div>
                    </li>

                    <!-- SLIDE 3 -->
                    <li data-index="rs-1" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default"
                        data-easeout="default" data-masterspeed="default"
                        data-thumb="{{ asset('theme-pharma') }}/images/001/bg3.jpg" data-rotate="0" data-saveperformance="off" data-title="Slide 1" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="{{ asset('theme-pharma') }}/images/001/bg3.jpg"  alt=""  data-bgposition="center 20%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-resizeme text-uppercase  bg-dark-transparent text-white font-raleway pl-30 pr-30"
                             id="rs-1-layer-1"

                             data-x="['right']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['-90']"
                             data-fontsize="['28']"
                             data-lineheight="['54']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:400; border-radius: 30px;">Masala & Sweets
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption tp-resizeme text-uppercase bg-theme-colored-transparent text-white font-raleway pl-30 pr-30"
                             id="rs-1-layer-2"

                             data-x="['right']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['-20']"
                             data-fontsize="['48']"
                             data-lineheight="['70']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1000"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 7; white-space: nowrap; font-weight:700; border-radius: 30px;">Masala & Sweets Online
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption tp-resizeme text-white text-center"
                             id="rs-1-layer-3"

                             data-x="['right']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['50']"
                             data-fontsize="['14','16',20']"
                             data-lineheight="['25']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;s:500"
                             data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                             data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                             data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:0px; font-weight:400;">Every day we bring joy to millions in the world's<br>  hardest places as a sign of God's unconditional love.
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-resizeme"
                             id="rs-1-layer-4"

                             data-x="['right']"
                             data-hoffset="['0']"
                             data-y="['middle']"
                             data-voffset="['115']"
                             data-width="none"
                             data-height="none"
                             data-whitespace="nowrap"
                             data-transform_idle="o:1;"
                             data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                             data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                             data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;"
                             data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                             data-start="1400"
                             data-splitin="none"
                             data-splitout="none"
                             data-responsive_offset="on"
                             style="z-index: 5; white-space: nowrap; letter-spacing:1px;"><a class="btn btn-default btn-circled  btn-theme-colored pl-20 pr-20" href="#">Contact Us</a>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- end .rev_slider -->
        </div>
        <!-- end .rev_slider_wrapper -->
        <script>
            $(document).ready(function(e) {
                $(".rev_slider").revolution({
                    sliderType:"standard",
                    sliderLayout: "auto",
                    dottedOverlay: "none",
                    delay: 5000,
                    navigation: {
                        keyboardNavigation: "off",
                        keyboard_direction: "horizontal",
                        mouseScrollNavigation: "off",
                        onHoverStop: "off",
                        touch: {
                            touchenabled: "on",
                            swipe_threshold: 75,
                            swipe_min_touches: 1,
                            swipe_direction: "horizontal",
                            drag_block_vertical: false
                        },
                        arrows: {
                            style:"gyges",
                            enable:true,
                            hide_onmobile:true,
                            hide_under:600,
                            hide_onleave:true,
                            hide_delay:200,
                            hide_delay_mobile:1200,
                            tmp:'<div class="tp-title-wrap">    <div class="tp-arr-imgholder"></div> </div>',
                            left: {
                                h_align:"left",
                                v_align:"center",
                                h_offset:30,
                                v_offset:0
                            },
                            right: {
                                h_align:"right",
                                v_align:"center",
                                h_offset:30,
                                v_offset:0
                            }
                        },
                        bullets: {
                            enable:true,
                            hide_onmobile:true,
                            hide_under:600,
                            style:"metis",
                            hide_onleave:true,
                            hide_delay:200,
                            hide_delay_mobile:1200,
                            direction:"horizontal",
                            h_align:"center",
                            v_align:"bottom",
                            h_offset:0,
                            v_offset:30,
                            space:5,
                            tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span><span class="tp-bullet-title">{title}</span>'
                        }
                    },
                    responsiveLevels: [1240, 1024, 778],
                    visibilityLevels: [1240, 1024, 778],
                    gridwidth: [1170, 1024, 778, 480],
                    gridheight: [600, 768, 960, 720],
                    lazyType: "none",
                    parallax: {
                        origo: "slidercenter",
                        speed: 1000,
                        levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 100, 55],
                        type: "scroll"
                    },
                    shadow: 0,
                    spinner: "off",
                    stopLoop: "on",
                    stopAfterLoops: 0,
                    stopAtSlide: -1,
                    shuffle: "off",
                    autoHeight: "off",
                    fullScreenAutoWidth: "off",
                    fullScreenAlignForce: "off",
                    fullScreenOffsetContainer: "",
                    fullScreenOffset: "0",
                    hideThumbsOnMobile: "off",
                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0,
                    debugMode: false,
                    fallbacks: {
                        simplifyAll: "off",
                        nextSlideOnWindowFocus: "off",
                        disableFocusListener: false,
                    }
                });
            });
        </script>
        <!-- Slider Revolution Ends -->

    </div>
</section>

<section>
    <div class="container-fluid p-0 p-sm-15">
        <div class="section-content">
            <div class="row equal-height-inner home-boxes">
                <div class="col-sm-12 col-md-3 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay1">
                    <div class="sm-height-auto bg-theme-colored">
                        <div class="p-30">
                            <div class="footer-box icon-box media mb-10"> <a href="#" class="media-left pull-left mr-10 mr-sm-15">
                                    <i class="flaticon-medical-medical109 text-white"></i></a>
                                <div class="media-body">
                                    <h4 class="text-uppercase text-white mt-0">Assistant in purchase of Medicines</h4>
                                    <a href="#" class="btn btn-border btn-circled btn-transparent btn-xs mt-5 ajaxload-popup">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay2">
                    <div class="sm-height-auto bg-theme-colored-darker2">
                        <div class="p-30">
                            <div class="footer-box icon-box media mb-10"> <a href="#" class="media-left pull-left mr-10 mr-sm-15">
                                    <i class="fa fa-shopping-cart text-white" style="font-size:48px"></i></a>
                                <div class="media-body">
                                    <h4 class="text-uppercase text-white mt-0">Assistant in purchase of Grocery Items</h4>
                                    <a href="#" class="btn btn-border btn-circled btn-transparent btn-xs mt-5">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 pl-0 pr-0 pl-sm-15 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3">
                    <div class="sm-height-auto bg-theme-colored-darker3">
                        <div class="p-30">
                            <div class="footer-box icon-box media mb-10"> <a href="#" class="media-left pull-left mr-10 mr-sm-15">
                                    <i class="sk-icon masala text-white"></i></a>
                                <div class="media-body">
                                    <h4 class="text-uppercase text-white mt-0">Assistant in purchase of Masala</h4>
                                    <a href="#" class="btn btn-border btn-circled btn-transparent btn-xs mt-5">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay4">
                    <div class="sm-height-auto bg-theme-colored-darker4">
                        <div class="p-30">
                            <div class="footer-box icon-box media mb-10"> <a href="#" class="media-left pull-left mr-10 mr-sm-15">
                                    <i class="sk-icon sweets text-white"></i></a>
                                <div class="media-body">
                                    <h4 class="text-uppercase text-white mt-0">Assistant in purchase of Sweets</h4>
                                    <a href="p#" class="btn btn-border btn-circled btn-transparent btn-xs mt-5">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="divider parallax layer-overlay overlay-dark-5" data-bg-img="{{ asset('theme-pharma') }}/images/bg/bg13.jpg">
    <div class="container pt-0 pb-0">
        <div class="section-content">
            <div class="row">
                <div class="col-md-7 sm-height-auto">
                    <div class="p-50 p-sm-30 pb-30 pt-sm-60 bg-deep-transparent">
                        <h4 class="title mt-0 line-bottom line-height-2 text-black-222 mb-30">Why People<span class="text-theme-colored"> Choose Us</span></h4>
                        <div class="items mb-30">
                            <div class="icon-box p-0">
                                <a href="#" class="icon mb-0 mr-0 pull-left">
                                    <i class="flaticon-medical-telephonecall3 text-theme-colored font-50"></i>
                                </a>
                                <div class="ml-80">
                                    <h5 class="icon-box-title">Excellent Services</h5>
                                    <p class="text-black-333">
                                        Customer service is the experience we deliver to our customer. It's the promise we keep to the customer. It's how we follow through for the customer.
                                        <a class="font-13" href="page-fundraise.html">Read more...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="items mb-30">
                            <div class="icon-box p-0">
                                <a href="#" class="icon mb-0 mr-0 pull-left">
                                    <i class="flaticon-medical-hospitals2 text-theme-colored font-50"></i>
                                </a>
                                <div class="ml-80">
                                    <h5 class="icon-box-title">Guaranteed Work</h5>
                                    <p class="text-black-333">We take care of our customers even after the sale through our customer service and policies. <a class="font-13" href="page-campaign.html">Read more...</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="items mb-30">
                            <div class="icon-box p-0">
                                <a href="#" class="icon mb-0 mr-0 pull-left">
                                    <span class="fa fa-paper-plane" style="color: #00a4ef;font-size: 57px;"></span>
                                </a>
                                <div class="ml-80">
                                    <h5 class="icon-box-title">Available Offshore Delivery</h5>
                                    <p class="text-black-333">We provide fully managed offshore delivery understanding the needs for Non-resident Indian.<a class="font-13" href="page-our-impact.html">Read more...</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Why Choose Us  -->
<section id="services">
    <div class="container pb-30">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-0 line-height-1">Services</h2>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row mtli-row-clearfix">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-medkit text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5">Medicines </h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-apple text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5">Grocery Items</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-life-saver text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5">Masala</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-yelp text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5">Sweets</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-gift text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5">Festival Gifts</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="icon-box p-20 mb-30 border-1px">
                        <div class="media-left">
                            <a class="icon icon-color flip mb-0 mr-0 mt-5" href="#">
                                <i class="fa fa-male text-theme-colored"></i>
                            </a>
                        </div>
                        <div class="icon-box-details media-body">
                            <h5 class="icon-box-title m-0 mb-5"> Traditional Wears</h5>
                            <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias non null</p>
                            <a href="#">read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Section: Call To Action -->
<section class="bg-theme-colored border-left border-3px">
    <div class="container pt-20 pb-20">
        <div class="call-to-action">
            <div class="row">
                <div class="col-sm-8 sm-text-center">
                    <h4 class="text-uppercase text-white">Best Medical service in the town!</h4>
                    <p class="text-white">Alienum phaedrum torquatos nec eu, vis detraxit periculis ex.</p>
                </div>
                <div class="col-sm-4 text-right flip sm-text-center">
                    <a href="page-contact1.html" class="btn btn-default mt-30 mt-sm-20">Contact With Us</a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Divider: testimonials -->

<section class="divider parallax layer-overlay overlay-white-6" data-bg-img="{{ asset('theme-pharma') }}/images/001/testimonial-bg.jpg" data-parallax-ratio="0.7">
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-0 line-height-1">Testimonials</h2>
                </div>
            </div>
        </div>

        <div class="section-content">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="testimonial">
                        <div class="owl-carousel-1col" data-dots="true">
                            <div class="item text-center">
                                <a class="mt-20 display-block" href="#">
                                    <img alt="" src="{{ asset('theme-pharma') }}/images/001/testi-2.jpg" class="p-5 border-2px">
                                </a>
                                <h4 class="service-box-title font-weight-800 text-black-222">Sushikanta Singh</h4>
                                <span class="font-14 font-weight-600 text-theme-colored">SE Analyst</span>
                                <p class="mb-0 font-droid font-22 text-black-444 mt-20">This is a great website for Indians living abroad and missing Indian products including medicines. Great job and I hope this website get notice quickly.</p>
                                <i class="fa fa-quote-left text-gray-lightgray font-42 mt-20"></i>
                            </div>
                            <div class="item text-center">
                                <a class="mt-20 display-block" href="#">
                                    <img alt="" src="{{ asset('theme-pharma') }}/images/001/testi-1.jpg" class="p-5 border-2px">
                                </a>
                                <h4 class="service-box-title font-weight-800 text-black-222">Sunny Kanchan</h4>
                                <span class="font-14 font-weight-600 text-theme-colored">web Desinger (ceo)</span>
                                <p class="mb-0 font-droid font-22 text-black-444 mt-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel esse quibusdam nihil a necessitatibus natus, voluptas fugiat officiis ipsa earum unde sit consequatur. Maxime harum ab pariatur obcaecati ut eos voluptatum.</p>
                                <i class="fa fa-quote-left text-gray-lightgray font-42 mt-20"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: blog -->
<section id="blog">
    <div class="container pb-sm-30">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                    <h2 class="mt-0 line-height-1 text-center text-uppercase">Latest <span class="text-theme-colored">News</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem temporibus quisquam voluptas natus, provident porro et odio perferendis ipsam, amet sint</p>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                    <article class="post clearfix mb-sm-30 bg-lighter">
                        <div class="entry-header">
                            <div class="post-thumb thumb">
                                <img src="{{ asset('theme-pharma') }}/images/blog/1.jpg" alt="" class="img-responsive img-fullwidth">
                            </div>
                        </div>
                        <div class="entry-content p-20 pr-10">
                            <div class="entry-meta media mt-0 no-bg no-border">
                                <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                    <ul>
                                        <li class="border-bottom">28</li>
                                        <li class="font-12 text-uppercase">Feb</li>
                                    </ul>
                                </div>
                                <div class="media-body pl-15">
                                    <div class="event-content pull-left flip">
                                        <h5 class="entry-title text-white text-uppercase m-0 mt-5"><a href="#">Post title here</a></h5>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> 214 Comments</span>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> 895 Likes</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-10">Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Molestias eius illum libero dolor nobis deleniti, sint assumenda. Pariatur iste veritatis excepturi, ipsa optio nobis.</p>
                            <a href="#" class="btn-read-more">Read more</a>
                            <div class="clearfix"></div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.4s">
                    <article class="post clearfix mb-sm-30 bg-lighter">
                        <div class="entry-header">
                            <div class="post-thumb thumb">
                                <img src="{{ asset('theme-pharma') }}/images/blog/2.jpg" alt="" class="img-responsive img-fullwidth">
                            </div>
                        </div>
                        <div class="entry-content p-20 pr-10">
                            <div class="entry-meta media mt-0 no-bg no-border">
                                <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                    <ul>
                                        <li class="border-bottom">28</li>
                                        <li class="font-12 text-uppercase">Feb</li>
                                    </ul>
                                </div>
                                <div class="media-body pl-15">
                                    <div class="event-content pull-left flip">
                                        <h5 class="entry-title text-white text-uppercase m-0 mt-5"><a href="#">Post title here</a></h5>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> 214 Comments</span>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> 895 Likes</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-10">Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Molestias eius illum libero dolor nobis deleniti, sint assumenda. Pariatur iste veritatis excepturi, ipsa optio nobis.</p>
                            <a href="#" class="btn-read-more">Read more</a>
                            <div class="clearfix"></div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s">
                    <article class="post clearfix mb-sm-30 bg-lighter">
                        <div class="entry-header">
                            <div class="post-thumb thumb">
                                <img src="{{ asset('theme-pharma') }}/images/blog/3.jpg" alt="" class="img-responsive img-fullwidth">
                            </div>
                        </div>
                        <div class="entry-content p-20 pr-10">
                            <div class="entry-meta media mt-0 no-bg no-border">
                                <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                    <ul>
                                        <li class="border-bottom">28</li>
                                        <li class="font-12 text-uppercase">Feb</li>
                                    </ul>
                                </div>
                                <div class="media-body pl-15">
                                    <div class="event-content pull-left flip">
                                        <h5 class="entry-title text-white text-uppercase m-0 mt-5"><a href="#">Post title here</a></h5>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-commenting-o mr-5 text-theme-colored"></i> 214 Comments</span>
                                        <span class="mb-10 text-gray-darkgray mr-10 font-13"><i class="fa fa-heart-o mr-5 text-theme-colored"></i> 895 Likes</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-10">Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Molestias eius illum libero dolor nobis deleniti, sint assumenda. Pariatur iste veritatis excepturi, ipsa optio nobis.</p>
                            <a href="#" class="btn-read-more">Read more</a>
                            <div class="clearfix"></div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Divider: Call To Action -->
<section class="bg-theme-colored">
    <div class="container pt-0 pb-0">
        <div class="row">
            <div class="call-to-action pt-30 pb-20">
                <div class="col-sm-4 col-md-4">
                    <div class="widget border-right mb-15"> <i class="fa fa-map text-white pull-left flip font-32 mr-30 mt-5"></i>
                        <h5 class="text-white mb-5 font-weight-600"> M88, Shastri Nagar, New Delhi</h5>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="widget mb-15"> <i class="fa fa-envelope-o text-white pull-left flip font-36 mr-30"></i>
                        <h5 class="text-white mb-5 pt-5 font-weight-600"> contact@nridelivery.com</h5>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="widget mb-15">
                        <!-- Mailchimp Subscription Form Starts Here -->
                        <form id="mailchimp-subscription-form" class="newsletter-form mt-15">
                            <div class="input-group">
                                <input type="email" value="" name="EMAIL" placeholder="Your Email" class="form-control input-lg font-16" data-height="45px" id="mce-EMAIL1">
                                <span class="input-group-btn">
                      <button data-height="45px" class="btn btn-default btn-gray btn-xs font-14 m-0" type="submit">Subscribe</button>
                    </span>
                            </div>
                        </form>
                        <!-- Mailchimp Subscription Form Validation-->
                        <script type="text/javascript">
                            $('#mailchimp-subscription-form').ajaxChimp({
                                callback: mailChimpCallBack,
                                url: '//thememascot.us9.list-manage.com/subscribe/post?u=a01f440178e35febc8cf4e51f&amp;id=49d6d30e1e'
                            });

                            function mailChimpCallBack(resp) {
                                // Hide any previous response text
                                var $mailchimpform = $('#mailchimp-subscription-form'),
                                    $response = '';
                                $mailchimpform.children(".alert").remove();
                                if (resp.result === 'success') {
                                    $response = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + resp.msg + '</div>';
                                } else if (resp.result === 'error') {
                                    $response = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + resp.msg + '</div>';
                                }
                                $mailchimpform.prepend($response);
                            }
                        </script>
                        <!-- Mailchimp Subscription Form Ends Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection