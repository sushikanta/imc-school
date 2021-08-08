@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Reset Password</h4>
            </div>
            {{--<div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="Show All Users">
                    <span class="fa fa-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('countries.country.create') }}" class="btn btn-success" title="Create New Countries">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                </a>

            </div>--}}
        </div>

        <div class="panel-body">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif


            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}" id="edit_user_form" name="edit_user_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <input name="user_id" type="hidden" value="{{$user->id}}">



                <input class="form-control" name="id" type="hidden" id="title" value="{{ old('title', optional($user)->id) }}" minlength="1" maxlength="255" placeholder="Enter title here...">

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">Password</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password" type="password" id="password" value="" minlength="1" placeholder="Type new password">
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>


                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label for="email" class="col-md-2 control-label">Confirm Password</label>
                    <div class="col-md-10">
                        <input class="form-control" name="password_confirmation" type="password" id="password_confirmation" value="" minlength="1" placeholder="Retype new password">
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Reset password">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection