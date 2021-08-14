@extends('school.layouts.default')
@section('content')
    <!-- Revolution slider start -->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <li data-slotamount="7" data-transition="3dcurtain-horizontal" data-masterspeed="1000" data-saveperformance="on"> <img alt="" src="{{ asset('theme-school') }}/images/dummy.png" data-lazyload="{{ asset('theme-school') }}/images/001/slider1.jpg">
                    <div class="caption lft large-title tp-resizeme slidertext2" data-x="center" data-y="100" data-speed="600" data-start="1600">
                        <span> Class XI Admission, 2021 </span></div>
                    <div class="caption lfb large-title tp-resizeme slidertext3" data-x="center" data-y="200" data-speed="600" data-start="2200">
                        Application open for Admission to Class XI - SCIENCE/ARTS for the academic session 2021-2022.
                    </div>
                    <div class="caption lfb large-title tp-resizeme slidertext4" data-x="330" data-y="300" data-speed="600" data-start="2800"> <a href="{{route('register')}}"><i class="fas fa-edit"></i> Register Today</a> </div>
                    <div class="caption lfb large-title tp-resizeme slidertext4 slidertext5" data-x="610" data-y="300" data-speed="600" data-start="3400"> <a href="{{route('contact')}}"><i class="far fa-calendar-alt"></i> Submit a query</a> </div>
                </li>

                <li data-slotamount="7" data-transition="slotzoom-horizontal" data-masterspeed="1000" data-saveperformance="on"> <img alt="" src="{{ asset('theme-school') }}/images/dummy.png" data-lazyload="{{ asset('theme-school') }}/images/slider.jpg">
                    <div class="caption lft large-title tp-resizeme slidertext2" data-x="center" data-y="70" data-speed="600" data-start="1600"><span>Integrated Manipur Academy</span></div>
                    <div class="caption lfb large-title tp-resizeme slidertext3" data-x="center" data-y="170" data-speed="600" data-start="2200">
                        We are more than just a school, We provide our students with a safe learning environment <br/>
                        that helps them grow as unique personalities. We know that each child is different and <br/>
                        hence a one size fits all teaching method would never do. <br/>
                        We employ several innovative teaching techniques that impart knowledge and <br/>
                        instill strong values into the child to become responsible future citizens of the world.
                    </div>
                    <div class="caption lfb large-title tp-resizeme slidertext4" data-x="330" data-y="350" data-speed="600" data-start="2800"> <a href="{{route('register')}}"><i class="fas fa-edit"></i> Enroll Today</a> </div>
                    <div class="caption lfb large-title tp-resizeme slidertext4 slidertext5" data-x="610" data-y="350" data-speed="600" data-start="3400"> <a href="{{route('contact')}}"><i class="far fa-calendar-alt"></i> Contact Us</a> </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Revolution slider end -->

    <!-- School Start -->
    <div class="our-course-categories-two ">
        <div class="container">
            <div class="categories_wrap">
                <ul class="row unorderList">
                    <li class="col-lg-3 col-md-6">
                        <!-- single-course-categories -->
                        <div class="categories-course">
                            <div class="item-inner">
                                <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{ asset('theme-school') }}/images/teacher.png" alt=""> </span> </div>
                                <div class="cours-title">
                                    <h4>Expert teachers</h4>
                                    <p>We provide teachers who understand the school vision, mission, values and practice curriculum in the best way, and present knowledge of content. </p>
                                </div>
                            </div>
                        </div>
                        <!--// single-course-categories -->
                    </li>
                    <li class="col-lg-3 col-md-6">
                        <!-- single-course-categories -->
                        <div class="categories-course">
                            <div class="item-inner">
                                <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{ asset('theme-school') }}/images/book.png" alt=""> </span> </div>
                                <div class="cours-title">
                                    <h4>Quality Education</h4>
                                    <p>it’s accepted that a quality education is key to a healthy and successful life and quality teachers are the real key to a quality education. </p>
                                </div>
                            </div>
                        </div>
                        <!--// single-course-categories -->
                    </li>
                    <li class="col-lg-3 col-md-6">
                        <!-- single-course-categories -->
                        <div class="categories-course" >
                            <div class="item-inner">
                                <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{ asset('theme-school') }}/images/support.png" alt=""> </span> </div>
                                <div class="cours-title">
                                    <h4>Life Skills</h4>
                                    <p>We work with our students on essential life skills to ensure that they are ready for the challenges of personal and professional life ahead. </p>
                                </div>
                            </div>
                        </div>
                        <!--// single-course-categories -->
                    </li>
                    <li class="col-lg-3 col-md-6">
                        <!-- single-course-categories -->
                        <div class="categories-course">
                            <div class="item-inner">
                                <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{ asset('theme-school') }}/images/scholarship.png" alt=""> </span> </div>
                                <div class="cours-title">
                                    <h4>Best Program</h4>
                                    <p>Our modules cover all the aspects of being well-groomed and confident from inside out. we focus on everything to set them up on road to success.</p>
                                </div>
                            </div>
                        </div>
                        <!--// single-course-categories -->
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- School End -->



    <!-- Choice Start -->
    <div class="choice-wrap ">
        <div class="container">
            <div class="title">
                <h1>We Are The Best <span>Choice For Your Child</span></h1>
            </div>
            <p>
                “Teaching children the behavior expected of them is a daily process.” Good manners and etiquette are key to a child’s social success. Our continuous etiquette training program ensures making the day to day etiquette a part of our girls’ personality. From teaching them basic courtesies to dining etiquette, from social networking etiquette to how etiquette varies in different parts of the world ‘we focus on everything to ensure bringing in the social confidence that will set them up on road to success.
            </p>
            <div class="readmore"><a href="{{route("contact")}}">Contact Us</a></div>
        </div>
    </div>
    <!-- Choice End -->




    <!-- Enroll Start -->
    <div class="choice-wrap enroll-wrap">
        <div class="container">
            <div class="title">
                <h1>Call To Enroll Today</h1>
            </div>
            <p>
                You want the best for your children, and at First Class Child Development, <br>that’s exactly what we’re here to provide. Enroll today, or learn more about the process.
            </p>
            <div class="phonewrp"><img src="{{ asset('theme-school') }}/images/phone_icon.png" alt=""><a href="#">(+91) - 9362 113 179</a></div>
        </div>
    </div>
    <!-- Enroll End -->

    <!-- Teacher Start -->
    {{--
    <section class="teachers-area-three teacher-wrap pt-100 pb-70  ">
        <div class="container">
            <div class="title center_title">
                <h1>Our Teachers</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-teachers">
                        <div class="teacherImg"> <img src="{{ asset('theme-school') }}/images/teachers01.jpg" alt="Image">
                            <ul class="social-icons list-inline">
                                <!-- social-icons -->
                                <li class="social-facebook"> <a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a> </li>
                                <li class="social-twitter"> <a href=""><i class="fab fa-twitter" aria-hidden="true"></i></a> </li>
                                <li class="social-linkedin"> <a href="#"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a> </li>
                                <li class="social-googleplus"> <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a> </li>
                            </ul>
                        </div>
                        <div class="teachers-content">
                            <h3>Stella Roffin</h3>
                            <div class="designation">Art teacher</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-teachers">
                        <div class="teacherImg"> <img src="{{ asset('theme-school') }}/images/teachers02.jpg" alt="Image">
                            <ul class="social-icons list-inline">
                                <!-- social-icons -->
                                <li class="social-facebook"> <a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a> </li>
                                <li class="social-twitter"> <a href=""><i class="fab fa-twitter" aria-hidden="true"></i></a> </li>
                                <li class="social-linkedin"> <a href="#"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a> </li>
                                <li class="social-googleplus"> <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a> </li>
                            </ul>
                        </div>
                        <div class="teachers-content">
                            <h3>Chris Miller</h3>
                            <div class="designation">Mathematic</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-teachers">
                        <div class="teacherImg"> <img src="{{ asset('theme-school') }}/images/teachers03.jpg" alt="Image">
                            <ul class="social-icons list-inline">
                                <!-- social-icons -->
                                <li class="social-facebook"> <a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a> </li>
                                <li class="social-twitter"> <a href=""><i class="fab fa-twitter" aria-hidden="true"></i></a> </li>
                                <li class="social-linkedin"> <a href="#"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a> </li>
                                <li class="social-googleplus"> <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a> </li>
                            </ul>
                        </div>
                        <div class="teachers-content">
                            <h3>Jesica Matt</h3>
                            <div class="designation">English Teacher</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-teachers">
                        <div class="teacherImg"> <img src="{{ asset('theme-school') }}/images/teachers04.jpg" alt="Image">
                            <ul class="social-icons list-inline">
                                <!-- social-icons -->
                                <li class="social-facebook"> <a href="#"><i class="fab fa-facebook-f" aria-hidden="true"></i></a> </li>
                                <li class="social-twitter"> <a href=""><i class="fab fa-twitter" aria-hidden="true"></i></a> </li>
                                <li class="social-linkedin"> <a href="#"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a> </li>
                                <li class="social-googleplus"> <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a> </li>
                            </ul>
                        </div>
                        <div class="teachers-content">
                            <h3>Lena Bodie</h3>
                            <div class="designation">Science Teacher</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}

    <!-- Teacher Start -->


    <!--Newsletter Start-->
    {{--<div class="newsletter-wrap ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title">
                        <h1>Newsletter</h1>
                    </div>
                    <p>Subscribe to our newsletters and get <br>updates delivered straight into your inbox</p>
                </div>
                <div class="col-lg-6">
                    <div class="news-info">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Email Address">
                                <div class="form_icon"><i class="fas fa-envelope"></i></div>
                            </div>
                            <button class="sigup">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <!--Newsletter End-->

@endsection