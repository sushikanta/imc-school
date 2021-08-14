@extends('school.layouts.default')
@section('content')



    <!-- About Start -->
    <div class="about-wrap " id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="aboutImg"><img src="{{asset('theme-school')}}/images/001/aboutImg.png" alt=""></div>
                </div>
                <div class="col-lg-5">
                    <div class="about_box">
                        <div class="title">
                            <h1>Best Learing <span>Program</span></h1>
                        </div>
                        <p>Our modules cover all the aspects of being well-groomed and confident from inside out. we focus on everything to set them up on road to success.</p>
                        <ul class="edu_list">
                            <li>
                                <div class="learing-wrp">
                                    <div class="edu_icon"><img src="{{asset('theme-school')}}/images/education.png"></div>
                                    <div class="learn_info" style="width: 460px;">
                                        <h3>Special Education</h3>
                                        <p>Providing vision, mission, values and practice curriculum in the best way.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="learing-wrp">
                                    <div class="edu_icon"><img src="{{asset('theme-school')}}/images/class.png"></div>
                                    <div class="learn_info" style="width: 460px;">
                                        <h3>Quality Education</h3>
                                        <p>Quality teachers are the real key to a quality education.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="learing-wrp">
                                    <div class="edu_icon"><img src="{{asset('theme-school')}}/images/academy.png"></div>
                                    <div class="learn_info" style="width: 460px;">
                                        <h3>Best Program</h3>
                                        <p>Our modules cover all the aspects of being well-groomed and confident.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


@endsection

@section('scripts')

@endsection