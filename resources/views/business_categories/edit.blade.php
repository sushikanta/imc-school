@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
  
        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ !empty($businessCategory->title) ? $businessCategory->title : 'Business Category' }}</h4>
            </div>
            <div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('business_categories.business_category.index') }}" class="btn btn-primary" title="Show All Business Category">
                    <span class="fa fa-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('business_categories.business_category.create') }}" class="btn btn-success" title="Create New Business Category">
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

            <form method="POST" action="{{ route('business_categories.business_category.update', $businessCategory->id) }}" id="edit_business_category_form" name="edit_business_category_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('business_categories.form', [
                                        'businessCategory' => $businessCategory,
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