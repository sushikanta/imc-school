@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($contactusQuery->name) ? $contactusQuery->name : 'Contactus Query' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('contactus_queries.contactus_query.destroy', $contactusQuery->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('contactus_queries.contactus_query.index') }}" class="btn btn-primary" title="Show All Contactus Query">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('contactus_queries.contactus_query.create') }}" class="btn btn-success" title="Create New Contactus Query">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('contactus_queries.contactus_query.edit', $contactusQuery->id ) }}" class="btn btn-primary" title="Edit Contactus Query">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Contactus Query" onclick="return confirm(&quot;Delete Contactus Query??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $contactusQuery->name }}</dd>
            <dt>Email</dt>
            <dd>{{ $contactusQuery->email }}</dd>
            <dt>Phone</dt>
            <dd>{{ $contactusQuery->phone }}</dd>
            <dt>Subject</dt>
            <dd>{{ $contactusQuery->subject }}</dd>
            <dt>Details</dt>
            <dd>{{ $contactusQuery->details }}</dd>
            <dt>Created At</dt>
            <dd>{{ $contactusQuery->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $contactusQuery->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection