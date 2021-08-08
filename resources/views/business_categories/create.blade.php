@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            
            <span class="pull-left">
                <h4>Create New Business Category</h4>
            </span>

            <div class="btn-group btn-group-sm pull-right" role="group">
            <a href="{{ route('business_categories.business_category.index') }}" title="Show All Business Category">
                                <button class="btn btn-labeled btn-green mb-2" type="button">
                                       <span class="btn-label"><i class="fa fa-list"></i>
                                       </span>Show All Business Category</button>
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

            <form method="POST" action="{{ route('business_categories.business_category.store') }}" accept-charset="UTF-8" id="create_business_category_form" name="create_business_category_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('business_categories.form', [
                                        'businessCategory' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


