@extends('school.layouts.default')
@section('content')


    <div class="innerHeading-wrap">
        <div class="container">
            <h1>Contact Us</h1>
        </div>
    </div>
    <!-- Inner Heading End -->

    <!-- Inner Content Start -->
    <div class="innerContent-wrap">
        <div class="container">
            <div class="cont_info ">
                <div class="row">
                    <div class="col-lg-3 col-md-6 md-mb-30">
                        <div class="address-item style">
                            <div class="address-icon"> <i class="fas fa-phone-alt"></i> </div>
                            <div class="address-text">
                                <h3 class="contact-title">Call Us</h3>
                                <ul class="unorderList">
                                    <li><a href="tel:9362113179">+91 - 9362 113 179</a></li>
                                    <li>_</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 md-mb-30">
                        <div class="address-item style">
                            <div class="address-icon"> <i class="far fa-envelope"></i> </div>
                            <div class="address-text">
                                <h3 class="contact-title">Mail Us</h3>
                                <ul class="unorderList">
                                    <li><a href="mailto:info@integratedmanipuracademy.com" style="    word-break: break-word;">
                                            info@integratedmanipuracademy.com
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 sm-mb-30">
                        <div class="address-item">
                            <div class="address-icon"> <i class="far fa-clock"></i> </div>
                            <div class="address-text">
                                <h3 class="contact-title">Opening Hours</h3>
                                <ul class="unorderList">
                                    <li>Mon - Sat : 9am to 6pm</li>
                                    <li>Sun : Closed</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="address-item">
                            <div class="address-icon"> <i class="fas fa-map-marker-alt"></i> </div>
                            <div class="address-text">
                                <h3 class="contact-title">Address</h3>
                                <p>
                                    Malom, Airport Road, Imphal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">

                    <!-- Register Start -->
                    <div class="login-wrap">
                        <div class="contact-info login_box">
                            <div class="contact-form loginWrp registerWrp">
                                <form method="post" action="{{route('contactus_queries.contactus_query.query')}}" id="contact_form" name="contact_form" class="comment-form">
                                    {{ csrf_field() }}
                                    <?php
                                    if(session('success_message')){
                                    ?>
                                    <div class="alert-message ot-shortcode-alert-message alert-green">
                                        <strong>{!! session('success_message') !!}</strong>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    @if ($errors->any())
                                        <ul class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <div>
                                                    <strong>{{ $error }}</strong>
                                                </div>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <h3>Get In Touch</h3>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input type="text" required name="name" class="form-control" placeholder="Enter Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="email" required name="email" class="form-control" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" required name="phone" class="form-control" placeholder="Phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <input name="subject" required class="form-control required" type="text" placeholder="Enter Subject">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <textarea name="details" required class="form-control" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button type="submit" class="default-btn btn send_btn"> Submit <span></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Register End -->
                </div>
                <div class="col-lg-5">
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3623.2711715024584!2d93.8781410143177!3d24.75188995569773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x37492f3149cb5957%3A0x64ba1493ec14d4a5!2sIntegrated%20Manipur%20Academy!5e0!3m2!1sen!2sin!4v1628957163722!5m2!1sen!2sin" width="100%" height="511" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Inner Content Start -->


@endsection

@section('scripts')

@endsection