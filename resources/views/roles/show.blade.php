@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($roles->title) ? $roles->title : 'Roles' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('roles.roles.destroy', $roles->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('roles.roles.index') }}" class="btn btn-primary" title="Show All Roles">
                        <i class="fa fa-list"></i>
                    </a>
 <!--
                    <a href="{{ route('roles.roles.create') }}" class="btn btn-success" title="Create New Roles">
                       <i class="fa fa-plus"></i>
                    </a>
                   
                    <a href="{{ route('roles.roles.edit', $roles->id ) }}" class="btn btn-primary" title="Edit Roles">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
					
                    <button type="submit" class="btn btn-danger" title="Delete Roles" onclick="return confirm(&quot;Delete Roles??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>-->
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd>{{ $roles->title }}</dd>
            <dt>Alias</dt>
            <dd>{{ $roles->alias }}</dd>
            <dt>Section</dt>
            <dd>{{ $roles->section }}</dd>

        </dl>

    </div>
</div>

@endsection