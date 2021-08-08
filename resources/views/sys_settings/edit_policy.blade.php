@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">
                    <?php
                        if($policy_type == 'terms_staff'){
                            echo 'Terms for Staff';
                        }else if($policy_type == 'terms_client'){
                            echo 'Terms for Client/Business';
                        }else if($policy_type == 'privacy'){
                            echo 'Privacy Policy';
                            }
                        ?>
                    </h4>
            </div>
        </div>

        <div class="panel-body">

            @if(Session::has('success_message'))
                <div class="alert alert-success col-md-10">
                    <span class="fa fa-check"></span>
                    {!! session('success_message') !!}

                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            @endif

            @if ($errors->any())
                <ul class="alert alert-danger col-md-10">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('sys_settings.policy.update')}}" id="edit_sys_setting_form" name="edit_sys_setting_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <input name="id" type="hidden" value="{{ @$sysSetting->id }}">
                <input name="policy_type" type="hidden" value="{{ @$policy_type }}">

                {{----}}





                <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
                    <div class="col-md-10">
                        <textarea  style="height: 400px"  class="form-control tinymce" name="value" cols="50" rows="10" id="value" minlength="1" placeholder="Enter terms here...">{{ old('value', optional($sysSetting)->value) }}</textarea>
                        {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

               {{----}}

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection





@section('styles')
    <!-- WYSIWYG-->
    <link rel="stylesheet" href="{{ asset('theme-angle')}}/vendor/bootstrap-wysiwyg/css/style.css">
@endsection
@section('javascript')
    <script src='{{ asset('theme-angle')}}/vendor/tinymce/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '.tinymce',
            menubar:false,
            theme: 'modern',
            plugins: 'code fullscreen image link media  hr pagebreak nonbreaking anchor  insertdatetime advlist lists textcolor wordcount   imagetools     colorpicker textpattern',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
            image_advtab: true,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
@endsection