@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
  
        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ !empty($title) ? $title : 'Sys Setting' }}</h4>
            </div>
            <div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('sys_settings.sys_setting.index') }}" class="btn btn-primary" title="Show All Sys Setting">
                    <span class="fa fa-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('sys_settings.sys_setting.create') }}" class="btn btn-success" title="Create New Sys Setting">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                </a>

            </div>
        </div>

        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('sys_settings.sys_setting.update', $sysSetting->id) }}" id="edit_sys_setting_form" name="edit_sys_setting_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('sys_settings.form', [
                                        'sysSetting' => $sysSetting,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection