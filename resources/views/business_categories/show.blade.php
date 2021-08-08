@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($businessCategory->title) ? $businessCategory->title : 'Business Category' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('business_categories.business_category.destroy', $businessCategory->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('business_categories.business_category.index') }}" class="btn btn-primary" title="Show All Business Category">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('business_categories.business_category.create') }}" class="btn btn-success" title="Create New Business Category">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('business_categories.business_category.edit', $businessCategory->id ) }}" class="btn btn-primary" title="Edit Business Category">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Business Category" onclick="return confirm(&quot;Delete Business Category??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Title</dt>
            <dd>{{ $businessCategory->title }}</dd>
            <dt>Parent</dt>
            <dd>{{ optional($businessCategory->parent)->title }}</dd>
            <dt>Published</dt>
            <dd>{{ $businessCategory->published }}</dd>
            <dt>Context</dt>
            <dd>{{ optional($businessCategory->context)->firstname }}</dd>
            <dt>Sort</dt>
            <dd>{{ $businessCategory->sort }}</dd>

        </dl>

    </div>
</div>

@endsection