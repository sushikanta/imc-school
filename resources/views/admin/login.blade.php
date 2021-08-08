<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Bootstrap Admin App + jQuery">
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
    <title>Realtyninfra - Admin</title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="{{ url('theme-angle/vendor/font-awesome/css/font-awesome.css') }}">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="{{ url('theme-angle/vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="{{ url('theme-angle/css/bootstrap.css') }}" id="bscss">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="{{ url('theme-angle/css/app.css') }}" id="maincss">
    <link id="autoloaded-stylesheet" rel="stylesheet" href="{{ url('theme-angle/css/theme-sk.css')}}">
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/images/new/favicon.png">
</head>

<body>
<div class="wrapper">
    <div class="block-center wd-xl" style="margin-top: 8rem">
        <!-- START card-->
        <div class="card card-flat login-card">
            <div class="card-header text-center bg-dark">
                <a href="javascript:void(0)">
                    <img height="30px" class="block-center rounded" src="{{asset('frontend') }}/images/new/logo_3_white.png" alt="Image">
                </a>
            </div>
            <div class="card-body">
                <p class="text-center py-2">SIGN IN TO CONTINUE.</p>
                <form class="mb-3" id="loginForm" novalidate  method="POST" action="{{ route('admin.login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="exampleInputEmail1" type="email" placeholder="Enter email" autocomplete="off" name="email"
                                   value="{{ old('email') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text fa fa-envelope text-muted bg-transparent border-left-0"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="exampleInputPassword1" type="password" name="password" placeholder="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text fa fa-lock text-muted bg-transparent border-left-0"></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="checkbox c-checkbox float-left mt-0">
                            <label>
                                <input type="checkbox" value="" name="remember">
                                <span class="fa fa-check"></span>Remember Me</label>
                        </div>
                        {{--<div class="float-right"><a class="text-muted" href="recover.html">Forgot your password?</a>
                        </div>--}}
                    </div>
                    <button class="btn btn-block mb-1 btn btn-warning" type="submit">Login</button>
                </form>
            </div>
        </div>
        <!-- END card-->
        <div class="p-3 text-center" style="color: white">
            <span class="mr-2">&copy;</span><span>{{ date('Y') }}</span><span class="mr-2"> -</span><span>RealtynInfra.com</span>
            <br>
        </div>
    </div>
</div>
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="{{ url('theme-angle/vendor/modernizr/modernizr.custom.js') }}"></script>
<!-- JQUERY-->
<script src="{{ url('theme-angle/vendor/jquery/dist/jquery.js') }}"></script>
<!-- BOOTSTRAP-->
<script src="{{ url('theme-angle/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
<!-- STORAGE API-->
<script src="{{ url('theme-angle/vendor/js-storage/js.storage.js') }}"></script>
<!-- PARSLEY-->
<script src="{{ url('theme-angle/vendor/parsleyjs/dist/parsley.js')}}"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="{{ url('theme-angle/js/app.js') }}"></script>
</body>

</html>