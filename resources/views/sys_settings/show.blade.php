@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Sys Setting' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('sys_settings.sys_setting.destroy', $sysSetting->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('sys_settings.sys_setting.index') }}" class="btn btn-primary" title="Show All Sys Setting">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('sys_settings.sys_setting.create') }}" class="btn btn-success" title="Create New Sys Setting">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('sys_settings.sys_setting.edit', $sysSetting->id ) }}" class="btn btn-primary" title="Edit Sys Setting">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Sys Setting" onclick="return confirm(&quot;Delete Sys Setting??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Type</dt>
            <dd>{{ $sysSetting->type }}</dd>
            <dt>Key</dt>
            <dd>{{ $sysSetting->key }}</dd>
            <dt>Value</dt>
            <dd>{{ $sysSetting->value }}</dd>
            <dt>Description</dt>
            <dd>{{ $sysSetting->description }}</dd>
            <dt>Published</dt>
            <dd>{{ ($sysSetting->published) ? 'No' : 'Yes' }}</dd>

        </dl>

    </div>
</div>

@endsection