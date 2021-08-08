@extends('site-pharma.default_layout')
@section('content')

    <!-- Section: Have Any Question -->
    <section class="divider">
        <div class="container pt-60 pb-60">
            <div class="section-title mb-60">
                <div class="row">
                    <div class="col-md-12">
                        <div class="esc-heading small-border text-center">
                            <h3>Have any Questions?</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-content">
                <div class="row">
                    <div class="col-sm-12 col-md-4">




                        <div class="contact-info text-center">
                            <i class="fa fa-phone font-36 mb-10 text-theme-colored"></i>
                            <h4>Call Us</h4>
                            <h6 class="text-gray">Phone: +91 844 702 4313</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="contact-info text-center">
                            <i class="fa fa-map-marker font-36 mb-10 text-theme-colored"></i>
                            <h4>Address</h4>
                            <h6 class="text-gray">M88, Shastri Nagar, New Delhi.</h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="contact-info text-center">
                            <i class="fa fa-envelope font-36 mb-10 text-theme-colored"></i>
                            <h4>Email</h4>
                            <h6 class="text-gray">contact@nridelivery.com</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Divider: Contact -->
    <section class="divider bg-lighter">
        <div class="container">
            <div class="row pt-30">
                <div class="col-md-7 col-md-offset-3">
                    <h3 class="line-bottom mt-0 mb-30">Interested in discussing?</h3>

                    <!-- Contact Form -->

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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name <small>*</small></label>
                                    <input name="name" class="form-control" type="text" placeholder="Enter Name" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <small>*</small></label>
                                    <input name="email" class="form-control required email" type="email" placeholder="Enter Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Subject <small>*</small></label>
                                    <input name="subject" class="form-control required" type="text" placeholder="Enter Subject">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input name="phone" class="form-control" type="text" placeholder="Enter Phone">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="details" class="form-control required" rows="5" placeholder="Enter Message"></textarea>
                        </div>
                        <div class="form-group">

                            <button type="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Send your message</button>
                        </div>
                    </form>
                    <!-- Contact Form Validation-->


                </div>
                <div class="col-md-5">

                </div>
            </div>
        </div>
    </section>
@endsection