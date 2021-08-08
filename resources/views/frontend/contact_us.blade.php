@extends('layouts.frontend')

@section('content')
    <!-- BEGIN .wrapper -->
    <!-- BEGIN .wrapper -->
    <div class="wrapper">

        <div class="content-wrapper">

            <!-- BEGIN .composs-main-content -->
            <div class="composs-main-content composs-main-content-s-1">
                <!-- BEGIN .composs-panel -->
                <div class="composs-panel">

                    <div class="composs-panel-title">
                        <strong>Contact us</strong>
                    </div>

                    <div class="composs-panel-inner">
                        <div class="comment-form">
                            <div id="respond" class="comment-respond">

                                <form method="post" action="{{route('contactus_queries.contactus_query.query')}}" class="comment-form">
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
                                    <!-- <div class="alert-message ot-shortcode-alert-message alert-red">
                                        <strong>Error! This an error message</strong>
                                    </div>
                                    <div class="alert-message ot-shortcode-alert-message">
                                        <strong>Warning! This a warning message</strong>
                                    </div> -->
                                    <div class="contact-form-content">
                                        <p class="contact-form-user">
                                            <label class="label-input">
                                                <span>Name<i class="required">*</i></span>
                                                <input type="text" placeholder="Name" name="name" value="">
                                            </label>
                                        </p>
                                        <p class="contact-form-email">
                                            <label class="label-input">
                                                <span>E-mail<i class="required">*</i></span>
                                                <input type="email" placeholder="E-mail" name="email" value="">
                                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                            </label>
                                        </p>

                                        <p class="contact-form-phone">
                                            <label class="label-input">
                                                <span>Phone<i class="required">*</i></span>
                                                <input type="text" placeholder="Phone" name="phone" value="">
                                            </label>
                                        </p>

                                        <p class="contact-form-email">
                                            <label class="label-input">
                                                <span>Subject<i class="required">*</i></span>
                                                <input type="text" placeholder="Subject" name="subject" value="">
                                            </label>
                                        </p>

                                        <p class="contact-form-comment">
                                            <label class="label-input">
                                                <span>Message<i class="required">*</i></span>
                                                <textarea name="details" placeholder="Message"></textarea>
                                            </label>
                                        </p>
                                        <p class="form-submit">
                                            <input name="submit" type="submit" id="submit" class="submit button" value="Send this message">
                                        </p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- END .composs-panel -->
                </div>

                <!-- END .composs-main-content -->
            </div>

            <!-- BEGIN #sidebar -->
            <aside id="sidebar">

                <!-- BEGIN .widget -->
                <div class="widget">
                    <h3>Socialize</h3>
                    <div class="widget-content ot-w-socialize">
                        <a target="_blank" href="https://www.facebook.com/Realtyninfracom-470857990125976/" class="ot-color-hover-facebook"><i class="fa fa-facebook"></i><span> Facebook</span></a>
                        <a target="_blank" href="https://twitter.com/realtyninfra" class="ot-color-hover-twitter"><i class="fa fa-twitter"></i><span> Twitter</span></a>
                        {{--<a href="#" class="ot-color-hover-google-plus"><i class="fa fa-google-plus"></i><span> Google+</span></a>--}}

                    </div>
                    <!-- END .widget -->
                </div>

                <!-- BEGIN .widget -->
                <div class="widget">
                    <h3>Contact Details</h3>
                    <div class="widget-content ot-w-article-list">

                        <div class="item">
                            <div> <img src="{{asset('frontend/images/new/tel.png')}}"></div>
                            <div><a href="mailto:editor@realtininfra.com"><i class="material-icons">email</i> editor@realtininfra.com</a></div>
                        </div>
                        <div class="item">

                        </div>

                    </div>
                    <!-- END .widget -->
                </div>

                <!-- END #sidebar -->
            </aside>

        </div>

        <!-- END .wrapper -->
    </div>

@endsection