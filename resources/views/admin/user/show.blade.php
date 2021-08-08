@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($users->title) ? $users->title : 'Users' }}</h4>
        </span>

            <div class="pull-right">

                <form method="POST" action="{!! route('users.user.destroy', $users->id) !!}" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('countries.country.index') }}" class="btn btn-primary" title="Show All Countries">
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        </a>

                        <a href="{{ route('countries.country.create') }}" class="btn btn-success" title="Create New Countries">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>

                        <a href="{{ route('countries.country.edit', $users->id ) }}" class="btn btn-primary" title="Edit Countries">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Countries" onclick="return confirm(&quot;Delete Users??&quot;)">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="panel-body">
            <dl class="dl-horizontal">
                <dt>Id</dt>
                <dd>{{ $users->id }}</dd>
                <dt>Email</dt>
                <dd>{{ $users->email }}</dd>
                <dt>First Name</dt>
                <dd>{{ ($users->firstname)}}</dd>
                <dt>Last Name</dt>
                <dd>{{ $users->lastname }}</dd>

            </dl>

        </div>
    </div>

@endsection